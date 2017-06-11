<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = $model->title;
?>
<div class="content">
    <h1><?php echo $model->title ?></h1>
    <?php echo $model->body ?>
</div>

<script type="text/javascript">
    $('nav .container').remove();
    $('nav').css('background-color','#35b9d0');
    var title = '';
    title += '<div class="title_box">';
    title += '<div class="col-md-8 text-center title">Starter 1 English Lessons for Kids</div>';
    title += '<div class="col-md-4 text-center breadcrumbs hidden-xs">';
    title += '<a class="btn btn-default btn-sm" href="<?php echo Yii::getAlias('@frontendUrl') ?>/site/index">Home</a>';
    title += '<i class="fa fa-angle-right"></i>';
    title += '<p>Starter 1 English Lessons for Kids</p>';
    title += '</div>';
    title += '</div>';
    // $('.container').show();
    $('nav').append(title);

</script>