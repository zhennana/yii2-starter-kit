<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/eeda5c365686c9888dbc13dbc58f89a1
 *
 * @package default
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 *
 * @var yii\web\View $this
 * @var backend\modules\campus\models\search\CoursewareCategorySearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="courseware-category-search">

    <?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

    		<?php echo $form->field($model, 'category_id') ?>

		<?php echo $form->field($model, 'parent_id') ?>

		<?php echo $form->field($model, 'name') ?>

		<?php echo $form->field($model, 'description') ?>

		<?php echo $form->field($model, 'banner_src') ?>

		<?php // echo $form->field($model, 'creater_id') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
