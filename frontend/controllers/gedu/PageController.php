<?php 
namespace frontend\controllers\gedu;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\Page;
use yii\web\Controller;

class PageController extends Controller{

	public function actionView($slug){
		$page=Page::find()->where(['slug'=>$slug,'status'=>Page::STATUS_PUBLISHED])->one();
		if(!$page){
			throw new NotFoundHttpException(Yii::t('frontend', 'Page not found'));
		}
		$viewFile = $page->view ?: 'view';
        return $this->render($viewFile, ['model'=>$page]);
	}
}

?>