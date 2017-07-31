<?php

namespace  frontend\models\edu\resources;

use Yii;
use frontend\models\base\FileStorageItem as BaseFileStorageItem;
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
