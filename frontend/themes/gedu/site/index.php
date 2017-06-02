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
                            <a href="#"><div class="main-1-icon-1"></div></a>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                            <h4><?php echo Html::a('小学部',['page/view','slug'=>'xiao-xue-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Primary School Department</h6></h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="row-box">
                            <a href="#"><div class="main-1-icon-2"></div></a>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                        
                            <h4><?php echo Html::a('中学部',['page/view','slug'=>'gao-zhong-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Daltonian</h6>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="row-box">
                            <a href="#"><div class="main-1-icon-3"></div></a>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                            
                            <h4><?php echo Html::a('国际部',['page/view','slug'=>'guo-ji-zhong-xue-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Oversea sales</h6>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="row-box">
                            <a href="#"><div class="main-1-icon-4"></div></a>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-1-line.png">
                            
                            <h4><?php echo Html::a('特长部',['page/view','slug'=>'te-zhang-bu-zhao-sheng-jian-zhang'],['class'=>'headcolor','data-method'=>'open',]);?>
                            <h6>Specialty department</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-2">
            <div class="main-2-head">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-top">
                            <h1>TEACHER STYLE</h1>
                            <h4>教师风采</h4>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-line.png" width="100%">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-nav">
                            <span>全部</span>
                            <span>小学部</span>
                            <span>中学部</span>
                            <span>国际部</span>
                            <span>特长部</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-2-teacher">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="myCarousel2" class="carousel slide">
                                <!-- 轮播（Carousel）指标 -->
                                <ol class="carousel-indicators main-2-teacher-ol">
                                    <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel2" data-slide-to="1"></li>
                                    <li data-target="#myCarousel2" data-slide-to="2"></li>
                                    <li data-target="#myCarousel2" data-slide-to="3"></li>
                                </ol>   
                                <!-- 轮播（Carousel）项目 -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <?php for($i=0;$i<4;$i++){?>
                                            <div class="col-xs-3 col-lg-3 main-2-teacher-inner">
                                                <a href="#">
                                                    <div class="main-2-teacher-inner-img">
                                                        <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                                    </div>
                                                    <div class="main-2-teacher-inner-p">
                                                        <p><?php echo Html::a('齐靖',['site/teacher']);?></p>
                                                    </div>
                                                </a>    
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="item">
                                        <?php for($i=0;$i<4;$i++){?>
                                            <div class="col-xs-3 col-lg-3 main-2-teacher-inner">
                                                <a href="#">
                                                    <div class="main-2-teacher-inner-img">
                                                        <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                                    </div>
                                                    <div class="main-2-teacher-inner-p">
                                                        <p><?php echo Html::a('齐靖',['site/teacher']);?></p>
                                                    </div>
                                                </a>    
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="item">
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                        <div class=" col-xs-3 col-lg-3 main-2-teacher-inner">
                                            <div class="main-2-teacher-inner-img">
                                                <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teacher.png">
                                            </div>
                                            <div class="main-2-teacher-inner-p">
                                                <p>齐靖</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 轮播（Carousel）导航 -->
                                <a class="carousel-control left main-2-teacher-left" href="#myCarousel2" 
                                   data-slide="prev"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-L.png"></a>
                                <a class="carousel-control right main-2-teacher-right" href="#myCarousel2" 
                                   data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-R.png"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
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
            <div class="main-3-school">

                <!-- <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3.png">
                        </div>
                    </div>
                </div> -->
                <div class="banner-bottom-left-grids">
                    <div class="banner-bottom-left-grid iusto">
                        <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png" alt=" " class="img-responsive" />
                        <div class="cap1">
                            <span> </span>
                        </div>
                    </div>
                   <!--  <div class="banner-bottom-left-grid">
                        <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png" alt=" " class="img-responsive" />
                        <div class="cap1">
                            <span> </span>
                        </div>
                    </div> -->
                    <div class="banner-bottom-left-grid txt">
                        <a>校园一角</a>
                        <hr class="hr1" />
                    </div>
                    <div class="banner-bottom-left-grid iusto">
                        <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-2.png" alt=" " class="img-responsive" />
                        <div class="cap">
                            <span> </span>
                        </div>
                    </div>
                    <div class="banner-bottom-left-grid iusto">
                        <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-3.png" alt=" " class="img-responsive" />
                        <div class="cap5">
                            <span> </span>
                        </div>
                    </div>
                    <div class="banner-bottom-left-grid txt">
            
                        <a>教室讲台</a>
                        <hr class="hr1" />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="banner-bottom-left-grids">
                    <div class="banner-bottom-left-grid2 txt">
                        <a>教学楼外观</a>
                        <hr class="hr1" />
                    </div>
                    <div class="banner-bottom-left-grid iusto">
                        <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-4.png" alt=" " class="img-responsive" />
                        <div class="cap3">
                            <span> </span>
                        </div>
                    </div>
                    <div class="banner-bottom-left-grid3 txt">
                        <a>招生咨询处</a>
                        <hr class="hr2" />
                    </div>
                    <div class="banner-bottom-left-grid2 txt">
                        <a>学校操场</a>
                        <hr class="hr1" />
                    </div>
                    <div class="banner-bottom-left-grid iusto">
                        <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-5.png" alt=" " class="img-responsive" />
                        <div class="cap4">
                            <span> </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            

            </div> 
        </div>
        <div class="main-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-4-newsBox">
                        <div class="newsBox">

                            <!-- <div class="newsBox-top">
                                <div class="newsBox-top-L">

                                    <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-news.png">

                                    <div class="newsBox-top-L-news">

                                        <p>NEWS</p>
                                        
                                    </div>
                                </div>
                                <div class="newsBox-top-R">
                                    <img class="newsBox-top-R-img-L" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-news-L.png">
                                    <p><span>02</span>/08</p>
                                    <img class="newsBox-top-R-img-R"  src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-news-R.png">
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-xs-12">
                                  <h2 class="page-header">
                                   <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-news.png">
                                   <?php echo Html::a(
                                            "新闻资讯",
                                            ['article/index'],
                                            ['class'=>'','data-method'=>'open',]);
                                        ?>
                                    <!-- <small class="pull-right">Date: 2/10/2014</small> -->
                                  </h2>
                                </div>
                               
                              </div>

                            <div class="newsBox-into">
                                <div id="myCarousel3" class="carousel slide">
                                    <!-- 轮播（Carousel）项目 -->
                                    <div class="carousel-inner">
                                    <?php if(isset($data['one'])&&!empty($data['one'])){?>
                                        <div class="item active">
                                            <div class="newsBox-news">
                                                <p class="newsBox-news-p1"><?php echo date('Y-m-d',$data['one']['created_at']);?></p>
                                                <h3 class="newsBox-news-h3"><?php echo $data['one']['title']?></h3>
                                                <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-line.png">
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
