<?php
use yii\helpers\Html;
 // echo'<pre>';var_dump($category['parent']['title']);exit;
$cateParent=!empty($category['pare_name'])?$category['pare_name']:'光大学校';
?>
<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      echo $this->render('@frontend/themes/gedu/article/common/sidebarnew',['category'=>$category]);
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-8 ">
    <div class="box box-widget geu-content">
            <div class="box-header with-border box-header with-border ">
                <ol class="breadcrumb" style="margin-bottom: -10px">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <?php if(!empty($category['parent'])){?>
                  <li><?php echo Html::a($cateParent,['article/index','category_id'=>$category['pare_id']])?></li>
                  <?php }?>
                  <li class="activeli"><?php echo $category['self']['title']?></li>
                </ol>
            </div>
            <div class="box-body">
               <div class="box-body">
              <ul class="todo-list ui-sortable">
              <?php foreach($modelArticle as $key=>$value){?>
              	<li class="coperli">
                  <span class="handle ui-sortable-handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                  </span>
                  <span class="text">
                  	
                  	<?php echo Html::a(
                       $value['title'],
                        ['article/view','id'=>$value['id']],
                        ['class'=>'','data-method'=>'open',]);
                    ?>
                  </span>
                  <small class="label"><i class="fa fa-clock-o"></i> <?php echo Yii::$app->formatter->asRelativeTime($value['created_at']);?></small>
                  <div class="tools">
                   <?php echo Html::a(
                       "详情" ,
                        ['article/view','id'=>$value['id']],
                        ['class'=>'','data-method'=>'open',]);
                    ?>
                  </div>
                </li>
              <?php }?>
                 <?php 
		        //   echo \yii\widgets\LinkPager::widget([
		        //     'pagination'=>$dataProvider->pagination,
		        //     'options' => ['class' => 'pagination'],
		        // ]);
            ?>

              </ul>
                   
      
            </div>
            </div>
      </div>
    </div>
  </div>
</div>