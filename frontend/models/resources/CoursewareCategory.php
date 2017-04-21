<?php
namespace frontend\models\resources;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\campus\models\CoursewareCategory as BaseCoursewareCategory;
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

    public function fields(){
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
        $model = self::find()->where(['status'=>self::CATEGORY_STATUS_OPEN])->asArray()->all();
        return  self::formatByApi($model);
    }

    public static  function formatByApi($parame,$pid = 0){
        $data = [];
        $clid = [];
        //$parame = ArrayHelper::index($parame,'category_id');
        foreach ($parame as $key => $value) {
            if($value['parent_id'] == $pid){
                $value['descriptions'] =  $value['description'];
                unset($parame[$key],$value['description']);
                $clid = self::formatByApi($parame,$value['category_id']); 
                if(!empty($clid)){
                    $value['child'] =  $clid;
                }else{
                    if($pid != 0){
                        //continue;
                        $value['url']   = \Yii::$app->request->hostInfo.Url::to(['courseware/list','category_id'=>$value['category_id']]);
                    }else{
                        continue;
                    }
                }

                $data[]    = $value;
            }

        }
        return $data;
    }
}

?>