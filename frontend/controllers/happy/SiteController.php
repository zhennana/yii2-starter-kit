<?php
namespace frontend\controllers\happy;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\data\Pagination;

use common\models\Article;
use common\models\ArticleCategory;

use frontend\models\ContactForm;

use backend\modules\campus\models\CoursewareToCourseware;
use backend\modules\campus\models\Courseware;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ],
        ];
    }

    public function actionIndex()
    {
        $master_id = CoursewareToCourseware::find()->select(['courseware_master_id'])->groupBY('courseware_master_id')->asArray()->all();
        $master_id = array_column($master_id, 'courseware_master_id');

        $query = Courseware::find()->where([
            'status'        => Courseware::COURSEWARE_STATUS_VALID,
            'courseware_id' => $master_id
        ]);

        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => '12',
        ]);

        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (!$model) {
            throw new HttpException(404, 'The requested page does not exist.');
        }

        return $this->render('index',[
            'model' => $model,
            'pages' => $pages
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
