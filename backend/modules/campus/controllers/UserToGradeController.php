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
        foreach ($model as $key => $value) {
             echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }

    }

    public function actionUserToSchoolForm(){
        $model = new UserToSchoolForm;
        if($model->load($_POST)){
            $model = $model->batch_create($_POST);
        }
        return $this->render('_user_to_school',
            [
            'model'=>$model,
            'rules'=>ArrayHelper::map(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id),'name','description')
            ]);
    }
}
