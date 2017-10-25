<?php
use yii\helpers\Html;
$imgsize="?imageView2/1/w/225/h/300";
?>
    <div class="main-2-head">
        <div class="row row-teacher">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-top">
                <div class="main-2-top-child">
                    <h1 style="text-align:center"><span style="display:inline-block;width:334px;height:30px;"><img src="http://static.v1.guangdaxuexiao.com/teacher%20style1.png" width="100%"><span></h1>
                    <h4>教师风采</h4>
                    <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-line.png" width="100%">
                </div>
            </div>
        </div>
    </div>
<!-- 教师风采图片-->
  <div class="tab-content-fu">
        <div class="teacher-wrap">
        <?php foreach($teacher as $key=>$value) { ?>
            <div class="col-sm-6 col-md-4 teacher-img teacher-img1">
                <div class="panel panel-default panel-card">
                    <div class="panel-heading">
                        <img style="width:100%;" src="http://static.v1.guangdaxuexiao.com/zongxiao.png">
                    </div>
                    <div class="panel-figure">
                        <img class="img-responsive img-circle" src="<?= getImgs($value['body'])[0].$imgsize; ?>">
                    </div>
                    <div class="panel-body text-center">
                        <h4 class="panel-header">
                          <?= $value['title']?></h4>
                        <span><?= strip_tags($value['body']) ?></span>
                    </div>
                    <div class="panel-thumbnails">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="icon">
                                  <?php
                                    $href= yii\helpers\Url::to(['site/teacher','category_id'=>'38']);
                                    $html='';
                                    $html.='<li><a href="'.$href.'">';
                                    $html.='<img class="img-responsive" src="http://static.v1.guangdaxuexiao.com/teachsearch.png">';
                                    $html.='</a></li>';
                                    echo $html;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>

        </div>
   </div>
 <script>
    $('.main-2-nav span').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    })
 </script>