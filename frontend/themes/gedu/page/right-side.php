<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\Article;
use common\models\school\School;
use frontend\models\ApplyToPlay;
use backend\modules\campus\models\CnProvince;

// 验证码场景
$model = new ApplyToPlay;
$model->setScenario('AjaxApply');
// var_dump($model->getScenario());exit;

// 瓦酷动态
$newsModel = Article::find()
    ->where(['category_id' => 3])
    ->limit('3')
    ->all();

// 选择地区
$province_id = CnProvince::find()->asArray()->all();
$province_id = ArrayHelper::map($province_id, 'province_id', 'province_name');

// 选择校区
$school_id = School::find()
    ->where(['parent_id' => 0])
    ->andWhere(['status' => School::SCHOOL_NORMAL])
    ->asArray()->all();
$school_id = ArrayHelper::map($school_id, 'id', 'school_title');

?>
<div class="col-sm-4 right_public">

    <!-- 卷角 -->
    <div class="corner" id="corner"></div>
    
    <!-- 预约报名 -->
    <div class="box-body bespeak" id="enlist">
        <?php
                $form = ActiveForm::begin([
                  'id'                     => 'form-id',
                  'action'                 => Url::to(['ajax-apply']),
                  // 'enableAjaxValidation'   => true,
                  'enableClientValidation' => true,
                  // 'validationUrl'          => Url::to(['apply-validate'])
                ])
                
        ?>
        <div class="alert bespeak_title">
            <h4 class="text-center no-margin">预约免费课程</h4>
        </div>
        <div class="col-sm-12 no-padding">
            <?php  echo $form->field($model,'username')
            ->textInput(['placeholder'=>'孩子姓名','class' => 'form-control bespeak_input'])->label(false)->hint(false) ?>

            <?php  echo $form->field($model,'phone_number')
            ->textInput(['placeholder'=>'联系电话','class' => 'form-control bespeak_input'])->label(false)->hint(false) ?>

            <?php  echo $form->field($model,'age')
            ->textInput(['placeholder'=>'孩子年龄','class' => 'form-control bespeak_input'])->label(false)->hint(false) ?>

            <?php  echo $form->field($model,'province_id')
            ->dropDownList($province_id, [
                'prompt'   => '选择地区',
                'onchange' => '$.get("'.Url::toRoute(['site/school-lists']).'",{ province_id : $(this).val() }).done(function(data){
                        var str ="";
                        $.each(data,function(k,v){
                            str += "<option value="+k+">"+v+"</option>";
                        });
                        $("select#applytoplay-school_id").html(str);
                })'
            ])->hint(false)->label(false) ?>

            <?php  echo $form->field($model, 'school_id')
            ->dropDownList($school_id, ['prompt' => '选择校区'])->hint(false)->label(false) ?>

            <?php  /*echo $form->field($model,'email')
            ->textInput(['placeholder'=>'请输入您的邮箱'])->label(false)->hint(false) */?>

            <?php 
                echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'options'      =>['placeholder'=>'验证码'],
                    // 'captchaAction'=>'site/contact_captcha',
                    'template'     => '<div class="row"><div class="code_input col-xs-8 col-md-7">{input}</div><div class="col-xs-4 col-md-5 code_img">{image}</div></div>',
                    'imageOptions' =>['alt'=>'图片无法加载','title'=>'点击换图', 'style'=>'cursor:pointer']
                ])
                ->label(false)->hint(false) ?>

        </div>

        <?php echo Html::submitButton(
            Yii::t('backend', '立即报名'), [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn apply col-sm-12'
            ]);
        ?>
        <?php  ActiveForm::end(); ?>
    </div>

    <!-- 招商加盟广告 -->
    <div class="box-body">
    <a href="<?php echo Yii::getAlias('@frontendUrl') ?>/index.php?r=page%2Fview&slug=zhao-shang-jia-meng">
        <img class="img-responsive" src="http://static.v1.wakooedu.com/rightside_jiameng_0405.png?imageView2/3/w/800/h/600">
    </a>
    </div>

    <!-- 瓦酷动态 -->
    <div class="box-body">
        <h3>瓦酷动态</h3>
        <div class="red_line">
            <ul class="no-padding no-margin">
            <?php 
                foreach ($newsModel as $key => $value) {
                $imageUrl = getImgs($value->body);
                $imageUrl = $imageUrl[0] ? $imageUrl[0] : 'http://static.v1.wakooedu.com/top_logo.png';
            ?>
            <a href="<?php echo Yii::getAlias('@frontendUrl') ?>/index.php?r=article%2Fview&id=<?php echo $value->id ?>">
                <li class="col-sm-12 no-padding">
                    <div class="col-sm-6 news_pic">
                        <img class="img-responsive" src="<?php echo $imageUrl; ?>?imageView2/3/w/400/h/300">
                    </div>
                    <div class="col-sm-6 news_content">
                        <h4><?php echo substr_auto($value->title,40) ?></h4>
                        <small class="text-muted">
                            <?php echo '时间：'.date('Y-m-d', $value->published_at) ?>
                        </small>
                    </div>
                </li>
            </a>
            <?php } ?>
            </ul>
        </div>
    </div>

</div>

<script>
// 面包屑
var width = $(window).width();
var map   = '<i class="glyphicon glyphicon-map-marker text-red"></i> 当前位置： ';
$('.breadcrumb').prepend(map);
$('.breadcrumb').css('width',''+width+'');
$(window).resize(function() {
    var width = $(window).width();
    $('.breadcrumb').css('width',''+width+'');
});

// 地区选择三级联动
/*$(function () {
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

});*/

// 预约表单异步
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
            url: '<?php echo Url::to(['site/ajax-apply']) ?>',
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                console.log(response);
                if(response.status){
                    alert('提交成功，感谢您的选择！我们的工作人员会尽快与您取得联系，请您耐心等待！');
                    $('#enlist input').val('');
                    $.ajax({
                    //使用ajax请求site/captcha方法，加上refresh参数，接口返回json数据
                        url:'<?php echo Url::to(['site/captcha','refresh'=>1]) ?>',
                        contentType:'application/json; charset=UTF-8',
                        dataType: 'json',
                        cache: false,
                        success: function (data) {
                            $("#applytoplay-verifycode-image").attr('src', data['url']);
                        }
                    });
                }else{
                    console.log(response.erros);
                    alert('提交失败！请填写正确信息！');
                }
            },
            error: function () {
               alert('网络错误！请稍后重试！');
            }
        });
        return false;
     });
});


</script>