<?php

namespace frontend\models\edu\resources;

use Yii;
use frontend\models\base\Course as BaseCourse;
use frontend\models\edu\resources\Courseware;
use frontend\models\edu\resources\FileStorageItem;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "Course".
 */
class Course extends BaseCourse
{
    CONST FREE_COURSE     = 2;  // 免费课程
    CONST VIP_FREE_COURSE = 1;  // 会员免费
    CONST NORMAL_COURSE   = 0;  // 普通课程

public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['parent_id','category_id','course_counts'],'integer'],
                ['course_counts','default','value' => function($model){
                    if (!isset($model->parent_id) || empty($model->parent_id)) {
                        return self::find()->where(['parent_id' => $model->course_id])->count();
                    }
                    return 1;
                }],
                [['banner_src'],'string'],
                [['original_price','present_price','vip_price','access_domain'],'integer'],
            ]
        );
    }

    public function fields(){
        return ArrayHelper::merge(
            parent::fields(),
            [
                'target_url'=>function($model){
                    return  \Yii::$app->request->hostInfo.Url::to(['v1/course/view','course_id'=>$model->course_id]);
                },
                'video_record' => function($model){
                    if (Yii::$app->user->isGuest) {
                        return 0;
                    }
                    $time = Collect::find()->where([
                        'user_id'   => Yii::$app->user->identity->id,
                        'course_id' => $model->course_id,
                        'status'    => Collect::STATUS_COLLECTED
                    ])->one();
                    if (!$time) {
                        return 0;
                    }
                    return $time->play_back_time;
                },
                'favorite' => function($model){
                    if (Yii::$app->user->isGuest) {
                        return 0;
                    }
                    $collect = Collect::find()->where([
                        'user_id' => Yii::$app->user->identity->id
                    ])->andWhere([
                        'course_master_id' => $model->course_id
                    ])->orWhere([
                        'course_id' => $model->course_id
                    ])->one();
                    if (!$collect) {
                        return 0;
                    }
                    return $collect->status;
                },
                'purchased' => function($model){
                    if (Yii::$app->user->isGuest) {
                        return 0;
                    }
                    $order = CourseOrderItem::find()->where([
                        'status'         => CourseOrderItem::STATUS_VALID,
                        'payment_status' => CourseOrderItem::PAYMENT_STATUS_PAID,
                        'user_id'        => Yii::$app->user->identity->id,
                        'course_id'  => $model->course_id,
                    ])->count();
                    if ($order) {
                        return 1;
                    }
                    return 0;
                },
            ]
        );
    }

    /**
     * [getSubjects 获取子课程相关数据，并格式化]
     * @return [type] [description]
     */
    public function getSubjectsByApi()
    {
        $data = [];
        $temp = [];

        $model = self::find()->where([
            self::tableName().'.parent_id' => $this->course_id,
            self::tableName().'.status'    => self::COURSE_STATUS_OPEN
        ])
        ->all();

        foreach ($model as $key => $value) {
            $temp = $value->toArray();
            $temp['type'] = '';
            $temp['courseware'] = [];

            if (isset($value->courseware) && !empty($value->courseware) && $value->courseware->status == Courseware::COURSEWARE_STATUS_VALID) {
                $courseware = $value->courseware;
                $temp['courseware']['courseware_id'] = $courseware->courseware_id;
                $temp['courseware']['cw_title']      = $courseware->title;
                $temp['courseware']['cw_body']       = $courseware->body;
                $temp['courseware']['cw_status']     = $courseware->status;
                $temp['courseware']['cw_sort']       = $courseware->sort;
                $temp['courseware']['files']         = [];

                if (isset($courseware->toFile) && !empty($courseware->toFile)) {
                    $file  = [];
                    $files = [];
                    $temp['type'] = isset($courseware->toFile[0]->fileStorageItem->type) ? $courseware->toFile[0]->fileStorageItem->type : '';
                    foreach ($courseware->toFile as $toFile) {
                        if (isset($toFile->fileStorageItem) && !empty($toFile->fileStorageItem) && $toFile->fileStorageItem->status == FileStorageItem::STORAGE_STATUS_OPEN) {
                            $file['file_id']     = $toFile->fileStorageItem->file_storage_item_id;
                            $file['file_url']    = $toFile->fileStorageItem->url.$toFile->fileStorageItem->file_name;
                            $file['file_type']   = $toFile->fileStorageItem->type;
                            $file['file_size']   = $toFile->fileStorageItem->size;
                            $file['file_status'] = $toFile->fileStorageItem->status;
                            $files[] = $file;
                        }
                    }

                    $temp['courseware']['files'] = $files;
                }

            }

            $data[] = $temp;
        }

        return $data;
    }

    /**
     * [searchCourse 课程搜索]
     * @param  string $keyword [description]
     * @return [type]          [description]
     */
    public function searchCourse($keyword = '')
    {
        $data = [];

        $model = self::find()->where([
            'status'    => self::COURSE_STATUS_OPEN,
            'parent_id' => 0
        ])->andWhere([
            'or',
            ['like','title',$keyword],
            ['like','intro',$keyword],
        ])->all();

        if ($model) {
            foreach ($model as $key => $value) {
                $data[] = $value->toArray();
            }
        }

        return $data;
    }

    /**
     * [streamData 首页流组装]
     * @param  [type] $params [description]
     * @return [type]       [description]
     */
    public function streamData($params)
    {
        $data = [];
        if (isset($params) && !empty($params)) {
            foreach ($params as $key => $value) {
                $data[$key]['type'] = $value['type'];
                $data[$key]['name'] = $value['name'];
                $data[$key]['items'] = $this->getSortCourse($value['type'],$value['sort']);
            }
        }
      return $data;
    }

    /**
     * [getSortCourse 获取首页流课程数据]
     * @param  [type] $sort [description]
     * @return [type]       [description]
     */
    public function getSortCourse($type,$sort)
    {
        $data   = [];

        $model  = self::find()->where([
            'parent_id' => 0
        ])->andwhere([
            'sort' => $sort
        ])->orderBy('sort,updated_at DESC')->all();

        foreach ($model as $key => $value) {
            if(!isset($data[$value->sort])){
                $data[$value->sort] = $value;
            }else{
                continue;
            }
        }
        if(count($data) < $type){
            return [];
        }

        return array_values($data);
    }
}