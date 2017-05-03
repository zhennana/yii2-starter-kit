<?php
namespace  frontend\models\base;

use Yii;
use \backend\modules\campus\models\ShareToFile as BaseShareToFile;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "share_to_file".
 */
class ShareToFile extends BaseShareToFile
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
