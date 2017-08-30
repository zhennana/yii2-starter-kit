
<?php
use yii\helpers\Html;

$school=[
    '1'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/tihuan1.jpg',
      'name'=>'快乐高效课堂',
      'school'=>'温馨快乐校园建设的主阵地，全面提高学生思想道德、科学文化、身心健康全面发展。'
      ],
    '2'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/wudao.jpg',
      'name'=>'跳动的精灵',
      'school'=>'在舞蹈的殿堂里，他们舒展沉睡的羽翼，释放天性，自由的飞舞，用心与美来感受爱的真谛。'
      ],
    '3'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/3xiaoyuan.jpg',
      'name'=>'探索 求知 明理',
      'school'=>'在实验室里动手动脑，大胆探索，反复实验，培养孩子广泛的求知欲。'
      ],
    '4'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/4xiaoyuan.jpg',
      'name'=>'网络让教育动起来',
      'school'=>'网络连接世界，在多彩的电脑课程中，培养孩子的搜索能力、鉴别能力、沟通能力'
      ],
    '5'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/xiaoyuan.jpg',
      'name'=>'快乐的元旦',
      'school'=>'微笑的脸蛋甜蜜灿烂，愿每个孩子的明天无限美丽，无限迷人，去获取你光明的未来。'
      ],
    '6'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/9xiaoyuan.jpg',
      'name'=>'中外交流',
      'school'=>'在课堂上让感受中外文化思想的碰撞，推动教育全球化，文化多样化。'
      ],
    '7'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/10xiaoyuan.jpg',
      'name'=>'生动活泼的乐园',
      'school'=>'作为课堂的延伸，为学生提供展示才华和发展特长的舞台，更要让学生体验到学习生活的多姿多彩。'
      ],
      '8'=>[
      'img'=>'http://static.v1.guangdaxuexiao.com/12xiaoyuan.jpg',
      'name'=>'成长道路上的激励与赞赏',
      'school'=>'孩子们不放弃一点机会，不停止一日努力，不抱有一丝幻想，成长的道路上你们一定能行！'
      ],
 ];
?>
<div class="tuoutu">
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

                      <ul style="overflow:hidden;padding:0;"><?php foreach($school as $key =>$value){
                        $img=$value['img']."?imageView2/1/w/500/h/400";
                        ?>
                        <li class="col-md-4  col-sm-4 col-xs-4 img" style="cursor:pointer;">
                          <div class="port-7 effect-2">
                            <div class="image-box" >
                              <img class="img-responsive" src="<?php echo $img;?>" alt="Photo">
                            </div>
                          </div>
                        </li> <?php }?>
                      </ul>
                       <div class="modal-img">
                        <!--<h4><?php //echo $value['name'];?></h4>
                                                         <p><?php //echo $value['school'];?></p>-->
                             <span class="pre" style="position:absolute;color:#fff;font-size:30px;top:50%;left:5%;z-index:2;cursor:pointer;">
                                <img src="http://static.v1.guangdaxuexiao.com/Left%20%281%29.png">
                             </span>
                             <ul>
                                <?php foreach($school as $key =>$value){
                                  ?>
                                 <li>
                                     <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                 </li>
                                 <?php }?>
                             </ul>
                             <span class="next1" style="position:absolute;color:#fff;font-size:30px;top:50%;right:5%;cursor:pointer;">
                                <img src="http://static.v1.guangdaxuexiao.com/right%20%285%29.png">
                             </span>
                             <span class="close1" style="color:#fff;cursor:pointer;">
                                <img src="http://static.v1.guangdaxuexiao.com/close.png">
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
          $('.next1').click(function(){
           if(num<all){
                $imgList.removeClass().eq(num+1).addClass("cur");
                num+=1;
            }else{
               $imgList.removeClass().eq(0).addClass("cur");
               num=0;
           }
          })

      });
     $('.close1').click(function(){
         $('.modal-img').css({'visibility':'hidden','opacity':0});
     })

</script>
