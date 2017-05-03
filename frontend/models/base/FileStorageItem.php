<?php
namespace frontend\models\base;

use Yii;
use \backend\modules\campus\models\FileStorageItem as BaseFileStorageItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file_storage_item".
 */
class FileStorageItem extends BaseFileStorageItem
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
