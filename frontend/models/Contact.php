<?php

namespace  frontend\models;

use Yii;
use  frontend\models\base\Contact as BaseContact;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "contact".
 */
class Contact extends BaseContact
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

    // public function contact($email)
    // {
    //   //var_dump(Yii::$app->params['robotEmail']);exit;
    
    //     if ($this->save()) {

    //         return Yii::$app->mailer->compose('mall',['date'=>$this->attributes])
    //             ->setTo($email)
    //             ->setFrom($email)
    //             //->setReplyTo([$this->email => $this->username])
    //             //->setSubject('ceshi')
    //             ->setTextBody($this->body)
    //             ->send();
    //     } else {
    //         return false;
    //     }
    // }
}
