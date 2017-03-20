<?php
/**
 * 前台控制器基类
 */
namespace common\components;
use Yii;
use yii\log\FileTarget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\wechat\Wechat;
use common\models\wechat\WechatFans;
use common\models\wechat\WechatFansMp;

class ControllerFrontendApi extends \yii\rest\ActiveController
{
    

    public function init() {
        parent::init();
        \Yii::$app->language = 'zh-CN';
    }
    /*
    public function beforeAction($action)
    {
        $result = parent::beforeAction($action);
        
        
        
        // your custom code here
        return true; // or false to not run the action
    }

     public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return $result;

    }
    */
}
