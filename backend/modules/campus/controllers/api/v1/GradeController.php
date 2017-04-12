<?php

namespace backend\modules\campus\controllers\api\v1;

/**
* This is the class for REST controller "GradeController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class GradeController extends \yii\rest\ActiveController
{
public $modelClass = 'backend\modules\campus\models\Grade';
    /**
    * @inheritdoc
    */
   /*
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [[
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
                    ]]
                ]
            ]
        );
    }
*/
    /**
     * @param  [action] yii\rest\IndexAction
     * @return [type] 
     */
    public function beforeAction($action)
    {
        $format = \Yii::$app->getRequest()->getQueryParam('format', 'json');

        if($format == 'xml'){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        }else{
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }

        // 移除access行为，参数为空全部移除
        // Yii::$app->controller->detachBehavior('access');
        return $action;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }


    // public function actions()
    // {
    //     return [
    //         'options' => OptionsAction::class,
    //     ];
    // }

    public $serializer = [
            'class'=>'common\rest\Serializer',
            'collectionEnvelope'=>'result',
            'symbol'=>'。'
            'errno'=>0,
            'message'=>['ok']
    ];

     /**
     * @SWG\Get(path="/campus/api/v1/grade/index",
     *     tags={"10-班级管理"},
     *     summary="展示数据",
     *     description="展示全部班级",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */
    
    /**
     * @SWG\Get(path="/campus/api/v1/grade/view",
     *     tags={"10-班级管理"},
     *     summary="展示数据",
     *     description="展示全部班级",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "query",
     *        name = "id",
     *        description = "id",
     *        required = true,
     *        type = "string"
     *     ),
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */
}
