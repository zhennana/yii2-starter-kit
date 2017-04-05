<?php
namespace frontend\controllers;

use Yii;
use frontend\models\ContactForm;
use yii\web\Controller;
use frontend\models\ApplyToPlay;
use frontend\models\Contact;
use common\models\Article;
use common\models\ArticleCategory;

/*
use Superman2014\Aliyun\Sms\Sms\Request\V20160927 as Sms;
use Superman2014\Aliyun\Core\Profile\DefaultProfile;
use Superman2014\Aliyun\Core\DefaultAcsClient;
*/

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
                'class'           => 'yii\captcha\CaptchaAction',
                'height'          => 40,
                'width'           => 100,
                'minLength'       => 4,
                'maxLength'       => 4,
                'padding'         => 0,
                'offset'          => 4,
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
                    //Yii::getAlias('@frontend/controllers/api'),
                    Yii::getAlias('@frontend/modules/api/v1/controllers'),
                    //Yii::getAlias('@api/modules/v1/models'),
                    //Yii::getAlias('@api/models'),
                ],
                //api_key 是文档浏览key,文档放到线上，我们并不需要让每个人都能看到，所以可以通过设置这项来实现。配置后浏览文档时需要在右上角的api_key输入框中输入配置的值，才能正常访问文档.
                'api_key' => '8868',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = ArticleCategory::find()
            ->select(['id','parent_id'])
            ->where([
              'or',
              ['id'        => [3, 22]],
              ['parent_id' => [9, 12]]
            ])
            ->andWhere([
                'status' => ArticleCategory::STATUS_ACTIVE
            ])
            ->asArray()
            ->all();

        // dump($model);exit;
        $course_left  = [];
        $course_right = [];
        $dongtai      = [];
        $zuopin       = [];
        foreach ($model as $key => $value) {
            if($value['parent_id'] == 9){
                $course_left[]  = $value['id'];

            }elseif($value['parent_id'] == 12){
                $course_right[] = $value['id'];

            }elseif($value['id'] == 22){
                $zuopin[] = $value['id'];

            }elseif($value['id'] == 3){
                $dongtai[]      = $value['id'];

            }
        }

        $ids = array_column($model, 'id');
        // dump($ids);exit;
        $articles = Article::find()
        ->where(['category_id' => $ids])
        ->orderBy(['updated_at' => SORT_DESC])
        ->asArray()
        ->all(); 

        $data = [
          'course_left'  => [],
          'course_right' => [],
          'dongtai'      => [],
          'zuopin'       => []
        ];

        // dump($articles);exit;
        foreach($articles as $key => $value){
            if(in_array($value['category_id'], $course_left)){
                $data['course_left'][] = $value;
            }

            if(in_array($value['category_id'], $course_right)){
                $data['course_right'][] = $value;
            }

            if(in_array($value['category_id'], $dongtai)){
                $data['dongtai'][] = $value;
            }
            if (in_array($value['category_id'], $zuopin)) {
                $data['zuopin'][] = $value;
            }
        }
        //dump($data['course_left']);exit;
            // if($value['id'] == 3){
            //  // $data['dongtai']['title'] = $value['title'];
            //   //wakoo 动态
            //   $data['dongtai'][] = $value;
            
            // }elseif($value['parent_id'] == 9){
            //   //$data['course_tope']          = $value;
              
            //   //wakoo 学前课程（3-6）
            //   $data['course_left'][]    = $value;
            
            // }elseif($value['parent_id'] == 12){
              
            //   //wakoo 学前课程（7-13）
            //   $data['course_right'][]    = $value;
            
            // }elseif($value['id'] == 1 ){
            //   //关于wakoo
            // }
    // dump($data);exit;
      //exit();
      /*
       * 阿里云发送短信.
       *
       * @param string $moblie 手机号 '18500466496,13512345678'
       * @param string $paramString {'code': '1234', 'product': 'orby'}
       * @param string $clientId 阿里云accessKey
       * @param string $clientSecret 阿里云accessSecret
       * @param string $signName 短信签名
       * @param string $templateCode 短信模板
       *
       * @throws Superman2014\Aliyun\Core\Exception\ClientException
       * @throws Superman2014\Aliyun\Core\Exception\ServerException;
       *
       * @return string
       */
        /*
        $sms = new \Superman2014\Aliyun\Sms\SmsSender();
        $paramsString = "{'code':'1234'}";
        $resource = $sms->send(
          '13910408910', 
          $paramsString, 
          '',
          '',
          '验证测试',
          'SMS_1111'
        );
        var_dump($resource);
        */
        return $this->render('index',[
            'model' => $data
        ]);
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
                return ['status'=>false,'errors' => $model->getErrors()];
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
                return ['status'=>false,'errors' => $model->getErrors()];
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
