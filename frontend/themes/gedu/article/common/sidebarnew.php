 
<?php
use yii\helpers\Html;
// echo'<pre>';var_dump($category);exit;
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
                <?php foreach($category['child'] as $key =>$value){
                  ?>
                <li class="treeview">
                     <span><?php 
                     if($value['id']==38){
                      echo Html::a($value['title'],['site/teacher']);
                     }else if($value['id']==37){
                      echo Html::a($value['title'],['site/sights']);
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
                <li><span>地址：河北省三河市燕郊开发区燕灵路236号（三河二中西门路北）</span></li>
                <li><span>电话：<br>办公室0316-5997070   转6009 <br>
                    小学部办公室         转6003 <br>
                    中学部办公室         转6013  <br>
                    国际部办公室         转2599  <br>
                    招生部办公室         转6688 </span></li>
                <li><span>网址：www.guangdaxuexiao.com</span></li>
              </ul>
            </div>
        </div>
      </div>
    </div>