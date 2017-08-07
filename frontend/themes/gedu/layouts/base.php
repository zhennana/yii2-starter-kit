<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
 <?php 
// 信息警告提示
if(Yii::$app->session->hasFlash('alert')):?>
    <?php echo \yii\bootstrap\Alert::widget([
        'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
        'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ]);
?>
<?php endif; ?>

<?php echo $this->render('@frontend/themes/gedu/layouts/common/_alert'); ?>
<style>

    .navbar-right li a{
        font-size:14px !important;
        font-family:'微软雅黑';
    }
    .top-nov .dropdown-menu li a{
//        font-size:12px !important;
    }
    .dropdown-menu > .active > a{
        background-color: #723c8e !important;
    }
    .dropdown-menu{
        box-shadow: none;
        border-color:transparent;
        padding: 0;
    }
    .navbar-collapse{
        padding:0 !important;
    }
    h4{margin:0;}
    .box .box-header{
        padding-left: 10px;
    }
    .navbar .container{
//        width:1000px;
        margin:0 auto;
        padding: 0 !important;
    }
    .top{margin:0 auto;}
    .top .container1-f{
        margin: 0 auto;
        text-align: center;
    }
    .top>.container1{
         width: 1000px;
         overflow: hidden;
        text-align: center;
    }
    @media (min-width: 1200px){
        .top > .container,.main-1 > .container{
            width: 1000px;
        }
        .container{width: 100%}
        .navbar .container{
             width:1000px;
        }
    }
    @media (min-width: 1200px){
        .navbar-right{
//            margin: 0 !important;
        }
    }
    @media (max-width: 768px){
        .navbar .container{
            width:100%;
        }
    }
</style>
<div class="wrap">
     <div class="top">
         <div class='container'>
             <div class="top-logo"><img width="190px" height="60px" src="http://orh16je38.bkt.clouddn.com/guangnewlogo.jpg?imageView2/1/w/800/h/259"></div>
            <div class="top-tel">
                <div class="top-tel-logo"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/top-tel-logo.png"></div>
                <div class="top-tel-text"><span style="font-weight: bold;font-family:'微软雅黑'">服务热线</span></div>
                <div class="top-tel-tel"> 0316-<span>5899988</span></div>
            </div>
         </div>
        <div class="clear"></div>
        <div class="top-nov">
           <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name.' - edu',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => '',
                ],
            ]); ?>
            <?php echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index']], 
                    ['label' => Yii::t('frontend', 'About'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', 'Shool & Department'),
                                'url' => ['/article/view', 'id'=>'55']
                            ],
                            [
                                'label' => Yii::t('frontend', 'Concepts'),
                                'url' => ['/article/view', 'id'=>'58'],
                            ],
                            [
                                'label' => Yii::t('frontend', 'Campus Mien'),
                                'url' => ['/site/sights', 'category_id'=>'37'],
                            ],
                            [
                                'label' => Yii::t('frontend', 'Faculties'),
                                'url' => ['/site/teacher','category_id'=>'38'],
                            ]
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', 'Academics'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', 'Communication'),
                                'url' => ['/article/index', 'category_id'=>'29']
                            ],
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', 'Cooperation'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', 'Partner'),
                                'url' => ['/article/index', 'category_id'=>'34']
                            ],
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', 'Admissions'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', 'Manual'),
                                'url' => ['/article/view', 'id'=>'50']
                            ],
                            // [
                            //     'label' => Yii::t('frontend', '幼小衔接班招生'),
                            //     'url' => ['/page/view', 'slug'=>'you-xiao-xian-jie-ban-zhao-sheng-jian-zhang']
                                
                            // ],
                            [
                                'label' => Yii::t('frontend', 'Primary'),
                                'url' => ['/article/view', 'id'=>'51']
                            
                            ],
                            // [
                            //     'label' => Yii::t('frontend', '初中部招生'),
                            //     'url' => ['/page/view', 'slug'=>'chu-zhong-bu-zhao-sheng-jian-zhang']
                              
                            // ],
                            [
                                'label' => Yii::t('frontend', 'Middle'),
                                'url' => ['/article/view', 'id'=>'53']
                            ],
                            [
                                'label' => Yii::t('frontend', 'International'),
                                'url' => ['/article/view', 'id'=>'54']
                            ],
                            [
                                'label' => Yii::t('frontend', 'Korean'),
                                'url' => ['/article/view', 'id'=>'59']
                            ],
                            [
                                'label' => Yii::t('frontend', 'Special'),
                                'url' => ['/article/view', 'id'=>'60']
                            ],
                            
                        ]
                    ],
                    // ['label' => Yii::t('frontend', '产品展示'), 'url' => ['/page/view', 'slug'=>'ke-cheng-ti-xi']],
                    ['label' => Yii::t('frontend', 'Recruitment'), 'url' => ['/article/index', 'category_id'=>'33']],
                    ['label' => Yii::t('frontend', 'Registration'), 'url' => ['/site/apply-to-play']],
                    ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
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
        </div>
    </div>
    


    <?php echo $content ?>

</div>

<footer class="footer">
     <div class="footer">
     <!--   <div class="footer-1">
            <div class="footer-1-inner">
                <img class="footer-1-inner-img" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-1-links.png">
                <span><a href="#"></a></span>
                <span><a href="#">光大学校</a></span>
            </div>
        </div> -->


  <!--       <div style="height: 150px;background: #76147c; padding: 28px 20px;">
            <div style="border:solid 1px;margin: 0 auto;width:1141px;height: 100px">
                <div class="col-md-6">
                    <div class="">
                                <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-2-add.png">
                            </div> 
                </div>
                <div class="col-md-6">
                    
                </div>

            </div>
        </div> -->
    <!--    <div class="footer-2">
                    <div class="container">
                        <div class="row footer-row">
                            <div class="col-md-4 col-md-4 col-sm-4 col-xs-4 row-box1" style="margin-top:15px;padding:0;">
                                <div class="footer-2-box1">
                                    <div class="footer-2-icon">
                                        <img width="27" height="27" src="http://orh16je38.bkt.clouddn.com/adress.png">
                                    </div>
                                    <div class="footer-2-text1">
                                        <h3 >Address</h3>
                                        <p>河北省三河市燕郊开发区燕灵路236号</p>
                                        <p id="footer-2-box1-p">（三河二中西门路北）</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-md-4 col-sm-4 col-xs-4" style="margin-top:15px;">
                                <div class="footer-2-box3">
                                    <div class="footer-2-icon dinahua">
                                        <img width="35" height="35" src="http://orh16je38.bkt.clouddn.com/dianhua.png">
                                    </div>
                                    <div class="footer-2-text">
                                        <h3>0316-5899988</h3>
                                        <p>服务热线</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-4 col-sm-4 col-xs-4" style="margin-top:15px;padding:0;text-align:right;">
                                <div class="footer-2-box3">
                                    <div class="footer-2-icon weixin-img">
                                        <img width="35" height="35" src="http://orh16je38.bkt.clouddn.com/weixin1.png">
                                    </div>
                                    <div class="footer-2-text weixin">
                                        <img width="70" height="70" class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/WechatIMG1.jpeg">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->


<div class="footer-3">
            <div class="container">
                <div class="row footer-row-nav col-xs-12">
                    <div class="footer-row-nav-fu">
                        <ul>
                            <li><h1><?php echo Html::a('走进光大',['article/index','category_id'=>9])?></h1></li>
                            <li><?php echo Html::a('学校概况',['article/index','category_id'=>9])?></li>
                            <li><?php echo Html::a('办学理念',['article/index','category_id'=>32])?></li>
                            <li><?php echo Html::a('校园风光',['site/sights','category_id'=>37])?></li>
                            <li><?php echo Html::a('教师风采',['site/teacher','category_id'=>38])?></li>
                        </ul>
                        <ul>
                            <li><h1><?php echo Html::a('教育教学',['article/index','category_id'=>29])?></h1></li>
                            <li><?php echo Html::a('家校沟通',['article/index','category_id'=>29])?></li>
                        </ul>
                        <ul>
                            <li><h1><?php echo Html::a('合作交流',['article/index','category_id'=>34])?></h1></li>
                            <li><?php echo Html::a('光大合作',['article/index','category_id'=>34])?></li>
                        </ul>
                        <ul>
                            <li><h1><?php echo Html::a('招生专栏',['article/index','category_id'=>25])?></h1></li>
                            <li><?php echo Html::a('入学手册',['article/index','category_id'=>25])?></li>
                            <li><?php echo Html::a('小学部招生',['article/index','category_id'=>26])?></li>
                            <li><?php echo Html::a('中学部招生',['article/index','category_id'=>27])?></li>
                            <li><?php echo Html::a('国际部招生',['article/index','category_id'=>28])?></li>
                            <li><?php echo Html::a('韩语班招生',['article/index','category_id'=>39])?></li>
                            <li><?php echo Html::a('特长部招生',['article/index','category_id'=>40])?></li>
                        </ul>
                        <ul>
                            <li><h1><?php echo Html::a('招贤纳士',['article/index','category_id'=>33])?></h1></li>
                        </ul>
                        <ul>
                            <li><h1><?php echo Html::a('在线报名',['site/apply-to-play'])?></h1></li>
                        </ul>
                        <div class="footer-info">
                            <div class="footer-weixin">
                                 <!--   <div class="footer-2-icon weixin-img">
                                        <img width="35" height="35" src="http://orh16je38.bkt.clouddn.com/weixin1.png">
                                    </div> -->
                                    <div class="weixin-img">
                                        <img width="110" height="110" class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/WechatIMG1.jpeg">
                                    </div>
                                    <span>关注光大微信公众号，及时了解光大动态，扫码开启吧!</span>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="footer-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <div class="footer-3-box1">
                            <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/WechatIMG1.jpeg">
                            <p>公众号</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="footer-3-box2">
                            <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-ma.png">
                            <p>服务号</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="footer-4">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 end">
                        <span>版权所有：光大学校&nbsp;&nbsp;&nbsp;2016 @ All Rights Reserved 冀ICP备16001426号-1</span>
                        <span style="margin-left:20px">技术支持：<a target="blank" href="http://www.yajol.com/">燕郊在线</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $this->endContent() ?>

<script>

    var boxwidth = $(window).width();
    if(boxwidth < 768){
        $('.top_logo').remove();
        $('.navbar-brand').show();
        var img = '<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/top-logo.png" alt="光大学校">'
        $('.navbar-brand').text('');
        $('.navbar-brand').append(img);
        $('.navbar-brand').addClass('col-xs-4');

    }
    if(navigator.userAgent.match(/mobile/i)) {
        $('.top_logo').remove();
        $('.navbar-brand').show();
        var img = '<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/top-logo.png" alt="光大学校">'
        $('.navbar-brand').text('');
        $('.navbar-brand').append(img);
        $('.navbar-brand').addClass('col-xs-4');

        $('.top').hide();
        $('.footer').hide();
        $('.gdu-content-wrap .col-md-3').hide();
        $('.row .col-md-3').hide();
        $('.box-header').hide();

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
            var img = '<img class="img-responsive" src="" alt="光大学校">'
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
