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
     *        default = "",
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
     *     summary="修改课件",
     *     description="修改课件",
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
     *        description = "教学目标",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "tags",
     *        description = "标签",
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


     /**
     * @SWG\Post(path="/campus/api/v1/courseware/create",
     *     tags={"400-Courseware-课件管理接口"},
     *     summary="创建课件",
     *     description="创建课件",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "Courseware[courseware_id]",
     *        description = "课件id",
     *        required = false,
     *        default = "0",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "Courseware[category_id]",
     *        description = "课件分类",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "Courseware[title]",
     *        description = "标题",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "Courseware[body]",
     *        description = "教学目标",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "tags",
     *        description = "标签 以逗号隔开",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "Courseware[status]",
     *        description = "状态",
     *        required = false,
     *        default = "",
     *        type = "integer",
     *        enum = {10,20}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "FileStorageItem[0][school_id]",
     *        description = "学校id",
     *        required = false,
     *        default = "0",
     *        type = "integer",
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "FileStorageItem[0][grade_id]",
     *        description = "班级id",
     *        required = false,
     *        default = "0",
     *        type = "integer",
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "FileStorageItem[0][file_category_id]",
     *        description = "文件分类",
     *        required = true,
     *        default = "3",
     *        type = "integer",
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "FileStorageItem[0][type]",
     *        description = "文件类型",
     *        required = true,
     *        default = "",
     *        type = "string",
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "FileStorageItem[0][file_name]",
     *        description = "服务器保存的名称",
     *        required = true,
     *        default = "",
     *        type = "string",
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "FileStorageItem[0][original]",
     *        description = "文件的原始名",
     *        required = true,
     *        default = "",
     *        type = "string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回课件信息,FileStorageItem 是上传文件后七牛云返回的信息"
     *     ),
     * )
     *
    **/
    public function actionCreate()
    {
        $model = new  $this->modelClass;
        if($_POST){
            return  $model->AddCollection($_POST);
        }else{
            $this->serializer['errno' ]    = 400;                        
            $this->serializer['message']   =  "数据为空";
            return [];
        }

       
    }
}
