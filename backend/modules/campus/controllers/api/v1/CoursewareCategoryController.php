<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/f197ab8e55d1e29a2dea883e84983544
 *
 * @package default
 */


namespace backend\modules\campus\controllers\api\v1;
/**
 * This is the class for REST controller "CoursewareCategoryController".
 */
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\search\CoursewareCategorySearch;


class CoursewareCategoryController extends \yii\rest\ActiveController
{
	public $modelClass = 'backend\modules\campus\models\CoursewareCategory';

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

	public function beforeAction($action)
	{
		$format = \Yii::$app->getRequest()->getQueryParam('format','json');
		if($format == 'xml'){
			\Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
		}else{
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		}
		return $action;
	}

	public function actions(){
		$actions = parent::actions();
		unset($actions['index']);
		return $actions;
	}

	public $serializer = [
			'class'=>'common\rest\Serializer',
			'collectionEnvelope'=>'result',
			'errno'				=> 0,
			'message'			=>''
	];

	/**
	 *@SWG\Get(path="/campus/api/v1/courseware-category/index",
	 * 	tags = {"400-Courseware-课件管理接口"},
	 * 	summary = "查询所有课件分类",
	 * 	description = "返回所有课件分类",
	 * 	produces = {"application/json"},
	 * 	@SWG\Parameter(
	 * 		in="query",
	 * 		name="category_id",
	 * 		description = "分类id",
	 * 		required = false,
	 * 		type    = "integer"
	 * 	),
	 * 	@SWG\Parameter(
	 * 		in="query",
	 * 		name="name",
	 * 		description = "分类名",
	 * 		required    = false,
	 * 		type        = "string"
	 * 	),
	 * 	@SWG\Parameter(
	 * 		in="query",
	 * 		name = "description",
	 * 		description = "描述",
	 * 		required    = false,
	 * 		type 		= "string"
	 * 	),
	 *  @SWG\Parameter(
	 * 		in="query",
	 * 		name = "status",
	 * 		description = "状态 10:正常；20：关闭",
	 * 		required    = false,
	 * 		type 		= "string",
	 * 		default     = "10",
	 * 		enum        = {10,20}
	 * 	),
	 * @SWG\Response(
	 * 		response = 200,
	 * 		description = "返回所有班级分了数据"
	 * 	)
	 * )
	 */
	public function actionIndex(){
		$searchModel = new CoursewareCategorySearch;
		$searchModel->load(\Yii::$app->request->queryParams,'');
		$dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
		$dataProvider->sort = [
				'defaultOrder'=>['updated_at'=>SORT_DESC]
		];
		return $dataProvider;
	}

	/**
	 *@SWG\Get(path="/campus/api/v1/courseware-category/view",
	 * 	tags = {"400-Courseware-课件管理接口"},
	 * 	summary = "课件分类详情",
	 * 	description = "课件分类详情",
	 * 	produces = {"application/json"},
	 * 	@SWG\Parameter(
	 * 		in="query",
	 * 		name="id",
	 * 		description = "分类id",
	 * 		required = false,
	 * 		type    = "integer"
	 * 	),
	 * @SWG\Response(
	 * 		response = 200,
	 * 		description = "课件分类详情"
	 * 	)
	 * )
	 */
	

	/**
	 *@SWG\Post(path="/campus/api/v1/courseware-category/update?id=1",
	 * 	tags = {"400-Courseware-课件管理接口"},
	 * 	summary = "修改课件分类",
	 * 	description = "修改课件分类",
	 * 	produces = {"application/json"},
	 * 	@SWG\Parameter(
	 * 		in="formData",
	 * 		name="category_id",
	 * 		description = "分类id",
	 * 		required = false,
	 * 		type    = "integer"
	 * 	),
	 * 	@SWG\Parameter(
	 * 		in="formData",
	 * 		name="name",
	 * 		description = "分类名",
	 * 		required    = false,
	 * 		type        = "string"
	 * 	),
	 * 	@SWG\Parameter(
	 * 		in="formData",
	 * 		name = "description",
	 * 		description = "描述",
	 * 		required    = false,
	 * 		type 		= "string"
	 * 	),
	 *  @SWG\Parameter(
	 * 		in="formData",
	 * 		name = "status",
	 * 		description = "状态 10:正常；20：关闭",
	 * 		required    = false,
	 * 		type 		= "string",
	 * 		default     = "10",
	 * 		enum        = {10,20}
	 * 	),
	 * @SWG\Response(
	 * 		response = 200,
	 * 		description = "修改课件"
	 * 	)
	 * )
	 */
	
		/**
	 *@SWG\Post(path="/campus/api/v1/courseware-category/create",
	 * 	tags = {"400-Courseware-课件管理接口"},
	 * 	summary = "创建课件分类",
	 * 	description = "创建课件分类",
	 * 	produces = {"application/json"},
	 * 	@SWG\Parameter(
	 * 		in="formData",
	 * 		name="prament_id",
	 * 		description = "父分类",
	 * 		required = false,
	 * 		type    = "integer"
	 * 	),
	 * @SWG\Parameter(
	 * 		in="formData",
	 * 		name="category_id",
	 * 		description = "分类id",
	 * 		required = true,
	 * 		type    = "integer"
	 * 	),
	 * 	@SWG\Parameter(
	 * 		in="formData",
	 * 		name="name",
	 * 		description = "分类名",
	 * 		required    = true,
	 * 		type        = "string"
	 * 	),
	 * 	@SWG\Parameter(
	 * 		in="formData",
	 * 		name = "description",
	 * 		description = "描述",
	 * 		required    = true,
	 * 		type 		= "string"
	 * 	),
	 * 	@SWG\Parameter(
	 * 		in="formData",
	 * 		name = "banner_src",
	 * 		description = "课件图片,这里需要上传七牛云返回url",
	 * 		required    = true,
	 * 		type 		= "string"
	 * 	),
	 *  @SWG\Parameter(
	 * 		in="formData",
	 * 		name = "status",
	 * 		description = "状态 10:正常；20：关闭",
	 * 		required    = true,
	 * 		type 		= "string",
	 * 		default     = "10",
	 * 		enum        = {10,20}
	 * 	),
	 * @SWG\Response(
	 * 		response = 200,
	 * 		description = "返回创建班级信息"
	 * 	)
	 * )
	 */

}
