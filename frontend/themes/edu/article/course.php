<div class="content">
    <div id="course">
        <div class="col-sm-8 course-left-side">
            <div class="course-title-warp">
                <div class="course-title left active">学前课程(3-6岁)</div>
                <div class="course-title right ">学龄课程(7-13岁)</div>
            </div>
            <div id="course_preschool">
                <div class="course-list">
                    <div class="course-type">
                        <span>3岁</span>(A+感知与认识/B+认识与思考)
                    </div>

                    <ul>
                        <li class="clear-fix">
                            <a href="#">
                                <img  src="http://static.v1.wakooedu.com/A-%E6%A2%A6%E5%B9%BB%E7%A9%BA%E9%97%B4.jpg"
                                alt="描述信息">
                                <div class="course-info">
                                    <h4>A梦幻空间 (20课次)</h4>
                                    <p>
                                        课程中围绕孩子们最先熟悉的家，展开一系列的故事和活动。课程宗旨让孩子发现自我，
                                        感知世界。培养孩子们学习口语和其他技巧。了解一些输入输出模型，原因和结果的概念以及相关知识。
                                        涵盖测量与比较、城市建设及生存环境，锻炼孩子大肌肉发展，开发孩子的智力和交流能力。
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="clear-fix">
                            <a href="http://www.baidu.com">
                                <img  src="http://static.v1.wakooedu.com/N-%E5%8A%A8%E5%8A%9B%E4%B8%8E%E6%9C%BA%E6%A2%B0%E2%85%A1.jpg"
                                alt="N-动力与机械Ⅱ.jpg">
                                <div class="course-info">
                                    <h4>A梦幻空间 (20课次)</h4>
                                    <p>
                                        课程中围绕孩子们最先熟悉的家，展开一系列的故事和活动。课程宗旨让孩子发现自我，
                                        感知世界。培养孩子们学习口语和其他技巧。了解一些输入输出模型，原因和结果的概念以及相关知识。
                                        涵盖测量与比较、城市建设及生存环境，锻炼孩子大肌肉发展，开发孩子的智力和交流能力。
                                    </p>
                                </div>
                            </a>
                        </li> 
                    </ul>
                </div>
            </div>

            <div id="course_school">
                <div class="course-list">
                    <div class="course-type">
                        <span>7岁</span>(中心思想)
                    </div>

                    <ul>
                        <li class="clear-fix">
                            <a href="#">
                                <img  src="http://static.v1.wakooedu.com/A-%E6%A2%A6%E5%B9%BB%E7%A9%BA%E9%97%B4.jpg"
                                alt="描述信息">
                                <div class="course-info">
                                    <h4>H梦幻空间 (20课次)</h4>
                                    <p>
                                        课程中围绕孩子们最先熟悉的家，展开一系列的故事和活动。课程宗旨让孩子发现自我，
                                        感知世界。培养孩子们学习口语和其他技巧。了解一些输入输出模型，原因和结果的概念以及相关知识。
                                        涵盖测量与比较、城市建设及生存环境，锻炼孩子大肌肉发展，开发孩子的智力和交流能力。
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="clear-fix">
                            <a href="http://www.baidu.com">
                                <img  src="http://static.v1.wakooedu.com/N-%E5%8A%A8%E5%8A%9B%E4%B8%8E%E6%9C%BA%E6%A2%B0%E2%85%A1.jpg"
                                alt="N-动力与机械Ⅱ.jpg">
                                <div class="course-info">
                                    <h4>I梦幻空间 (20课次)</h4>
                                    <p>
                                        课程中围绕孩子们最先熟悉的家，展开一系列的故事和活动。课程宗旨让孩子发现自我，
                                        感知世界。培养孩子们学习口语和其他技巧。了解一些输入输出模型，原因和结果的概念以及相关知识。
                                        涵盖测量与比较、城市建设及生存环境，锻炼孩子大肌肉发展，开发孩子的智力和交流能力。
                                    </p>
                                </div>
                            </a>
                        </li> 
                    </ul>
                </div>
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
