<?php
use yii\helpers\Html;
$imgsize="?imageView2/1/w/250/h/300";

 $teachers=[

    '1'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg',
      'name'=>'靳荣',
      ],
    '2'=>[
      
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/libaocai1.jpg',
      'name'=>'李宝才',
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
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/liangfengrui1.jpg',
      'name'=>'梁丰瑞',
      ],
    '11'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/qijing1.JPG',
      'name'=>'齐婧',
    ],
    '12'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/dongyanchun2.jpg',
      'name'=>'董燕春',
      ],
 ];
?>

    <div class="main-2-head">
        <div class="row row-teacher">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-top">
                <div class="main-2-top-child">
                    <h1>TEACHER STYLE</h1>
                    <h4>教师风采</h4>
                    <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-line.png" width="100%">
                </div>
            </div>
        <!--    <div class="main-2-nav-fu">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-2-nav">
                  <span class="active"><a href="#revenue-chart" data-toggle="tab" aria-expanded="true">全部</a></span>
                  <span class=""><a href="#primary-chart" data-toggle="tab" aria-expanded="false">小学部</a></span>
                  <span class=""><a href="#middle-chart" data-toggle="tab" aria-expanded="false">中学部</a></span>
                  <span class=""><a href="#internation-chart" data-toggle="tab" aria-expanded="false">国际部</a></span>
                  <span class=""><a href="#speciality-chart" data-toggle="tab" aria-expanded="false">特长部</a></span>
              </div>
            </div> -->
           
        </div>
    </div>
<!-- 教师风采图片-->
   <div class="tab-content-fu">
        <div class="teacher-wrap">
            <div class="col-sm-6 col-md-4 teacher-img teacher-img1">
                <div class="panel panel-default panel-card">
                    <div class="panel-heading">
                        <img style="width:100%;height:100%;" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png?imageView2/1/w/272/h/50">
                    </div>
                    <div class="panel-figure">
                        <img class="img-responsive img-circle" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg">
                    </div>
                    <div class="panel-body text-center">
                        <h4 class="panel-header"><a href="http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg">靳荣</a></h4>
                        <small>女，29岁，本科，河北师范大学（音乐教育），音乐。</small>
                    </div>
                    <div class="panel-thumbnails">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="icon">
                                  <?php
                                    $href= yii\helpers\Url::to(['site/teacher','category_id'=>'38']);
                                    $html='';
                                    $html.='<li><a href="'.$href.'">';
                                    $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                    $html.='</a></li>';
                                    echo $html;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 teacher-img teacher-img1">
                <div class="panel panel-default panel-card">
                    <div class="panel-heading">
                        <img style="width:100%;height:100%;" src="http://orh16je38.bkt.clouddn.com/11.jpg?imageView2/1/w/272/h/50">
                    </div>
                    <div class="panel-figure">
                        <img class="img-responsive img-circle" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/libaocai1.jpg">
                    </div>
                    <div class="panel-body text-center">
                        <h4 class="panel-header"><a href="http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg">李宝才</a></h4>
                        <small>男，56岁，本科，哈尔滨师范大学，中学高级教师,光大小学教务主任。</small>
                    </div>
                    <div class="panel-thumbnails">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="icon">
                                  <?php
                                    $href= yii\helpers\Url::to(['site/teacher','category_id'=>'38']);
                                    $html='';
                                    $html.='<li><a href="'.$href.'">';
                                    $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                    $html.='</a></li>';
                                    echo $html;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 teacher-img teacher-img1">
                <div class="panel panel-default panel-card">
                    <div class="panel-heading">
                        <img style="width:100%;height:100%;" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png?imageView2/1/w/272/h/50">
                    </div>
                    <div class="panel-figure">
                        <img class="img-responsive img-circle" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/liuyanan1.jpg">
                    </div>
                    <div class="panel-body text-center">
                        <h4 class="panel-header"><a href="http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg">刘亚南</a></h4>
                        <small>女，27岁，本科，河北师范大学（汉语言文学），语文。</small>
                    </div>
                    <div class="panel-thumbnails">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="icon">
                                  <?php
                                    $href= yii\helpers\Url::to(['site/teacher','category_id'=>'38']);
                                    $html='';
                                    $html.='<li><a href="'.$href.'">';
                                    $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                    $html.='</a></li>';
                                    echo $html;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 teacher-img teacher-img2">
                <div class="panel panel-default panel-card">
                    <div class="panel-heading">
                        <img style="width:100%;height:100%;" src="http://orh16je38.bkt.clouddn.com/11.jpg?imageView2/1/w/272/h/50">
                    </div>
                    <div class="panel-figure">
                        <img class="img-responsive img-circle" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/tianyadong1.jpg">
                    </div>
                    <div class="panel-body text-center">
                        <h4 class="panel-header"><a href="http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg">田亚东</a></h4>
                        <small>女，35岁，本科，河北师范大学（英语教育），英语。</small>
                    </div>
                    <div class="panel-thumbnails">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="icon">
                                  <?php
                                    $href= yii\helpers\Url::to(['site/teacher','category_id'=>'38']);
                                    $html='';
                                    $html.='<li><a href="'.$href.'">';
                                    $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                    $html.='</a></li>';
                                    echo $html;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 teacher-img teacher-img2">
                <div class="panel panel-default panel-card">
                    <div class="panel-heading">
                        <img style="width:100%;height:100%;" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png?imageView2/1/w/272/h/50">
                    </div>
                    <div class="panel-figure">
                        <img class="img-responsive img-circle" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/tianyuan1.jpg">
                    </div>
                    <div class="panel-body text-center">
                        <h4 class="panel-header"><a href="http://7xsm8j.com2.z0.glb.qiniucdn.com/tianyuan1.jpg">田媛</a></h4>
                        <small>女，26岁，本科，西华师范大学（汉语言文学）。</small>
                    </div>
                    <div class="panel-thumbnails">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="icon">
                                  <?php
                                    $href= yii\helpers\Url::to(['site/teacher','category_id'=>'38']);
                                    $html='';
                                    $html.='<li><a href="'.$href.'">';
                                    $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                    $html.='</a></li>';
                                    echo $html;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 teacher-img teacher-img2">
                <div class="panel panel-default panel-card">
                    <div class="panel-heading">
                        <img style="width:100%;height:100%;" src="http://orh16je38.bkt.clouddn.com/11.jpg?imageView2/1/w/272/h/50">
                    </div>
                    <div class="panel-figure">
                        <img class="img-responsive img-circle" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/yangmeijuan1.jpg">
                    </div>
                    <div class="panel-body text-center">
                        <h4 class="panel-header"><a href="http://7xsm8j.com2.z0.glb.qiniucdn.com/jinrong1.jpg">杨美娟</a></h4>
                        <small>女，35岁，本科，朝阳师范学院（美术教育 ），美术。</small>
                    </div>
                    <div class="panel-thumbnails">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="icon">
                                  <?php
                                    $href= yii\helpers\Url::to(['site/teacher','category_id'=>'38']);
                                    $html='';
                                    $html.='<li><a href="'.$href.'">';
                                    $html.='<img class="img-responsive" src="http://7xsm8j.com2.z0.glb.qiniucdn.com/teachsearch.png">';
                                    $html.='</a></li>';
                                    echo $html;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
   </div>
 <script>
    $('.main-2-nav span').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    })
 </script>