<?php
use yii\helpers\Html; 
?>
    <div class="main">
        <div class="main-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="row-box">
                            <!-- <div class="main-1-icon-1"><a href="#"><div class="aaa"></div></a></div> -->
                            <!-- <a href="#"><div class="main-1-icon-1"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['page/view','slug'=>'xiao-xue-bu-zhao-sheng-jian-zhang']);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-1"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                            <h4><?php echo Html::a('小学部',['page/view','slug'=>'xiao-xue-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Primary School Department</h6></h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="row-box">
                            <!-- <a href="#"><div class="main-1-icon-2"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['page/view','slug'=>'chu-zhong-bu-zhao-sheng-jian-zhang']);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-1"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                        
                            <h4><?php echo Html::a('中学部',['page/view','slug'=>'gao-zhong-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Daltonian</h6>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="row-box">
                            <!-- <a href="#"><div class="main-1-icon-3"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['page/view','slug'=>'guo-ji-zhong-xue-bu-zhao-sheng-jian-zhang']);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-1"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                            
                            <h4><?php echo Html::a('国际部',['page/view','slug'=>'guo-ji-zhong-xue-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Oversea sales</h6>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="row-box">
                            <!-- <a href="#"><div class="main-1-icon-4"></div></a> -->
                            <?php 
                                $href= yii\helpers\Url::to(['page/view','slug'=>'te-zhang-bu-zhao-sheng-jian-zhang']);
                                $html='';
                                $html.='<a href="'.$href.'">';
                                $html.='<div class="main-1-icon-1"></div>';
                                $html.='</a>';
                                echo $html;
                            ?>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                            
                            <h4><?php echo Html::a('特长部',['page/view','slug'=>'te-zhang-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Specialty department</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>


       <?php echo $this->render('@frontend/themes/gedu/site/common/teacher.php',['data'=>$data]);?>



        
        <div class="main-3">
            <div class="main-3-head">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-top">
                            <h1>CAMPUS FEATURES</h1>
                            <h4>校园风采</h4>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-line.png" width="100%">
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if(!is_mobile()){
                    echo $this->render('@frontend/themes/gedu/site/common/elegant.php');
                }else{
                    echo $this->render('@frontend/themes/gedu/site/common/mobile_elegant');
                } 
            ?>
        <div class="main-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-4-newsBox">
                        <div class="newsBox">  
                          <h2 class="page-header">
                           <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-news.png">
                           <?php echo Html::a(
                                    "新闻资讯",
                                    ['article/index'],
                                    ['class'=>'','data-method'=>'open',]);
                            ?>
                          </h2>
                        <div class="newsBox-into">
                            <div id="myCarousel3" class="carousel slide">
                                <!-- 轮播（Carousel）项目 -->
                                <div class="carousel-inner">
                                <?php if(isset($data['one'])&&!empty($data['one'])){?>
                                    <div class="item active">
                                        <div class="newsBox-news">
                                            <p class="newsBox-news-p1"><?php echo date('Y-m-d',$data['one']['created_at']);?></p>
                                            <h3 class="newsBox-news-h3" style="border-bottom-style:solid;border-bottom-color: #723c8e;border-bottom-width: 2px; "><?php echo $data['one']['title']?></h3>
                                           
                                            <p class="newsBox-news-p2"><?php echo Html::a(
                                                substr_auto(strip_tags($data['one']['body']),200),
                                                ['article/view','id'=>$data['one']['id']],
                                                ['class'=>'','data-method'=>'open',]);
                                            ?></p>
                                            
                                        </div>
                                    </div>
                                    <?php }?>

                                    <?php if(isset($data['other'])&&!empty($data['other']))
                                            {
                                                foreach ($data['other'] as $key => $value) {  
                                    ?>
                                    <div class="item">
                                        <div class="newsBox-news">
                                            <p class="newsBox-news-p1"><?php echo date('Y-m-d',$value['created_at']);?></p>
                                            <h3 class="newsBox-news-h3"><?php echo $value['title'];?></h3>
                                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-line.png">
                                            <p class="newsBox-news-p2"><?php echo Html::a(
                                                substr_auto(strip_tags($value['body']),200),
                                                ['article/view','id'=>$value['id']],
                                                ['class'=>'','data-method'=>'open',]);
                                            ?></p>
                                        </div>
                                    </div>
                                    <?php
                                       }}
                                    ?>     
                                </div>
                                <!-- 轮播（Carousel）导航 -->
                                <a class="carousel-control right" href="#myCarousel3" 
                                   data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-circle.png"></a>
                            </div> 
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="videoBox">
                            <video width="100%" height="100%" id="yjzxVideo" controls >
                                <source src="http://7xsm8j.com2.z0.glb.qiniucdn.com/yanjiaozaixian-about-hd.mp4">
                                您的浏览器不支持该视频播放
                            </video>
                            <div class="videoBg">
                                <div class="videoBtn"></div>
                                <p id="videoBtn-p">视频展播</p>
                            </div>
                        </div>                              
                    </div>
                </div>
            </div>
        </div>

    </div>
   


    <script type="text/javascript">
      $(function(){
        var oV=document.getElementById('yjzxVideo');
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
        oVbox.on('click',function(){
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
</script>
