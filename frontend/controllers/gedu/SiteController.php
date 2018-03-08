<?php
namespace frontend\controllers\gedu;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use yii\web\Controller;
use common\models\Article;
use common\models\Page;
use common\models\ArticleAttachment;
use frontend\models\search\ArticleSearch;
use frontend\models\Contact;
use common\models\ArticleCategory;
use frontend\models\ContactForm;
use frontend\models\gedu\ApplyToPlay;
/*
use Superman2014\Aliyun\Sms\Sms\Request\V20160927 as Sms;
use Superman2014\Aliyun\Core\Profile\DefaultProfile;
use Superman2014\Aliyun\Core\DefaultAcsClient;
*/

/**
 * Site controller
 */
class SiteController extends \frontend\controllers\SiteController
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

        $teacher = Article::find()->published()
            ->orderBy('page_rank DESC, created_at DESC')
            ->andWhere(['category_id' => 38])
            ->limit(6)
            ->asArray()
            ->all();

        $sights = Article::find()->published()
            ->orderBy('page_rank DESC, created_at DESC')
            ->andWhere(['category_id' => 37])
            ->limit(8)
            ->asArray()
            ->all();
        return $this->render('index',[
            'data'    => $data,
            'teacher' => $teacher,
            'sights' => $sights,
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
    public function actionTeacher($category_id=""){
        if ($category_id == '') {
            throw new \yii\web\NotFoundHttpException(Yii::t('frontend','页面未找到'));
        }
       $category=[];
        if($category_id){
            $category['childs']=ArticleCategory::find()->where(['parent_id'=>$category_id])->asArray()->all();

            $category['cateIds']=ArrayHelper::getColumn($category['childs'],'id');
            $category['self']=ArticleCategory::find()->where(['id'=>$category_id])->asArray()->one();

            $category['parent']=ArticleCategory::find()->where(['id'=>$category['self']['parent_id']])->asArray()->one();
            if(empty($category['parent'])){
                $category['pare_name']=$category['self']['title'];
                $category['pare_id']=$category['self']['id'];
            }else{
                $category['pare_name']=$category['parent']['title'];
                $category['pare_id']=$category['parent']['id'];
            }

            $category['child']=ArticleCategory::find()->where(['parent_id'=>$category['self']['parent_id']])->asArray()->all();
            
        }  

        $query = Article::find()
            ->where(['category_id' => 38])
            ->published()
            ->orderBy('page_rank DESC, created_at DESC');
        $pages = new Pagination([
            'totalCount' =>$query->count(),
            'pageSize' => '6'
        ]);
        $teacher = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render("teacher",[
            'category'=>$category,
            'teacher' => $teacher,
            'pages' => $pages
        ]);
    }
     /**
    *校园风光
    */
    public function actionSights($category_id=""){
        if ($category_id == '') {
            throw new \yii\web\NotFoundHttpException(Yii::t('frontend','页面未找到'));
        }
        $category=[];
        if($category_id){
            $category['childs']=ArticleCategory::find()->where(['parent_id'=>$category_id])->asArray()->all();

            $category['cateIds']=ArrayHelper::getColumn($category['childs'],'id');
            $category['self']=ArticleCategory::find()->where(['id'=>$category_id])->asArray()->one();

            $category['parent']=ArticleCategory::find()->where(['id'=>$category['self']['parent_id']])->asArray()->one();
            if(empty($category['parent'])){
                $category['pare_name']=$category['self']['title'];
                $category['pare_id']=$category['self']['id'];
            }else{
                $category['pare_name']=$category['parent']['title'];
                $category['pare_id']=$category['parent']['id'];
            }

            $category['child']=ArticleCategory::find()->where(['parent_id'=>$category['self']['parent_id']])->asArray()->all();
        }

        $query = Article::find()
            ->where(['category_id' => 37])
            ->published()
            ->orderBy('page_rank DESC, created_at DESC');
        $pages = new Pagination([
            'totalCount' =>$query->count(),
            'pageSize' => '12'
        ]);
        $sights = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        
        return $this->render("sights",[
            'category' => $category,
            'sights'   => $sights,
            'pages'    => $pages
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
    //报名表
    public function actionApplyToPlay(){
        $model=new ApplyToPlay;
        
         if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->apply($post)) {
                Yii::$app->session->setFlash('info', '报名成功');
            }
        }
        return $this->render("apply-to-play",['model' => $model]);
    }


}
