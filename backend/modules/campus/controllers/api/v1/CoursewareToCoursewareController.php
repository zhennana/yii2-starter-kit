<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/f197ab8e55d1e29a2dea883e84983544
 *
 * @package default
 */


namespace backend\modules\campus\controllers\api\v1;

/**
 * This is the class for REST controller "CoursewareToCoursewareController".
 */
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\search\CoursewareToCoursewareSearch;

class CoursewareToCoursewareController extends \yii\rest\ActiveController
{
	public $modelClass = 'backend\modules\campus\models\CoursewareToCourseware';

	/**
	 *
	 * @inheritdoc
	 * @return unknown
	 */
	public function behaviors() {
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'allow' => true,
							'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
						]
					]
				]
			]
		);
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
        unset($actions['index']);
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
     * @SWG\Get(path="/campus/api/v1/courseware-to-courseware/index",
     *     tags={"400-Courseware-课件管理接口"},
     *     summary="课件关系表",
     *     description="返回所有课件",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "courseware_to_courseware_id",
     *        description = "id",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *    @SWG\Parameter(
     *        in = "query",
     *        name = "courseware_master_id",
     *        description = "主课件id",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *    @SWG\Parameter(
     *        in = "query",
     *        name = "courseware_id",
     *        description = "相关课件ID",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *    @SWG\Parameter(
     *        in = "query",
     *        name = "status",
     *        description = "状态 1:正常; 0:删除",
     *        required = false,
     *        default = "1",
     *        enum    = "{1,0}",
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建学校信息"
     *     ),
     * )
     *
    **/
    public function actionIndex()
    {
        $searchModel = new CoursewareToCoursewareSearch;
        $searchModel->load(\yii::$app->request->queryParams,'');
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $dataProvider;
    }

    /**
     * @SWG\Get(path="/campus/api/v1/courseware-to-courseware/view",
     *     tags={"400-Courseware-课件管理接口"},
     *     summary="关联课件详情",
     *     description="返回所有课件",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "id",
     *        description = "id",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建学校信息"
     *     ),
     * )
     *
    **/


    /**
     * @SWG\Post(path="/campus/api/v1/courseware-to-courseware/update?id=1",
     *     tags={"400-Courseware-课件管理接口"},
     *     summary="修改课件关系",
     *     description="修改课件关系",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_to_courseware_id",
     *        description = "id",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *    @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_master_id",
     *        description = "主课件id",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *    @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_id",
     *        description = "相关课件ID",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *    @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态 1:正常; 0:删除",
     *        required = false,
     *        default = "1",
     *        enum    = {1,0},
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建信息"
     *     ),
     * )
     *
    **/



}
