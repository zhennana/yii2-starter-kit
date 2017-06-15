<?php
use yii\helpers\Html;
?>
<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      echo $this->render('@frontend/themes/gedu/page/common/sidebarteacher');
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-8 ">
    <div class="box box-widget geu-content">
            <!-- div class="box-header with-border ">
              <div class="">
                <span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i><a href="#">当前位置:首页>小学部>校园风光</a></span>
              </div>
            </div> -->
            <div class="box-header with-border box-header with-border ">
                <ol class="breadcrumb" style="margin-bottom: -10px">
                  <li> <span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <li class="activeli"><span>校园风光</span></li>
                </ol>
            </div>
            <div class="box-body">
                <div class="demo">
                    <div class="row">
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-2.png?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-3.png?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/jiaoxuelou.jpg?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/guangdapeitao.jpg?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/guangdapei.jpg?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/guangda-1.jpg?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 scholbor">
                          <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/guagndasmal.jpg?imageView2/1/w/500/h/400" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            </div>
      </div>
    </div>
  </div>
</div>
</div> 