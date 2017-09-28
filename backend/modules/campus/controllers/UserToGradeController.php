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
         echo Html::tag('option','请选择班级',['value'=>'']);
        foreach ($model as $key => $value) {    
         echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }

    }
    /**
     * 转班
     * @return [type] [description]
     */
    public function actionTurn($user_to_grade_id){
        $model = $this->findModel($user_to_grade_id);
        $newModel = new UserToGrade;
        if(Yii::$app->request->post() && $_POST['UserToGrade']['grade_id']){
            $data = $model->attributes;
            $model->status = UserToGrade::USER_GRADE_STATUS_CHANGE;
            $model->save();
            $data['grade_id'] = $_POST['UserToGrade']['grade_id'];
            unset($data['updated_at'],$data['created_at']);
            $newModel->load($data,'');
            if(!$newModel->save()){
                return $this->render('turn',['model'=>$model,'newModel'=>$newModel]);
            }else{
                return $this->redirect(['index']);
            }
        }
        return $this->render('turn',['model'=>$model,'newModel'=>$newModel]);
    }
}
