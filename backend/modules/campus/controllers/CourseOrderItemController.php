<?php

namespace backend\modules\campus\controllers;

use yii\helpers\Html;
use backend\modules\campus\models\CourseOrderItem;
/**
* This is the class for controller "CourseOrderItemController".
*/
class CourseOrderItemController extends \backend\modules\campus\controllers\base\CourseOrderItemController
{
    /**
     * 二级联动
     * @return [type] [description]
     */
    public function actionAjaxForm(){
        //var_dump($_GET);exit;
        $model = new CourseOrderItem;
        $model = $model->getlist($_GET['type_id'],$_GET['id']);
        foreach ($model as $key => $value) {
             echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }

    }

    /**
     *  [actionBatchOrder 根据批量创建订单]
     *  @return [type] [description]
     */
    public function actionBatchOrder()
    {
        $model = new CourseOrderItem;
        // $model->scenario = 'batch_create';

        if ($model->load(\Yii::$app->request->post())) {
            $info = $model->batchOrder();
            if ($info->hasErrors()) {
                return $this->render('batch-order', [
                    'model' => $model,
                    'info' => $info,
                ]);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('batch-order',[
                'model' => $model
            ]);
        }
    }
}
