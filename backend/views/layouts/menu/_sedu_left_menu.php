<?php
// use Yii;
use common\models\TimelineEvent;
use yii\helpers\Html;
use yii\helpers\Url;
    return [
//总部
            [
                'label'=>Yii::t('backend', 'Timeline'),
                'icon'=>'<i class="fa fa-bar-chart-o"></i>',
                'url'=>['/timeline-event/index'],
                  'visible'=>(
                    Yii::$app->user->can('manager') ||
                    Yii::$app->user->can('E_manager')),
                'badge'=> TimelineEvent::find()->today()->count(),
                'badgeBgClass'=>'label-success',
            ],
            [
                'label'=>Yii::t('backend', '总部(校企)'),
                'options' => ['class' => 'header'],
                'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
            ],
            [
                    'label'=>Yii::t('backend', '网站内容管理'),
                    'url' => '#',
                    'icon'=>'<i class="fa fa-edit"></i>',
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager')),
                    'options'=>['class'=>'treeview'],
                    'items'=>[
                        ['label'=>Yii::t('backend', '文章'), 'url'=>['/article/index','type'=>1], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                        ['label'=>Yii::t('backend', '轮播组件'), 'url'=>['/widget-carousel/index','type'=>1], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                        ['label'=>Yii::t('backend', 'Cache'), 'url'=>['/cache/index','type'=>1], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                        ]
            ],
            [
                'label'=>Yii::t('backend', '课件管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-edit"></i>',
                  'visible'=>(
                     Yii::$app->user->can('manager') ||
                     Yii::$app->user->can('E_manager')),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                    'label'=>Yii::t('backend', '课件管理'), 
                    'url'=>['/campus/courseware/index','type'=>1],
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),

                     'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],
                    ['label'=>Yii::t('backend', '课件附件'), 
                    'url'=>['/campus/courseware-to-file/index'],
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                     'icon'=>'<i class="fa fa-angle-double-right"></i>'
                    ],
                    ['label'=>Yii::t('backend', '课件分类'),
                     'url'=>['/campus/courseware-category/index',], 
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),

                     'icon'=>'<i class=" fa  fa-file-text"></i>'
                    ],
                    ['label'=>Yii::t('backend', '课件关系'),
                     'url'=>['/campus/courseware-to-courseware/index'], 
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),

                     'icon'=>'<i class=" fa  fa-file-text"></i>'
                    ],
                    ['label'=>Yii::t('backend', '附件管理'),
                    'url'=>['/campus/file-storage-item/index'],
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                     'icon'=>'<i class=" fa  fa-file-text"></i>'
                    ],
            ],
                ],
            /*
            [
                'label'=>Yii::t('backend', '班级管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-edit"></i>',
                'options'=>['class'=>'treeview'],
                'items'=>[
                    ['label'=>Yii::t('backend', '学生管理'), 'url'=>['/campus/apply-to-play/index'], 'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],
                    ['label'=>Yii::t('backend', '学员档案管理'), 'url'=>['/campus/contact/index'], 'icon'=>'<i class=" fa  fa-file-text"></i>'
                    ],

                ]
            ],
            */
           /*
            [
                'label'=>Yii::t('backend', '通知管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-edit"></i>',
                'options'=>['class'=>'treeview'],
                'items'=>[
                    ['label'=>Yii::t('backend', '通知列表'), 'url'=>['/campus/apply-to-play/index'], 'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],
                ]
            ],
            [
                'label'=>Yii::t('backend', '微信管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-edit"></i>',
                'options'=>['class'=>'treeview'],
                'items'=>[
                    ['label'=>Yii::t('backend', '粉丝列表'), 'url'=>['/campus/apply-to-play/index'], 'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],
                ]
            ],
            */
            [
                'label'=>Yii::t('backend', '教务管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-university"></i>',
                'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                        'label'   =>Yii::t('backend', '学校管理'), 
                        'url'     =>['/campus/school/index','type'=>1],
                        'icon'    =>'<i class="fa fa-angle-double-right"></i>',
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                    ],
                    [
                        'label'=>Yii::t('backend', '班级分类管理'),
                        'url'=>['/campus/grade-category/index','type'=>1],
                        'icon'=>'<i class="fa fa-angle-double-right"></i>',
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                    ],
                ]
            ],
            [
                'label'=>Yii::t('backend', '通知公告管理'),
                'url' => '#',
                'icon'=>'<i class="fa  fa-volume-up"></i>',
                'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager')),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                        'label'=>Yii::t('backend', '预约信息'), 
                        'url'=>['/campus/apply-to-play/index','type'=>1], 
                        'icon'=>'<i class="fa  fa-file-text"></i>',
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                    ],
                    [
                    'label'=>Yii::t('backend', '联系我们'), 
                    'url'=>['/campus/contact/index'], 
                    'icon'=>'<i class=" fa  fa-file-text"></i>',
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),

                    ],
                ],
            ],
            [
                'label'=>Yii::t('backend', '用户管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-users"></i>',
                'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                        'label'=>Yii::t('backend', '用户管理'),
                        'icon'=>'<i class="fa fa-database"></i>',
                        'options'=>['class'=>'treeview'],
                        'url'=>['/campus/user/index'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager')),
                        //'badge'=> TimelineEvent::find()->today()->count(),
                        //'badgeBgClass'=>'label-success',
                    ],
                    [
                        'label'=>Yii::t('backend', '学校人员管理'),
                        'icon'=>'<i class="fa fa-database"></i>',
                        'options'=>['class'=>'treeview'],
                        'url'=>['/campus/user-to-school/index','type'=>'100'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') ),
                        //'badge'=> TimelineEvent::find()->today()->count(),
                        //'badgeBgClass'=>'label-success',
                    ],
                    [
                        'label'=>Yii::t('backend', '激活码'),
                        'icon'=>'<i class="fa fa-database"></i>',
                        'options'=>['class'=>'treeview'],
                        'url'=>['/campus/activation-code/index','type'=>'100'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager')),
                        //'badge'=> TimelineEvent::find()->today()->count(),
                        //'badgeBgClass'=>'label-success',
                    ],
                /*    [
                        'label'=>Yii::t('backend', '账号关联管理'),
                        'icon'=>'<i class="fa fa-database"></i>',
                        'options'=>['class'=>'treeview'],
                        'url'=>['/campus/users-to-users/index','type'=>'100'],
                        'visible'=>(Yii::$app->user->can('manager') || env('THEME') == 'gedu' ),
                        //'badge'=> TimelineEvent::find()->today()->count(),
                        //'badgeBgClass'=>'label-success',
                    ],
                */
                ]
            ],
//代理
            [
                'label'=>Yii::t('backend', '分部(代理)'),
                'options' => ['class' => 'header'],
                'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher') || Yii::$app->user->can('E_financial') || Yii::$app->user->can('P_financial')),
            ],
            [
                'label'=>Yii::t('backend', '教务管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-university"></i>',
                'visible'=>(Yii::$app->user->can('manager')     ||
                            Yii::$app->user->can('E_manager')   ||
                            Yii::$app->user->can('P_financial') ||
                            Yii::$app->user->can('E_financial') ||
                            Yii::$app->user->can('P_teacher')
                            ),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                        'label'   =>Yii::t('backend', '学校管理'), 
                        'url'     =>['/campus/school/index','type'=>2],
                        'icon'    =>'<i class="fa fa-angle-double-right"></i>',
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                    ],
                    [
                        'label'=>Yii::t('backend', '班级分类管理'),
                        'url'=>['/campus/grade-category/index','type'=>2],
                        'icon'=>'<i class="fa fa-angle-double-right"></i>',
                         'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                    ],
                    [
                        'label'=>Yii::t('backend', '班级管理'),
                         'url'=>['/campus/grade/index'],
                         'icon'=>'<i class="fa fa-angle-double-right"></i>',
                          'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),

                    ],
                    [
                        'label'=>Yii::t('backend', '班级人员管理'),
                        'url'=>['/campus/user-to-grade/index'],
                        'icon'=>'<i class="fa fa-angle-double-right"></i>',
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
                    ],
                    [
                        'label'=>Yii::t('backend', '学员档案管理'),
                        'url'=>['/campus/student-record/index'],
                        'icon'=>'<i class="fa fa-angle-double-right"></i>',
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
                    ],
                    [
                        'label'=>Yii::t('backend', '课程订单管理'),
                        'url'=>['/campus/course-order-item/index','type'=>2], 'icon'=>'<i class=" fa  fa-file-text"></i>',
                         'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_financial') || Yii::$app->user->can('P_financial')),
                    ],

                    [
                        'label'=>Yii::t('backend', '教师工作记录'), 
                        'url'=>['/campus/work-record/index'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
                        'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],

                ],
            ],

            [
                'label'=>Yii::t('backend', '课件管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-edit"></i>',
                  'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                    'label'=>Yii::t('backend', '课件管理'), 
                    'url'=>['/campus/courseware/index','type'=>2],
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager')|| Yii::$app->user->can('P_director')),

                     'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],
                ],
            ],
          /*  [
                'label'=>Yii::t('backend', '课程管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-mortar-board"></i>',
                'options'=>['class'=>'treeview'],
                'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                'items'=>[
                    [
                    'label'=>Yii::t('backend', '课程分类管理'), 
                    'url'=>['/campus/course-category/index'], 
                     'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
                    'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],
                    [
                    'label'=>Yii::t('backend', '课程管理'), 
                    'url'=>['/campus/course/index'], 
                     'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
                    'icon'=>'<i class="fa  fa-file-text"></i>'
                    ], 
                ]
            ],*/
            [
                'label'=>Yii::t('backend', '排课管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-edit"></i>',
                  'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                    'label'=>Yii::t('backend', '排课管理'), 
                    'url'=>['/campus/course-schedule/index','type'=>2],
                    'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager')|| Yii::$app->user->can('P_teacher')),

                     'icon'=>'<i class="fa  fa-file-text"></i>'
                    ],
                    [
                    'label'=>Yii::t('backend', '签到管理'), 
                    'url'=>['/campus/sign-in/index'],
                     'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),

                     'icon'=>'<i class=" fa  fa-file-text"></i>'
                    ],
                ],
            ],
            [
                'label'=>Yii::t('backend', '通知公告管理'),
                'url' => '#',
                'icon'=>'<i class="fa  fa-volume-up"></i>',
                'visible'=>(Yii::$app->user->can('P_teacher') ||
                    Yii::$app->user->can('E_manager') ||
                    Yii::$app->user->can('manager')
                    ),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                        'label'=>Yii::t('backend', '学校公告'),
                        'url'=>['/campus/notice/school-notice'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_manager')),

                        'icon'=>'<i class=" fa  fa-volume-up"></i>'
                    ],

                    [
                        'label'=>Yii::t('backend', '教师公告'), 
                        'url'=>['/campus/notice/teacher-notice'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                        'icon'=>'<i class=" fa  fa-volume-up"></i>'
                    ],

                    [
                        'label'=>Yii::t('backend', '班级公告'),
                        'url'=>['/campus/notice/grade-notice'], 
                        'visible'=>Yii::$app->user->can('manager'),


                        'icon'=>'<i class=" fa  fa-volume-up"></i>'
                    ],
                    [
                        'label'=>Yii::t('backend', '家校沟通'),
                         'url'=>['/campus/notice/family-school-notice'],
                         'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
                         'icon'=>'<i class=" fa  fa-volume-up"></i>'
                    ],
                    [
                        'label'=>Yii::t('backend', '个推列表'),
                         'url'=>['/campus/notice/a-push'],
                         'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                         'icon'=>'<i class=" fa  fa-volume-up"></i>'
                    ],
                    [
                        'label'=>Yii::t('backend', '发布分享消息'), 
                        'url'=>['/campus/share-stream/index'], 
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),

                        'icon'=>'<i class=" fa  fa-volume-up"></i>'
                    ],
                    [
                        'label'=>Yii::t('backend', '预约信息'), 
                        'url'=>['/campus/apply-to-play/index','type'=>2], 
                        'icon'=>'<i class="fa  fa-file-text"></i>',
                         'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),

                    ],
                ],
            ],
            [
                'label'=>Yii::t('backend', '校园人员管理'),
                'url' => '#',
                'icon'=>'<i class="fa fa-users"></i>',
               'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                'options'=>['class'=>'treeview'],
                'items'=>[
                    [
                        'label'=>Yii::t('backend', '校园人员管理'),
                        'icon'=>'<i class="fa fa-database"></i>',
                        'options'=>['class'=>'treeview'],
                        'url'=>['/campus/user-to-school/index','type'=>'200'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),

                        //'badge'=> TimelineEvent::find()->today()->count(),
                        //'badgeBgClass'=>'label-success',
                    ],
                    [
                        'label'=>Yii::t('backend', '激活码'),
                        'icon'=>'<i class="fa fa-database"></i>',
                        'options'=>['class'=>'treeview'],
                        'url'=>['/campus/activation-code/index','type'=>'200'],
                        'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_financial') || Yii::$app->user->can('P_financial')),
                        //'badge'=> TimelineEvent::find()->today()->count(),
                        //'badgeBgClass'=>'label-success',
                    ],
                  /*  [
                        'label'=>Yii::t('backend', '账号关联管理'),
                        'icon'=>'<i class="fa fa-database"></i>',
                        'options'=>['class'=>'treeview'],
                        'url'=>['/campus/users-to-users/index','type'=>'200'],
                        'visible'=>(Yii::$app->user->can('manager') || env('THEME') == 'gedu'),
                        //'badge'=> TimelineEvent::find()->today()->count(),
                        //'badgeBgClass'=>'label-success',
                    ],*/
                ]
            ],
    ];
?>