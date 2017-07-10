<?php

namespace backend\modules\campus\controllers;
use kartik\mpdf\Pdf;


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
        $domain =  \Yii::$app->params['qiniu']['wakooedu']['domain'];
        if(!isset($_GET['files'])){
            $_GET['files'] = '';
        }
       return $this->render('_picture',['files'=>$domain.'/'.$_GET['files']]);
    }
}