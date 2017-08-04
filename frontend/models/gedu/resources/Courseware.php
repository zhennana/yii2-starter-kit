<?php
namespace frontend\models\gedu\resources;

use yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\base\Courseware  as BaseCourseware;
use frontend\models\gedu\resources\CoursewareToCourseware;
use frontend\models\gedu\resources\CoursewareCategory;
use frontend\models\gedu\resources\Collect;
use frontend\models\gedu\resources\CourseOrderItem;

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
                'target' => function($model){
                    if (json_decode($model->body)) {
                        return json_decode($model->body)->target;
                    }
                    return $model->body;
                },
                'process' => function($model){
                    if (json_decode($model->body)) {
                        return json_decode($model->body)->process;
                    }
                    return $model->body;
                },
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
                'filetype' => function($model){
                    $childOne = $this->childCoursewareOne();
                    if (isset($childOne) && !empty($childOne)) {
                        $model = $childOne;
                    }
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
        return $this->hasMany(\frontend\models\gedu\resources\CoursewareToCourseware::className(),
            ['courseware_master_id'=>'courseware_id']);
    }
    public function formatByApi($model, $file)
    {
        // var_dump($model);exit;
    }
    
    /**
     * [streamData 首页流组装【废弃】]
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
     * [getSortCourse 获取首页流课程数据【废弃】]
     * @param  [type] $sort [description]
     * @return [type]       [description]
     */
    public function getSortCourse($type,$sort)
    {
        $data   = [];

        $model  = self::find()->where([
            'courseware_id' => $this->prentCourseware()
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

    /**
     * 获取主课件id
     */
    public function prentCourseware(){
        $model = CoursewareToCourseware::find()->select(['courseware_master_id'])->groupBY('courseware_master_id')->asArray()->all();
        $model = array_column($model, 'courseware_master_id');

        return $model;
    }

    /**
     * [childCoursewareOne 获取一个子课件]
     * @return [type] [description]
     */
    public function childCoursewareOne(){
        $model = CoursewareToCourseware::find()
            ->joinWith('courseware')
            ->where(['courseware_master_id' => $this->courseware_id])
            ->one();
        if ($model) {
            return $model->courseware;
        }
        return null;
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
        ])->orderBy([
            'sort' => SORT_DESC
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
