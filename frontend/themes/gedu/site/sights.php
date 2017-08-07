
<?php
use yii\helpers\Html;

$school=[
    '1'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-2.png?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '2'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '3'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-3.png?imageView2/1/w/500/h/400',
      'name'=>'讲台',
      'school'=>'光大学校讲台'
      ],
    '4'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/jiaoxuelou.jpg?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '5'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/shiyanshi.jpg?imageView2/1/w/500/h/400',
      'name'=>'实验室',
      'school'=>'光大学校教学楼'
      ],
    '6'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/librayry.jpg?imageView2/1/w/500/h/400',
      'name'=>'图书馆',
      'school'=>'光大学校图书馆'
      ],
    '7'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/sushe.jpg?imageView2/1/w/500/h/400',
      'name'=>'宿舍',
      'school'=>'光大学校宿舍'
      ],
 ];
?>
<div style="margin-left:-15px;margin-right:-15px;">
    <img width='100%' src="http://orh16je38.bkt.clouddn.com/everbright.jpg?imageView2/1/w/1920/h/400">
</div>
<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      echo $this->render('@frontend/themes/gedu/article/common/sidebarnew',['category'=>$category]);
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-9 campuse-content">
      <div class="box box-widget geu-content">
            <div class="box-header with-border ">
              <div class="">
                <ol class="breadcrumb">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <li><?php echo Html::a('走进光大',['article/index','category_id'=>1])?></li>
                  <li class="activeli">校园风光</li>
                </ol>
              </div>
            </div>
            <div class="box-body">
                <div class="demo">
                  <div class="">
                    <div class="row teabor">
                    <?php foreach($school as $key =>$value){?>
                      <ul class="col-md-4  col-sm-4 col-xs-4 img">
                        <li>
                          <div class="port-7 effect-2">
                            <div class="image-box" >
                              <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                            </div>
                            <div class="modal-img">
                                <!--   <h4><?php echo $value['name'];?></h4>
                                <p><?php echo $value['school'];?></p> -->
                               <img src="<?php echo $value['img'];?>" alt="Photo">
//                               <span style="color:#fff" class="pre">上一张</span>
//                               <span style="color:#fff" class="next">下一张</span>
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
</div></div>
<script>
    $('.image-box').click(function(){
        $(this).next().css({'visibility':'visible','opacity':1});
      });
     $('.modal-img').click(function(){
         $(this).css({'visibility':'hidden','opacity':0});
     })

</script>
