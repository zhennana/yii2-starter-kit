<?php
namespace frontend\controllers\happy;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use common\models\Article;
use common\models\ArticleCategory;

use frontend\models\ContactForm;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        $model = ArticleCategory::find()
            ->where(['status' => ArticleCategory::STATUS_ACTIVE])
            ->asArray()
            ->all();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        return $this->render('index',[
            'model' => $model
        ]);
    }
   

    public function actionContact()
    {
        $model = new ContactForm();

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
