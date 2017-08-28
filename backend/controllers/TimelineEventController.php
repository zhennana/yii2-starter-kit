<?php

namespace backend\controllers;

use Yii;
use backend\models\search\TimelineEventSearch;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
{
    public $layout = 'common';
    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    //默认控制器
    public function actionDefault(){
        if(Yii::$app->user->can('manager') ||
            Yii::$app->user->can('E_manager')
            ){
            return $this->redirect(['/timeline-event/index']);
        }else if(Yii::$app->user->can('P_manager')){
            return $this->redirect(['campus/school/index','type'=>1]);
        }else if(Yii::$app->user->can('P_financial')  || Yii::$app->user->can('E_financial')
        ){
            return $this->redirect([
                    'campus/course-order-item/index','type'=>2
                ]);
        }else{
            return $this->redirect(['campus/user-to-grade/index']);
        }
    }
}
