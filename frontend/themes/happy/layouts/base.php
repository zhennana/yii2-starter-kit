<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">

    <div class="top_box row">
        <div class="col-md-4 col-xs-2 top_logo">
            <a href="<?php echo Yii::getAlias('@frontendUrl') ?>">
                <img class=" pull-left" src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/fredisalearns_index_03.png">
            </a>
        </div>

        <div class="col-md-4 col-xs-2 sign_in hidden-xs no-padding">
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
                    <input type="text" class="form-control" placeholder="Password">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-warning btn-flat">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </span>
                </div>

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
            ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index']],
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
            [
                'label' => Yii::t('frontend', 'Extra'),
                'items' => [
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
        <div class="web_map">
            <ul class="no-margin no-padding">
                <li class="col-xs-4">
                    <h4>About</h4>
                    <p>FredisaLearns™ is a product of Eduterials Limited, a Hong Kong based Education company. We are the same team that authored kizphonics.com, eslgamesplus.com, kizschool.com and much more, used by millions of people across the globe. If you have ever used any of these resources, you know our mission is first and foremost to provide the best educational content for our users. Our team of skilled educators come from the US, UK, South Africa, Hong Kong and other nationalities. This varied mix of educators help create materials that appeal to global audiences.</p>
                </li>
                <li class="col-xs-4">
                    <h4>Privacy Policy</h4>
                    <p>We take our users' privacy very seriously! At fredisalearns.com, we do not pass onto third parties any identifiable information about our users.Your email address and personal information is NEVER shared with a third party.</p>
                </li>
                <li class="col-xs-4">
                    <h4>Our Location</h4>
                    <p>Eduterials Limited</p>
                    <p>Rm 22B, 22/F, Kiu Yin Commercial Bldg</p>
                    <p>361-363 Lockhart Rd</p>
                    <p>Wanchai, Hong Kong</p>
                    <p>+8528127 7575</p>
                </li>
            </ul>
        </div>
        
        <div class="col-xs-12 bottom">
            <p class="pull-left">
                <?php
                    $html = '';
                    $html .= 'FredisaLearns &copy; ';
                    $html .= date('Y',time());
                    $html .= ' All Rights Reserved ';
                    echo $html;
                ?>
            </p>
        </div>
    </div>
</footer>
<?php $this->endContent() ?>

<script type="text/javascript">
    $(document).off('click.bs.dropdown.data-api');
        $('.nav .dropdown').mouseenter(function(){
            $(this).addClass('open');
        });
        $('.nav .dropdown').mouseleave(function(){
            $(this).removeClass('open');
        });
</script>