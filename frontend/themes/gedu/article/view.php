<?php
use yii\helpers\Html;
$category=$model->category->title;
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
            <div class="box-header with-border box-header with-border ">
                <ol class="breadcrumb" style="margin-bottom: -10px">
                  <li><?php echo Html::a('首页',['site/index'])?></li>
                  <li><a href="#"><?php echo Html::a($category,['article/index','category_id'=>$model->category_id])?></a></li>
                  <li class="activeli"><?php echo $model->title;?></li>
                </ol>
            </div>
            <div class="box-body">
              <?php echo $model->body;?>
            </div>
      </div>
    </div>
  </div>
</div>