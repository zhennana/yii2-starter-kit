<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$imgsize="?imageView2/1/w/300/h/400";

?>
<div class="tuoutu">
    <img width='100%' src="http://orh16je38.bkt.clouddn.com/everbright.jpg?imageView2/1/w/1920/h/400">
</div>

<div class="gdu-content">
  <div class="row">
  <!-- 左边侧边栏 -->
  <?= $this->render('@frontend/themes/gedu/article/common/sidebarnew',['category'=>$category]); ?>

  <!-- 文章内容部分 -->
    <div class="col-md-9 techer-content">
      <div class="box box-widget geu-content">

        <div class="box-header with-border ">
            <ol class="breadcrumb">
              <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
              <li><?php echo Html::a('走进光大',['article/index','category_id'=>1])?></li>
              <li class="activeli">教师风采</li>
            </ol>
        </div>

        <div class="box-body">
          <div class="demo">

              <div class="row teabor">
                <?php foreach ($teacher as $key => $value) : 
                ?>
                  <div class="teacher-content">

                    <div class="col-xs-3 col-sm-2 col-md-3 teacher-image">
                      <span class="img-wrap">
                        <img style="width:100%;height:100%;" src="<?= getImgs($value['body'])[0].$imgsize; ?>">
                      </span>
                    </div>

                    <div class="col-xs-9 col-sm-10 col-md-9 teacher-introduce">
                      <h3><?= $value['title'] ?></h3>
                      <p><?= strip_tags($value['body']) ?></p>
                    </div>

                  </div>
                <?php  endforeach; ?>
              </div>
              <?= LinkPager::widget(['pagination' => $pages]); ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
















