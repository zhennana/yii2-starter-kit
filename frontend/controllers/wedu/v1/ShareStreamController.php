<?php
namespace frontend\controllers\wedu\v1;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use frontend\models\wedu\resources\ShareStream;
use backend\modules\campus\models\UserToGrade;
use yii\data\Pagination;

class ShareStreamController extends \common\rest\Controller
{
    /**
     * @var array
     */
    public $serializer = [
        'class' => 'common\rest\Serializer',    // 返回格式数据化字段
        'collectionEnvelope' => 'result',       // 制定数据字段名称
        'errno' => 0,                           // 错误处理数字
        'message' => 'OK',                      // 文本提示
    ];

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

    /**
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function afterAction($action, $result){
        $result = parent::afterAction($action, $result);

        return $result;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['crete']);
        return $actions;
    }

    public $modelClass = 'frontend\models\wedu\resources\ShareStream';
    /**
     * *
     * @return [type] [description]
     */
    

     /**
     * @SWG\Post(path="/share-stream/create",
     *     tags={"400-Share-Stream-分享"},
     *     summary="发布分享",
     *     description="分享",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "ShareStream[school_id]",
     *        description = "学校id",
     *        required = true,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "ShareStream[grade_id]",
     *        description = "班级ID",
     *        required = true,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "ShareStream[body]",
     *        description = "分享内容",
     *        required = true,
     *        default = "",
     *        type = "integer"
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
     *         description = "返回提交者信息"
     *     ),
     * )
     *
    **/
    public function actionCreate(){
        $model = new $this->modelClass; 
        return   $model->batch_create($_POST);
    }

    /**
     * @SWG\Get(path="/share-stream/index",
     *     tags={"400-Share-Stream-分享"},
     *     summary="分享列表展示",
     *     description="分享",
     *     produces={"application/json"},
     *  
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "school_id",
     *        description = "学校",
     *        required = true,
     *        default = "",
     *        type = "integer",
     *     ),
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "班级",
     *        required = true,
     *        default = "",
     *        type = "integer",
     *     ),
     *  @SWG\Response(
     *         response = 200,
     *         description = "返回分享列表"
     *     ),
     * )
    **/
    /**
     *
     * @param  boolean $school_id [description]
     * @param  boolean $grade_id  [description]
     * @return [type]             [description]
     */
    public function actionIndex($school_id = false ,$grade_id= false){
        if(!$school_id){
            $this->serializer['errno']   = '422';
            $this->serializer['message'] = '找不到你所在的学校或者班级';
            return [];
        }
        $models = new $this->modelClass;
        $sql = '';
        $sql .= "SELECT * FROM share_stream where ";
        $sql .= " (find_in_set($school_id,school_id) ";
        if($grade_id){
             $sql .= " and find_in_set($grade_id,grade_id) ";
        }
       
        $sql  .= ") or (school_id = 0 and grade_id = 0) ";
        $sql  .= " or (school_id = $school_id and grade_id = 0) ";
        // //var_dump($sql);exit;
        $models = $models::findBySql($sql);
        $pages = new Pagination(['totalCount' =>$models->count(), 'pageSize' => '1']);
        $models =  $models->offset($pages->offset)->limit($pages->limit)->all();
        $data['pages'] = $pages;
        return  ArrayHelper::merge($models,$data);
    }   
}