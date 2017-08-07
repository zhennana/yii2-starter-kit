<?php
/**
 * @var $this yii\web\View
 */
use backend\assets\BackendAsset;
use backend\widgets\Menu;
use common\models\TimelineEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
$bundle = BackendAsset::register($this);

$avatar = '';
if(!Yii::$app->user->isGuest){
    $avatar = Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg'));
}else{
    $avatar = $this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg');
}

$avatar .= '?imageView2/3/w/215/h/215';
?>
<?php $this->beginContent('@backend/views/layouts/base.php'); ?>
    <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
            <a href="<?php echo Yii::getAlias('@frontendUrl') ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php echo Yii::$app->name ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?php echo Yii::t('backend', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div id="schools_select" class="col-xs-5 col-md-5" style="height: 50px; float:left;">
                                    <?php
                                        $form = ActiveForm::begin([
                                            'id'=>'schools_form'
                                        ]);
                                    ?>
                                    <?php
                                        echo Html::HiddenInput(
                                            'select_school_grade',
                                            1,
                                            ['id'=>'select_school_grade']
                                            );
                                        //this.from.submit()
                                        echo Html::dropDownList(
                                            'school_id',
                                            Yii::$app->user->identity->getCurrentSchoolId(),
                                            ArrayHelper::map(
                                                Yii::$app->user->identity->getSchoolsInfo(), //items
                                                'school_id', // select key
                                                'school_title'   // select value
                                            ),
                                            [
                                            'id'=>'school_id',
                                            'class'=>'col-xs-5 col-md-5',
                                            'onchange'=> 'this.form.submit()'
                                            ]);
                                    ?>
                                    <?php
                                        echo Html::dropDownList(
                                            'grade_id',
                                            Yii::$app->user->identity->getCurrentGradeId(),
                                            ArrayHelper::map(
                                                Yii::$app->user->identity->getGradesInfo(), //items
                                                'grade_id', 
                                                'grade_name'
                                            ),
                                            [
                                            'id'=>'grade_id',
                                            'class'=>'col-xs-5 col-md-5',
                                            'onchange'=>'this.form.submit()'
                                            ]);
                                    ?>
                                    <?php  ActiveForm::end();?>
                            </div> 
             
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                    
                    	<li id="timeline-notifications" class="notifications-menu">
                            <a href="<?php echo Yii::getAlias('@frontendUrl') ?>">
                                前台
                            </a>
                        </li>
                        <li id="timeline-notifications" class="notifications-menu">
                            <a href="<?php echo Yii::getAlias('@backendUrl') ?>">
                                后台
                            </a>
                        </li>
                        <li id="timeline-notifications" class="notifications-menu">
                            <a href="<?php echo Url::to(['/timeline-event/index']) ?>">
                                <i class="fa fa-bell"></i>
                                <span class="label label-success">
                                    <?php echo TimelineEvent::find()->today()->count() ?>
                                </span>
                            </a>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li id="log-dropdown" class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                            <span class="label label-danger">
                                <?php echo \backend\models\SystemLog::find()->count() ?>
                            </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php echo Yii::t('backend', 'You have {num} log items', ['num'=>\backend\models\SystemLog::find()->count()]) ?></li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach(\backend\models\SystemLog::find()->orderBy(['log_time'=>SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                            <li>
                                                <a href="<?php echo Yii::$app->urlManager->createUrl(['/log/view', 'id'=>$logEntry->id]) ?>">
                                                    <i class="fa fa-warning <?php echo $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                                    <?php echo $logEntry->category ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <?php echo Html::a(Yii::t('backend', 'View all'), ['/log/index']) ?>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo $avatar; ?>" class="user-image">
                                <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header light-blue">
                                    <img src="<?php echo $avatar; ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo Yii::$app->user->identity->username ?>
                                        <small>
                                            <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                        </small>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-left">
                                        <?php echo Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class'=>'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php echo Html::a('<i class="fa fa-cogs"></i>', ['/site/settings'])?>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo $avatar; ?>" class="img-circle" />
                    </div>
                    <div class="pull-left info">
                        <p><?php echo Yii::t('backend', 'Hello, {username}', ['username'=>Yii::$app->user->identity->getPublicIdentity()]) ?></p>
                        <a href="<?php echo Url::to(['/sign-in/profile']) ?>">
                            <i class="fa fa-circle text-success"></i>
                            <?php echo Yii::$app->formatter->asDatetime(time()) ?>
                        </a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?php echo Menu::widget([
                    'options'=>['class'=>'sidebar-menu'],
                    'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                    'submenuTemplate'=>"\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                    'activateParents'=>true,
                    'items'=>[
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
                                /*
                                ['label'=>Yii::t('backend', '课件管理'), 'url'=>['/campus/courseware/index'], 'icon'=>'<i class="fa  fa-file-text"></i>'
                                ],
                                */
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
                        [
                            'label'=>Yii::t('backend', '课程管理'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-mortar-board"></i>',
                            'options'=>['class'=>'treeview'],
                            'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
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
                                [
                                'label'=>Yii::t('backend', '签到管理'), 
                                'url'=>['/campus/sign-in/index'],
                                 'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),

                                 'icon'=>'<i class=" fa  fa-file-text"></i>'
                                ],
                            ]
                        ],
                        [
                            'label'=>Yii::t('backend', '排课管理'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-edit"></i>',
                              'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')),
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                'label'=>Yii::t('backend', '排课管理'), 
                                'url'=>['/campus/course-schedule/index','type'=>2],
                                'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager')|| Yii::$app->user->can('P_director')),

                                 'icon'=>'<i class="fa  fa-file-text"></i>'
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
                                     'visible'=>(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_teacher')),
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
                            ]
                        ],
//系统
                        [
                            'label'=>Yii::t('backend', 'System'),
                            'options' => ['class' => 'header'],
                            'visible'=>  Yii::$app->user->can('administrator'),
                        ],
                        [
                            'label'=>Yii::t('backend', '用户管理'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-users"></i>',
                            'visible'=>  Yii::$app->user->can('administrator'),
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', '用户管理'),
                                    'icon'=>'<i class="fa fa-database"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'url'=>['/user/index'],
                                    'visible'=> Yii::$app->user->can('administrator')
                                    //'badge'=> TimelineEvent::find()->today()->count(),
                                    //'badgeBgClass'=>'label-success',
                                ],
                                [
                                    'label'=>Yii::t('backend', '验证码管理'),
                                    'icon'=>'<i class="fa fa-hand-o-right"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'url'=>['/user-token/index'],
                                    'visible'=>Yii::$app->user->can('administrator')
                                    //'badge'=> TimelineEvent::find()->today()->count(),
                                    //'badgeBgClass'=>'label-success',
                                ],
                            ]
                        ],
                        [
                            'label'=>Yii::t('backend', 'Content'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-edit"></i>',
                            'visible'=>Yii::$app->user->can('administrator'),
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                ['label'=>Yii::t('backend', '静态页面'), 'url'=>['/page/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', '文章'), 'url'=>['/article/index','type'=>2], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', '文章分类'), 'url'=>['/article-category/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', '文本组件'), 'url'=>['/widget-text/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', '菜单组件'), 'url'=>['/widget-menu/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', '轮播组件'), 'url'=>['/widget-carousel/index','type'=>2], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                [
                                    'label'=>Yii::t('backend', '用户反馈意见'), 
                                    'url'=>['/campus/notice/feedback'], 
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                ],
                            ]

                        ],
                        [
                            'label'=>Yii::t('backend', 'Other'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-cogs"></i>',
                            'visible'=>Yii::$app->user->can('administrator'),
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'i18n'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'i18n Source Message'), 'url'=>['/i18n/i18n-source-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'i18n Message'), 'url'=>['/i18n/i18n-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
                                ['label'=>Yii::t('backend', 'Key-Value Storage'), 'url'=>['/key-storage/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'File Storage'), 'url'=>['/file-storage/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Cache'), 'url'=>['/cache/index','type'=>2], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'File Manager'), 'url'=>['/file-manager/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                [
                                    'label'=>Yii::t('backend', 'System Information'),
                                    'url'=>['/system-information/index'],
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                ],
                                [
                                    'label'=>Yii::t('backend', 'PHP Info'),
                                    'url'=>['/system-information/info'],
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Logs'),
                                    'url'=>['/log/index'],
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
                                    'badge'=>\backend\models\SystemLog::find()->count(),
                                    'badgeBgClass'=>'label-danger',
                                ],
                            ],
                        ],


                        [
                            'label'=>Yii::t('backend', '开发工具'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-heart"></i>',
                            'visible'=>Yii::$app->user->can('administrator'),
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', '前台API'),
                                    'icon'=>'<i class="fa fa-database"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'url'=> Yii::getAlias('@frontendUrl').'/site/frontend-doc',
                                    'visible'=>Yii::$app->user->can('administrator')
                                    //'badge'=> TimelineEvent::find()->today()->count(),
                                    //'badgeBgClass'=>'label-success',
                                ],
                                [
                                    'label'=>Yii::t('backend', '前台脚手架'),
                                    'icon'=>'<i class="fa fa-hand-o-right"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'url'=>Yii::getAlias('@frontendUrl').'/gii',
                                    'visible'=>Yii::$app->user->can('administrator')
                                    //'badge'=> TimelineEvent::find()->today()->count(),
                                    //'badgeBgClass'=>'label-success',
                                ],
                                [
                                    'label'=>Yii::t('backend', '后台API'),
                                    'icon'=>'<i class="fa fa-database"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'url'=> URL::to(['/site/doc']),
                                    'visible'=>(Yii::$app->user->can('administrator')|| Yii::$app->user->can('leader') || Yii::$app->user->can('director'))
                                    //'badge'=> TimelineEvent::find()->today()->count(),
                                    //'badgeBgClass'=>'label-success',
                                ],
                                [
                                    'label'=>Yii::t('backend', '后台脚手架'),
                                    'icon'=>'<i class="fa fa-hand-o-right"></i>',
                                    'url'=>['/gii'],
                                    'visible'=>Yii::$app->user->can('administrator'),
                                    //'badge'=> TimelineEvent::find()->today()->count(),
                                    //'badgeBgClass'=>'label-success',
                                ],
                                /*
                                ['label'=>Yii::t('backend', '课件管理'), 'url'=>['/campus/courseware/index'], 'icon'=>'<i class="fa  fa-file-text"></i>'
                                ], 
                                */
                            ]
                        ],
 
                    ]
                ]) ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $this->title ?>
                    <?php if (isset($this->params['subtitle'])): ?>
                        <small><?php echo $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                </h1>

                <?php echo Breadcrumbs::widget([
                    'tag'=>'ol',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if (Yii::$app->session->hasFlash('alert')):?>
                    <?php echo \yii\bootstrap\Alert::widget([
                        'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                        'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                    ])?>
                <?php endif; ?>
                <?php echo $content ?>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

<?php $this->endContent(); ?>
<style type="text/css">

    /*#school-box {
        width: colx
    }*/

    #school_id ,#grade_id{
        margin: 10px 10px;
        height: 30px;
    }
</style>
<script type="text/javascript">

   function getClientInfo(event){
        console.log(event);
    }

</script>