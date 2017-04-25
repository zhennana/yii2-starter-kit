<?php

namespace backend\modules\campus\controllers\api\v1;

/**
* This is the class for REST controller "UserToGradeController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\search\UserToGradeSearch;
class UserToGradeController extends \yii\rest\ActiveController
{
    public $modelClass = 'backend\modules\campus\models\UserToGrade';
    /**
    * @inheritdoc
    */
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
     * @SWG\Get(path="/campus/api/v1/user-to-grade/index",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="查询所有班级学员",
     *     description="返回用户学员管理",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *      in = "query",
     *      name = "user_to_grade_id",
     *      description = "id",
     *      required    = false,
     *      type        = "integer"
     *      
     *      ),
     * @SWG\Parameter(
     *      in = "query",
     *      name = "user_id",
     *      description = "用户id",
     *      required    = false,
     *      type        = "integer"
     *      ),  
     *         
     * @SWG\Parameter(
     *      in ="query",
     *      name = "school_id",
     *      description = "学校id",
     *      required    = false,
     *      type        = "integer"
     *      ),         
     * @SWG\Parameter(
     *      in = "query",
     *      name = "grade_id",
     *      description = "班级id",
     *      required    = false,
     *      type        = "integer"
     *      ), 
     * @SWG\Parameter(
     *      in = "query",
     *      name = "user_title_id_at_grade",
     *      description = "用户在班级的描述性展示行",
     *      required    = false,
     *      type        = "integer"
     *      ), 
     * @SWG\Parameter(
     *      in="query",
     *      name = "statuse",
     *      description = "状态 1:正常;0:删除;3已转办；4已退休",
     *      required    = false,
     *      type        = "integer",
     *      enum        = {0,1}
     *      ), 
     *
     * @SWG\Response(
     *         response = 200,
     *         description = "返回用户学员管理"
     *     ),
     * )
     *
    **/
    public function actionIndex(){
        $searchModel = new UserToGradeSearch;
        $searchModel->load(\yii::$app->request->queryParams,'');
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $dataProvider;
    }

    /**
     * @SWG\Get(path="/campus/api/v1/user-to-grade/view",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="班级学员关系表创建",
     *     description="返回用户学员管理",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *      in = "query",
     *      name = "id",
     *      description = "id",
     *      required    = true,
     *      type        = "integer"
     *      
     *      ),
     * @SWG\Response(
     *         response = 200,
     *         description = "返回用户学员管理"
     *     ),
     * )
     *
    **/
  
    /**
     * @SWG\Post(path="/campus/api/v1/user-to-grade/create",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="创建班级学员关系表",
     *     description="返回班级学员",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *      in = "formData",
     *      name = "user_id[]",
     *      description = "用户id",
     *      required    = true,
     *      type        = "integer"
     *      ),  
     *         
     * @SWG\Parameter(
     *      in ="formData",
     *      name = "school_id",
     *      description = "学校id",
     *      required    = true,
     *      type        = "integer"
     *      ),         
     * @SWG\Parameter(
     *      in = "formData",
     *      name = "grade_id",
     *      description = "班级id",
     *      required    = true,
     *      type        = "integer"
     *      ), 
     * @SWG\Parameter(
     *      in = "formData",
     *      name = "user_title_id_at_grade",
     *      description = "用户在班级的描述性展示行",
     *      required    = true,
     *      type        = "integer"
     *      ), 
     * @SWG\Parameter(
     *      in="formData",
     *      name = "grade_user_type",
     *      description = "状态 10:老师;20：家长",
     *      required    = true,
     *      default     = 10,
     *      type        = "integer",
     *      enum        = {10,20}
     *      ), 
     * @SWG\Parameter(
     *      in="formData",
     *      name = "status",
     *      description = "状态 1:正常;0:删除;3已转办；4已退休",
     *      required    = true,
     *      default     = 1,
     *      type        = "integer",
     *      enum        = {0,1,3,4}
     *      ), 
     *
     * @SWG\Response(
     *         response = 200,
     *         description = "返回用户学员管理"
     *     ),
     * )
     *
    **/
    public function actionCreate()
    {
        $model = new $this->modelClass;
        if($_POST){
            $info = $model->batch_create($_POST);
            if(isset($info['error'])){
                $this->serializer['message'] = $info['error'];
            }
            return $info['message'];
        }
        $this->serializer['errno']   = 400; 
        $this->serializer['message'] = "数据不能为空";
        return [];
    }


    /**
     * @SWG\Post(path="/campus/api/v1/user-to-grade/update?id=9",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="修改班级学员关系表",
     *     description="修改班级学员关系表",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *      in = "formData",
     *      name = "user_id",
     *      description = "用户id",
     *      required    = true,
     *      type        = "integer"
     *      ),  
     *         
     * @SWG\Parameter(
     *      in ="formData",
     *      name = "school_id",
     *      description = "学校id",
     *      required    = true,
     *      type        = "integer"
     *      ),         
     * @SWG\Parameter(
     *      in = "formData",
     *      name = "grade_id",
     *      description = "班级id",
     *      required    = true,
     *      type        = "integer"
     *      ), 
     * @SWG\Parameter(
     *      in = "formData",
     *      name = "user_title_id_at_grade",
     *      description = "用户在班级的描述性展示行",
     *      required    = true,
     *      type        = "integer"
     *      ), 
     * @SWG\Parameter(
     *      in="formData",
     *      name = "grade_user_type",
     *      description = "状态 10:老师;20：家长",
     *      required    = true,
     *      default     = 10,
     *      type        = "integer",
     *      enum        = {10,20}
     *      ), 
     * @SWG\Parameter(
     *      in="formData",
     *      name = "status",
     *      description = "状态 1:正常;0:删除;3已转办；4已退休",
     *      required    = true,
     *      default     = 1,
     *      type        = "integer",
     *      enum        = {0,1,3,4}
     *      ), 
     *
     * @SWG\Response(
     *         response = 200,
     *         description = "返回用户学员管理"
     *     ),
     * )
     *
    **/
}
