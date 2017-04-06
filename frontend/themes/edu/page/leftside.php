<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
echo \common\widgets\DbMenu::widget([
            'key' => 'frontend-index'
    ]);
$this->title = $model->title;

//$this->title = Yii::t('frontend', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
	<!-- <div class="c0l-sm-12">
		<button class="btn btn-warning">按钮</button>
	   </div> -->
	<div class="col-sm-8">
		<h1 class="sub-title"><?php echo $model->title ?></h1>
		<div class="left-side-self">
			<?php echo $model->body ?>
		</div>
	</div>
	<?php echo $this->render('right-side'); ?>
</div>



