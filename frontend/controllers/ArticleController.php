<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\ArticleCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Article;
use common\models\ArticleAttachment;
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
//$model->view ?:
        $viewFile =  'view';
        return $this->render($viewFile, ['model'=>$model]);
    }

    /**
     * @param $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAttachmentDownload($id)
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }
    public function  actionCourse(){
        $model_category =  ArticleCategory::find()->where(['parent_id'=>[9,12]])->with('articles')->asArray()->all();
        $data = [
            'left'=>[],
            'right'=>[]
        ];
        foreach ($model_category as $key => $value) {
            if($value['parent_id'] == 9){
                $data['left'][$key] = $value;
            }else{
                $data['right'][$key] = $value;
            }
        }
        return $this->render('course',['model'=>$data]);
    }


    /**
     * [actionNews description]
     * @return [type] [description]
     */
    public function actionNews(){
        $query = Article::find()->published()->where(['category_id' => 3]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => '10',
        ]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('news',[
            'model' => $model,
            'pages' => $pages
        ]);
    }

     /**
     * [获取新闻列表数据]
     * @param  integer $pager [页码]
     * @param  boolean $first [是否跳转第一页]
     * @param  integer $limit [每页展示个数]
     * @param  boolean $end   [是否跳转最后一页]
     * @return [type]         [description]
     */
    /*public function actionGetNews($pager = 0, $first= false,$limit=5,$end =false ){
     
            $model_category =  Article::find()
                ->select(['id','published_at','title','body'])
                ->where(['category_id'=>3])
                ->offset($pager*$limit)
                ->limit($limit)
                ->asArray();
            $model_cont = (int) $model_category->count();
            $model_category = $model_category->all();
            $data = [
                'totalPage'=>ceil($model_cont/$limit),
                'pager'    =>$pager,
                'data'     =>[],
            ];
            foreach ($model_category as $key => $value) {
                 \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $replace =["\r\n", "\r","\n"," "];
                $image = '';
                $image = getImgs($value['body']);
                $value['url'] = Url::to(['article/view','id'=>$value['id']]);
                $value['image'] = isset($image[0]) ? $image[0] : '' ;
                $value['body']  = str_replace($replace,"",strip_tags($value['body'])); 
                $value['body']  = substr_auto($value['body'],100);

                $data['data'][$key] = $value; 
            }
           // var_dump($data);exit;
         return $data;
    }*/
    public function actionAbout(){
        $model = Article::find()
        ->published()
        ->where(['category_id'=> 1])
        ->one();
        if (!$model) {
            throw new NotFoundHttpException('找不到该页面');
        }
        //var_dump($model);exit;
        return $this->render('@frontend/themes/edu/page/view',['model'=>$model]);
    }

    public function actionMerchants(){
        $model = Article::find()
        ->published()
        ->where(['category_id'=> 6])
        ->one();
        if (!$model) {
            throw new NotFoundHttpException('找不到该页面');
        }
        //var_dump($model);exit;
        return $this->render('@frontend/themes/edu/page/view',['model'=>$model]);
    }
}
