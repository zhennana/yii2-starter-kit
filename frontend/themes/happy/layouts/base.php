<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php');
$logo = 'http://orfaphl6n.bkt.clouddn.com/logo.png?imageView2/3/w/257/h/115';
?>
<div class="wrap">

    <div class="top_box row">
        <div class="col-lg-4 col-md-6 col-xs-6 top_logo">
            <a href="<?php echo Yii::getAlias('@frontendUrl') ?>">
                <img class="pull-left" src="<?= $logo ?>">
            </a>
        </div>
<!--
        <form class="form-horizontal col-lg-4 col-md-6 col-xs-6 sign_in hidden-xs no-padding">
                <div class="input-group margin">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" class="form-control" placeholder="Username">
                </div>
                <div class="input-group margin">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input type="password" class="form-control" placeholder="Password">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning btn-flat">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </span>
                </div>

        </form>
-->
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
            ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index']],
            [
                'label' => Yii::t('frontend', 'English Course'),
                'items'=>[
                    [
                        'label' => Yii::t('frontend', 'Starter 1 English'),
                        'url' => ['/article/course','master_id' => 17]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Starter 2 English'),
                        'url' => ['/article/course','master_id' => 27]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 1 English'),
                        'url' => ['/article/course','master_id' => 37]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 2 English'),
                        'url' => ['/article/course','master_id' => 49]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 3 English'),
                        'url' => ['/article/course','master_id' => 60]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 4 English'),
                        'url' => ['/article/course','master_id' => 71]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 5 English'),
                        'url' => ['/article/course','master_id' => 82]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 6 English'),
                        'url' => ['/article/course','master_id' => 94]
                    ],
                    [
                        'label' => Yii::t('frontend', 'Level 7 English'),
                        'url' => ['/article/course','master_id' => 105]
                    ],
                ]
            ],
            ['label' => Yii::t('frontend', 'Extra')],
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

    <?php
        /* 导航搜索 */
        /*
        $search = '';
        $search .= Html::beginForm(['#'], 'get', ['class' => 'nav_search pull-right input-group col-xs-2']);
        $search .= '<div class="input-group">';
        $search .= Html::textInput('search', '',['placeholder' => 'Search course']);
        $search .= '<span class="input-group-btn">';
        $search .= Html::submitButton('<i class="fa fa-search"></i>',['class'=>'btn btn_search']);
        $search .= '</span>';
        $search .= '</div>';
        $search .= Html::endForm();
        echo $search;
        */
    ?>

    <?php NavBar::end(); ?>

    <?php echo $content ?>

</div>

<footer class="footer">
    <div class="container">
        <div class="web_map">
            <ul class="no-margin no-padding">
                <li class="col-xs-12 col-sm-4">
                    <h4>About</h4>
                    <p>FredisaLearns™ is a product of Eduterials Limited, a Hong Kong based Education company. We are the same team that authored kizphonics.com, eslgamesplus.com, kizschool.com and much more, used by millions of people across the globe. If you have ever used any of these resources, you know our mission is first and foremost to provide the best educational content for our users. Our team of skilled educators come from the US, UK, South Africa, Hong Kong and other nationalities. This varied mix of educators help create materials that appeal to global audiences.</p>
                </li>
                <li class="col-xs-12 col-sm-4">
                    <h4>Privacy Policy</h4>
                    <p>We take our users' privacy very seriously! At fredisalearns.com, we do not pass onto third parties any identifiable information about our users.Your email address and personal information is NEVER shared with a third party.</p>
                </li>
                <li class="col-xs-12 col-sm-4">
                    <h4>Our Location</h4>
                    <p>
                        Eduterials Limited</br>
                        Rm 22B, 22/F, Kiu Yin Commercial Bldg</br>
                        361-363 Lockhart Rd</br>
                        Wanchai, Hong Kong
                    </p>
                </li>
            </ul>
        </div>
        
        <div class="col-xs-12 bottom">
            <div class="pull-left">
                <?php
                    $html = '';
                    $html .= 'FredisaLearns &copy; ';
                    $html .= date('Y',time());
                    $html .= ' All Rights Reserved ';
                    echo $html;
                ?>
                <a href="#">Terms of Use</a>
                |
                <a href="#">About Us</a>
            </div>
        </div>
    </div>
</footer>
<?php $this->endContent() ?>

<script type="text/javascript">
    var boxwidth = $(window).width();
    if(boxwidth < 768){
        $('.top_logo').remove();
        var img = '<a href="<?= Yii::getAlias('@frontendUrl') ?>"><img class="img-responsive center-block" src="<?= $logo ?>" ></a>';
        $('.top_box').append(img);
        $('.top_box').css("padding-top","20px");
    }else{
        $(document).off('click.bs.dropdown.data-api');
            $('.nav .dropdown').mouseenter(function(){
                $(this).addClass('open');
            });
            $('.nav .dropdown').mouseleave(function(){
                $(this).removeClass('open');
            });
    }
</script>
