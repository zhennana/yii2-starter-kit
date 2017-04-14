<?php

namespace backend\modules\campus\controllers\api\v1;

/**
* This is the class for REST controller "CoursewareController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\search\CoursewareSearch;

class CoursewareController extends \yii\rest\ActiveController
{
public $modelClass = 'backend\modules\campus\models\Courseware';
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => 
                [
                    'class' => AccessControl::className(),
                    'rules' => [[
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
                    ]]
                ]
            ]);
    }

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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['create']);
        return $actions;
    }

    /**
     * @var array
     */
    public $serializer = [
        'class'              => 'common\rest\Serializer',   // 返回格式数据化字段
        'collectionEnvelope' => 'result',                   // 制定数据字段名称
        'errno'              => 0,                          // 错误处理数字
        'message'            => [ 'OK' ],                   // 文本提示
    ];

    /**
     * @SWG\Get(path="/campus/api/v1/courseware/index",
     *     tags={"400-Courseware-课件管理接口"},
     *     summary="返回所有课件",
     *     description="返回所有课件",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "courseware_id",
     *        description = "课件id",
     *        required = false,
     *        default = "0",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "category_id",
     *        description = "课件分类",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "title",
     *        description = "标题",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "body",
     *        description = "课件详情",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "status",
     *        description = "状态 10:正常； 20：删除",
     *        required = false,
     *        default = "10",
     *        type = "string",
     *        enum = {10,20}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建学校信息"
     *     ),
     * )
     *
    **/
    public function actionIndex(){
        //$response = \Yii::$app->getResponse();
        //$response->getHeaders()->set('Access-Control-Allow-Origin',"*");
        $searchModel = new CoursewareSearch;
        $searchModel->load(\yii::$app->request->queryParams,'');
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $dataProvider;
    }

    /**
     * @SWG\Post(path="/campus/api/v1/courseware/update&id=1",
     *     tags={"400-Courseware-课件管理接口"},
     *     summary="返回所有课件",
     *     description="返回所有课件",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_id",
     *        description = "课件id",
     *        required = false,
     *        default = "0",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "category_id",
     *        description = "课件分类",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "title",
     *        description = "标题",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "body",
     *        description = "课件详情",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态",
     *        required = false,
     *        default = "",
     *        type = "integer",
     *        enum = {10,20}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建学校信息"
     *     ),
     * )
     *
    **/
}
