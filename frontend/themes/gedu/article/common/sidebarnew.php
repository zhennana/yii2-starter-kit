 
<?php
use yii\helpers\Html;

$childNew=!empty($category['childs'])?$category['childs']:$category['child'];

$cateParent=!empty($category['pare_name'])?$category['pare_name']:'光大学校';
?><!-- 左边侧边栏 -->
    <div class="col-md-4">
      
      <div class="" >
        <div class="gbox">
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
                     }else{
                      echo Html::a($value['title'],['article/index','category_id'=>$value['id']]);
                     } ?>
                     </span>
                </li>
                <?php }?>
              </ul>
            </section>
          </aside>
        </div>
      </div>
      <div class="">
        <div class="gbox">
          <h4 class="">联系我们</h4>
        </div>
        <div class="box-body geu-sidebar2" >
           <div class="box-body">
              <ul>
                <li><span href="#">地址：<br>
                  1、总校 燕郊高新区燕灵路236号（三河二中西邻）<br>

                  2、海油大街校区 燕郊高新区海油大街30号（方舟广场往东400米路南）<br>

                  3、智慧星校区 燕郊高新区京榆大街1402号（福成国际大酒店对面）
                </span></li>
                <li><span>电话：<br>办公室0316-5997070   转6009 <br>
                    小学部办公室         转6003 <br>
                    中学部办公室         转6013  <br>
                    国际部办公室         转6009  <br>
                    招生部办公室         转6688 </span></li>
                <li><span>网址：www.guangdaxuexiao.com</span></li>
              </ul>
            </div>
        </div>
      </div>
    </div>