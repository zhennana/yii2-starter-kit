<?php

namespace frontend\controllers\happy;

use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\HttpException;
use common\models\ArticleCategory;
use yii\helpers\Url;
use common\models\Article;
use frontend\models\search\ArticleSearch;

use backend\modules\campus\models\CoursewareCategory;
use backend\modules\campus\models\CoursewareToCourseware;
use backend\modules\campus\models\Courseware;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

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
    public function actionView($courseware_id)
    {
        $files = [];
        $model = Courseware::find()->where([
            'status'        => Courseware::COURSEWARE_STATUS_VALID,
            'courseware_id' => $courseware_id
        ])->one();

        if (!$model) {
            throw new HttpException(404, 'The requested page does not exist.');
        }
        if ($model->toFile) {
            foreach ($model->toFile as $key => $value) {
                $files[$key] = $value->fileStorageItem->toArray();
            }
        }

        $to_courseware = CoursewareToCourseware::find()
            ->with('coursewareMaster')
            ->where([
                'courseware_id' => $courseware_id
            ])->one();
        if (!$to_courseware) {
            throw new HttpException(404, 'The requested page does not exist.');
        }
        $viewFile =  'view';
        return $this->render($viewFile, [
            'model'        => $model,
            'files'        => $files,
            'to_courseware' => $to_courseware,
        ]);
    }
   
    /**
     * [actionCourse description]
     * @return [type] [description]
     */
    public function actionCourse($master_id)
    {
        $sub_courseware = CoursewareToCourseware::find()->where([
            'status'               => CoursewareToCourseware::COURSEWARE_STATUS_OPEN,
            'courseware_master_id' => $master_id
        ])->asArray()->all();
        if ($sub_courseware) {
            $sub_courseware = array_column($sub_courseware, 'courseware_id');
        }

        $query = Courseware::find()
            ->where([
                'status'        => Courseware::COURSEWARE_STATUS_VALID,
                'courseware_id' => $sub_courseware,
            ]);

        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => '10',
        ]);

        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $masterModel = Courseware::find()->where([
            'status'        => Courseware::COURSEWARE_STATUS_VALID,
            'courseware_id' => $master_id,
        ])->one();

        if ($masterModel) {
            $master = $masterModel->toArray();
            foreach ($masterModel->toFile as $key => $value) {
                $master['files'][$key] = $value->fileStorageItem->toArray();
            }
        }
        if (!isset($master) || empty($master) || !$model) {
            throw new HttpException(404, 'The requested page does not exist.');
        }

        return $this->render('course',[
            'model'  => $model,
            'pages'  => $pages,
            'master' => $master
        ]);
    }

}
