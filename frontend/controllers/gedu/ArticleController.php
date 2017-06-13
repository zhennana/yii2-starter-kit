<?php
namespace frontend\controllers\gedu;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\Article;
use common\models\ArticleCategory;
use yii\web\Controller;
use frontend\models\search\ArticleSearch;

class ArticleController extends Controller{
	
	public function actionIndex($category_id=''){

		/**
		1，首先，判断是否传入的care gory，如果没传入，默认全查，如果传入，执行下面
		2，判断传入的categoryid是否事一级分类；如果事一级分类，查找分类下的所有分类；
		3，如果不是一级分类，查找这个分类的父级分类，然后找出这个分类下的所有分类；

		*/
		$articleQuery=Article::find()->where(['status'=>Article::STATUS_PUBLISHED]);
		
		$category=[];
		if($category_id){
			$category['self']=ArticleCategory::find()->where(['id'=>$category_id])->asArray()->one();
			//如何传入的是二级分类，查找该类的一级分类，级这个分类下的所有分类；
			$category['parent']=ArticleCategory::find()->where(['id'=>$category['self']['parent_id']])->asArray()->one();
			//如何传入的是一级分类，查找分类下的子分类
			$category['child']=ArticleCategory::find()->where(['parent_id'=>$category['parent']['id']])->asArray()->all();
		
			$articleQuery->andWhere(['category_id'=>$category_id])->asArray()->all();
			
		}
		

		$modelArticle=$articleQuery->asArray()->all();
		
        return $this->render('index', ['category'=>$category,'modelArticle'=>$modelArticle]);
	}

	public function actionView($id=''){

		$article=Article::find()->where(['id'=>$id])->one();

		if(!$article){
			throw new NotFoundHttpException(Yii::t('frontend','页面未找到'));
		}
		 $viewFile="view";
		return $this->render($viewFile,['model'=>$article]);
	}
}

?>