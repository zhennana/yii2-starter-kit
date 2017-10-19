<?php
namespace backend\modules\campus\controllers;

use Yii;
use common\models\User;
use backend\modules\campus\models\search\UserSearch;
use yii\helpers\ArrayHelper;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\campus\models\UserForm;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \backend\controllers\UserController
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

    /**+
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserForm();
        $e_roles = Yii::$app->authManager->getChildRoles('E_administrator');
        ArrayHelper::multisort($e_roles,['updatedAt'],[SORT_ASC]);
        $e_roles =  ArrayHelper::map($e_roles,'name','description');
        $p_roles = Yii::$app->authManager->getChildRoles('P_administrator');
        ArrayHelper::multisort($p_roles,['updatedAt'],[SORT_ASC]);
        //var_dump('<pre>',$p_roles);exit;
        $p_roles = ArrayHelper::map($p_roles,'name','description');

        $roles = ArrayHelper::merge($e_roles,$p_roles);
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'roles' => $roles
        ]);
    }

    /**
     * Updates an existing User model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new UserForm();
        $model->setModel($this->findModel($id));
        $e_roles = [];
        $e_roles = Yii::$app->authManager->getChildRoles('E_administrator');
        ArrayHelper::multisort($e_roles,['updatedAt'],[SORT_ASC]);
        $e_roles =  ArrayHelper::map($e_roles,'name','description');
        $p_roles = Yii::$app->authManager->getChildRoles('P_administrator');
        ArrayHelper::multisort($p_roles,['updatedAt'],[SORT_ASC]);
        //var_dump('<pre>',$p_roles);exit;
        $p_roles = ArrayHelper::map($p_roles,'name','description');

        $roles = ArrayHelper::merge($e_roles,$p_roles);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'roles' => $roles
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->authManager->revokeAll($id);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
