<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
//  echo'<pre>';var_dump($category['parent']);
$cateParent=!empty($category['pare_name'])?$category['pare_name']:'光大学校';
$banner=array(
24=>"http://orh16je38.bkt.clouddn.com/Admissions%20.jpg?imageView2/1/w/1920/h/400",//招生专栏
36=>"http://orh16je38.bkt.clouddn.com/education.jpg?imageView2/1/w/1920/h/400",//教育教学
30=>"http://orh16je38.bkt.clouddn.com/cooperation.jpg?imageView2/1/w/1920/h/400",//合作交流
31=>"http://orh16je38.bkt.clouddn.com/celebrated%20.jpg?imageView2/1/w/1920/h/400",//招贤纳士
30=>"http://orh16je38.bkt.clouddn.com/cooperation.jpg?imageView2/1/w/1920/h/400",//合作交流
1=>"http://orh16je38.bkt.clouddn.com/everbright.jpg?imageView2/1/w/1920/h/400",//走进光大
);
//var_dump($banner);
?>
<div style="margin-left:-15px;margin-right:-15px;">
    <?php if($category['parent']['id']==1){ ?>
        <img width='100%' src="<?php echo $banner[1]?>">
    <?php }else if($category['parent']['id']==24){ ?>
        <img width='100%' src="<?php echo $banner[24]?>">
    <?php }else if($category['parent']['id']==36){ ?>
        <img width='100%' src="<?php echo $banner[36]?>">
    <?php }else if($category['parent']['id']==30){ ?>
            <img width='100%' src="<?php echo $banner[30]?>">
    <?php }else if($category['parent']['id']==31){ ?>
            <img width='100%' src="<?php echo $banner[31]?>">
     <?php }?>

</div>
<div class="gdu-content">
  <div class="row gdu-content-wrap">
    <!-- 左边侧边栏 -->
    <?php
    if($category['parent']['id']==46){
        echo $this->render('@frontend/themes/gedu/article/common/sidebar');
    }else{
      echo $this->render('@frontend/themes/gedu/article/common/sidebarnew',['category'=>$category]);
    }
    ?>
    <!-- 文章内容部分 -->
    <div class="content-wrap col-md-9" style="padding-right:0; box-sizing:border-box;">
    <div class="box box-widget geu-content">
            <div class="box-header with-border box-header with-border ">
                <ol class="breadcrumb" style="margin-bottom: -10px">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <?php 
                    if(!empty($category['parent'])&&$category['parent']['id']!=46){               
                  ?>
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
                  echo LinkPager::widget([
                    'pagination'=>$pagination,
                    ])
                ?>

              </ul>
                   
      
            </div>
            </div>
      </div>
    </div>
  </div>
</div>