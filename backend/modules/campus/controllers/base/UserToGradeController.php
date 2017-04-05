<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\controllers\base;

use backend\modules\campus\models\UserToGrade;
    use backend\modules\campus\models\search\UserToGradeSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* UserToGradeController implements the CRUD actions for UserToGrade model.
*/
class UserToGradeController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
    return [
    'access' => [
    'class' => AccessControl::className(),
    'rules' => [
    [
    'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['CampusUserToGradeFull'],
                    ],
    [
    'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['CampusUserToGradeView'],
                    ],
    [
    'allow' => true,
                        'actions' => ['update', 'create', 'delete'],
                        'roles' => ['CampusUserToGradeEdit'],
                    ],
    
                ],
            ],
    ];
    }

/**
* Lists all UserToGrade models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new UserToGradeSearch;
    $dataProvider = $searchModel->search($_GET);

    Tabs::clearLocalStorage();

    Url::remember();
    \Yii::$app->session['__crudReturnUrl'] = null;

    return $this->render('index', [
    'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]);
}

/**
* Displays a single UserToGrade model.
* @param integer $user_to_grade_id
*
* @return mixed
*/
public function actionView($user_to_grade_id)
{
    \Yii::$app->session['__crudReturnUrl'] = Url::previous();
    Url::remember();
    Tabs::rememberActiveState();

    return $this->render('view', [
        'model' => $this->findModel($user_to_grade_id),
    ]);
}

/**
* Creates a new UserToGrade model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
    $model = new UserToGrade;
    if($model->load($_POST)){
        $info = $model->date_save($_POST['UserToGrade']);
        //dump(!empty($info['error']));exit;
        if(!empty($info['error'])){
            return $this->render('create',['model'=>$model,'info'=>$info]);
        }
        return $this->redirect(['user-to-grade/index']);
    }
// try {
//     if ($model->load($_POST) && $model->save()) {
//     return $this->redirect(['view', 'user_to_grade_id' => $model->user_to_grade_id]);
// } elseif (!\Yii::$app->request->isPost) {
//     $model->load($_GET);
// }
// } catch (\Exception $e) {
//     $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
//     $model->addError('_exception', $msg);
// }
return $this->render('create', ['model' => $model]);
}

/**
* Updates an existing UserToGrade model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $user_to_grade_id
* @return mixed
*/
public function actionUpdate($user_to_grade_id)
{
$model = $this->findModel($user_to_grade_id);

    if ($model->load($_POST) && $model->save()) {

        return $this->redirect(Url::previous());
    } else {
        return $this->render('update', [
        'model' => $model,
        ]);
    }
}

/**
* Deletes an existing UserToGrade model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $user_to_grade_id
* @return mixed
*/
public function actionDelete($user_to_grade_id)
{
try {
$this->findModel($user_to_grade_id)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$user_to_grade_id',',');
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
* Finds the UserToGrade model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $user_to_grade_id
* @return UserToGrade the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($user_to_grade_id)
{
if (($model = UserToGrade::findOne($user_to_grade_id)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}