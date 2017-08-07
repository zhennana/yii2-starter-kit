 
<?php
use yii\helpers\Html;
use common\models\Article;

$childNew=!empty($category['childs'])?$category['childs']:$category['child'];
 // echo '<pre>';var_dump($childNew);exit;

$cateParent=!empty($category['pare_name'])?$category['pare_name']:'光大学校';
?><!-- 左边侧边栏 -->
    <div class="col-md-3" style="box-sizing: border-box;padding:0">
      
      <div class="" >
        <div class="gbox school-g">
          <h4 class=""><?php echo $cateParent?></h4>
        </div>
        <div class="box-body geu-sidebar">
           <aside class="">
            <section class="sidebar">
              <ul class="sidebar-menu tree" data-widget="tree">
                <?php foreach($childNew as $key =>$value){
                  ?>
                <li class="treeview">
                     <span><?php 
                     if($value['id']==38){
                      echo Html::a($value['title'],['site/teacher','category_id'=>38]);
                     }else if($value['id']==37){
                      echo Html::a($value['title'],['site/sights','category_id'=>37]);
                     }else if($value['parent_id']==24 || $value['parent_id']==1){
                        $article=Article::find()->where(['category_id'=>$value['id']])->asArray()->one();
                        if(isset($article)){
                          echo Html::a($value['title'],['article/view','id'=>$article['id']]);
                        }else{
                          continue;
                        }      
                     }else{
                        echo Html::a($value['title'],['article/index','category_id'=>$value['id']]);
                     }
                      ?>
                     </span>
                </li>
                <?php }?>
              </ul>
            </section>
          </aside>
        </div>
      </div>
<!--     联系我们 -->
  <!--    <div class="">
        <div class="gbox">
          <h4 class="">联系我们</h4>
        </div>
        <div class="box-body geu-sidebar2 box-body2" >
           <div class="box-body">
              <ul>
                <li><p style="line-height: 22px"><span style="display:inline-block;font-size: 14px; font-weight: bold;margin:0;padding:10px 0 5px">地址：</span><br>
                  1、总校 燕郊高新区燕灵路236号（三河二中西邻）<br>

                  2、海油大街校区 燕郊高新区海油大街30号（方舟广场往东400米路南）<br>

                  3、智慧星校区 燕郊高新区京榆大街1402号（福成国际大酒店对面）
                </p></li>
                <li><p style="line-height: 22px"><span style="display:inline-block;font-size: 14px; font-weight: bold;margin:0;padding:10px 0 5px">电话：</span><br>办公室0316-5997070   转6009 <br>
                    小学部办公室         转6003 <br>
                    中学部办公室         转6013  <br>
                    国际部办公室         转6009  <br>
                    招生部办公室         转6688 </p></li>
                <li><span><span style="display:inline-block;font-size: 14px; font-weight: bold;margin:0;padding:10px 0 5px">网址：</span><a href="http://www.guangdaxuexiao.com/">www.guangdaxuexiao.com</a></span></li>
              </ul>
            </div>
        </div>
      </div> -->
      <div style="background:#f1f1f1">
        <span style="display:inline-block;padding:5px 0;"><img width='100%' src="http://orh16je38.bkt.clouddn.com/Sidebar1.jpg?imageView2/1/w/357/h/179"></span>
        <span style="display:inline-block;padding:5px 0;"><img width='100%' src="http://orh16je38.bkt.clouddn.com/Sidebar2.jpg?imageView2/1/w/357/h/179"></span>
      </div>
    </div>
    <style type="text/css">
      .box-body{
        padding:10px 0;
      }
      .box-body2{
        padding:10px;
      }
    </style>