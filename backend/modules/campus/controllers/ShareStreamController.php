<?php

namespace backend\modules\campus\controllers;
use backend\modules\campus\models\ShareStreamToGrade;
use backend\modules\campus\models\ShareStream;
use yii\helpers\Html;
/**
* This is the class for controller "ShareStreamController".
*/
class ShareStreamController extends \backend\modules\campus\controllers\base\ShareStreamController
{

    public function actionCreate(){
        $model = new ShareStream;
        $data = [];
        if($_POST){
            $data = $model->batch_create($_POST);
            if(empty($data->getErrors())){
                return $this->redirect(['index']);;
            }
        }
        return $this->render('create',['model'=>$model,'model1'=>$data]);
    }
    /**
     * 发布分享授权
     * @return [type] [description]
     */
    public function actionAuthorization($share_stream_id){
         $model = new ShareStreamToGrade;
         $default_data = $model->data_init($share_stream_id);
         //var_dump($_GET);exit;
       if($_POST){
            var_dump('<pre>',$_POST);exit();
        }
        return $this->renderAjax('authorization',[
                    'model'=>$model,
                    'default_data' =>$default_data
        ]);
    }

    public function actionAjaxForm(){
         $model = new ShareStreamToGrade;
        if($_GET['id']){
            $model = $model->getList($_GET['type_id'],$_GET['id']);
            foreach ($model as  $k=>$v) {
                 echo '<optgroup label='.$k .'>';
                foreach ($v as $key => $value) {
                    echo Html::tag('option',Html::encode($value),array('value'=>$key));
                }
            }
        }
    }
}
