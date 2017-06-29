<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">
    <div class="top_logo row">
        <a href="<?php echo Yii::getAlias('@frontendUrl') ?>"><img class="img-responsive pull-left" src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/top_logo.png"></a>
        <h3 class="pull-right">咨询热线：400-608-0515</h3>
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
            //['label' => Yii::t('frontend', 'About'), 'url' => ['/page/view', 'slug'=>'about']],
            //['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
            //['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
            // ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/user/sign-in/signup'], 'visible'=>Yii::$app->user->isGuest],
            ['label' => Yii::t('frontend', '关于瓦酷'), 'url' => ['/article/about']],

            ['label' => Yii::t('frontend', '课程体系'), 'url' => ['/article/course']],
            ['label' => Yii::t('frontend', '瓦酷动态'), 'url' => ['/article/news']],
            //['label' => Yii::t('frontend', '赛事游学'), 'url' => ['/page/view', 'slug'=>'sai-shi-you-xue']],
            //['label' => Yii::t('frontend', '亲子课堂'), 'url' => ['/page/view', 'slug'=>'qin-zi-ke-tang']],
            ['label' => Yii::t('frontend', '招商加盟'), 'url' => ['/article/merchants']],
            ['label' => Yii::t('frontend', '联系我们'), 'url' => ['/site/ajax-contact']],
            ['label' => Yii::t('frontend', 'FAQ'), 'url' => ['/page/view', 'slug'=>'faq']],
            // ['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
            // ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
            // ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/user/sign-in/signup'], 'visible'=>Yii::$app->user->isGuest],
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

<script>

    var boxwidth = $(window).width();
    if(boxwidth < 768){
        $('.top_logo').remove();
        $('.navbar-brand').show();
        var img = '<img class="img-responsive" src="http://static.v1.wakooedu.com/top_logo.png?imageView2/3/w/120/h/100" alt="瓦酷机器人">'
        $('.navbar-brand').text('');
        $('.navbar-brand').append(img);
        $('.navbar-brand').addClass('col-xs-4');
    }
    if(navigator.userAgent.match(/mobile/i)) {
        $('.top_logo').remove();
        $('.navbar-brand').show();
        var img = '<img class="img-responsive" src="http://static.v1.wakooedu.com/top_logo.png?imageView2/3/w/120/h/100" alt="瓦酷机器人">'
        $('.navbar-brand').text('');
        $('.navbar-brand').append(img);
        $('.navbar-brand').addClass('col-xs-4');

        $('.nav .dropdown').click(function(){
            if($(this).hasClass('active')){
                $(document).on('click.bs.dropdown.data-api');
            }else{
                $(document).off('click.bs.dropdown.data-api');
            }
        });

    }else{
        $(document).off('click.bs.dropdown.data-api');
        $('.nav .dropdown').mouseenter(function(){
            $(this).addClass('open');
        });
        $('.nav .dropdown').mouseleave(function(){
            $(this).removeClass('open');
        });
    }


    var Hight = $('.top_logo img').height();
    $('.top_logo h3').css('line-height',''+Hight+'px');
    var width = $(window).width();
    $('.breadcrumb').css('width',''+width+'');

    $(window).resize(function() {
        var width = $(window).width();
        $('.breadcrumb').css('width',''+width+'');
        var boxwidth = $(window).width();
        if(boxwidth < 768){
            $('.top_logo').hide();
            $('.navbar-brand').show();
            var img = '<img class="img-responsive" src="http://static.v1.wakooedu.com/top_logo.png?imageView2/3/w/120/h/100" alt="瓦酷机器人">'
            $('.navbar-brand').text('');
            $('.navbar-brand').append(img);
            $('.navbar-brand img').css('height','100%');

            $('.navbar-brand').addClass('col-xs-4');
        }else{
            $('.top_logo').show();
            $('.navbar-brand').hide();
        }
    });

</script>
