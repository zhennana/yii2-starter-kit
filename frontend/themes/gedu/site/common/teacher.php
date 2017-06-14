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
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/dongyanchun2.jpg',
      'name'=>'董燕春',
      ],
 ];
?>

    <div class="main-2-head">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-top">
                    <h1>TEACHER STYLE</h1>
                    <h4>教师风采</h4>
                    <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-line.png" width="100%">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-nav">
                    <span class="active"><a href="#revenue-chart" data-toggle="tab" aria-expanded="true">全部</a></span>
                    <span class=""><a href="#primary-chart" data-toggle="tab" aria-expanded="false">小学部</a></span>
                    <span class=""><a href="#middle-chart" data-toggle="tab" aria-expanded="false">中学部</a></span>
                    <span class=""><a href="#internation-chart" data-toggle="tab" aria-expanded="false">国际部</a></span>
                    <span class=""><a href="#speciality-chart" data-toggle="tab" aria-expanded="false">特长部</a></span> 
                </div>
            </div>
        </div>
    </div>
  <div class="tab-content no-padding">
    <!-- Morris chart - Sales -->
    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 500px;">
        <div class="main-2-teacher">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="myCarousel2" class="carousel slide">
                        <!-- 轮播（Carousel）指标 -->
                        <ol class="carousel-indicators main-2-teacher-ol">
                            <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel2" data-slide-to="1"></li>
                            <li data-target="#myCarousel2" data-slide-to="2"></li>
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner" id="teacher">
                            <div class="item active">
                                <?php
                                    foreach ($teachers as $key => $value) {
                                        
                                        if($key>1&&$key<6){          
                                ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="box1">
                                      <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                      <div class="box-content">
                                        <ul class="icon">
                                          <?php 
                                            $href= yii\helpers\Url::to(['site/teacher']);
                                            $html='';
                                            $html.='<li><a href="'.$href.'">';
                                            $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                            $html.='</a></li>';
                                            echo $html;
                                        ?> 
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                                  </div> 
                                  <?php }}
                                ?>
                            </div>                                   
                            
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(5<$key&&$key<10){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(9<$key&&$key<14){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                        </div>
                        <!-- 轮播（Carousel）导航 -->
                        <a class="carousel-control left main-2-teacher-left" href="#myCarousel2" 
                           data-slide="prev"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-L.png"></a>
                        <a class="carousel-control right main-2-teacher-right" href="#myCarousel2" 
                           data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-R.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    </div>
    <div class="chart tab-pane" id="primary-chart" style="position: relative; height: 500px;">
      <div class="main-2-teacher">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="myCarousel3" class="carousel slide">
                        <!-- 轮播（Carousel）指标 -->
                        <ol class="carousel-indicators main-2-teacher-ol">
                            <li data-target="#myCarousel3" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel3" data-slide-to="1"></li>
                            <li data-target="#myCarousel6" data-slide-to="2"></li>

                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner" id="teacher">
                            <div class="item active">
                                <?php
                                    
                                    foreach ($teachers as $key => $value) {
                                        
                                        if($key>2&&$key<7){          
                                ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="box1">
                                      <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                      <div class="box-content">
                                        <ul class="icon">
                                          <?php 
                                            $href= yii\helpers\Url::to(['site/teacher']);
                                            $html='';
                                            $html.='<li><a href="'.$href.'">';
                                            $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                            $html.='</a></li>';
                                            echo $html;
                                        ?> 
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                                  </div> 
                                  <?php }}
                                ?>
                            </div>                                   
                            
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(6<$key&&$key<11){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(10<$key&&$key<14){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                        </div>
                        <!-- 轮播（Carousel）导航 -->
                        <a class="carousel-control left main-2-teacher-left" href="#myCarousel2" 
                           data-slide="prev"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-L.png"></a>
                        <a class="carousel-control right main-2-teacher-right" href="#myCarousel2" 
                           data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-R.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    </div>
    <div class="chart tab-pane" id="middle-chart" style="position: relative; height: 500px;">
      <div class="main-2-teacher">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="myCarousel4" class="carousel slide">
                        <!-- 轮播（Carousel）指标 -->
                        <ol class="carousel-indicators main-2-teacher-ol">
                            <li data-target="#myCarousel4" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel4" data-slide-to="1"></li>
                            <li data-target="#myCarousel6" data-slide-to="2"></li>
                            
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner" id="teacher">
                            <div class="item active">
                                <?php
                                    
                                    foreach ($teachers as $key => $value) {
                                        
                                        if($key<5){          
                                ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="box1">
                                      <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                      <div class="box-content">
                                        <ul class="icon">
                                          <?php 
                                            $href= yii\helpers\Url::to(['site/teacher']);
                                            $html='';
                                            $html.='<li><a href="'.$href.'">';
                                            $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                            $html.='</a></li>';
                                            echo $html;
                                        ?> 
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                                  </div> 
                                  <?php }}
                                ?>
                            </div>                                   
                            
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(4<$key&&$key<9){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(8<$key&&$key<13){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                        </div>
                        <!-- 轮播（Carousel）导航 -->
                        <a class="carousel-control left main-2-teacher-left" href="#myCarousel2" 
                           data-slide="prev"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-L.png"></a>
                        <a class="carousel-control right main-2-teacher-right" href="#myCarousel2" 
                           data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-R.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    </div>
    <div class="chart tab-pane" id="internation-chart" style="position: relative; height: 500px;">
      <div class="main-2-teacher">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="myCarousel5" class="carousel slide">
                        <!-- 轮播（Carousel）指标 -->
                        <ol class="carousel-indicators main-2-teacher-ol">
                            <li data-target="#myCarousel5" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel5" data-slide-to="1"></li>
                            <li data-target="#myCarousel6" data-slide-to="2"></li>

                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner" id="teacher">
                            <div class="item active">
                                <?php
                                    
                                    foreach ($teachers as $key => $value) {
                                        
                                        if($key>3&&$key<8){          
                                ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="box1">
                                      <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                      <div class="box-content">
                                        <ul class="icon">
                                          <?php 
                                            $href= yii\helpers\Url::to(['site/teacher']);
                                            $html='';
                                            $html.='<li><a href="'.$href.'">';
                                            $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                            $html.='</a></li>';
                                            echo $html;
                                        ?> 
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                                  </div> 
                                  <?php }}
                                ?>
                            </div>                                   
                            
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(4<$key&&$key<9){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(8<$key&&$key<13){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                        </div>
                        <!-- 轮播（Carousel）导航 -->
                        <a class="carousel-control left main-2-teacher-left" href="#myCarousel2" 
                           data-slide="prev"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-L.png"></a>
                        <a class="carousel-control right main-2-teacher-right" href="#myCarousel2" 
                           data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-R.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    </div>
    <div class="chart tab-pane" id="speciality-chart" style="position: relative; height: 500px;">
      <div class="main-2-teacher">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="myCarousel6" class="carousel slide">
                        <!-- 轮播（Carousel）指标 -->
                        <ol class="carousel-indicators main-2-teacher-ol">
                            <li data-target="#myCarousel6" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel6" data-slide-to="1"></li>
                            <li data-target="#myCarousel6" data-slide-to="2"></li>
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner" id="teacher">
                            <div class="item active">
                                <?php
                                    
                                    foreach ($teachers as $key => $value) {
                                        
                                        if($key<5){          
                                ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="box1">
                                      <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                      <div class="box-content">
                                        <ul class="icon">
                                          <?php 
                                            $href= yii\helpers\Url::to(['site/teacher']);
                                            $html='';
                                            $html.='<li><a href="'.$href.'">';
                                            $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                            $html.='</a></li>';
                                            echo $html;
                                        ?> 
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                                  </div> 
                                  <?php }}
                                ?>
                            </div>                                   
                            
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(4<$key&&$key<9){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                            <div class="item">
                            <?php
                                
                                foreach ($teachers as $key => $value) {
                                    
                                    if(8<$key&&$key<13){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                                  <div class="box-content">
                                    <ul class="icon">
                                      <?php 
                                        $href= yii\helpers\Url::to(['site/teacher']);
                                        $html='';
                                        $html.='<li><a href="'.$href.'">';
                                        $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                        $html.='</a></li>';
                                        echo $html;
                                    ?> 
                                    </ul>
                                  </div>
                                </div>
                                <div class="main-2-teacher-inner-p"><p><?php echo $value['name'];?></p></div>
                              </div> 
                              <?php }}
                            ?>
                            </div>
                        </div>
                        <!-- 轮播（Carousel）导航 -->
                        <a class="carousel-control left main-2-teacher-left" href="#myCarousel2" 
                           data-slide="prev"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-L.png"></a>
                        <a class="carousel-control right main-2-teacher-right" href="#myCarousel2" 
                           data-slide="next"><img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-2-R.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    </div>
  </div>