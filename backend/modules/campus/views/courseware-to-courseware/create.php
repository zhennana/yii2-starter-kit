<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/fccccf4deb34aed738291a9c38e87215
 *
 * @package default
 */


use yii\helpers\Html;

/**
 *
 * @var yii\web\View $this
 * @var backend\modules\campus\models\CoursewareToCourseware $model
 */
$this->title = Yii::t('backend', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To Coursewares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud courseware-to-courseware-create">

    <h1>
        <?php echo Yii::t('backend', 'Courseware To Courseware') ?>
        <small>
                        <?php echo $model->courseware_to_courseware_id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?php echo             Html::a(
	Yii::t('backend', 'Cancel'),
	\yii\helpers\Url::previous(),
	['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?php echo $this->render('_form', [
		'model' => $model,
        'courseware_ids'=>$courseware_ids,
        'courseware'    =>$courseware
	]); ?>

</div>
