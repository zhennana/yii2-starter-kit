<?php
use yii\helpers\Html;
// echo'<pre>';var_dump($model);exit;
?>

<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      if($model->id==31){
        echo $this->render('@frontend/themes/gedu/page/common/sidebarteacher');
      }else{
        echo $this->render('@frontend/themes/gedu/page/common/sidebar');
      }
      
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-8 ">
    <div class="box box-widget geu-content">
            <div class="box-header with-border box-header with-border ">
                <ol class="breadcrumb" style="margin-bottom: -10px">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
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