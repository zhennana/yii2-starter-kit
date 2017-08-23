<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\ActivationCode as BaseActivationCode;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activation_code".
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

    /**
     *  [random 生成六位随机字母数字组合]
     *  @param  integer $length [description]
     *  @return [type]          [description]
     */
    public static function randomStr($length = 6)
    {
        return substr(md5(microtime(true)), 0, $length);
    }

    /**
     *  [batchCreate 批量创建]
     *  @param  [type] $params [description]
     *  @return [type]         [description]
     */
    public function batchCreate($params)
    {
        if (isset($params['ActivationCode']) && !empty($params['ActivationCode'])) {

            $count = (int)$params['ActivationCode']['quantity'];
            if ($count > self::MAX_QUANTITY) {
                $count = self::MAX_QUANTITY;
            }elseif($count < self::MIN_QUANTITY){
                $count = self::MIN_QUANTITY;
            }

            for ($i=1; $i < $count; $i++) { 
                $model = new self;
                $model->load($params);
                $model->activation_code = self::randomStr(6);
                if (!$model->save()) {
                    var_dump($model->getErrors());exit;
                    // continue;
                }
            }
            return true;
        }
        return false;
    }
}
