 
<?php
use yii\helpers\Html;
// echo'<pre>';var_dump($category);exit;
$articlban=!empty($category['self']['title'])?$category['self']['title']:'光大新闻';
?><!-- 左边侧边栏 -->
    <div class="col-md-4">
      <!-- <div class="">
        <div class="gbox">
          <h4 class="">成绩查询</h4>
        </div>
        <div class="box-body geu-grup" >
            <div class="" style="margin: 15px 20px;"> 
                  <div class="btn "><span class="fa fa-star-o"></span>考试性质
                  </div>
                <input class="" type="text">
            </div>
             <div class="" style="margin: 15px 21px 15px 8px;"> 
                  <div class="btn "><span class="fa fa-star-o"></span>姓名／考号
                  </div>
                <input class="" type="text">
            </div>
        </div>
      </div> -->
      <div class="" >
        <div class="gbox">
          <h4 class=""><?php echo $category['self']['title']?></h4>
        </div>
        <div class="box-body geu-sidebar">
           <aside class="">
            <section class="sidebar">
              <ul class="sidebar-menu tree" data-widget="tree">
                <?php foreach($category['child'] as $key =>$value){?>
                <li class="treeview">
                  <a href="javascript:">
                     <span><?php echo Html::a($value['title'],['article/index','category_id'=>$value['id']]) ?></span>
                  </a>
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
                <li><a href="#">地址：河北省三河市燕郊开发区燕灵路236号（三河二中西门路北）</a></li>
                <li><a href="#">电话：<br>办公室0316-5997070   转6009 <br>
                    小学部办公室         转6003 <br>
                    中学部办公室         转6013  <br>
                    国际部办公室         转2599  <br>
                    招生部办公室         转6688 </a></li>
                <li><a href="#">网址：www.guangdaxuexiao.com</a></li>
              </ul>
            </div>
        </div>
      </div>
    </div>