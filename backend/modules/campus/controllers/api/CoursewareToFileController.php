<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/f197ab8e55d1e29a2dea883e84983544
 *
 * @package default
 */


namespace backend\modules\campus\controllers\api;

/**
 * This is the class for REST controller "CoursewareToFileController".
 */
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CoursewareToFileController extends \yii\rest\ActiveController
{
	public $modelClass = 'backend\modules\campus\models\CoursewareToFile';

	/**
	 *
	 * @inheritdoc
	 * @return unknown
	 */
	public function behaviors() {
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'allow' => true,
							'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
						]
					]
				]
			]
		);
	}


}
