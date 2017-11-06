
<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$imgsize = '?imageView2/1/w/500/h/400';

?>
<div class="tuoutu">
    <img width='100%' src="http://orh16je38.bkt.clouddn.com/everbright.jpg?imageView2/1/w/1920/h/400">
</div>

<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?= $this->render('@frontend/themes/gedu/article/common/sidebarnew',['category'=>$category]); ?>

    <!-- 文章内容部分 -->
    <div class="col-md-9 campuse-content">
      <div class="box box-widget geu-content">
        <div class="box-header with-border ">

          <ol class="breadcrumb">
            <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp
              <?php echo Html::a('首页',['site/index'])?></li>
            <li><?php echo Html::a('走进光大',['article/index','category_id'=>1])?></li>
            <li class="activeli">校园风光</li>
          </ol>

        </div>

        <div class="box-body">
          <div class="demo">
            <div class="row teabor">

              <ul class="xiaotu" style="overflow:hidden;padding:0;">

                <?php foreach($sights as $key =>$value){ ?>
                  <li class="col-md-4  col-sm-4 col-xs-4 img">
                    <div class="port-7 effect-2">

                      <div class="image-box" >
                      <img class="img-responsive" src="<?= getImgs($value['body'])[0].$imgsize;?>" alt="Photo">
                        <p class="img-title"><?= strip_tags($value['body']) ?>
                          <span class="img-time">上传时间:<?= date('Y-m-d',$value['published_at']) ?></span>
                        </p>
                      </div>

                    </div>
                  </li>
                <?php }?>

              </ul>

              <div class="modal-img">
                <span class="pre" style="position:absolute;color:#fff;font-size:30px;top:50%;left:5%;z-index:2;">
                  <img src="http://static.v1.guangdaxuexiao.com/Left%20%281%29.png">
                </span>

                <ul>
                  <?php foreach($sights as $key =>$value){ ?>
                    <li>
                    <img class="img-responsive" src="<?= getImgs($value['body'])[0];?>" alt="Photo">

                      <!--<p class="bigImg-title"><?= $value['title'] ?></p>-->
                     <!--<p class="bigImg-title"><?= strip_tags($value['body']) ?></p>-->

                    </li>
                  <?php } ?>
                </ul>

                <span class="next1" style="position:absolute;color:#fff;font-size:30px;top:50%;right:5%;">
                  <img src="http://static.v1.guangdaxuexiao.com/right%20%285%29.png">
                </span>

                <span class="close1" style="color:#fff;">
                  <img src="http://static.v1.guangdaxuexiao.com/close.png">
                </span>
              </div>

              <?= LinkPager::widget(['pagination' => $pages]); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).on('click','.img',function(e){
        var num=$(this).index();
        var all=$(".modal-img ul li").size()-1;
        console.log(num);
        $('.xiaotu').css({'display':'none'});
         $('.modal-img').css({'visibility':'visible','opacity':1});
         $imgList=$(".modal-img ul li");
          $imgList.removeClass().eq(num).addClass("cur");
          $(document).on('click','.pre',function(){
             if(num>0){
                 $imgList.removeClass().eq(num-1).addClass("cur");
                 num-=1;
             }else{
                $imgList.removeClass().eq(all).addClass("cur");
                num=all;
            }
          })
          $(document).on('click','.next1',function(){
           if(num<all){
                $imgList.removeClass().eq(num+1).addClass("cur");
                num+=1;
            }else{
               $imgList.removeClass().eq(0).addClass("cur");
               num=0;
           }
          })

      });
     $(document).on('click','.close1',function(){
         $('.modal-img').css({'visibility':'hidden','opacity':0});
         $('.xiaotu').css({'display':'block'});
     });
</script>
