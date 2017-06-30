<?php
use yii\helpers\Html;

$imgsize="?imageView2/1/w/250/h/300";

 $teachers=[
    '1'=>[
    'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/libaocai1.jpg',
      'name'=>'李宝才',
      'school'=>'男，56岁，本科，哈尔滨师范大学，中学高级教师,光大小学教务主任。'
      
      ],
    '2'=>[
      
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg',
      'name'=>'靳荣',
      'school'=>'女，29岁，本科，河北师范大学（音乐教育），音乐。'
      ],
    '3'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/liuyanan1.jpg',
      'name'=>'刘亚南',
      'school'=>'女，27岁，本科，河北师范大学（汉语言文学），语文。'
      ],
    '4'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/tianyadong1.jpg',
      'name'=>'田亚东',
      'school'=>'女，35岁，本科，河北师范大学（英语教育），英语。',
      ],
    '5'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/tianyuan1.jpg',
      'name'=>'田媛',
      'school'=>'女，26岁，本科，西华师范大学（汉语言文学）。'
      ],
    '6'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/yangmeijuan1.jpg',
      'name'=>'杨美娟',
      'school'=>'女，35岁，本科，朝阳师范学院（美术教育 ），美术。'
      ],
    '7'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/zhangyibo1.jpg',
      'name'=>'张毅博',
      'school'=>'男，28岁，本科，北京体育大学（运动训练），体育。'
      ],
    '8'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/gaojiannan1.jpg',
      'name'=>'高建楠',
      'school'=>'女，25岁，本科，防灾科技学院（广告学），语文。'
      ],
    '9'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/guoxiaorong1.jpg',
      'name'=>'郭小溶',
      'school'=>'女，24岁，本科，北京城市学院，数学。'
      ],
    '10'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/qijing1.JPG',
      'name'=>'齐婧',
      'school'=>'女，26岁，本科，邢台学院（小学教育），数学。'
      ],
    '11'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/liangfengrui1.jpg',
      'name'=>'梁丰瑞',
      'school'=>'女，29岁，本科，河北师范大学，数学。'
    ],
    '12'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/dongyanchun2.jpg',
      'name'=>'董燕春',
      'school'=>'女，36岁，本科，廊坊师范学院（英语教育），英语。'
      ],
 ];
?>

<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      echo $this->render('@frontend/themes/gedu/article/common/sidebarnew',['category'=>$category]);
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-9 ">
      <div class="box box-widget geu-content">
            <div class="box-header with-border ">
              <div class="">
                <ol class="breadcrumb">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <li><?php echo Html::a('走进光大',['article/index','category_id'=>1])?></li>
                  <li class="activeli">教师风采</li>
                </ol>
              </div>
            </div>
            <div class="box-body">
                <div class="demo">
                  <div class="">
                    <div class="row teabor">
                    <?php foreach($teachers as $key =>$value){?>
                      <ul class="col-md-4 col-sm-4 col-xs-4">
                        <li>
                          <div class="port-3 effect-3">
                            <div class="image-box">
                              <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                            </div>
                            <div class="text-desc">
                              <h4><?php echo $value['name'];?></h4>
                              <p><?php echo $value['school'];?></p>
                            </div>
                          </div>
                        </li>
                        
                      </ul>
                      <?php }?>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>



<!-- 
  <div class="full-length row">
  <div class="container">
     <ul>
      <li>
        <div class="port-6 effect-1 ">
          <div class="image-box ">
            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/liangfengrui1.jpg" alt="Image-1">
          </div>
          <div class="text-desc">
            <h3>Your Title</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <a href="#" class="btn">Learn more</a>
          </div>
        </div>
      </li>
      <li>
        <div class="port-6 effect-2 ">
          <div class="image-box" style="height: 15px;width: 20px">
            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/liangfengrui1.jpg" alt="Image-2">
          </div>
          <div class="text-desc">
            <h3>Your Title</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <a href="#" class="btn">Learn more</a>
          </div>
        </div>
      </li>
      <li class="col-md-4">
        <div class="port-6 effect-3 ">
          <div class="image-box">
            <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/liangfengrui1.jpg" alt="Image-3">
          </div>
          <div class="text-desc">
            <h3>Your Title</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <a href="#" class="btn">Learn more</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div> -->















