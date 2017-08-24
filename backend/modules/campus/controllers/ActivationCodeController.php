<?php

namespace backend\modules\campus\controllers;

use Yii;
use backend\modules\campus\models\ActivationCode;
use backend\modules\campus\models\search\ActivationCodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivationCodeController implements the CRUD actions for ActivationCode model.
 */
class ActivationCodeController extends Controller
{
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
     * Lists all ActivationCode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivationCodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ActivationCode model.
     * @param integer $activation_code_id
     * @return mixed
     */
    public function actionView($activation_code_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($activation_code_id),
        ]);
    }

    /**
     * Creates a new ActivationCode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActivationCode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'activation_code_id' => $model->activation_code_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ActivationCode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $activation_code_id
     * @return mixed
     */
    public function actionUpdate($activation_code_id)
    {
        $model = $this->findModel($activation_code_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'activation_code_id' => $model->activation_code_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ActivationCode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $activation_code_id
     * @return mixed
     */
    public function actionDelete($activation_code_id)
    {
        $this->findModel($activation_code_id)->delete();

        return $this->redirect(['index']);
    }

    public function actionBatchCreate()
    {
        $model = new ActivationCode;
        $model->scenario = 'batch_create';

        if ($model->load(Yii::$app->request->post())) {
            $info = $model->batchCreate();
            if (!empty($info)) {
                return $this->render('batch-create', [
                    'model' => $model,
                    'info' => $info,
                ]);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('batch-create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the ActivationCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $activation_code_id
     * @return ActivationCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($activation_code_id)
    {
        if (($model = ActivationCode::findOne($activation_code_id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
