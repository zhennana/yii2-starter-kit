<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\helpers\Url;

use frontend\modules\api\v1\resources\Article;
use frontend\models\edu\resources\Course;
use frontend\models\edu\resources\UsersToUsers;
use frontend\models\edu\resources\Courseware;
use frontend\models\wedu\resources\Notice;

class MyController extends \common\rest\Controller
{
    /**
     * @var array
     */
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
     * @SWG\Get(path="/my/my-course",
     *     tags={"700-My-我的页面接口"},
     *     summary="我的课程",
     *     description="返回我的课程列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionMyCourse()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        return [];
    }

    /**
     * @SWG\Get(path="/my/my-notice",
     *     tags={"700-My-我的页面接口"},
     *     summary="我的消息",
     *     description="返回我的消息列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionMyNotice()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        $data  = [];
        $model = Notice::find()->where([
            'receiver_id' => Yii::$app->user->identity->id,
            'status_send' => Notice::STATUS_SEND_SENT
        ])->asArray()->all();

        if ($model) {
            foreach ($model as $key => $value) {
                $value['sender_name']   = Notice::getUserName($value['sender_id']);
                $value['receiver_name'] = Notice::getUserName($value['receiver_id']);
                $data[] = $value;
            }
        }

        return $data;
    }


}