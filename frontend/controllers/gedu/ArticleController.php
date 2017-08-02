<?php
namespace frontend\controllers\gedu;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\Article;
use common\models\ArticleCategory;
use yii\web\Controller;
use frontend\models\search\ArticleSearch;
use yii\data\Pagination;

class ArticleController extends Controller{
	public $enableCsrfValidation = false;
	public function actionIndex($category_id=''){

		/**
		1，首先，判断是否传入的care gory，如果没传入，默认全查，如果传入，执行下面
		2，判断传入的categoryid是否事一级分类；如果事一级分类，查找分类下的所有分类；
		3，如果不是一级分类，查找这个分类的父级分类，然后找出这个分类下的所有分类；

		*/
		$articleQuery=Article::find()->where(['status'=>Article::STATUS_PUBLISHED]);
		
		$category=[];
		if($category_id){
			/*
			查找是否已category_id为父类的所有二级分类
		 	如果不为空，传入的category_id有许多二级分类。说明这个分类为一级分类。
		 	如果为空，说明没有分类继承这个分类，则这个分类是二级分类；
			**/
			$category['childs']=ArticleCategory::find()->where(['parent_id'=>$category_id])->asArray()->all();



			$category['cateIds']=ArrayHelper::getColumn($category['childs'],'id');
			$category['self']=ArticleCategory::find()->where(['id'=>$category_id])->asArray()->one();

			//查找这个类的上一级分类，如果没有查不到上级分类。则一级分类名就是$category['self']的分类名；如果可以查到，一级分类名为$category['parent']的类名；
			$category['parent']=ArticleCategory::find()->where(['id'=>$category['self']['parent_id']])->asArray()->one();
			if(empty($category['parent'])){
				$category['pare_name']=$category['self']['title'];
				$category['pare_id']=$category['self']['id'];
			}else{
				$category['pare_name']=$category['parent']['title'];
				$category['pare_id']=$category['parent']['id'];
			}
			//查找同级分类，如果传入的是一级分类，输出所有一级分类；如果是二级分类，查重处于同一级分类的所有分类
			if(empty($category['self']['parent_id'])){
				$category['child']=ArticleCategory::find()->where(['parent_id'=>$category['self']['parent_id']])->asArray()->all();
			}else{
				$category['child']=ArticleCategory::find()->where(['parent_id'=>$category['self']['parent_id']])->asArray()->all();
			}
			
			
			$articleQuery->andWhere(['category_id'=>!empty($category['cateIds'])?$category['cateIds']:$category_id])->asArray()->all();
			
		}
		$count=$articleQuery->count();
		$pagination=new Pagination([
			'totalCount'=>$count,
			'pageSize'=>10,
			]);
		
		$modelArticle=$articleQuery
		->limit($pagination->limit)
		->asArray()
		->all();
		
		
        return $this->render('index', [
        	'category'=>$category,
        	'modelArticle'=>$modelArticle,
        	'pagination'=>$pagination
        	]);
	}

	public function actionView($id=''){

		$article=Article::find()->where(['id'=>$id])->one();
		$categoryModel=$article->category;
		$category['self']=$categoryModel->title;
		//查找是否有父级分类,如果该类就是一级分类
		$category['parent']=ArticleCategory::find()->where(['id'=>$categoryModel->parent_id])->asArray()->one();

		//如果传入的是二级分类，查找与此处于同级分类下的子类
		if(!empty($category['parent'])){
			$category['child']=ArticleCategory::find()->where(['parent_id'=>$category['parent']['id']])->asArray()->all();
			$category['pare_name']=$category['parent']['title'];
			$category['pare_id']=$category['parent']['id'];

		}else{
			$category['child']=ArticleCategory::find()->where(['parent_id'=>null])->asArray()->all();
			$category['pare_name']=$category['self'];
			$category['pare_id']=$categoryModel->id;
		}

		if(!$article){
			throw new NotFoundHttpException(Yii::t('frontend','页面未找到'));
		}
		$viewFile="view";
		return $this->render($viewFile,[
			'model'=>$article,
			'category'=>$category
			]);
	}
}

?>