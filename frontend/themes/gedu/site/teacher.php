<?php
$imgsize="?imageView2/1/w/250/h/300";

 $teachers=[
    '1'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/liangfengrui1.jpg',
      'name'=>'梁丰瑞',
      ],
    '2'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/qijing1.JPG',
      'name'=>'齐婧',
      ],
    '3'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/liuyanan1.jpg',
      'name'=>'刘亚南',
      ],
    '4'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/tianyadong1.jpg',
      'name'=>'田亚东',
      ],
    '5'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/tianyuan1.jpg',
      'name'=>'田媛',
      ],
    '6'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/yangmeijuan1.jpg',
      'name'=>'杨美娟',
      ],
    '7'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/zhangyibo1.jpg',
      'name'=>'张毅博',
      ],
    '8'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/gaojiannan1.jpg',
      'name'=>'高建楠',
      ],
    '9'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/guoxiaorong1.jpg',
      'name'=>'郭小溶',
      ],
    '10'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg',
      'name'=>'靳荣',
      ],
    '11'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/libaocai1.jpg',
      'name'=>'李宝才',
    ],
    '12'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/dongyanchun1.jpg',
      'name'=>'董燕春',
      ],
 ];
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
            <div class="box-header with-border ">
              <div class="">
                <span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i><a href="#">当前位置:首页>小学部>教师风采</a></span>
              </div>
            </div>
            <div class="box-body">
                <div class="demo">
                  <div class="">
                    <div class="row teabor">

                    <?php foreach($teachers as $key =>$value){?>
                      <div class="col-md-4 col-sm-6">
                        <div class="box1 teacherdetail">
                          <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                          <div class="box-content">
                            <ul class="icon">
                              <li><a href="#"> <img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png" alt="Photo"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <?php }?>
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