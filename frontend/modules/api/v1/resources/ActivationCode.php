<?php

namespace frontend\modules\api\v1\resources;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\ActivationCode as BaseActivationCode;
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ActivationCode extends BaseActivationCode
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

    public function checkCode()
    {
        $model = self::find()
            ->where(['activation_code' => $this->activation_code])
            ->notActive()
            ->notExpired()
            ->one();
        return $model;
    }

    public function updateCode($orderModel)
    {
        if ($orderModel) {
            $this->course_order_item_id = $orderModel->course_order_item_id;
            $this->status               = self::STATUS_ACTIVATED;
            $this->save();
            return $this;
        }
        return false;
    }
}
