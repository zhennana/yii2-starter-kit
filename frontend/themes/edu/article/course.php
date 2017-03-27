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
                        <?php foreach($value['articles'] as $article){?>
                        <li class="clear-fix">
                            <a href="#">
                                <img  src="http://static.v1.wakooedu.com/A-%E6%A2%A6%E5%B9%BB%E7%A9%BA%E9%97%B4.jpg"
                                alt="描述信息">
                                <div class="course-info">
                                    <h4><?php echo $article['title']?></h4>
                                    <p>
                                       <?php echo $article['body'] ?>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
            <?php } ?>
            </div>
      
             <div id="course_school">
             <?php foreach($model['right'] as $key =>$value ){
                    if(empty($value['articles'])){
                        continue;
                    }
                ?>
                <div class="course-list">
                    <div class="course-type">
                        <span><?php echo $value['title']?></span>(中心思想)
                    </div>

                    <ul>
                    <?php foreach($value['articles'] as $k=>$article){?>
                        <li class="clear-fix">
                            <a href="#">
                                <img  src="http://static.v1.wakooedu.com/A-%E6%A2%A6%E5%B9%BB%E7%A9%BA%E9%97%B4.jpg"
                                alt="描述信息">
                                <div class="course-info">
                                    <h4><?php echo $article['title']?></h4>
                                    <p>
                                      <?php echo $article['body'] ?>
                                    </p>
                                </div>
                            </a>
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
         // var imgs = $('course-list').find('li').find('img');
        console.log(width);
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
         // var imgs = $('course-list').find('li').find('img');
        console.log(width);
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
