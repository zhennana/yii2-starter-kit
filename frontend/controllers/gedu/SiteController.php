<?php
namespace frontend\controllers\gedu;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use common\models\Article;
use common\models\Page;
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
        $data = [];
        $data['all']=Article::find()->where(['status'=>Article::STATUS_PUBLISHED])->andWhere(['category_id'=>22])->orderby(['published_at'=>SORT_DESC])->asArray()->all();
       // echo'<pre>';var_dump($data['all']);exit;
        //取数组的第一个值
        $data['one']=current($data['all']);
        //从第二个元素开始
        $data['other']=array_slice($data['all'], 1);
        
        $data['teacher']['all']=Page::find()->where(['slug'=>'jiao-shi-jian-jie'])->asArray()->one();
        //小学老师
        $data['teacher']['primary']=Page::find()->where(['slug'=>'xiao-xue-lao-shi'])->asArray()->one();
        //中学老师
        $data['teacher']['middle']=Page::find()->where(['slug'=>'zhong-xue-lao-shi'])->asArray()->one();
        //国际部老师
        $data['teacher']['internation']=Page::find()->where(['slug'=>'guo-ji-lao-shi'])->asArray()->one();
        //特长部老师
        $data['teacher']['speciality']=Page::find()->where(['slug'=>'te-zhang-lao-shi'])->asArray()->one();
        return $this->render('index',[
            'data'=>$data,
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
        $data['teacher']['all']=Page::find()->where(['slug'=>'jiao-shi-jian-jie'])->asArray()->one();
        //小学老师
        $data['teacher']['primary']=Page::find()->where(['slug'=>'xiao-xue-lao-shi'])->asArray()->one();
        //中学老师
        $data['teacher']['middle']=Page::find()->where(['slug'=>'zhong-xue-lao-shi'])->asArray()->one();
        //国际部老师
        $data['teacher']['internation']=Page::find()->where(['slug'=>'guo-ji-lao-shi'])->asArray()->one();
        //特长部老师
        $data['teacher']['speciality']=Page::find()->where(['slug'=>'te-zhang-lao-shi'])->asArray()->one();

        return $this->render("teacher",['data'=>$data]);
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
