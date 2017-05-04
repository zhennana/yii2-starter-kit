<?php
namespace frontend\models\base;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\ShareStream as BaseShareStream;

class ShareStream extends BaseShareStream
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

}

?>