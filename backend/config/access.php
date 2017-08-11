<?php
/** 权限验证笔记
 * yii\filters\AccessRule::roles: 
 *      ? 匹配未验证用户，来宾
 *      @ 匹配身份验证用户
 * yii\filters\AccessRule::ips 匹配'192.168.*'
 * yii\filters\AccessRule::verbs: 指定请求方法。例如GET、POST
 *
 * Yii::$app->authManager
 **/
return [
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
           [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['error']
            ],
            [
                'controllers'=>['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers'=>['user'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers'=>['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['manager','E_manager'],
            ],
            [
                'controllers'=>['timeline-event'],
                'allow' => true,
                'roles' => ['administrator'],
                'actions'=>['index']
            ],
            //排课管理
            [
                'controllers'=>['campus/course'],
                'allow'=>true,
                'actions'=>['index','view','ajax-form'],
                'roles'=>['manager','P_teacher']
            ],
            [
                'controllers'=>['campus/course'],
                'allow'=>true,
                'actions'=>['create','update','course-batch','course-validations'],
                'roles'=>['manager','P_director','E_manager']
            ],
            [
                'controllers'=>['campus/course-schedule'],
                'allow'=>true,
                'actions'=>['index'],
                'roles'=>['manager','P_teacher','E_manager']
            ],
            //签到管理
            [
                'controllers'=>['campus/sign-in'],
                'allow'=>true,
                'actions'=>['create','update','index','view','ajax-form'],
                'roles'=>['manager','P_director']
            ],
            //课程体系管理
            [
                'controllers'=>['campus/courseware'],
                'allow'=>true,
                'actions'=>['index','view','ajax-form','pdf','picture','video'],
                'roles'=>['manager','P_teacher','E_manager']
            ],
            [
                'controllers'=>['campus/courseware','campus/courseware-to-file','campus/courseware-category','campus/courseware-to-courseware','campus/file-storage-item'],
                'allow'=>true,
                'actions'=>['create','update'],
                'roles'=>['manager']
            ],
            [
                'controllers'=>['campus/courseware','campus/courseware-to-file','campus/courseware-category','campus/courseware-to-courseware','campus/file-storage-item'],
                'allow'=>true,
                'actions'=>['index','view'],
                'roles'=>['P_teacher']
            ],

            //查看 学校 班级 人员档案
            [
                'controllers'=>['campus/school','campus/grade','campus/grade-category','campus/user-to-grade','campus/student-record'],
                'allow'=>true,
                'actions'=>['index','view','ajax-form'],
                'roles'=>['P_teacher']
            ],
            //创建修改学校
            [
                'controllers'=>['campus/grade','campus/user-to-grade'],
                'allow'=>true,
                'actions'=>['create','update'],
                'roles'=>['P_director']
            ],
            //班级创建学生档案
            [
                'controllers'=>['campus/student-record'],
                'allow'=>true,
                'actions'=>['create','update'],
                'roles'=>['P_teacher']
            ],
            //修改学校
            [
                'controllers'=>['campus/school','campus/grade-category'],
                'allow'=>true,
                //'actions'=>['create','update'],
                'roles'=>['manager']
            ],
            //查看 修改 订单管理
            [
                'controllers'=>['campus/course-order-item'],
                'allow'=>true,
                //'actions'=>['index','view','create','update'],
                'roles'=>['P_financial']
            ],
            //查看消息分享 学校通知 班级通知 教师通知 通知
            [
                'controllers'=>['campus/notice','campus/share-stream'],
                'allow'=>true,
                'actions'=>['index','ajax-form','school-notice','school-notice-create','teacher-notice','teacher-notice-create','create','update','view'],
                'roles'=>['P_director']
            ],
            //查看班级通知,家校沟通
            [
                'controllers'=>['campus/notice','campus/student-record-value'],
                'allow'=>true,
                'actions'=>['grade-notice','ajax-form','family-school-notice','family-school-notice-create','create-value','grade-notice-create','remove'],
                'roles'=>['P_teacher']
            ],
            //查看预约信息
            [
                'controllers'=>['campus/apply-to-play'],
                'allow'=>true,
                'actions'=>['index'],
                'roles'=>['P_director']
            ],
            //查看学校人员管理
            [
                'controllers'=>['campus/user-to-school'],
                'allow'=>true,
                //'actions'=>['index','user-to-school-form'],
                'roles'=>['P_director']
            ],
            //上传图片
            [
                'controllers'=>['campus/courseware-category'],
                'allow'=>true,
                //'actions'=>['index','user-to-school-form'],
                'roles'=>['P_teacher']
            ],

             //教师工作
            [
                'controllers'=>['campus/work-record'],
                'allow'=>true,
                'actions'=>['index'],
                'roles'=>['E_manager','manager','P_teacher']
            ],
            [
                'controllers'=>['campus/work-record'],
                'allow'=>true,
                'actions'=>['update'],
                'roles'=>['E_manager','manager','P_director']
            ],
        ]
    ];