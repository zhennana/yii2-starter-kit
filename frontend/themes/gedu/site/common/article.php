<?php
use yii\helpers\Html; 
?>
<div class="move-box move-box1" style="display:none">
    <div class="embed-box" id="video_play">
        <video id="yjzxVideo" src="http://orh16je38.bkt.clouddn.com/guangda86m.mov" quality="high" width="860" height="483" align="middle" controls='controls'>您的浏览器不支持该视频播放</video>
        <button id="video_close">X</button>
    </div>
</div>
<div class="row col-xs-12" style="position:relative;height:280px;padding:0;">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-4-newsBox">
        <div class="newsBox">  
          <h2 class="page-header">
           <img width="27" height="" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-news.png">
           <?php echo Html::a(
                    "新闻资讯",
                    ['article/index','category_id'=>22],
                    ['class'=>'','data-method'=>'open',]);
            ?>
          </h2>
        <div class="newsBox-into">
            <div id="myCarousel8" class="carousel slide">
                <!-- 轮播（Carousel）项目 -->
                <div class="carousel-inner">
                <?php if(isset($data['one'])&&!empty($data['one'])){?>
                    <div class="item active">
                        <div class="newsBox-news">
                            <p class="newsBox-news-p1"><?php echo date('Y-m-d',$data['one']['created_at']);?></p>

                            <h3 class="newsBox-news-h3">
                            <?php echo Html::a(
                                                            substr_auto(strip_tags($data['one']['title']),35),
                                                            ['article/view','id'=>$data['one']['id']],
                                                            ['class'=>'','data-method'=>'open',]);
                                                        ?></h3>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-line.png" style="width: 20%;height: 3px">
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
                                // var_dump($data['other']);
                                foreach ($data['other'] as $key => $value) {
                    ?>
                    <div class="item">
                        <div class="newsBox-news">
                            <p class="newsBox-news-p1"><?php echo date('Y-m-d',$value['created_at']);?></p>
                            <h3 class="newsBox-news-h3"><?php echo Html::a(
                                substr_auto(strip_tags($value['title']),35),
                                ['article/view','id'=>$value['id']],
                                ['class'=>'','data-method'=>'open',]);
                            ?></h3>
                            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-line.png" style="width: 20%;height: 3px">
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
                <a class="carousel-control right right-row" href="#myCarousel8"
                   data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-circle.png"></a>
            </div> 
        </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-4-videoBox">
        <div class="video">
            <img class="img-responsive" style="height:260px;width:100%;" src="http://orh16je38.bkt.clouddn.com/%E9%85%8D%E5%A5%97%E6%9C%8D%E5%8A%A1%E6%95%88%E6%9E%9C%E5%9B%BE1.png?imageView2/3/h/260/w/485"></a>
            <div class="mask"></div>
            <i class="icon-video"></i>
        </div>
    </div>
</div>
<script>
    $('.main-4-videoBox').click(function(){
        $(".move-box1").show();
        $('video').trigger('play');
        $('video').enterFullScreen();
    });

   $("#video_close").click(function(){
        $(".move-box1").hide();
        $('video').trigger('pause');
   });
</script>
