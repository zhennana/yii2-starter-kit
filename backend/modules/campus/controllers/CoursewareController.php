<?php

namespace backend\modules\campus\controllers;



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
}