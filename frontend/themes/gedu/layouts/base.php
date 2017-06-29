<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

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
    }
    .top-nov .dropdown-menu li a{
        font-size:12px !important;
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
        margin:0 auto;
        padding: 0 !important;
        width: 1000px;
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
    }
    @media (min-width: 1200px){
        .navbar-right{
            margin: 0 !important;
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
             <div class="top-logo"><img width="190px" height="60px" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/top-logo.png"></div>
            <div class="top-tel">
                <div class="top-tel-logo"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/top-tel-logo.png"></div>
                <div class="top-tel-text"><span style="font-weight: bold;">服务热线</span></div>
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
                    ['label' => Yii::t('frontend', '首页'), 'url' => ['/site/index']], 
                    ['label' => Yii::t('frontend', '走进光大'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', '学校概况'),
                                'url' => ['/article/index', 'category_id'=>'9']
                            ],
                            [
                                'label' => Yii::t('frontend', '办学理念'),
                                'url' => ['/article/index', 'category_id'=>'32'],
                            ],
                            [
                                'label' => Yii::t('frontend', '校园风光'),
                                'url' => ['/site/sights', 'category_id'=>'37'],
                            ],
                            [
                                'label' => Yii::t('frontend', '教师风采'),
                                'url' => ['/site/teacher','category_id'=>'38'],
                            ]
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', '教育教学'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', '家校沟通'),
                                'url' => ['/article/index', 'category_id'=>'29']
                            ],
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', '合作交流'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', '光大合作'),
                                'url' => ['/article/index', 'category_id'=>'34']
                            ],
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', '招生专栏'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', '入学手册'),
                                'url' => ['/article/index', 'category_id'=>'25']
                            ],
                            // [
                            //     'label' => Yii::t('frontend', '幼小衔接班招生'),
                            //     'url' => ['/page/view', 'slug'=>'you-xiao-xian-jie-ban-zhao-sheng-jian-zhang']
                                
                            // ],
                            [
                                'label' => Yii::t('frontend', '小学部招生'),
                                'url' => ['/article/index', 'category_id'=>'26']
                            
                            ],
                            // [
                            //     'label' => Yii::t('frontend', '初中部招生'),
                            //     'url' => ['/page/view', 'slug'=>'chu-zhong-bu-zhao-sheng-jian-zhang']
                              
                            // ],
                            [
                                'label' => Yii::t('frontend', '中学部招生'),
                                'url' => ['/article/index', 'category_id'=>'27']
                            ],
                            [
                                'label' => Yii::t('frontend', '国际部招生'),
                                'url' => ['/article/index', 'category_id'=>'28']
                            ],
                            [
                                'label' => Yii::t('frontend', '韩语班招生'),
                                'url' => ['/article/index', 'category_id'=>'39']
                            ],
                            [
                                'label' => Yii::t('frontend', '特长部招生'),
                                'url' => ['/article/index', 'category_id'=>'40']
                            ],
                            
                        ]
                    ],
                    // ['label' => Yii::t('frontend', '产品展示'), 'url' => ['/page/view', 'slug'=>'ke-cheng-ti-xi']],
                    ['label' => Yii::t('frontend', '招贤纳士'), 'url' => ['/article/index', 'category_id'=>'33']],
                    ['label' => Yii::t('frontend', '在线报名'), 'url' => ['/site/apply-to-play']],
                    ['label' => Yii::t('frontend', '联系我们'), 'url' => ['/site/contact']],
                ]
            ]); ?>
            <?php NavBar::end(); ?>
        </div>
    </div>
    
    <?php echo \common\widgets\DbCarousel::widget([
        'key'=>'index',
        'options' => [
            'class' => 'slide', // enables slide effect
        ],
    ]) ?>

    <?php echo $content ?>

</div>

<footer class="footer">
     <div class="footer">
        <div class="footer-1">
            <div class="footer-1-inner">
                <img class="footer-1-inner-img" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-1-links.png">
                <span><a href="#"></a></span>
                <span><a href="#">光大学校</a></span>
            </div>
        </div>


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


        <div class="footer-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-4 col-sm-4 col-xs-4 row-box1">
                        <div class="footer-2-box1">
                            <div class="footer-2-icon">
                                <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-2-add.png">
                            </div>                        
                            <div class="footer-2-text">
                                <h3 >Address</h3>
                                <p>河北省三河市燕郊开发区燕灵路236号</p>
                                <p id="footer-2-box1-p">（三河二中西门路北）</p>
                            </div> 
                        </div>
                    </div>
                   
                    <div class="col-md-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="footer-2-box3">
                            <div class="footer-2-icon">
                                <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-2-tel.png">
                            </div>                        
                            <div class="footer-2-text">
                                <h3>0316-5899988</h3>
                                <p>服务热线</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="footer-2-box3">
                            <div class="footer-2-icon">
                                <img width="50px" height="42px" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/weixin.png">
                            </div>                        
                            <div class="footer-2-text">
                                <img width="100px" height="100px" class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/WechatIMG1.jpeg">
                           
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
                    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                        <p>版权所有：光大学校&nbsp;&nbsp;&nbsp;2016 @ All Rights Reserved 冀ICP备16001426号-1</p>
                        <p>技术支持：<a target="blank" href="http://www.yajol.com/">燕郊在线</a></p>     
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
