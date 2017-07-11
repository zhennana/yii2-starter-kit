<?php

namespace backend\modules\campus\controllers;
use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\BucketManager; 
use common\components\Qiniu\Processing\PersistentFop;

/**
* This is the class for controller "CoursewareController".
*/
class CoursewareController extends \backend\modules\campus\controllers\base\CoursewareController
{
	public function actions()
    {
    	
        return [
            // 七牛云
            'token-cloud' => [//得到上传token
                'class' => 'common\actions\QiniuCoursewareAction',
                'type' => 'token'
            ],
            'upload-cloud' => [//上传
                'class' => 'common\actions\QiniuCoursewareAction',
                'type' => 'upload',
            ],
            'delete-cloud'=>[
             	'class' =>'common\actions\QiniuCoursewareAction',
            	'type'=>'delete',
             ],
            'privacy' => [//是否公开delete
                'class' => 'common\actions\QiniuCoursewareAction',
                'type' => 'privacy'
            ],
        ];
    }

    public function actionPdf(){
        $this->layout = false;
        return   $this->render('_PDF');
    }

    public function actionPicture(){
       // $this->layout = false;
        $domain =  \Yii::$app->params['qiniu']['wakooedu']['domain'];
        if(!isset($_GET['files'])){
            $_GET['files'] = '';
        }
       return $this->render('_picture',['files'=>$domain.'/'.$_GET['files']]);
    }

    public function actionVideo(){
        $domain =  \Yii::$app->params['qiniu']['wakooedu']['domain'];
            if(!isset($_GET['files'])){
                $_GET['files'] = '';
            }
        return $this->render('_video',['files'=>$domain.'/'.$_GET['files']]);

        //$bucket = 'wakooedu';
        //$key = 'o_1bil7rau811nngqouui1b6gqr69.mp4';
        //七牛上传水印接口调用
        // $auth = new Auth(\Yii::$app->params['qiniu']['wakooedu']['access_key'], \Yii::$app->params['qiniu']['wakooedu']['secret_key']);
        // $wmImg = base64_encode('http://static.v1.wakooedu.com/o_1bd34mv4dngusr61u9h1ajir6j9.png');
        // $vmText = base64_encode('第一次水印');
        // $encodeFont = base64_encode('宋体');
        // $color      = base64_encode('red');
        // //添加水印
        // $pfopOps = "avthumb/mp4/wmImage/$wmImg/wmText/$vmText/cmVk/wmFontSize/60/wmGravityText/North";
         //"wmText/$wmImg/wmFont/$encodeFont/wmFontColor/$color/wmFontSize/100";
        //var_dump($pfopOps);exit;
        // $policy = array(
        //     'persistentOps' => $pfopOps,
        // );
        //$pipeline = 'abc';
        //var_dump($pfopOps);exit;
       // $pfop = new PersistentFop($auth, $bucket);
       // var_dump($pfop);exit;
        // list($id, $err) = $pfop->execute($key, $pfopOps);
        // if($err != null) {
        //     var_dump('<pre>',$err);
        // } else {
        //     //z1.5964313b8a3c0c3794c8042f 
        //     echo "PersistentFop Id: $id\n";
        // }
// zf2rZtPIWa3Tb3OiG5iSFvLijlE=/lsmsODafREY6mPYb2o64VWkdd383
//zf2rZtPIWa3Tb3OiG5iSFvLijlE=/lsmsODafREY6mPYb2o64VWkdd383
        // list($ret, $err) = $pfop->status('z1.59645c248a3c0c3794c920eb');
        //      // echo "\n====> pfop avthumb status: \n";
        //       if ($err != null) {
        //           var_dump($err);
        //       } else {
        //           var_dump('zheng','<pre>',$ret);
        //       }
            //  o_1bil7rau811nngqouui1b6gqr69.mp4

        //  exit;*/
       // $upToken = $auth->uploadToken($bucket, null, 3600, $policy);
       // var_dump($upToken);
       //var_dump($upToken);exit;
    }
}