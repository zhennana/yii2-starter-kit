<?php

namespace frontend\models\base;

use Yii;
use \backend\modules\campus\models\Notice as BaseNotice;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "notice".
 */
class Notice extends BaseNotice
{

public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
             parent::rules(),
             [
                  # custom validation rules
             ]
        );
    }

    public function changeCheckStatus($model)
    {
        if ($model->status_check == self::STATUS_CHECK_LOOK) {
            $model->status_check = self::STATUS_CHECK_NOT_LOOK;
        }else{
            $model->status_check = self::STATUS_CHECK_LOOK;
        }

        if (!$model->save()) {
            return $model->getErrors();
        }
        return $model;
        // var_dump($model);exit;
    }
}
