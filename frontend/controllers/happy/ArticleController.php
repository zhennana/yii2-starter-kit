<?php

namespace frontend\controllers\happy;

use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\ArticleCategory;
use yii\helpers\Url;
use common\models\Article;
use frontend\models\search\ArticleSearch;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', ['dataProvider'=>$dataProvider]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Article::find()->published()->andWhere(['id'=>$id])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }

        $viewFile =  'view';
        return $this->render($viewFile, ['model'=>$model]);
    }

    /**
     * [actionCourse description]
     * @return [type] [description]
     */
    public function actionCourse($category_id)
    {
        $query = Article::find()->where(['category_id' => $category_id]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => '8',
        ]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['page_rank'=> SORT_ASC])
            ->all();

        return $this->render('course',[
            'model' => $model,
            'pages' => $pages
        ]);
    }

}
