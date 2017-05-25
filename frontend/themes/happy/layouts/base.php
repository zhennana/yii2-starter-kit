<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">

    <div class="top_box">
    <div>
        <a href="<?php echo Yii::getAlias('@frontendUrl') ?>">
            <img class="img-responsive pull-left" src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/fredisalearns_index_03.png">
        </a>
    </div>
    </div>

    <?php NavBar::begin([
        'brandLabel' => 'FredisaLearns™',
        'brandUrl' => '#',
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]); ?>

    <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => Yii::t('frontend', 'Home'), 'url' => ['#']],
            [
                'label' => Yii::t('frontend', 'English Course'),
                'items'=>[
                    [
                        'label' => Yii::t('frontend', 'Starter 1 English'),
                        'url' => ['#']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 1 English'),
                        'url' => ['#']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 2 English'),
                        'url' => ['#']
                    ],
                ]
            ],
            ['label' => Yii::t('frontend', 'Extra'), 'url' => ['#']],
            /*
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
            */
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

    <?php 
    /* 导航搜索 */
    echo Html::beginForm(['site/search'], 'get', ['class' => 'navbar-form navbar-right']);
    echo Html::textInput('q');
    echo Html::endForm();
    ?>

    <?php NavBar::end(); ?>

    <?php echo $content ?>

</div>

<footer class="footer">
    <div class="container">
        <div class="col-xs-12 top">
            <div class="web_map">
                <ul class="no-margin no-padding col-xs-8">
                    <li class="col-xs-2">
                        <h4>关于瓦酷</h4>
                        <p>瓦酷介绍</p>
                        <p>品牌故事</p>
                        <p>专家团队</p>
                        <p>教育理念</p>
                        <p>运营管理</p>
                        <p>加盟校区</p>
                        <p>校区展示</p>
                    </li>
                    <li class="col-xs-2">
                        <h4>招商加盟</h4>
                        <p>瓦酷加盟体系</p>
                        <p>加盟流程</p>
                        <p>加盟条件</p>
                        <p>服务支持</p>
                        <p>项目优势</p>
                        <p>投资收益分析</p>
                        <p>授权证书</p>
                        <p>行业趋势</p>
                    </li>
                    <li class="col-xs-2">
                        <h4>课程体系</h4>
                        <p>学前课程</p>
                        <p>学龄课程</p>
                        <p>精品课程</p>
                    </li>
                    <li class="col-xs-2">
                        <h4>瓦酷动态</h4>
                        <p>瓦酷动态</p>
                        <p>瓦酷视频</p>
                    </li>
                    <li class="col-xs-4">
                        <h4>联系我们</h4>
                        <p class="no-margin">全国咨询热线</p>
                        <h3 class="no-margin">400-608-0515</h3>
                        <h5>地址：河北省廊坊市三河市燕郊开发区</h5>
                        <p>邮编：065201</p>
                    </li>
                </ul>
            </div>
            <div class="bottom_logo">
                <img class="img-responsive col-xs-4" src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/bottom_logo.png">
            </div>
        </div>
        <div class="col-xs-12 bottom">
            <p class="pull-left">
                <?php
                    $html = '';
                    $html .= '&copy; 版权所有(2016-';
                    $html .= date('Y',time());
                    $html .= ')：北京魔趣教育科技有限公司 ';
                    // $html .= 'copyright 2016-';
                    // $html .= date('Y',time());
                    // $html .= ' wakooedu.com All rights reserved.';
                    $html .= ' <a href="http://www.miitbeian.gov.cn" target="_blank">京ICP备17007940号</a>';
                    echo $html;
                ?>
            </p>
            <p class="pull-right">技术支持：三河市物联网络技术有限公司</p>
        </div>
    </div>
</footer>
<?php $this->endContent() ?>