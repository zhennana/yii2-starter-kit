<?php
namespace frontend\models\gedu\resources;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\base\CoursewareCategory as BaseCoursewareCategory;
/**
 * 
 */
class CoursewareCategory extends BaseCoursewareCategory
{
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

    public function fields()
    {
        $fields =  ArrayHelper::merge(
            parent::fields(),
            [
                'descriptions'=>'description'
            ]);
        unset($fields['description']);
        return $fields;
    }

    /**
     * [get_category 课件分类无限级递归]
     * @param  [type]  $model [description]
     * @param  integer $pid   [description]
     * @return [type]         [description]
     */
    public function categoryList()
    {
        $model = self::find()->where(['status'=>self::CATEGORY_STATUS_OPEN,'parent_id' => 0])->asArray()->all();
        $data =  self::formatByApi($model);
        return $data;
    }

    /*
    public static  function formatByApi($parame,$pid = 0,$level = 1){
        $data = [];
        $clid = [];
        //$parame = ArrayHelper::index($parame,'category_id');
        foreach ($parame as $key => $value) {
            if($value['parent_id'] == $pid){
                $value['descriptions'] =  $value['description'];
                $value['imgUrl'] =  'http://orh16je38.bkt.clouddn.com/study-picture.png?imageView2/1/w/509/h/209';
                unset($parame[$key],$value['description']);
                $clid = self::formatByApi($parame,$value['category_id'],$level+1);
                
                if(in_array($level,[1,2]) && empty($clid)){
                    continue;
                } 

                if(!empty($clid)){
                    $value['child'] =  $clid;
                }else{
                    if($level == 3){
                        //continue;
                        $value['target_url'] = \Yii::$app->request->hostInfo.Url::to(['edu/courseware/list','category_id'=>$value['category_id']]);
                    }
                }

                $data[] = $value;
            }

        }
        return $data;
    }
    */
    public static function formatByApi($params){
        $data = [];
        $child = [];
        foreach ($params as $key => $value) {
            $child = self::find()->where(['status'=>self::CATEGORY_STATUS_OPEN,'parent_id' => $value['category_id']])->asArray()->all();
            $temp = $value;
            $temp['imgUrl'] = 'http://orh16je38.bkt.clouddn.com/study-picture.png?imageView2/1/w/509/h/209';
            $temp['child'] = $child;
            $data[] = $temp;
        }
        return $data;
    }
}

