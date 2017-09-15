<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->name;
use frontend\models\ApplyToPlay;
use frontend\models\Contact;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\captcha\Captcha;
use common\models\WidgetMenu;
//$model = new ApplyToPlay;
//$model->setScenario('AjaxApply');
//var_dump($model->getScenario());exit;
$contact = new Contact;
$contact->setScenario('AjaxContact');
$image = 'http://static.v1.wakooedu.com/A-%E6%A2%A6%E5%B9%BB%E7%A9%BA%E9%97%B4.jpg'.'?imageView2/3/w/400/h/400';
?>
<div class="site-index">
    <div class="home_block bg_red col-xs-12 hidden-xs hidden-sm">
            <div class="block_logo col-xs-7">
                <img class="pull-left" src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/wakoo_radius.png">
                <p class="text-center pull-left no-margin">瓦酷，让孩子更具生存力！</p>
            </div>
            <div class="block_hotline text-center col-xs-5">
                <p class="text-center no-margin">咨询热线：400-608-0515</p>
            </div>
    </div>
    <div class="home_continer bg_gray col-xs-12">
        <div class="body-content home_title">
            <img src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/wakoo_logo.png">
            <h3 class="text-center no-padding no-margin">关于瓦酷</h3>
        </div>
        <div class="col-xs-12  col-md-12 margin_bottom no-padding">
            <div class="col-md-12 about_wakoo">
                <p>
                    <?= isset($model['about'][0]['body']) ? $model['about'][0]['body'] : ''; ?>
                </p>
            </div>
            <!--<div class="col-md-6">
                <img class="img-responsive about_img" src="http://static.v1.wakooedu.com/bell1.png">
            </div>-->
        </div>
        <div class="col-xs-12 no-padding">
        <?php
            if(isset($model['about'][0]['articleAttachments']) && !empty($model['about'][0]['articleAttachments']) && (count($model['about'][0]['articleAttachments']) >= 4) ){
                $Attachments = $model['about'][0]['articleAttachments'];
            foreach ($Attachments as $key => $value) {
                if($key > 3 ){
                    break;
                }
                $url = $value['base_url'] .'/'. $value['path'].'?imageView2/3/w/400/h/300';
        ?>
           <div class="col-xs-3">
                <img class="img-responsive about_img" src="<?php echo $url ?>">
            </div>
            <?php 
                }}else{
            ?>

            <div class="col-xs-3">
                <img class="img-responsive about_img" src="http://static.v1.wakooedu.com/chuangzao.png?imageView2/3/w/400/h/300">
            </div>
            <div  class="col-xs-3">
                <img class="img-responsive about_img" src="http://static.v1.wakooedu.com/find.png?imageView2/3/w/400/h/300">
            </div>
            <div class="col-xs-3">
                <img class="img-responsive about_img" src="http://static.v1.wakooedu.com/goutong.png?imageView2/3/w/400/h/300">
            </div>
            <div class="col-xs-3">
                <img class="img-responsive about_img" src="http://static.v1.wakooedu.com/jiejue.png?imageView2/3/w/400/h/300">
            </div>
        <?php }?>
        </div>

        <div class="col-xs-12 knowmore">
            <?php 
                echo Html::a('了解详情',
                    ['/page/view', 'slug' => 'guan-yu-wa-ku'],
                    ['class' => 'btn btn-defult btn-lg more']
                )
            ?>
        </div>
    </div>
    <div class="home_continer col-xs-12 col-md-12">
        <div class="body-content home_title">
            <img src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/wakoo_logo.png">
            <h3 class="text-center no-padding no-margin">瓦酷动态</h3>
        </div>
        <div class="col-md-12 col-md-12 margin_bottom">
            <?php 
                foreach($model['dongtai'] as $key => $value ){
                    //var_dump(Yii::getAlias('@frontendUrl'));exit;
            ?>
                <a  class="col-xs-6  margin_bottom home_news news_caonima" href="<?php echo Url::to(['article/view','id'=>$value['id']]) ?>">
                    <div class="time col-xs-2 no-padding">
                        <h1><?php echo date('d',$value['updated_at']);?></h1>
                        <p><?php echo date('Y/m',$value['updated_at']);?></p>
                    </div>
                    <!-- <?php
                          //  echo Html::a('<h1>'.date('d',$article['created_at']).'</h1><p>'.date('Y/m',$article['created_at']).'</p>',['article/view','id'=>'1']);
                        ?> -->
                    <div class="col-xs-9 news no-padding">
                        <h4>  
                                <?php  echo substr_auto(strip_tags($value['title']),35);?>
                             <!--  //  var_dump(($value['body'])); -->        
                        </h4>
                        <p><?php  
                                $replace =["\r\n", "\r","\n"];
                                $value['body']  = str_replace($replace," ",strip_tags($value['body'])); 
                                echo substr_auto($value['body'],100);

                        ?> </p>
                    </div>
                </a>
            <?php } ?>
        </div>
        <div class="col-xs-12 knowmore">
            <?php 
                echo Html::a('更多内容',
                    ['/page/view', 'slug' => 'wa-ku-dong-tai'],
                    ['class' => 'btn btn-defult btn-lg more']
                )
            ?>
        </div>
    </div>
    <div class="home_continer course_sys bg_gray col-xs-12">
        <div class="body-content home_title">
            <img src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/wakoo_logo.png">
            <h3 class="text-center no-padding no-margin">课程体系</h3>
        </div>
        <div class="col-xs-12 text-center course">
            <div class="col-xs-6 text-right no-padding">
                <h4 id="find1" class="text-center yellow    pull-right">学前课程（3～6周岁）</h4>
            </div>
            <div class="col-xs-6 text-left no-padding">
                <h4 id="find2" class="text-center">学龄课程（7～13周岁）</h4>
            </div>
        </div>
        <div class="box-body col-xs-12 box1">
            <div id="carousel-example-generic1" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <ul class="run_left no-padding pull-left col-xs-12">
                        <?php foreach($model['course_left'] as $key=>$value){
                                if($key > 2){
                                    break;
                                }
                                $images = [];
                                $images = getImgs($value['body']);
                                 if(!empty($images)){
                                    $image = $images[0].'?imageView2/3/w/300/h/300';
                                 }
                                ?>
                            <li class="col-xs-4 col-lg-4 no-padding">
                                <div class="img_info">
                                    <?php
                                        echo Html::a(
                                            '<img class="img-responsive" src='.$image.'/><h4>'. $value['title'] .'</h4>',
                                            [
                                                'article/view','id'=>$value['id']
                                            ]);
                                    ?>
                                </div>
                                <div class="course_info">
                                    <p>
                                        <?php 
                                            echo Html::a(
                                                    substr_auto(strip_tags($value['body']),50),
                                                    [ 'article/view','id'=>$value['id']]); 
                                        ?>
                                       
                                   </p>
                                </div>
                            </li>
                        <?php }?>
                        </ul>
                    </div>
                    <div class="item ">
                        <ul class="run_left no-padding pull-left col-xs-12">
                          <?php foreach($model['course_left'] as $key=>$value){
                                if($key>2 && $key < 6){
                                $images = [];
                                $images = getImgs($value['body']);
                                if(!empty($images)){
                                    $image = $images[0].'?imageView2/3/w/300/h/300';
                                }
                            ?>
                            <li class="col-xs-4 col-lg-4 no-padding">
                                <div class="img_info">
                                    <?php
                                        echo Html::a(
                                            '<img class="img-responsive" src='.$image.'/><h4>'. $value['title'] .'</h4>',
                                            [
                                                'article/view','id'=>$value['id']
                                            ]);
                                    ?>
                                </div>
                                <div class="course_info">
                               <p>
                                    <?php 
                                        echo Html::a(
                                                substr_auto(strip_tags($value['body']),50),
                                                [ 'article/view','id'=>$value['id']]); 
                                    ?>
                                       
                                </p>
                                </div>
                            </li>
                            
                        <?php }} ?>
                        </ul>
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic1" data-slide="prev">
                    <img class="run_L" src="http://static.v1.wakooedu.com/run_L_01.png">
                </a>
                <a class="right carousel-control" href="#carousel-example-generic1" data-slide="next">
                    <img class="run_R" src="http://static.v1.wakooedu.com/run_R_01.png">
                </a>
            </div>
        </div>
        <div class="box-body col-xs-12 box2">
            <div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <ul class="run_right no-padding pull-left col-xs-12">
                            <?php foreach($model['course_right'] as $key=>$value){
                                if($key > 2){break;}
                                $images = [];
                                $images = getImgs($value['body']);
                                if(!empty($images)){
                                    $image = $images[0].'?imageView2/3/w/300/h/300';
                                }
                        
                            ?>
                            <li class="col-xs-4 col-lg-4 no-padding">
                                <div class="img_info">
                                    <?php
                                        echo Html::a(
                                            '<img class="img-responsive" src='.$image.'/><h4>'. $value['title'] .'</h4>',
                                            [
                                                'article/view','id'=>$value['id']
                                            ]);
                                    ?>
                                </div>
                                <div class="course_info">
                                    <p>
                                    <?php 
                                        echo Html::a(
                                                substr_auto(strip_tags($value['body']),50),
                                                [ 'article/view','id'=>$value['id']]); 
                                    ?>
                                       
                                   </p>
                                </div>
                            </li>
                           <?php }?>
                         
                        </ul>
                    </div>
                    <div class="item ">
                        <ul class="run_right no-padding pull-left col-xs-12">
                            <?php foreach($model['course_right'] as $key=>$value){
                                if($key>2 && $key < 6){
                                $images = [];
                                $images = getImgs($value['body']);
                                 if(!empty($images)){
                                    $image = $images[0].'?imageView2/3/w/300/h/300';
                                 }
                            ?>
                            <li class="col-xs-4 col-lg-4 no-padding">
                                <div class="img_info">
                                <?php
                                    echo Html::a(
                                        '<img class="img-responsive" src='.$image.'/><h4>'. $value['title'] .'</h4>',
                                        [
                                            'article/view','id'=>$value['id']
                                        ]
                                    );
                                ?>
                                </div>
                                <div class="course_info">
                                   <p>
                                   <?php 
                                        echo Html::a(
                                            substr_auto(strip_tags($value['body']),50),
                                            [ 'article/view','id'=>$value['id']]); 
                                   ?>
                                       
                                   </p>
                                </div>
                            </li>
                            
                        <?php }} ?>
                        </ul>
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic2" data-slide="prev">
                    <img class="run_L" src="http://static.v1.wakooedu.com/run_L_01.png">
                </a>
                <a class="right carousel-control" href="#carousel-example-generic2" data-slide="next">
                    <img class="run_R" src="http://static.v1.wakooedu.com/run_R_01.png">
                </a>
            </div>
        </div>
    </div>
    <div class="home_continer show_work col-xs-12">
        <div class="body-content home_title">
            <img src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/wakoo_logo.png">
            <h3 class="text-center no-padding no-margin">作品展示</h3>
        </div>
        <div class="box-body col-xs-12">
            <div id="carousel-example-generic3" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner down_run">
                    <div class="item active">
                        <ul class="no-padding pull-left col-xs-12">
                            <?php
                                foreach ($model['zuopin'] as $key => $value) {
                                    if ($key > 2) {
                                        break;
                                    }
                                    $images = [];
                                    $images = getImgs($value['body']);
                                    if(!empty($images)){
                                        $image = $images[0].'?imageView2/3/w/300/h/300';
                                    }
                            ?>
                            <li class="col-xs-4 no-padding">
                                <img class="img-responsive " src="<?php echo $image; ?>">
                                <h4><?php echo $value['title']; ?></h4>
                                <div class="col-xs-12 no-padding">
                                    <p>
                                        <?php echo substr_auto(strip_tags($value['body']),120); ?>
                                    </p>
                                    <?php
                                        echo Html::a('了解详情',
                                            [ 
                                                'article/view',
                                                'id' => $value['id']
                                            ],
                                            ['class' => 'btn btn-defult']
                                        ); 
                                    ?>
                                </div>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                    <div class="item ">
                        <ul class="no-padding pull-left col-xs-12">
                            <?php
                                foreach ($model['zuopin'] as $key => $value) { 
                                    if ($key > 2 && $key < 6) {
                                        $images = [];
                                        $images = getImgs($value['body']);
                                        if(!empty($images)){
                                            $image = $images[0].'?imageView2/3/w/300/h/300';
                                        }
                            ?>
                            <li class="col-xs-4 no-padding">
                                <img class="img-responsive " src="<?php echo $image; ?>">
                                <h4><?php echo $value['title']; ?></h4>
                                <div class="col-xs-12 no-padding">
                                    <p>
                                        <?php echo substr_auto(strip_tags($value['body']),120); ?>
                                    </p>
                                    <?php
                                        echo Html::a('了解详情',
                                            [ 
                                                'article/view',
                                                'id' => $value['id']
                                            ],
                                            ['class' => 'btn btn-defult']
                                        ); 
                                    ?>
                                </div>
                            </li>
                            <?php }} ?>
                        </ul>
                    </div>
                    <div class="item ">
                        <ul class="no-padding pull-left col-xs-12">
                            <?php
                                foreach ($model['zuopin'] as $key => $value) { 
                                    if ($key > 6 && $key < 10) {
                                        $images = [];
                                        $images = getImgs($value['body']);
                                        if(!empty($images)){
                                            $image = $images[0].'?imageView2/3/w/300/h/300';
                                        }
                            ?>
                            <li class="col-xs-4 no-padding">
                                <img class="img-responsive " src="<?php echo $image; ?>">
                                <h4><?php echo $value['title']; ?></h4>
                                <div class="col-xs-12 no-padding">
                                    <p>
                                        <?php echo substr_auto(strip_tags($value['body']),120); ?>
                                    </p>
                                    <?php
                                        echo Html::a('了解详情',
                                            [ 
                                                'article/view',
                                                'id' => $value['id']
                                            ],
                                            ['class' => 'btn btn-defult']
                                        ); 
                                    ?>
                                </div>
                            </li>
                            <?php }} ?>
                        </ul>
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic3" data-slide="prev">
                    <img class="run_L" src="http://static.v1.wakooedu.com/run_L_02.png">
                </a>
                <a class="right carousel-control" href="#carousel-example-generic3" data-slide="next">
                    <img class="run_R" src="http://static.v1.wakooedu.com/run_R_02.png">
                </a>
            </div>
        </div>
    </div>
    <div class="home_continer contact_us bg_gray col-xs-12">
        <div class="body-content home_title">
            <h3 class="text-center no-padding no-margin">联系我们</h3>
        </div>
        <div class="col-xs-12 no-padding">
            <div class="col-sm-6 ourinfo">
            <?php
                $footer = \Yii::$app->cache->get('footer_menu');
                if(!isset($footer['footer_contact'])){
                    $model = WidgetMenu::find()->where(['id'=>[6],'status'=>WidgetMenu::STATUS_ACTIVE])->one();
                   if($model){
                        $model->getArrayItems();
                        $footer = $model->body;
                        $footer['title'] = $model->title;
                   }
                }else{
                    $footer = $footer['footer_contact'];
                }
            ?>
                <h4 class="text-left">联系方式</h4>
                <p><?php echo isset($footer['company_name']) ? $footer['company_name'] : ''; ?> </p>
                <p>总公司地址：<?php echo isset($footer['address']) ? $footer['address'] : ''; ?> </p>
                <p>分公司地址：<?php echo isset($footer['child_address']) ? $footer['child_address'] : ''; ?> </p>
                <p>办公电话：<?php echo isset($footer['telephone']) ? $footer['telephone'] : ''; ?>
                </p>
                <p>网址：www.wakooedu.com</p>
            </div>
            <div class="col-sm-6 ourinfo">
                <h4 class="text-left">在线留言</h4>
               <!--  <input class="col-xs-12" placeholder="请填写您的姓名">
                <input class="col-xs-12" placeholder="请填写您的电话">
                <textarea class="col-xs-12" placeholder="请填写不超过100字的留言"></textarea> -->
                <?php $form = ActiveForm::begin([
                      'id' => 'form']
                )?>
                <?= $form->field($contact,'username')
                ->textInput(['placeholder'=>'请输入您的姓名'])->label(false)->hint(false);?>
                <?=  $form->field($contact,'phone_number')
                ->textInput(['placeholder'=>'请输入您的电话'])->label(false)->hint(false); ?>
                <?= $form->field($contact,'body')->textarea(['placeholder'=>'请填写不超过100字的留言'])->label(false)->hint(false);?>

                <?php
                    echo $form->field($contact, 'verifyCode')->widget(Captcha::className(), [
                        'options'=>['placeholder'=>'请输入验证码'],
                        'captchaAction'=>'site/contact_captcha',
                        'template' => '<div class="body"><div class="col-lg-4 col-sm-4 col-xs-4 no-padding code_input">{input}</div><div class="col-lg-3 col-sm-3 col-xs-3">{image}</div></div>',
                        'imageOptions'=>['alt'=>'图片无法加载','title'=>'点击换图', 'style'=>'cursor:pointer'],
                    ])
                ->label(false)->hint(false)  ?>
                <button class="btn btn-defult pull-left col-sm-12 col-xs-12">提交</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
    <!--
    <div class="address_choose col-xs-12" id="enlist">
      <?php /*
            $form = ActiveForm::begin([
              'id'                     => 'form-id',
              'action'                 => Url::to(['ajax-apply']),
              // 'enableAjaxValidation'   => true,
              'enableClientValidation' =>true,
              // 'validationUrl'          => Url::to(['apply-validate'])
              ])
            */
        ?>
        <h4>瓦酷，创造不一样！</h4>
         <div class="col-sm-12 no-padding">

            <div class="form-group">

                 <div class="col-sm-4 no-padding">
                    <?php /* echo $form->field($model,'province')
                    ->dropDownList([])->hint(false)->label(false) */?>
    -->
                    <!-- <select name="input_province" id="input_province" class="form-control"></select> -->
    <!--
                </div>
                <div class="col-sm-4 no-padding">
                    <?php /* echo $form->field($model,'city')
                    ->dropDownList([])->hint(false)->label(false) */?>
    -->
                    <!-- <select name="input_city" id="input_city" class="form-control"></select> -->
    <!--
                </div>
                <div class="col-sm-4 no-padding">
                     <?php /* echo $form->field($model,'region')
                    ->dropDownList([])->hint(false)->label(false) */?>
    -->
                   <!--  <select name="input_area" id="input_area" class="form-control"></select> -->
    <!--
                </div>
            </div>

    </div>
        <div class="col-sm-12 no-padding">
            <?php /* echo $form->field($model,'username')
            ->textInput(['placeholder'=>'请输入您的姓名'])->label(false)->hint(false) */?>

            <?php /* echo $form->field($model,'phone_number')
            ->textInput(['placeholder'=>'请输入您的电话'])->label(false)->hint(false) */?>

            <?php /* echo $form->field($model,'email')
            ->textInput(['placeholder'=>'请输入您的邮箱'])->label(false)->hint(false) */?>

            <?php /*
               echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'options'=>['placeholder'=>'验证码'],
                        'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
                        'imageOptions'=>['alt'=>'图片无法加载','title'=>'点击换图', 'style'=>'cursor:pointer']
                    ])
                ->label(false)->hint(false)  */?>
    -->
            <!-- <input class="col-sm-12" placeholder="请输入您的姓名">
            <input class="col-sm-12" placeholder="请输入您的电话">
            <input class="col-sm-12" placeholder="请输入您的邮箱"> -->
    <!--
        </div>
    -->
        <!-- <button  class="btn btn-warning col-sm-12">立即报名</button> -->
    <!--
        <?php /* echo Html::submitButton(
            Yii::t('backend', '立即报名'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-warning col-sm-12'
            ]);
            */?>
        <?php /* ActiveForm::end(); */?>
    </div>
    -->



<script>
$(window).load(function(){
    Change();
    showfont();
    showhide();
});

function Change(){
    $('.box2').hide();
    $('#find1').mouseenter(function(){
        $('.course h4').removeClass('yellow');
        $(this).addClass('yellow');
        $('.box2').hide();
        $('.box1').show();
    });
    $('#find2').mouseenter(function(){
        $('.course h4').removeClass('yellow');
        $(this).addClass('yellow');
        $('.box1').hide();
        $('.box2').show();
    });
}

function showfont(){
    $('.container').css('margin','0');
    $('.container').css('padding','0');
    $('.container').css('width','100%');
    var H_li = $('.down_run li img').height();
    //console.log(H_li);
    $('.down_run li div').hide();
    $('.down_run li').hover(function(){
        $(this).children('div').show();
        $(this).children('div').css('height',''+H_li+'');
        $(this).children('div').children('p').css('padding','5%');
    },function(){
        $(this).children('div').hide();
    });
}
$(window).resize(function() {
    showfont();
    news_resize();
});





$(function () {
    var html = "<option value='0'>== 请选择 ==</option>";
    $("#applytoplay-city").append(html);
    $("#applytoplay-region").append(html);
    $.each(pdata,function(idx,item){
        if (parseInt(item.level) == 0) {
            html += "<option value='" + item.names + "' exid='" + item.code + "'>" + item.names + "</option>";
        }
    });
    $("#applytoplay-province").append(html);

    $("#applytoplay-province").change(function(){
        if ($(this).val() == "0"){
          $("#applytoplay-city option").remove();
          $("#applytoplay-region option").remove();
          var html = "<option value='0'>== 请选择 ==</option>";
          $("#applytoplay-region").append(html);
          $("#applytoplay-city").append(html);
          return;
       }

        $("#applytoplay-city option").remove(); $("#applytoplay-region option").remove();
        var code = $(this).find("option:selected").attr("exid"); code = code.substring(0,2);
        var html = "<option value='0'>== 请选择 ==</option>"; $("#applytoplay-region").append(html);
        $.each(pdata,function(idx,item){
            if (parseInt(item.level) == 1 && code == item.code.substring(0,2)) {
                html += "<option value='" + item.names + "' exid='" + item.code + "'>" + item.names + "</option>";
            }
        });
        $("#applytoplay-city").append(html);
    });

    $("#applytoplay-city").change(function(){
        if ($(this).val() == "0"){
          $("#applytoplay-region option").remove();
          var html = "<option value='0'>== 请选择 ==</option>";
          $("#applytoplay-region").append(html);
          return;
       }
        $("#applytoplay-region option").remove();
        var code = $(this).find("option:selected").attr("exid"); code = code.substring(0,4);
        var html = "<option value='0'>== 请选择 ==</option>";
        $.each(pdata,function(idx,item){
            if (parseInt(item.level) == 2 && code == item.code.substring(0,4)) {
                html += "<option value='" + item.names + "' exid='" + item.code + "'>" + item.names + "</option>";
            }
        });
        $("#applytoplay-region").append(html);
    });
    //绑定
    $("#applytoplay-province").val("北京市");$("#applytoplay-province").change();
    $("#applytoplay-city").val("市辖区");$("#applytoplay-city").change();
    $("#applytoplay-region").val("朝阳区");

});

function showhide(){
    var Width = $(window).width();
    //console.log(Width);
    if(Width < 768){
        $('#enlist').removeClass('address_choose');
        $('#enlist').addClass('address_choose1');
    }else {
        $('#enlist').removeClass('address_choose1');
        $('#enlist').addClass('address_choose');
    }
    $(window).resize(function(){
        var Width = $(window).width();
        if(Width < 768){
          $('#enlist').removeClass('address_choose');
          $('#enlist').addClass('address_choose1');
      }else {
          $('#enlist').removeClass('address_choose1');
          $('#enlist').addClass('address_choose');
        }
    });
}

if(navigator.userAgent.match(/mobile/i)) {
    $('#enlist').removeClass('address_choose');
    $('#enlist').addClass('address_choose1');
}

$(document).ready(function () {
        $('body').on('beforeSubmit', 'form#form-id', function () {
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length)
            {
                return false;
            }
            // submit form
            $.ajax({
            url    : '<?php echo  Url::to(['site/ajax-apply']) ?>',
            type   : 'POST',
            data   : form.serialize(),
            success: function (response)
            {
                if(response.status){
                    alert('保存成功');
                    $('#enlist input').val('');
                    $.ajax({
                    //使用ajax请求site/captcha方法，加上refresh参数，接口返回json数据
                        url:'<?php echo  Url::to(['site/captcha','refresh'=>1]) ?>',
                        contentType:'application/json; charset=UTF-8',
                        dataType: 'json',
                        cache: false,
                        success: function (data) {
                            $("#applytoplay-verifycode-image").attr('src', data['url']);
                        }
                    });
                }else{
                    console.log(response.erros);
                    alert('保存失败');
                }
            },
            error  : function ()
            {
               alter('网络错误');
            }
            });
            return false;
         });
    });

    $(document).ready(function () {
        $('body').on('beforeSubmit', 'form#form', function () {
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length)
            {
                return false;
            }
            // submit form
            $.ajax({
            url    : '<?php echo  Url::to(['site/ajax-contact']) ?>',
            type   : 'POST',
            data   : form.serialize(),
            success: function (response)
            {
                if(response.status){
                    alert('保存成功');
                    $('.ourinfo .form-control,input').val('');
                    $.ajax({
                    //使用ajax请求site/captcha方法，加上refresh参数，接口返回json数据
                        url:'<?php echo  Url::to(['site/contact_captcha','refresh'=>1]) ?>',
                        contentType:'application/json; charset=UTF-8',
                        dataType: 'json',
                        cache: false,
                        success: function (data) {
                            $("#contact-verifycode-image").attr('src', data['url']);
                        }
                    });
                }else{
                    console.log(response.erros);
                    alert('保存失败');
                }
            },
            error  : function ()
            {
               alter('网络错误');
            }
            });
            return false;
         });
    });

    function news_resize() {
        var width = $(window).width();
         if(width<1000){
            $('.news_caonima').removeClass('col-xs-6').addClass('col-xs-12');
            
         }else{
          $('.news_caonima').removeClass('col-xs-12').addClass('col-xs-6');
         }
    };
     $(window).load(function(){
         var width = $(window).width();
        if(width<1000){
            $('.news_caonima').removeClass('col-xs-6').addClass('col-xs-12');
         }else{
            $('.news_caonima').removeClass('col-xs-12').addClass('col-xs-6');
         }
    });
</script>

<style>
    #applytoplay-verifycode-image{
        cursor:pointer;
    }
</style>
