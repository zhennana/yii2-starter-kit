<?php
use yii\helpers\Html;
?>
 <!-- 左边侧边栏 -->
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
      <div class="">
        <div class="gbox">
          <h4 class="">合作交流</h4>
        </div>
        <div class="box-body geu-sidebar" >
           <aside class="">
            <section class="sidebar">
              <ul class="sidebar-menu tree" data-widget="tree">
                <li class="treeview">
                  
                    <i class="fa fa-pie-chart"></i>
                    <span><?php echo Html::a('关于我们',['page/view','slug'=>'guan-yu-guang-da'])?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                 
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-folder"></i> <span>作息时间</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li><a href=""><i class="fa fa-circle-o"></i> <?php echo Html::a('周一',['page/view','slug'=>'guan-yu-guang-da'])?></a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> 周二</a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> 周三</a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> 周四</a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-share"></i> <span>每周食谱</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-share"></i> <span>班车路线</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-share"></i> <span><?php echo Html::a('学生活动',['page/view','slug'=>'guan-yu-guang-da'])?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-share"></i> <span><?php echo Html::a('兴趣课堂',['page/view','slug'=>'guan-yu-guang-da'])?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                </li>
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