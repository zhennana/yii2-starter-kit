<?php

namespace common\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

/**
 * Class OwnModelAccessFilter
 * @author Eugene Terentev <eugene@terentev.net>
 */
class OneFilter extends ActionFilter
{

    private $_startTime;

    public function beforeAction($action)
    {
        $this->_startTime = microtime(true);
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $time = microtime(true) - $this->_startTime;
        Yii::trace("Action '{$action->uniqueId}' spent $time second.");
        return parent::afterAction($action, $result);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws ForbiddenHttpException
     */
    /*
    public function beforeAction($action)
    {
        echo 'aaaaaa'; exit();
        if(!parent::beforeAction($action)) {  
            return false;  
        } 

        $actionID = $action->id;  
        if(!Yii::$app->user->isGuest && $actionID != 'logout')  
        {  
            $id = Yii::$app->user->id;  
            $session = Yii::$app->session;  
            $username = Yii::$app->user->identity->username;  
            $udid_now = \Yii::$app->session->set('user.udid',$udid);

            $session_data  = new yii\web\DbSession();
            $data = $session_data->db->createCommand("select * from {$session->sessionTable} where user_id = ".$id);

            $tokenTBL = $sessionTBL->session_token;  

            if($udid_now != $tokenTBL)  //如果用户登录在 session中token不同于数据表中token  
            {  
                Yii::$app->user->logout(); //执行登出操作  
                Yii::$app->run();  

            }  
        }
        return true; 
    }
*/


}
