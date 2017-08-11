<?php
namespace common\components\APush;
header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.AppMessage.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/' . 'igetui/template/IGt.BaseTemplate.php');
require_once(dirname(__FILE__) . '/' . 'IGt.Batch.php');
require_once(dirname(__FILE__) . '/' . 'igetui/utils/AppConditions.php');
define('APPKEY',env('GETUI_APP_KEY'));
define('APPID',env('GETUI_APP_ID'));
define('MASTERSECRET',env('GETUI_MASTERSECRET'));
define('HOST',env('GETUI_HOST'));
//var_dump(\Yii::$app->user->identity->id);exit;
class APush {
    // 批量单推
    // $data 数据结构是
    // $data =[
    //          [
    //           'client_source_type' =>'',
    //            'cid'                 =>'',
    //            'message'            =>
    //            [
    //             'title' =>'',
    //             'body'  =>'',
    //            ],
    //          ]
    //          ]
    // ;
  public  function  pushMessageToSingleBatch($data)
    {
        //var_dump($this->a);exit;
            putenv("gexin_pushSingleBatch_needAsync=false");
        //var_dump('<pre>',$data);exit;
            $igt = new \IGeTui(HOST, APPKEY, MASTERSECRET);
            $batch = new \IGtBatch(APPKEY, $igt);
            $batch->setApiUrl(HOST);
            //通知弹框下载功能模板
            //$template = IGtNotyPopLoadTemplateDemo();

            //通知打开链接功能模板
            //$templateLink = IGtLinkTemplateDemo();

            //通知透传功能模板
            //$templateNoti = IGtNotificationTemplateDemo();

            //透传功能模板
            //$template = IGtTransmissionTemplateDemo($data);

            foreach ($data as $key => $value) {

                if($value['client_source_type'] == 10){
                    //安卓 通知透传模板
                    $template = $this->IGtNotificationTemplateDemo($value['message']);
                }else{
                    //ios  透传模板
                    $template = $this->IGtTransmissionTemplateDemo($value['message']);
                }

                //个推信息体
                $messageLink = new \IGtSingleMessage();
                $messageLink->set_isOffline(true);//是否离线
                $messageLink->set_offlineExpireTime(12 * 1000 * 3600);//离线时间
                $messageLink->set_data($template);//设置推送消息类型
                $messageLink->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送

                $targetLink = new \IGtTarget();
                $targetLink->set_appId(APPID);
                $targetLink->set_clientId($value['cid']);
                $batch->add($messageLink, $targetLink);
            }
            try {
                $rep = $batch->submit();
                //var_dump($rep);
            }catch(Exception $e){
                $rep=$batch->retry();
                //var_dump($rep);
            }
        }

        //推送任务停止
       public function stoptask(){

            $igt = new \IGeTui(HOST,APPKEY,MASTERSECRET);
            $igt->stop("OSA-0416_n0Oad0AmYq5O4aZ0oyBAt3");
        }

       public function getPushMessageResultDemo(){



            $igt = new \IGeTui(HOST,APPKEY,MASTERSECRET);

        //    $ret = $igt->getPushResult("OSA-0522_QZ7nHpBlxF6vrxGaLb1FA3");
        //    var_dump($ret);

        //    $ret = $igt->queryAppUserDataByDate(APPID,"20140807");
        //    var_dump($ret);
            $time = date("Ymd");
            //var_dump($time);exit;
            //$time = strtotime($time);
            $ret = $igt->queryAppPushDataByDate(APPID,$time);
            //var_dump('<pre>',$ret);
        }
        //
        //服务端推送接口，支持三个接口推送
        //1.PushMessageToSingle接口：支持对单个用户进行推送
        //2.PushMessageToList接口：支持对多个用户进行推送，建议为50个用户
        //3.pushMessageToApp接口：对单个应用下的所有用户进行推送，可根据省份，标签，机型过滤推送
        //


            //    $datas =[
            //         'type'=>2,//安卓调用
            //         'cid'  =>[
            //             'd88e7106e22aad23e38cfb1a6219b66e'
            //         ],
            //         'message'=>[
            //             'title'=>'安卓',
            //             'body' =>'老谢谢 你好啊'
            //         ],
            //    ];
            // $data2 =[
            //         'type'=>1,//ios调用
            //         'cid'  =>[
            //             '9d999e50541561113a6044ef78b2061d'
            //         ],
            //         'message'=>[
            //             'title'=>'ios',
            //             'body' =>'小鑫鑫你好啊'
            //         ],
            //    ];
        //多推接口案例
       public  function  pushMessageToList($data)
        {
            putenv("gexin_pushList_needDetails=true");
            putenv("gexin_pushList_needAsync=true");

            $igt = new \IGeTui(HOST, APPKEY, MASTERSECRET);
            if($data['client_source_type'] == 10){
                //安卓 通知透传模板
                $template = $this->IGtNotificationTemplateDemo($data['message']);
            }else{
                //ios  透传模板
                $template = $this->IGtTransmissionTemplateDemo($data['message']);
            }
            $message = new \IGtListMessage();
            $message->set_isOffline(true);//是否离线
            $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
            $message->set_data($template);//设置推送消息类型
            $message->set_PushNetWorkType(0); //设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
            $contentId = $igt->getContentId($message);

            foreach ($data['cid'] as $key => $value) {
               //接收方1
                $target = new \IGtTarget();
                $target->set_appId(APPID);
                $target->set_clientId($value);
                $targetList[] = $target;
            }
            $rep = $igt->pushMessageToList($contentId, $targetList);

            var_dump($rep);

            //echo ("<br><br>");

        }


        //单推接口案例
       public function pushMessageToSingle($data){

            if($data['client_source_type'] == 10){
                    //安卓 通知透传模板
                    $template = $this->IGtNotificationTemplateDemo($data['message']);
                }else{
                    //ios  透传模板
                    $template = $this->IGtTransmissionTemplateDemo($data['message']);
            }
            $igt = new \IGeTui(HOST,APPKEY,MASTERSECRET);
            //$template = \IGtTransmissionTemplateDemo();
            $message = new \IGtSingleMessage();

            $message->set_isOffline(true);//是否离线
            $message->set_offlineExpireTime(3600*12*1000);//离线时间
            $message->set_data($template);//设置推送消息类型
        //  $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
            //接收方
            $target = new \IGtTarget();
            $target->set_appId(APPID);
            $target->set_clientId($data['cid']);
        //$target->set_alias(Alias);


            try {
                $rep = $igt->pushMessageToSingle($message, $target);
                return $rep;
                // var_dump($rep);
                // echo ("<br><br>");

            }catch(RequestException $e){
               // $requstId =$e->getRequestId();
              //  $rep = $igt->pushMessageToSingle($message, $target,$requstId);
               // var_dump($rep);
               // echo ("<br><br>");
            }

        }

        //所有推送接口均支持四个消息模板，依次为通知弹框下载模板，通知链接模板，通知透传模板，透传模板
        //注：IOS离线推送需通过APN进行转发，需填写pushInfo字段，目前仅不支持通知弹框下载功能

       public function IGtNotyPopLoadTemplateDemo(){
            $template =  new \IGtNotyPopLoadTemplate();

            $template ->set_appId(APPID);//应用appid
            $template ->set_appkey(APPKEY);//应用appkey
            //通知栏
            $template ->set_notyTitle("个推");//通知栏标题
            $template ->set_notyContent("个推最新版点击下载");//通知栏内容
            $template ->set_notyIcon("");//通知栏logo
            $template ->set_isBelled(true);//是否响铃
            $template ->set_isVibrationed(true);//是否震动
            $template ->set_isCleared(true);//通知栏是否可清除
            //弹框
            $template ->set_popTitle("弹框标题");//弹框标题
            $template ->set_popContent("弹框内容");//弹框内容
            $template ->set_popImage("");//弹框图片
            $template ->set_popButton1("下载");//左键
            $template ->set_popButton2("取消");//右键
            //下载
            $template ->set_loadIcon("");//弹框图片
            $template ->set_loadTitle("地震速报下载");
            $template ->set_loadUrl("http://dizhensubao.igexin.com/dl/com.ceic.apk");
            $template ->set_isAutoInstall(false);
            $template ->set_isActived(true);
            //$template->set_notifyStyle(0);
            //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

            return $template;
        }

      public  function IGtLinkTemplateDemo(){
            $template =  new \IGtLinkTemplate();
            $template ->set_appId(APPID);//应用appid
            $template ->set_appkey(APPKEY);//应用appkey
            $template ->set_title("这是第一次安卓的");//通知栏标题
            $template ->set_text("这是第一次");//通知栏内容
            $template ->set_logo("");//通知栏logo
            $template ->set_isRing(true);//是否响铃
            $template ->set_isVibrate(true);//是否震动
            $template ->set_isClearable(true);//通知栏是否可清除
            $template ->set_url("http://www.baidu.com/");//打开连接地址
            //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
            return $template;
        }

        //安卓用通知模板透传
      public  function IGtNotificationTemplateDemo($data){
            $template =  new \IGtNotificationTemplate();
            $template->set_appId(APPID);//应用appid
            $template->set_appkey(APPKEY);//应用appkey
            $template->set_transmissionType(1);//透传消息类型
            $template->set_transmissionContent($data['body']);//透传内容
            $template->set_title($data['title']);//通知栏标题
            $template->set_text($data['body']);//通知栏内容
            $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
            $template->set_isRing(true);//是否响铃
            $template->set_isVibrate(true);//是否震动
            $template->set_isClearable(true);//通知栏是否可清除
            //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
            return $template;
        }
        //ios 用
      public  function IGtTransmissionTemplateDemo($data){
            $template =  new \IGtTransmissionTemplate();
            $template->set_appId(APPID);//应用appid
            $template->set_appkey(APPKEY);//应用appkey
            $template->set_transmissionType(2);//透传消息类型
            $template->set_transmissionContent("安卓弟弟");//透传内容
        //APN高级推送
            $apn = new \IGtAPNPayload();
            $alertmsg=new \DictionaryAlertMsg();
            $alertmsg->body=$data['body'];
            $alertmsg->actionLocKey="ActionLockey";
            $alertmsg->locKey="LocKey";
            $alertmsg->locArgs=array("locargs");
            $alertmsg->launchImage="launchimage";
        //IOS8.2 支持
            $alertmsg->title=$data['title'];
            $alertmsg->titleLocKey="TitleLocKey";
            $alertmsg->titleLocArgs=array("TitleLocArg");

            $apn->alertMsg=$alertmsg;
            $apn->badge=7;
            $apn->sound="";
            $apn->add_customMsg("payload","payload");
            $apn->contentAvailable=1;
            $apn->category="ACTIONABLE";
            $template->set_apnInfo($apn);

            return $template;
        }
}
?>

