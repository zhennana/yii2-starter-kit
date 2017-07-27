<?php

namespace backend\controllers;

use common\models\WidgetCarousel;
use Yii;
use common\models\WidgetCarouselItem;
use backend\models\search\WidgetCarouselItemSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\BucketManager;

/**
 * WidgetCarouselItemController implements the CRUD actions for WidgetCarouselItem model.
 */
class WidgetCarouselItemController extends Controller
{
    public function actions()
    {
        return [
            'token-cloud' => [
                'class' => '\common\actions\QiniuCarouselAction',
                'type' => 'token'
            ],
            'upload' => [
                'class' => '\common\actions\QiniuCarouselAction',
                'type' => 'upload'
            ],
            'upload-delete' => [
                'class' => '\common\actions\QiniuCarouselAction',
                'type'  => 'delattach'
            ],
        ];
    }
    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'widget-carousel/item';
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Creates a new WidgetCarouselItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($carousel_id)
    {
        $model = new WidgetCarouselItem();
        $carousel = WidgetCarousel::findOne($carousel_id);
        if (!$carousel) {
            throw new HttpException(400);
        }

        $model->carousel_id =  $carousel->id;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
               // dump($model);exit;
                Yii::$app->getSession()->setFlash('alert', ['options'=>['class'=>'alert-success'], 'body'=>Yii::t('backend', 'Carousel slide was successfully saved')]);
                return $this->redirect(['/widget-carousel/update', 'id' => $model->carousel_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'carousel' => $carousel,
        ]);
    }

    /**
     * Updates an existing WidgetCarouselItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(isset($_POST['WidgetCarouselItem']['path2'])){
                $keys = $_POST['WidgetCarouselItem']['path2'];
                $auth = new Auth(
                        \Yii::$app->params['qiniu']['wakooedu']['access_key'], 
                        \Yii::$app->params['qiniu']['wakooedu']['secret_key']
                );
                $bucketMgr = new BucketManager($auth);
                $bucket    = \Yii::$app->params['qiniu']['wakooedu']['bucket'];
                $err       = $bucketMgr->delete($bucket,$keys);
            }
            Yii::$app->getSession()->setFlash('alert', ['options'=>['class'=>'alert-success'], 'body'=>Yii::t('backend', 'Carousel slide was successfully saved')]);
            return $this->redirect(['/widget-carousel/update', 'id' => $model->carousel_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WidgetCarouselItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            return $this->redirect(['/widget-carousel/update', 'id'=>$model->carousel_id]);
        };
    }

    /**
     * Finds the WidgetCarouselItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WidgetCarouselItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WidgetCarouselItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
