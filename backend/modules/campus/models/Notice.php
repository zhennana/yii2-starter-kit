<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Notice as BaseNotice;
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

    public function dataSave($data)
    {
        $info = ['error' => []];

        if(!isset($data) && empty($data) && !is_array($data['receiver_id']))
        {
            return false;
        }

        foreach ($data['receiver_id'] as $key => $value) {
            if($value){
                $model              = new Notice;
                $model->receiver_id = $value;
                $model->category     = $data['category'];
                $model->title        = $data['title'];
                $model->message      = $data['message'];
                $model->sender_id    = $data['sender_id'];
                $model->status_send  = $data['status_send'];
                $model->message_hash = md5($data['message']);
                $model->times        = 1;
                $model->created_at   = time();
                $model->updated_at   = time();
                if(!$model->save()){
                    $info['error'][$key] = $model->getErrors();
                    continue;
                }
            }
        }
        return $info;
    }
}
