<?php
namespace frontend\controllers;

use Yii;
use frontend\models\ContactForm;
use yii\web\Controller;
use backend\modules\campus\models\ApplyToPlay;
use backend\modules\campus\models\Contact;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                  'height' => 40,
                  'width' => 100,
                  'minLength' => 4,
                  'maxLength' => 4,
                  'padding'=>0, 
                  'offset'=>4, 
                  'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null

            ],
            'contact_captcha'=>[
                'class' => 'yii\captcha\CaptchaAction',
                  'height' => 40,
                  'width' => 100,
                  'minLength' => 4,
                  'maxLength' => 4,
                  'padding'=>0, 
                  'offset'=>4, 
                  // 'controller'=>'ajax-ontact',
                  'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ],
            
            //文档预览地址,配置好后可以直接访问:http://api.yourhost.com/sign-in/doc
            'doc' => [
                'class' => 'light\swagger\SwaggerAction',
                'restUrl' => \yii\helpers\Url::to(['/site/api'], true),
            ],
            //看到上面配置的*restUrl*了么，没错, 它就是指向这个地址
            'api' => [
                'class' => 'light\swagger\SwaggerApiAction',
                //这里配置需要扫描的目录,不支持yii的alias,所以需要这里直接获取到真实地址
                'scanDir' => [
                    Yii::getAlias('@orange/controllers/api'),
                    //Yii::getAlias('@frontend/modules/api/v1/controllers'),
                    //Yii::getAlias('@api/modules/v1/models'),
                    //Yii::getAlias('@api/models'),
                ],
                //api_key 是文档浏览key,文档放到线上，我们并不需要让每个人都能看到，所以可以通过设置这项来实现。配置后浏览文档时需要在右上角的api_key输入框中输入配置的值，才能正常访问文档.
                'api_key' => 'yajol',
            ],

        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * *
     *
     * 
     */
    public function actionAjaxApply(){
        $model = new ApplyToPlay;
        $model->setScenario('AjaxApply');
        if (Yii::$app->request->isAjax) {
           
           Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          
            if($model->load(Yii::$app->request->post()) && $model->save()){
                return ['status' => true];
            }else{
                //var_dump($model->getErrors());
                return ['status'=>false];
            }
        }

    }
    /**
     * 异步提交数据
     * @return [type] [description]
     */
    public function actionAjaxContact(){
        $model = new Contact;
        if (Yii::$app->request->isAjax) {
           
           Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          
            if($model->load(Yii::$app->request->post()) && $model->save()){
                return ['status' => true];
            }else{
               // var_dump($model->getErrors());
                return ['status'=>false];
            }
        }
        if($model->load(Yii::$app->request->post())){
            if($model->save()){
               Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),

                    'options'=>['class'=>'alert-info']
                ]);
                return $this->refresh();
        }else{
            Yii::$app->getSession()->setFlash('alert', [
                    'body'=>\Yii::t('frontend', 'There was an error sending email.'),
                    'options'=>['class'=>'alert-danger']
            ]);
        }
    }
        return $this->render('contact',[
                'model'=>$model
            ]);

    }
   

    public function actionContact()
    {
        $model = new ContactForm();
        //var_dump(Yii::$app->params['adminEmail']);exit;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options'=>['class'=>'alert-success']
                ]);
                return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>\Yii::t('frontend', 'There was an error sending email.'),
                    //'options'=>['class'=>'alert-danger']
                ]);
            }
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }
}
