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
	<div class="col-sm-4 right_public">
		<img class="img-responsive margin_bottom" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b89ov8r2ak91qdt4i71mrc15rs9.png">
		<img class="img-responsive margin_bottom" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b89ov8r2ak91qdt4i71mrc15rs9.png">
		<div class="box-body">
			<h3>游学赛事</h3>
			<div class="red_line">
				<ul class="no-padding no-margin">
					<li class="col-sm-12 no-padding">
						<div class="col-sm-6">
							<img class="img-responsive" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b89ov8r2ak91qdt4i71mrc15rs9.png">
						</div>
						<div class="col-sm-6">
							<h4>世界工业大国...</h4>
							<small class="text-muted">时间：2017-2-10</small>
						</div>
					</li>
					<li class="col-sm-12 no-padding">
						<div class="col-sm-6">
							<img class="img-responsive" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b89ov8r2ak91qdt4i71mrc15rs9.png">
						</div>
						<div class="col-sm-6">
							<h4>世界工业大国...</h4>
							<small class="text-muted">时间：2017-2-10</small>
						</div>
					</li>
					<li class="col-sm-12 no-padding">
						<div class="col-sm-6">
							<img class="img-responsive" src="http://7xthhn.com2.z0.glb.clouddn.com/o_1b89ov8r2ak91qdt4i71mrc15rs9.png">
						</div>
						<div class="col-sm-6">
							<h4>世界工业大国...</h4>
							<small class="text-muted">时间：2017-2-10</small>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="box-body">
			<h3>校区展示</h3>
			<div class="red_line">
				<?php echo \common\widgets\DbCarousel::widget([
			        'key'=>'index',
			        'options' => [
			            'class' => 'slide', // enables slide effect
			        ],
			    ]) ?>
			</div>
		</div>
	</div>
</div>

<script>
var width = $(window).width();
var map = '<i class="glyphicon glyphicon-map-marker text-red"></i>当前位置：';
$('.breadcrumb').prepend(map);
$('.breadcrumb').css('width',''+width+'');
$(window).resize(function() {
  	var width = $(window).width();
	$('.breadcrumb').css('width',''+width+'');
});
</script>

