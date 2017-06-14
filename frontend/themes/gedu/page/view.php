<?php
use yii\helpers\Html;

?>

<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      echo $this->render('@frontend/themes/gedu/page/common/sidebar');
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-8 ">
    <div class="box box-widget geu-content">
            <div class="box-header with-border ">
              <div class="">
                <ol class="breadcrumb">
                  <li><?php echo Html::a('首页',['site/index'])?></li>
                  <li class="activeli" style="color:#723c8e "><?php echo $model->title;?></li>
                </ol>
              </div>
            </div>
            <div class="box-body">
              <?php echo $model->body;?>
            </div>
      </div>
    </div>
  </div>
</div>