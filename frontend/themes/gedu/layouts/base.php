<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">
     <div class="top">
        <div class="top-logo"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/top-logo.png"></div>
        <div class="top-tel">
            <div class="top-tel-logo"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/top-tel-logo.png"></div>
            <div class="top-tel-text">全国免费服务热线</div>
            <div class="top-tel-tel">400-820-<span>8888</span></div>
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
                'options' => ['class' => 'navbar-nav '],
                'items' => [
                    ['label' => Yii::t('frontend', '首页'), 'url' => ['/site/index']], 
                    ['label' => Yii::t('frontend', '走进光大'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', '学校概况'),
                                'url' => ['/page/view', 'slug'=>'guan-yu-guang-da']
                            ],
                            [
                                'label' => Yii::t('frontend', '办学理念'),
                                'url' => ['/page/view', 'slug'=>'jiao-yu-li-nian'],
                            ],
                            [
                                'label' => Yii::t('frontend', '校园风光'),
                                'url' => ['/page/view', 'slug'=>'jiao-yu-li-nian'],
                            ],
                            [
                                'label' => Yii::t('frontend', '教师风采'),
                                'url' => ['/site/teacher'],
                            ]
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', '教育教学'), 'url' => ['/page/view', 'slug'=>'sai-shi-you-xue']],
                    ['label' => Yii::t('frontend', '合作交流'), 'url' => ['/page/view', 'slug'=>'zhao-shang-jia-meng']],
                    ['label' => Yii::t('frontend', '招生专栏'),
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', '入学手册'),
                                'url' => ['/page/view', 'slug'=>'ru-xue-shou-ce']
                            ],
                            [
                                'label' => Yii::t('frontend', '幼小衔接班招生'),
                                'url' => ['/page/view', 'slug'=>'you-xiao-xian-jie-ban-zhao-sheng-jian-zhang']
                                
                            ],
                            [
                                'label' => Yii::t('frontend', '小学部招生'),
                                'url' => ['/page/view', 'slug'=>'xiao-xue-bu-zhao-sheng-jian-zhang']
                            
                            ],
                            [
                                'label' => Yii::t('frontend', '初中部招生'),
                                'url' => ['/page/view', 'slug'=>'chu-zhong-bu-zhao-sheng-jian-zhang']
                              
                            ],
                            [
                                'label' => Yii::t('frontend', '高中部招生'),
                                'url' => ['/page/view', 'slug'=>'gao-zhong-bu-zhao-sheng-jian-zhang']
                            ],
                            [
                                'label' => Yii::t('frontend', '国际部招生'),
                                'url' => ['/page/view', 'slug'=>'guo-ji-zhong-xue-bu-zhao-sheng-jian-zhang']
                            ],
                            [
                                'label' => Yii::t('frontend', '特长部招生'),
                                'url' => ['/page/view', 'slug'=>'te-zhang-bu-zhao-sheng-jian-zhang']
                            ],
                            
                        ]
                    ],
                    ['label' => Yii::t('frontend', '产品展示'), 'url' => ['/page/view', 'slug'=>'ke-cheng-ti-xi']],
                    ['label' => Yii::t('frontend', '招贤纳士'), 'url' => ['/page/view', 'slug'=>'zhao-pin']],
                    ['label' => Yii::t('frontend', '在线报名'), 'url' => ['/page/view', 'slug'=>'faq']],
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
                <span><a href="#">凤凰视频</a></span>
                <span><a href="#">光大学校</a></span>
            </div>
        </div>
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
                            <div class="footer-2-text-small">
                                <h3 >Address</h3>
                                <p>河北省三河市燕郊开发</p>
                                <p id="footer-2-box1-p">区燕灵路236号</p>
                                <p id="footer-2-box1-p">（三河二中西门路北）</p>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="footer-2-box2">
                            <div class="footer-2-icon">
                                <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-2-fax.png">
                            </div>                        
                            <div class="footer-2-text">
                                <h3>Fax</h3>
                                <p>0316-8888888</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="footer-2-box3">
                            <div class="footer-2-icon">
                                <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-2-tel.png">
                            </div>                        
                            <div class="footer-2-text">
                                <h3>400-820-8888</h3>
                                <p>全国免费服务热线</p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="footer-3-box1">
                            <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-ma.png">
                            <p>订阅号</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="footer-3-box2">
                            <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/footer-ma.png">
                            <p>服务号</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
