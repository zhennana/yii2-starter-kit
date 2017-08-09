<?php

namespace backend\modules\campus\controllers\base;

use Yii;
use backend\modules\campus\models\UsersToUsers;
use backend\modules\campus\models\search\UsersToUsersSearch;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;

/**
 * UsersToUsersController implements the CRUD actions for UsersToUsers model.
 */
class UsersToUsersController extends Controller
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
     * Lists all UsersToUsers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersToUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersToUsers model.
     * @param integer $users_to_users_id
     * @return mixed
     */
    public function actionView($users_to_users_id)
    {
        \Yii::$app->session['__crudReturnUrl'] = Url::previous();
        Url::remember();
        Tabs::rememberActiveState();
        return $this->render('view', [
            'model' => $this->findModel($users_to_users_id),
        ]);
    }

    /**
     * Creates a new UsersToUsers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsersToUsers();

        try {
            if ($model->load($_POST) && $model->save()) {
                return $this->redirect(['view', 'users_to_users_id' => $model->users_to_users_id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing UsersToUsers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $users_to_users_id
     * @return mixed
     */
    public function actionUpdate($users_to_users_id)
    {
        $model = $this->findModel($users_to_users_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'users_to_users_id' => $model->users_to_users_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UsersToUsers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $users_to_users_id
     * @return mixed
     */
    public function actionDelete($users_to_users_id)
    {
        try {
            $this->findModel($users_to_users_id)->delete();
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            \Yii::$app->getSession()->addFlash('error', $msg);
            return $this->redirect(Url::previous());
        }

        // TODO: improve detection
        $isPivot = strstr('$users_to_users_id',',');
        if ($isPivot == true) {
            return $this->redirect(Url::previous());
        } elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
            Url::remember(null);
            $url = \Yii::$app->session['__crudReturnUrl'];
            \Yii::$app->session['__crudReturnUrl'] = null;

            return $this->redirect($url);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the UsersToUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $users_to_users_id
     * @return UsersToUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($users_to_users_id)
    {
        if (($model = UsersToUsers::findOne($users_to_users_id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
