<?php

namespace backend\modules\campus\controllers;



/**
* This is the class for controller "CoursewareController".
*/
class CoursewareController extends \backend\modules\campus\controllers\base\CoursewareController
{
	public function actions()
    {
    	//Yii::$app->cache->flush();
        // return [
        //     // 七牛云
        //     'token-cloud' => [//得到上传token
        //         'class' => 'common\actions\QiniuActions',
        //         'type' => 'token'
        //     ],
        //     'upload-cloud' => [//上传
        //         'class' => 'common\actions\QiniuActions',
        //         'type' => 'upload',
        //     ],
        //     'delete-cloud'=>[
        //      	'class' =>'common\actions\QiniuActions',
        //     	'type'=>'delete',
        //      ],
        //     'privacy' => [//是否公开delete
        //         'class' => 'common\actions\QiniuCoursewareAction',
        //         'type' => 'privacy'
        //     ],
        // ];
    }
}