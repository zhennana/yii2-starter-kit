<?php
namespace frontend\controllers\wedu\v1;

use Yii;
use yii\web\Response;
use yii\data\ActiveDataProvider;

class NoticeController extends \common\rest\Controller
{
     public $modelClass = 'frontend\models\wedu\resources\Notice'; 
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

   


    /**
     * @SWG\Get(path="/notice/index",
     *     tags={"WEDU-Notice-通知消息列表"},
     *     summary="message",
     *     description="返回通知消息",
     *     produces={"application/json"},
     *
     * @SWG\Parameter(
     *        in = "query",
     *        name = "type",
     *        description = "1消息通知 ；2老师对学生说的话， ",
     *        required = false,
     *        default = 1,
     *        type = "string"
     *     ),
     * @SWG\Parameter(
     *        in = "query",
     *        name = "school_id",
     *        description = "学校",
     *        required = false,
     *        default = 1,
     *        type = "integer"
     *     ),
     * @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "班级",
     *        required = false,
     *        default = 1,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "消息通知必须加学校 班级,type 传1,老师对学生说的话type传2 就好了"
     *     ),
     * )
     *
    **/

    /**
     *
     * @return [type]       [description]
     */
    public function actionIndex($type = 1,$school_id = NULL,$grade_id = NULL)
    {
        if(!isset(Yii::$app->user->identity->id)){
            $this->serializer['errno']   = 3;
            $this->serializer['message'] = '请登录';
            return [];
        }
        $model = new  $this->modelClass;
        $model = $model::find()->select(['message','created_at'])->where(['category'=>$type]);
        if($type == 2){
            $model->andWhere([
                'receiver_id'=>Yii::$app->user->identity->id
            ]);
        }else{
            $model->andWhere([
                'or',
                ['receiver_id'=>Yii::$app->user->identity->id],
                ['school_id'=> $school_id,'grade_id'=> 0,'receiver_id'=> NULL],
                ['school_id'=>$school_id , 'grade_id' => $grade_id ,'receiver_id'=>NULL],
            ]);
        }
        $model->orderBy(['created_at'=> SORT_DESC]);
        return new ActiveDataProvider(
                    [
                    'query'=>$model
                    ]);
    }
}