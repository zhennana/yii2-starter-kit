<?php

namespace backend\controllers;

use Yii;
use common\models\WidgetMenu;
use backend\models\search\WidgetMenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WidgetMenuController implements the CRUD actions for WidgetMenu model.
 */
class WidgetMenuController extends Controller
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
     * Lists all WidgetMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WidgetMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new WidgetMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WidgetMenu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WidgetMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WidgetMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WidgetMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WidgetMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WidgetMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    //页脚菜单
    /*
    public function actionFooterIndex(){
        $model = new WidgetMenu;
 // var_Dump('<pre>',Yii::$app->request->post());exit;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('footer', [
                'model' => $model,
            ]);
        }
        /*
        $searchModel = new WidgetMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['key'=>'footer','status'=>WidgetMenu::STATUS_ACTIVE]);
        return $this->render('footer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/
    //页脚展示
    public function actionFooterIndex(){
        $searchModel = new WidgetMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//这里静态写死展示页脚的几个id.
        $dataProvider->query->where(['id'=>[2,3,4,5,6]]);
        return $this->render('footer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateFooter(){
         $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    //联系我们修改
    public function actionFooterUpdate($id){
        $model = $this->findModel($id);
        $model->getArrayItems();
        $post = Yii::$app->request->post();

        if($id != 6 && isset($post['WidgetMenu']['body'])){
            $sort = $post['WidgetMenu']['body']['sort'];
            unset($post['WidgetMenu']['body']['sort']);
            rsort($post['WidgetMenu']['body']);
            $post['WidgetMenu']['body']['sort'] = $sort;
        }
        if($model->load($post)){
           $model->getJsonItems();
           if($model->save()){
                return $this->redirect(['footer-index']);
           }
        }
        if($id == 6){
            return $this->render('footer_contact',[
                'model'=>$model,
            ]);
        }else{
            return $this->render('footer_form',[
                'model'=>$model,
            ]);
        }
    }
}
