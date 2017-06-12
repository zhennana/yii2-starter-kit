<?php
namespace frontend\controllers\gedu;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\Article;
use yii\web\Controller;
use frontend\models\search\ArticleSearch;

class ArticleController extends Controller{
	
	public function actionIndex(){
		$searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', ['dataProvider'=>$dataProvider]);
	}

	public function actionView($id=''){
		// var_dump($id);exit;
		$article=Article::find()->where(['id'=>$id])->one();

		if(!$article){
			throw new NotFoundHttpException(Yii::t('frontend','页面未找到'));
		}
		 $viewFile="view";
		return $this->render($viewFile,['model'=>$article]);
	}
}

?>