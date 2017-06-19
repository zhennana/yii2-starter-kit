<?php

namespace backend\modules\campus\controllers;

use Yii;
use backend\modules\campus\models\UserToSchool;
use backend\modules\campus\models\search\UserToSchoolSearch;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use backend\modules\campus\models\UserToSchoolForm;


/**
 * UserToSchoolController implements the CRUD actions for UserToSchool model.
 */
class UserToSchoolController extends Controller
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
            }else{
                return $this->redirect(['index']);
            }
        }
        return $this->render('_user_to_school',
            [
            'model'=>$model,
            'rules'=>ArrayHelper::map(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id),'name','description')
            ]);
    }

    /**
     * Lists all UserToSchool models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserToSchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');
        $dataProvider->query->andWhere([
            'school_id'=> array_keys($schools),
            ]);

        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'schools'      => $schools,
        ]);
    }

    /**
     * Displays a single UserToSchool model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserToSchool model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserToSchool();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_to_school_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserToSchool model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_to_school_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserToSchool model.
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
     * Finds the UserToSchool model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserToSchool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserToSchool::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
