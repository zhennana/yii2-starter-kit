<?php
//var_dump(1111);exit;
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
                <span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i><a href="#">当前位置:首页><?php echo $model->title;?></a></span>
              </div>
            </div>
            <div class="box-body">
              <?php echo $model->body;?>
            </div>
      </div>
    </div>
  </div>
</div>