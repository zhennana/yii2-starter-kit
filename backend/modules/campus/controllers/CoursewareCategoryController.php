<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/49eb2de82346bc30092f584268252ed2
 *
 * @package default
 */


namespace backend\modules\campus\controllers;

/**
 * This is the class for controller "CoursewareCategoryController".
 */
class CoursewareCategoryController extends \backend\modules\campus\controllers\base\CoursewareCategoryController
{	
	public function actions(){
	 return [
            // 七牛云
            'token-cloud' => [//得到上传token
                'class' => 'common\actions\QiniuCoursewareCategoryAction',
                'type' => 'token'
            ],
            // 'upload-cloud' => [//上传
            //     'class' => 'common\actions\QiniuCoursewareCategoryAction',
            //     'type' => 'upload',
            // ],
            'delete-cloud'=>[
             	'class' =>'common\actions\QiniuCoursewareCategoryAction',
            	'type'=>'delete',
             ],
            // 'privacy' => [//是否公开delete
            //     'class' => 'common\actions\QiniuCoursewareCategoryAction',
            //     'type' => 'privacy'
            // ],
        ];
    }
}
