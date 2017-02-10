<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">
    <div class="top_logo row">
        <a href="<?php echo Yii::getAlias('@frontendUrl') ?>"><img class="img-responsive pull-left" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b89ov8r2ak91qdt4i71mrc15rs9.png"></a>
        <h3 class="pull-right">咨询热线：0316—8888888</h3>
    </div>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name.' - edu',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]); ?>
    <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('frontend', 'About'), 'url' => ['/page/view', 'slug'=>'about']],
            ['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
            ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
            ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/user/sign-in/signup'], 'visible'=>Yii::$app->user->isGuest],
            ['label' => Yii::t('frontend', 'Login'), 'url' => ['/user/sign-in/login'], 'visible'=>Yii::$app->user->isGuest],
            [
                'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
                'visible'=>!Yii::$app->user->isGuest,
                'items'=>[
                    [
                        'label' => Yii::t('frontend', 'Settings'),
                        'url' => ['/user/default/index']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Backend'),
                        'url' => Yii::getAlias('@backendUrl'),
                        'visible'=>Yii::$app->user->can('manager')
                    ],
                    [
                        'label' => Yii::t('frontend', 'Logout'),
                        'url' => ['/user/sign-in/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]
            ],
            [
                'label'=>Yii::t('frontend', 'Language'),
                'items'=>array_map(function ($code) {
                    return [
                        'label' => Yii::$app->params['availableLocales'][$code],
                        'url' => ['/site/set-locale', 'locale'=>$code],
                        'active' => Yii::$app->language === $code
                    ];
                }, array_keys(Yii::$app->params['availableLocales']))
            ]
        ]
    ]); ?>
    <?php NavBar::end(); ?>
    <?php echo \common\widgets\DbCarousel::widget([
        'key'=>'index',
        'options' => [
            'class' => 'slide', // enables slide effect
        ],
    ]) ?>

    <?php echo $content ?>

</div>

<footer class="footer">
    <div class="container">
        <div class="col-xs-12 top">
            <ul class="no-margin no-padding col-xs-8">
                <li class="col-xs-2">
                    <h4>关于瓦酷</h4>
                    <p>瓦酷介绍</p>
                    <p>品牌故事</p>
                    <p>专家团队</p>
                    <p>教育理念</p>
                    <p>运营管理部</p>
                </li>
                <li class="col-xs-2">
                    <h4>关于瓦酷</h4>
                    <p>瓦酷介绍</p>
                    <p>品牌故事</p>
                    <p>专家团队</p>
                    <p>教育理念</p>
                    <p>运营管理部</p>
                </li>
                <li class="col-xs-2">
                    <h4>关于瓦酷</h4>
                    <p>瓦酷介绍</p>
                    <p>品牌故事</p>
                    <p>专家团队</p>
                    <p>教育理念</p>
                    <p>运营管理部</p>
                </li>
                <li class="col-xs-2">
                    <h4>关于瓦酷</h4>
                    <p>瓦酷介绍</p>
                    <p>品牌故事</p>
                    <p>专家团队</p>
                    <p>教育理念</p>
                    <p>运营管理部</p>
                </li>
                <li class="col-xs-4">
                    <h4>关于瓦酷</h4>
                    <p class="no-margin">全国咨询热线</p>
                    <h3 class="no-margin">0316-8888888</h3>
                    <h5>地址：河北省三河市燕郊开发区</h5>
                    <p>邮编：065201</p>
                </li>
            </ul>
            <img class="img-responsive col-xs-4" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b89ov8r2ak91qdt4i71mrc15rs9.png">
        </div>
        <div class="col-xs-12 bottom">
            <p class="pull-left">&copy; 版权所有：瓦酷机器人copyright2014-2016 wakcoo.com all rights reserved. 京icp备15002974号－1?></p>
            <p class="pull-right"><?php echo Yii::powered() ?></p>
        </div>
    </div>
</footer>
<?php $this->endContent() ?>

<script>
    $('.navbar-brand').hide();
    if(navigator.userAgent.match(/mobile/i)) {
        $('.top_logo').remove(); 
        $('.navbar-brand').show();
        var img = '<img class="img-responsive" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b8gf7g9n9bb1s5nvei1rb81ikg9.png" alt="瓦酷机器人">'
        console.log(img);
        $('.navbar-brand').text('');
        $('.navbar-brand').append(img);
        $('.navbar-brand').addClass('col-xs-4');
    }
    var Hight = $('.top_logo img').height();
    $('.top_logo h3').css('line-height',''+Hight+'px');
    var width = $(window).width();
    $('.breadcrumb').css('width',''+width+'');
    $(window).resize(function() {
        var width = $(window).width();
        $('.breadcrumb').css('width',''+width+'');
    });
</script>

