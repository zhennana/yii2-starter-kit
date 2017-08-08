
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

                      <ul><?php foreach($school as $key =>$value){?>
                        <li class="col-md-4  col-sm-4 col-xs-4 img">
                          <div class="port-7 effect-2">
                            <div class="image-box" >
                              <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                            </div>
                          </div>
                        </li> <?php }?>
                      </ul>
                       <div class="modal-img">
                        <!--<h4><?php echo $value['name'];?></h4>
                                                         <p><?php echo $value['school'];?></p>-->
                             <span class="pre" style="position:absolute;color:#fff;font-size:30px;top:50%;left:10%;">
                                <img src="http://otdndy0jt.bkt.clouddn.com/left.png">
                             </span>
                             <ul>
                                <?php foreach($school as $key =>$value){?>
                                 <li>
                                     <img src="<?php echo $value['img'];?>" alt="Photo">
                                 </li>
                                 <?php }?>
                             </ul>
                             <span class="next" style="position:absolute;color:#fff;font-size:30px;top:50%;right:10%;">
                                <img src="http://otdndy0jt.bkt.clouddn.com/right.png">
                             </span>
                             <span class="close" style="color:#fff;">
                                <img src="http://otdndy0jt.bkt.clouddn.com/close1.png">
                             </span>
                     </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div></div>
<script>
    $('.img').click(function(){
        var num=$(this).index();
        var all=$(".modal-img ul li").size()-1;
        console.log(num);
         $('.modal-img').css({'visibility':'visible','opacity':1});
         $imgList=$(".modal-img ul li");
          $imgList.removeClass().eq(num).addClass("cur");
          $('.pre').click(function(){
             if(num>0){
                 $imgList.removeClass().eq(num-1).addClass("cur");
                 num-=1;
             }else{
                $imgList.removeClass().eq(all).addClass("cur");
                num=all;
            }
          })
          $('.next').click(function(){
           if(num<all){
                $imgList.removeClass().eq(num+1).addClass("cur");
                num+=1;
            }else{
               $imgList.removeClass().eq(0).addClass("cur");
               num=0;
           }
          })

      });
     $('.close').click(function(){
         $('.modal-img').css({'visibility':'hidden','opacity':0});
     })

</script>
