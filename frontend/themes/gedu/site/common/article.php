<?php
use yii\helpers\Html; 
?>
<div class="container">
    <div class="row" >
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-4-newsBox">
            <div class="newsBox">  
              <h2 class="page-header">
               <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-news.png">
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

                                <h3 class="newsBox-news-h3"><?php echo $data['one']['title']?></h3>
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
                                <h3 class="newsBox-news-h3"><?php echo $value['title'];?></h3>
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
                    <a class="carousel-control right" href="#myCarousel8" 
                       data-slide="next" style="margin-top: 180px"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-circle.png"></a>
                </div> 
            </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="videoBox ">
                <video width="100%" height="100%" id="yjzxVideo" controls >
                    <source src="http://orh16je38.bkt.clouddn.com/guangda86m.mov">
                    您的浏览器不支持该视频播放
                </video>
                <!-- <div class="videoBg">
                    <div class="videoBtn"></div>
                    <p id="videoBtn-p">视频展播</p>
                </div> -->
            </div>                              
        </div>
    </div>
</div>
