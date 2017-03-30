<?php

namespace backend\modules\campus\controllers;

use backend\modules\campus\models\SignIn;
/**
* This is the class for controller "SignInController".
*/
class SignInController extends \backend\modules\campus\controllers\base\SignInController
{
	public function actionAudit()
	{
		// var_dump($_POST);
		$info                 = [];
		$info['code']         = 0;
		$value['ids']         = isset($_POST['ids']) ? $_POST['ids'] : NULL;
		$value['operator_id'] = \Yii::$app->user->identity->id;

		if (isset($value['ids'] ) && !empty($value['ids']) && isset($value['operator_id'])) {
			$info['count'] = count($value['ids']);
			$audit_count = SignIn::updateAll(
				[
					'auditor_id' => $value['operator_id'],
					'updated_at' => time(),
				],
				[	// 审核条件
					'signin_id'  => $value['ids'],
					'auditor_id' => 0,
				]
			);

			if ($audit_count == $info['count']) {
				$info['code']    = 200;
				$info['success'] = $info['count'];
			}else{
				$info['code']    = 400;
				$info['fail']    = $info['count']-$audit_count;
				$info['success'] = $info['count']-$info['fail'];
			}
		}
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $info;
	}
}
