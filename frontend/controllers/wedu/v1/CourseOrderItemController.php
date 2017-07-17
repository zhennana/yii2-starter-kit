<?php
namespace frontend\controllers\wedu\v1;

use Yii;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use frontend\models\wedu\resources\CourseOrderItem;

class CourseOrderItemController extends \common\rest\Controller
{
    public $modelClass = 'frontend\models\wedu\resources\CourseOrderItem';
    /**
     * @var array
     */
    
    // $this->linksEnvelope => Link::serialize($pagination->getLinks(true)),
    // $this->metaEnvelope => [
    //     'totalCount' => $pagination->totalCount,
    //     'pageCount' => $pagination->getPageCount(),
    //     'currentPage' => $pagination->getPage() + 1,
    //     'perPage' => $pagination->getPageSize(),
    // ],
    public $serializer = [
        'class' => 'common\rest\Serializer',    // 返回格式数据化字段
        'collectionEnvelope' => 'result',       // 制定数据字段名称
        // 'errno' => 0,                           // 错误处理数字
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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

     /**
     * @SWG\Get(path="/course-order-item/index",
     *     tags={"WEDU-CourseOrderItem-课程订单展示"},
     *     summary="message",
     *     description="返回用户缴费情况",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回用户缴费列表"
     *     ),
     * )
     *
    **/
    /**
     * 课件订单展示
     */
    public function actionIndex(){
        if(!isset(Yii::$app->user->identity->id)){
            $this->serializer['errno']   = 300;
            $this->serializer['message'] = '请你先登录';
            return  [];
        }
        $model = new $this->modelClass;
        $data['detalis'] = $model::find()
            ->select(['total_course','presented_course','real_price','created_at'])
            ->where(
                [
                'user_id'=>Yii::$app->user->identity->id,
                'payment_status'=>CourseOrderItem::PAYMENT_STATUS_PAID,
                'status'        =>CourseOrderItem::STATUS_VALID
                ])
            ->orderBy(['created_at'=>'SORT_DESC'])
            ->asArray()
            ->all();
           // var_dump($data);exit;
        foreach ($data['detalis'] as $key => $value) {
            $data['detalis'][$key]['total_course'] ='总共'.(int)$value['total_course'].'节课';
            $data['detalis'][$key]['presented_course'] = '赠送'.(int)$value['presented_course'].'节课';
            $data['detalis'][$key]['real_price'] = (int)$value['real_price'];
            $data['detalis'][$key]['created_at'] =$value['created_at'];

        }
        $data['statistical'] = $model->statistical();
        return $data;
    }
}