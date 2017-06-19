<?php

namespace backend\modules\campus\controllers;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\Course;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\UserToSchoolForm;
/**
* This is the class for controller "UserToGradeController".
*/
class UserToGradeController extends \backend\modules\campus\controllers\base\UserToGradeController
{
    /**
     * 二级联动
     * @return [type] [description]
     */
    public function actionAjaxForm(){
        //var_dump($_GET);exit;
        $model = new UserToGrade;
        $model = $model->getlist($_GET['type_id'],$_GET['id']);
         echo Html::tag('option','请选择班级',['value'=>'0']);
        foreach ($model as $key => $value) {    
         echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }

    }

    public function actionUserToSchoolForm(){
        $model = new UserToSchoolForm;
        $info = [];
        if($model->load($_POST)){
            $info = $model->batch_create($_POST);
           // var_dump($info);exit;
            if(isset($info['error']) && !empty($info['error'])){

                 return $this->render('_user_to_school',
                    [
                    'model'=>$model,
                    'rules'=>ArrayHelper::map(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id),'name','description'),
                    'info'=>$info['error'],
                    ]);
            }
        }
        return $this->render('_user_to_school',
            [
            'model'=>$model,
            'rules'=>ArrayHelper::map(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id),'name','description')
            ]);
    }
}
