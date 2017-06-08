<div class="main-2">
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
                            <li data-target="#myCarousel2" data-slide-to="3"></li>
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner">
                            <div class="item active">
                            <?php
                                $images=getImgs($data['teacher']['all']['body']);
                                //echo'<pre>';var_dump($images) ;exit;
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key<4){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>全部</p></div>
                              </div> 
                              <?php }}
                            ?>
                            
                              </div>                                   
                            
                            <div class="item">
                            <?php
                                $images=getImgs($data['teacher']['all']['body']);
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key>3&&$key<8){                 
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>全部</p></div>
                              </div>
                               <?php }} ?>
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
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner">
                            <div class="item active">
                            <?php
                                $images=getImgs($data['teacher']['primary']['body']);
                                //echo'<pre>';var_dump($images) ;exit;
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key<4){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>小学部</p></div>
                              </div> 
                              <?php }}
                            ?>
                            
                              </div>                                   
                            
                            <div class="item">
                            <?php
                                $images=getImgs($data['teacher']['primary']['body']);
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key>3&&$key<8){ 
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>小学部</p></div>
                              </div>
                               <?php }} ?>

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
                            
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner">
                            <div class="item active">
                            <?php
                                $images=getImgs($data['teacher']['middle']['body']);
                                //echo'<pre>';var_dump($images) ;exit;
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key<4){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>中学</p></div>
                              </div> 
                              <?php }}
                            ?>
                            
                              </div>                                   
                            
                            <div class="item">
                            <?php
                                $images=getImgs($data['teacher']['middle']['body']);
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key>3&&$key<8){                 
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>中学</p></div>
                              </div>
                               <?php }} ?>
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
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner">
                            <div class="item active">
                            <?php
                                $images=getImgs($data['teacher']['internation']['body']);
                                //echo'<pre>';var_dump($images) ;exit;
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key<4){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>国际部</p></div>
                              </div> 
                              <?php }}
                            ?>
                            
                              </div>                                   
                            
                            <div class="item">
                            <?php
                                $images=getImgs($data['teacher']['middle']['body']);
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key>3&&$key<8){                 
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>齐靖</p></div>
                              </div>
                               <?php }} ?>
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
                        </ol>   
                        <!-- 轮播（Carousel）项目 -->
                        <div class="carousel-inner">
                            <div class="item active">
                            <?php
                                $images=getImgs($data['teacher']['speciality']['body']);
                                //echo'<pre>';var_dump($images) ;exit;
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key<4){          
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>特长部</p></div>
                              </div> 
                              <?php }}
                            ?>
                            
                              </div>                                   
                            
                            <div class="item">
                            <?php
                                $images=getImgs($data['teacher']['speciality']['body']);
                                foreach ($images as $key => $value) {
                                    $img[$key]=$value.'?imageView2/1/w/250/h/300';
                                    if($key>3&&$key<8){                 
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="box1">
                                  <img class="img-responsive" src="<?php echo $img[$key];?>" alt="Photo">
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
                                <div class="main-2-teacher-inner-p"><p>特长部</p></div>
                              </div>
                               <?php }} ?>
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
</div>
