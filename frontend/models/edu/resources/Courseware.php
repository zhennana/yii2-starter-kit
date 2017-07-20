<?php
namespace frontend\models\edu\resources;

use yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\base\Courseware  as BaseCourseware;
use frontend\models\edu\resources\CoursewareToCourseware;
use frontend\models\edu\resources\CoursewareCategory;
use frontend\models\edu\resources\Collect;
use frontend\models\edu\resources\CourseOrderItem;

/**
 * 
 */
class Courseware extends BaseCourseware
{
    public $counts;
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
                [['original_price','present_price','vip_price','sort'],'integer'],
            ]
        );
    }

    public function fields(){
        return ArrayHelper::merge(
            parent::fields(),
            [
                'target_url'=>function($model){
                    return  \Yii::$app->request->hostInfo.Url::to(['gedu/v1/courseware/view','courseware_id'=>$model->courseware_id]);
                },
                'fileUrl' => function($model){
                    if (isset($model->toFile) && !empty($model->toFile)) {
                        foreach ($model->toFile as $key => $value) {
                            if ($value->status != 0) {
                                return $value->fileStorageItem->url.$value->fileStorageItem->file_name;
                            }
                            continue;
                        }
                    }else{
                        return 'http://orh16je38.bkt.clouddn.com/1024.png?imageView2/1/w/200/h/100';
                    }
                },
                'filetype'   => function($model){
                    if (isset($model->toFile) && !empty($model->toFile)) {
                        foreach ($model->toFile as $key => $value) {
                            if ($value->status != 0) {
                                return $value->fileStorageItem->type;
                            }
                            continue;
                        }
                    }else{
                        return 'image/jpeg';
                    }
                },
                'video_record' => function($model){
                    if (Yii::$app->user->isGuest) {
                        return 0;
                    }
                    $time = Collect::find()->where([
                        'user_id'       => Yii::$app->user->identity->id,
                        'courseware_id' => $model->courseware_id,
                        'status'        => Collect::STATUS_COLLECTED
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
                        'courseware_master_id' => $model->courseware_id
                    ])->orWhere([
                        'courseware_id' => $model->courseware_id
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
                        'courseware_id'  => $model->courseware_id,
                    ])->count();
                    if ($order) {
                        return 1;
                    }
                    return 0;
                },
            ]
        );
    }


    public function getCoursewareToCourseware(){
        return $this->hasMany(\frontend\models\edu\resources\CoursewareToCourseware::className(),
            ['courseware_master_id'=>'courseware_id']);
    }
    public function formatByApi($model, $file)
    {
        // var_dump($model);exit;
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
                $temp = [];
                $temp['type'] = $value['type'];
                $temp['name'] = $value['name'];
                for ($i=0; $i < $value['type']; $i++) { 
                    $temp['item'] = $this->getSortCourse($value['sort']);
                }

                if ($temp['type'] != count($temp['item'])) {
                    $temp['item'] = [];
                }
                $data[] = $temp;
            }
        }
      return $data;
    }

    /**
     * [getSortCourse 获取首页流课程数据]
     * @param  [type] $sort [description]
     * @return [type]       [description]
     */
    public function getSortCourse($sort)
    {
        $data   = [];
        $params = [];

        $model  = self::find()->where([
            'courseware_id' => $this->prentCourseware()
        ])->andwhere([
            'sort' => $sort
        ])->orderBy('sort,updated_at DESC')->all();

        foreach ($model as $key => $value) {
            if (!isset($data[$key-1]->sort) || empty($data[$key-1]->sort)) {
                $data[$key] = $value;
            }
        }

        foreach ($data as $k => $v) {
            $params[] =  $data[$k];
        }
        return $params;
    }

    /**
     * 获取主课件id
     */
    public function prentCourseware(){
        $model = CoursewareToCourseware::find()->select(['courseware_master_id'])->groupBY('courseware_master_id')->asArray()->all();
        $model = array_column($model, 'courseware_master_id');

        return $model;
    }

    /**
     * [searchCourseware 搜索课件接口，返回主课件]
     * @return [type] [description]
     */
    public function searchCourseware($keyword = '')
    {
        $data = [];
        
        $model = Courseware::find()->where([
            'status'        => Courseware::COURSEWARE_STATUS_VALID,
            'courseware_id' => $this->prentCourseware()
        ])->andWhere([
            'or',
            ['like','title',$keyword],
            ['like','title',$keyword],
        ])->all();

        if ($model) {
            foreach ($model as $key => $value) {
                $data[] = $value->toArray();
            }
        }

        return $data;
    }
}

?>
