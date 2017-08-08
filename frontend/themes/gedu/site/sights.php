
<?php
use yii\helpers\Html;

$school=[
    '1'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/1xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'快乐高效课堂',
      'school'=>'温馨快乐校园建设的主阵地，全面提高学生思想道德、科学文化、身心健康全面发展。'
      ],
    '2'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/2xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'陶冶性情的熔炉',
      'school'=>'用音乐打开想象的闸门，聆听，最美丽的音乐；倾听，最唯美的境界。'
      ],
    '3'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/3xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'探索 求知 明理',
      'school'=>'在实验室里动手动脑，大胆探索，反复实验，培养孩子广泛的求知欲。'
      ],
    '4'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/4xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'网络让教育动起来',
      'school'=>'网络连接世界，在多彩的电脑课程中，培养孩子的搜索能力、鉴别能力、沟通能力'
      ],
    '5'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/7xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'文明宿舍一条心',
      'school'=>'温馨整洁的宿舍，是漫漫求学路上一个贴心而又温暖的港湾。'
      ],
    '6'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/9xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'中外交流',
      'school'=>'在课堂上让感受中外文化思想的碰撞，推动教育全球化，文化多样化。'
      ],
    '7'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/10xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'生动活泼的乐园',
      'school'=>'作为课堂的延伸，为学生提供展示才华和发展特长的舞台，更要让学生体验到学习生活的多姿多彩。'
      ],
      '8'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/12xiaoyuan.jpg?imageView2/1/w/500/h/400',
      'name'=>'成长道路上的激励与赞赏',
      'school'=>'孩子们不放弃一点机会，不停止一日努力，不抱有一丝幻想，成长的道路上你们一定能行！'
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
