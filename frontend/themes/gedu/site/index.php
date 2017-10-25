<?php
use yii\helpers\Html; 
//var_dump(empty(null));exit;
//var_dump($data['other']);exit;
?>
<?php echo \common\widgets\DbCarousel::widget([
          'key'=>'index',
          'options' => [
              'class' => 'slide', // enables slide effect
          ],
      ]) ?>
<style type="text/css">
    .wrap > .container{
        padding: 0 0 40px ;
    }
</style>
    <div class="main">
        <div class="main-1">
            <div class="container">
                <div class="row">
                    <div class="kbotton">
                        <div class="row-box">
                            <!-- <div class="main-1-icon-1"><a href="#"><div class="aaa"></div></a></div> -->
                            <!-- <a href="#"><div class="main-1-icon-1"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['article/index','category_id'=>41]);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-1"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://static.v1.guangdaxuexiao.com/main-1-line.png">
                            <h4><?php echo Html::a('小学部',['article/index','category_id'=>41],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Primary School Department</h6></h4>
                        </div>
                    </div>
                    <div class="kbotton">
                        <div class="row-box">
                            <!-- <a href="#"><div class="main-1-icon-2"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['article/index','category_id'=>42]);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-2"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://static.v1.guangdaxuexiao.com/main-1-line.png">
                        
                            <h4><?php echo Html::a('中学部',['article/index','category_id'=>42],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Daltonian</h6>
                        </div>
                    </div>
                    <div class="kbotton">
                        <div class="row-box">
                            <!-- <a href="#"><div class="main-1-icon-3"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['article/index','category_id'=>43]);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-3"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://static.v1.guangdaxuexiao.com/main-1-line.png">
                            
                            <h4><?php echo Html::a('国际部',['article/index','category_id'=>43],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Oversea sales</h6>
                        </div>
                    </div>
                    <div class="kbotton">
                        <div class="row-box">
                            <!-- <a href="#"><div class="main-1-icon-4"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['article/index','category_id'=>44]);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-4"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://static.v1.guangdaxuexiao.com/main-1-line.png">
                            
                            <h4><?php echo Html::a('特长部',['article/index','category_id'=>44],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Specialty department</h6>
                        </div>
                    </div>
                   <!--全脑开发部分-->
                    <div class="kbotton">
                        <div class="row-box">
                            <!-- <a href="#"><div class="main-1-icon-5"></div></a> -->
                            <?php
                                $href= yii\helpers\Url::to(['article/index','category_id'=>49]);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-5"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://static.v1.guangdaxuexiao.com/main-1-line.png">

                            <h4><?php echo Html::a('IBC脑开发',['article/index','category_id'=>49],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>IBC BrainHealth Center</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!--新闻模块，视频播放模块 -->
                <div class="main-4">
                    <div class="main-4-fu">
                     <?php echo $this->render('@frontend/themes/gedu/site/common/article.php',['data'=>$data]);?>
                    </div>

                </div>
        <!--教师风采页面-->
        <div class="main-2">
            <?php echo $this->render('@frontend/themes/gedu/site/common/teacher.php',['teacher'=>$teacher]);?>
        </div>
        <div class="main-2">
                <div class="main-3-head-fu">
                               <div class="main-3-head">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-top">
                                            <h1 style="text-align:center"><span style="display:inline-block;width:392px;height:30px;"><img src="http://static.v1.guangdaxuexiao.com/campuse%20features1.png" width="100%"><span></h1>
                                            <h4>校园风采</h4>
                                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-line.png" width="100%">
                                        </div>
                                    </div>
                                </div>
                                <!--校园风采模块 -->
                                <?php
                                    if(!is_mobile()){
                                        echo $this->render('@frontend/themes/gedu/site/common/elegant.php');
                                    }else{
                                        echo $this->render('@frontend/themes/gedu/site/common/mobile_elegant');
                                    }
                                ?>
                            </div>
            </div>
    </div>

    <script type="text/javascript">
      $(function(){
        var oV=document.getElementById('yjzxVideo');
        var oVmask=$('.main-4-videoBox');
        var oVbtn=$('.videoBtn');
        var oVbox=$('.videoBox');
        var oVbg=$('.videoBg');
        var nav=$('.navbar');
        var navWord=$('.navbar-nav li a');
        var logo1=$('.logo1 img');
        var logo2=$('.logo2 img');
        var donebg_p=$('.done_bg p');
        var donebg=$('.done_bg');

     
         if(!(navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") == -1)){
//            oVbox.on('click',function(){
             oVmask.on('click',function(){
              oV.play();
              oVbg.css({'display':'none','background':'none'});
            });
            }
            /*oV.play();*/
            if(navigator.userAgent.indexOf('Firefox') >= 0){
                donebg.addClass('fire_bg');
                donebg_p.css({'display':'-moz-box','padding-bottom':'170px'});
            }
            if(navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") == -1){
                oVbox.css({'height':'0'});
                oVbtn.on('click',function(){

                      oVbtn.css({'display':'none','background':'none'});
                    });
         }
      })
      $(function() {
          $(window).bind('scroll', function() {
              if($(window).scrollTop()>350){
                $(".main-4-newsBox").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
                $(".main-4-videoBox").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
            };
            if($(window).scrollTop()>1850){
                $(".campus-top").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
                $(".campus-bottom").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
            };
            if($(window).scrollTop()>650){
                $(".teacher-img1:nth-child(1)").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
                $(".teacher-img1:nth-child(2)").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
                $(".teacher-img1:nth-child(3)").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
            };
            if($(window).scrollTop()>1250){
                $(".teacher-img1:nth-child(4)").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
                $(".teacher-img1:nth-child(5)").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
                $(".teacher-img1:nth-child(6)").css({
                   "transform": "translate3d(0, 0, 0)",
                   "-ms-transform": "translate3d(0, 0, 0)",
                   "-o-transform": "translate3d(0, 0, 0)",
                   "-webkit-transform": "translate3d(0, 0, 0)",
                   "-moz-transform": "translate3d(0, 0, 0)",
                   "opacity": 1
                });
            };
          });
      }());
     $(document).ready(function(){
         $(window).scroll(function(){

         });
     });
</script>
