<?php
namespace frontend\models\edu\resources;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\base\Courseware  as BaseCourseware;
use frontend\models\base\CoursewareToCourseware;
use frontend\models\base\CoursewareCategory;

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
                # custom validation rules
            ]
        );
    }

    public function fields(){
        return ArrayHelper::merge(
            parent::fields(),
            [
                'target_url'=>function($model){
                    return  \Yii::$app->request->hostInfo.Url::to(['edu/courseware/view','courseware_id'=>$model->courseware_id]);
                },
                'imgUrl' => function($model){
                    if(isset($model->toFile[0]->fileStorageItem->url)&& isset($model->toFile[0]->fileStorageItem->file_name)){
                        return $model->toFile[0]->fileStorageItem->url.$model->toFile[0]->fileStorageItem->file_name;
                    }else{
                        return 'http://7xsm8j.com2.z0.glb.qiniucdn.com/yajolyajol_activity_banner_01.png?imageView2/1/w/200/h/100';
                    }
                },
                'type'   => function($model){
                    return isset($model->toFile[0]->fileStorageItem->type) ? $model->toFile[0]->fileStorageItem->type : 'image/jpeg';
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
     * 首页流数据
     * @return [type] [description]
     */
    public  function streamData(){
        $params = [];
        foreach ($this->category() as $key => $value) {
            // var_dump($value->counts);exit;
            if(in_array($value->counts,[2,3,4])){
               $model = self::find()
                ->select(['courseware_id','title'])
                ->where(['courseware_id'=>$this->prentCourseware(),'category_id'=>$value['category_id']])
                ->limit($value->counts)->all();
                $params[$key]['type'] = $value->counts;
                $params[$key]['name'] = $value->coursewareCategory->name;
                $params[$key]['target_url'] = '跳转' ;
                $params[$key]['items']       = $model;
                unset($model);
        }
        continue;
    }
      return  $params ;
    }

    /**
     * 获取主课件id
     */
    public function prentCourseware(){
        $model = CoursewareToCourseware::find()->select(['courseware_master_id'])->groupBY('courseware_master_id')->asArray()->all();
        $model = array_column($model, 'courseware_master_id');
        //var_dump($model);exit;
        return $model;
    }

    /**
     * 获取主课件的分类 符合首页展示数据流 分类
     */
    public function category(){
        $model = Courseware::find()->select(['category_id',"count(*) as counts"])->where(['courseware_id'=>$this->prentCourseware()])->groupBY('category_id')->all();
        return $model;
    }
}

?>
