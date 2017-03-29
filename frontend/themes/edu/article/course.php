<?php
use yii\helpers\Html;
//默认图片
$image = 'http://static.v1.wakooedu.com/A-%E6%A2%A6%E5%B9%BB%E7%A9%BA%E9%97%B4.jpg'.'?imageView2/3/w/400/h/400';
?>
<div class="content">
    <div id="course">
        <div class="col-sm-8 course-left-side">
            <div class="course-title-warp">
                <div class="course-title left active">学前课程(3-6岁)</div>
                <div class="course-title right ">学龄课程(7-13岁)</div>
            </div>
           
             <div id="course_preschool">
                <?php foreach($model['left'] as $key=>$value){
                        if(empty($value['articles'])){
                            continue;
                        }
                    ?>
                <div class="course-list">
                    <div class="course-type">
                        <span><?php echo $value['title']?>
                </div>

                    <ul>
                        <?php foreach($value['articles'] as $article){
                           // var_dump($article['body']);exit;
                            $images = [];
                            $images = getImgs($article['body']);
                             if(!empty($images)){
                                $image = $images[0].'?imageView2/3/w/400/h/400';
                             }
                        
                            ?>
                        <li class="clear-fix">
                            <?php
                                echo Html::a(
                                    '<img  src='.$image.' alt="描述信息"/>'.
                                    '<div class="course-info"><h4>'. $article['title'].'</h4><p>'.strip_tags($article['body']).'</p></div>',
                                    [
                                        'article/view','id'=>$article['id']
                                    ]);
                            ?>        
                        </li>
                        <?php }?>
                    </ul>
                </div>
            <?php } ?>
            </div>
      
             <div id="course_school" style="display: none">
             <?php foreach($model['right'] as $key =>$value ){
                    if(empty($value['articles'])){
                        continue;
                    }
                ?>
                <div class="course-list">
                    <div class="course-type">
                        <span><?php echo $value['title']?></span>
                    </div>

                    <ul>
                    <?php foreach($value['articles'] as $k=>$article){
                            $images = [];
                            $images = getImgs($article['body']);
                            if(!empty($images)){
                                $image = $images[0].'?imageView2/3/w/400/h/400';
                            }
                        ?>
                        <li class="clear-fix">
                             <?php
                                echo Html::a(
                                    '<img  src='.$image.' alt="描述信息"/>'.
                                    '<div class="course-info"><h4>'. $article['title'].'</h4><p>'.strip_tags($article['body']).'</p></div>',
                                    [
                                        'article/view','id'=>$article['id']
                                    ]);
                            ?>        
                        </li>
                    <?php }?>
                    </ul>
                </div>
                <?php }?>
            </div> 
            
        </div>

        <div class="col-sm-4 right-public">
        
        </div>
    </div>
</div>
<script>
    // 课程体系页面 列表百分比适配  
    $(window).load(function(){
         var width = $(window).width();
         if(width<1000){
          
            $('.course-list ul li img').css('width','100%');
            $('.course-list ul li .course-info').css('width','100%');
            $('.course-list ul li .course-info').css('margin-top','10px');
         }else{
            $('.course-list ul li img').css('width','48%');
            $('.course-list ul li .course-info').css('width','50%');
            $('.course-list ul li .course-info').css('margin-top','');
         }
    });


    $(window).resize(function(){
         var width = $(window).width();
         if(width<1000){
            $('.course-list ul li img').css('width','100%');
            $('.course-list ul li .course-info').css('width','100%');
            $('.course-list ul li .course-info').css('margin-top','10px');
         }else{
            $('.course-list ul li img').css('width','48%');
            $('.course-list ul li .course-info').css('width','50%');
              $('.course-list ul li .course-info').css('margin-top','');
         }
    });

    //学前学龄课程点击事件
    $(".course-title-warp .right").click(function(event) {
        if(event.target.getAttribute('class').indexOf('active')===-1){
            event.target.setAttribute('class','course-title right active');
            $("#course_school").css('display','block');
            $("#course_preschool").css('display', 'none');
            $(".course-title-warp .left").removeClass('active');
        }
        
        event.stopPropagation();
    });


    $(".course-title-warp .left").click(function(event) {
        if(event.target.getAttribute('class').indexOf('active')===-1){
            event.target.setAttribute('class','course-title left active');
            $("#course_school").css('display','none');
            $("#course_preschool").css('display', 'block');
            $(".course-title-warp .right").removeClass('active');
        }   
        
        event.stopPropagation();
    });
</script>
