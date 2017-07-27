<?php
use yii\helpers\Html;
?>

<div class="gdu-content">
  <div class="row" style="margin:0;">
    <!-- 左边侧边栏 -->
    <?php
    if($category['parent']['id']==46){
      echo $this->render('@frontend/themes/gedu/article/common/sidebar');
    }else{
      echo $this->render('@frontend/themes/gedu/article/common/sidebarnew',[
       'category'=>$category
       ]);
    }
          ?>
    <!-- 文章内容部分 -->
    <div class="col-md-9 content-wrap" style="box-sizing: border-box;padding-right: 0;">

        <div class="box box-widget geu-content">
                <div class="box-header with-border box-header with-border ">
                    <ol class="breadcrumb" style="margin-bottom: -10px">
                      <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                      <?php if(!empty($category['parent']&&$category['parent']['id']!=46)){?>
                      <li><?php echo Html::a($category['pare_name'],['article/index','category_id'=>$model->category_id])?></li>
                      <?php }?>
                      <li><?php echo Html::a($category['self'],['article/index','category_id'=>$model->category_id])?></li>
                      <li class="activeli"><?php echo $model->title;?></li>
                    </ol>
                </div>
                <div class="box-body">
                  <h3 style="text-align:center;font-family:'微软雅黑'"><?php echo $model->title;?></h3>
                  <?php echo $model->body;?>
                </div>
        </div>
    </div>
  </div>
</div>