<?php

namespace backend\controllers;

use Yii;
use common\models\Article;
use backend\models\search\ArticleSearch;
use \common\models\ArticleCategory;
use \common\models\ArticleAttachment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\BucketManager;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }

        public function actions()
    {
        return [
            // 七牛云
            'token-cloud' => [//得到上传token
                'class' => 'common\actions\QiniuArticleAction',
                'type' => 'token'
            ],
            'upload-cloud' => [//上传
                'class' => 'common\actions\QiniuArticleAction',
                'type' => 'upload'
            ],
            'privacy' => [//是否公开
                'class' => 'common\actions\QiniuArticleAction',
                'type' => 'privacy'
            ],

            // 系统
            'upload' => [
                'class' => 'trntv\filekit\actions\UploadAction',
                'deleteRoute' => 'upload-delete'
            ],
            'upload-delete' => [
                'class' => 'trntv\filekit\actions\DeleteAction'
            ],

            // 文章活动内容编辑器，本地上传
            'upload-imperavi' => [
                'class' => 'trntv\filekit\actions\UploadAction',
                'fileparam' => 'file',
                'responseUrlParam'=> 'filelink',
                'multiple' => false,
                'disableCsrf' => true
            ]
        ];
    }
    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['published_at'=>SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $categories  = $model->category_recursion(ArticleCategory::find()->active()->asArray()->all());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories  = $model->category_recursion(ArticleCategory::find()->active()->asArray()->all());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    //删除附件
    public function actionDeleteAttachments($id)
    {
       $model = ArticleAttachment::findOne($id);
       //dump(\Yii::$app->session['__crudReturnUrl']);exit;
       if($model){
            $keys = $model->path;
            $model->delete();
            $auth = new Auth(
                \Yii::$app->params['qiniu']['wakooedu']['access_key'], 
                \Yii::$app->params['qiniu']['wakooedu']['secret_key']
            );
            $bucketMgr = new BucketManager($auth);
            $bucket    = \Yii::$app->params['qiniu']['wakooedu']['bucket'];
            $err       = $bucketMgr->delete($bucket,$keys);
            //var_dump($err);
           }
       if(isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/'){
            Url::remember(null);
            $url = \Yii::$app->session['__crudReturnUrl'];
            \Yii::$app->session['__crudReturnUrl'] = null;

            return $this->redirect($url);
        }else{
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
