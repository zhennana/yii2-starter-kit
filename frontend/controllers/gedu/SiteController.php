<?php
namespace frontend\controllers\gedu;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use common\models\Article;
use common\models\ArticleAttachment;
use frontend\models\search\ArticleSearch;
use frontend\models\Contact;
use frontend\models\ContactForm;
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
        return parent::actions();
    }
    
    public function actionIndex()
    {
        //$this->layout = false;
        $article=Article::find()->where(['status'=>Article::STATUS_PUBLISHED])->asArray()->all();
       
        $searchModel= new ArticleSearch;
        $dataProvider=$searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort=[
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];
        // var_dump($dataProvider->getModels());exit;
        return $this->render('index',[
            'dataProvider'=>$dataProvider,
            'modelArticle'=>$article
            ]);
    }
    /**
    *小学
    */
    public function actionPrimary(){
        return $this->render("primary");
    }
    public function actionAboutUs(){
        return $this->render("about");
    }
    /**
    *合作交流
    */
    public function actionCooperation(){
        return $this->render("cooperation");
    }
    /**
    *教师风采
    */
    public function actionTeacher(){
        return $this->render("teacher");
    }
     /**
    *校园风光
    */
    public function actionSights(){
        return $this->render("sights");
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
    //报名表
    public function actionApplyToPlay(){
        return $this->render("apply-to-play");
    }


}
