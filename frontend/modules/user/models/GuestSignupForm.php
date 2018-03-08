<?php
namespace frontend\modules\user\models;

use Yii;
use yii\helpers\Url;
use yii\base\Exception;
use cheatsheet\Time;
use common\models\User;
use frontend\modules\user\models\SignupForm;

/**
 * Signup form
 */
class GuestSignupForm extends SignupForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'string'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass'=>'\common\models\User',
                'message' => Yii::t('frontend', 'This username has already been taken.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $shouldBeActivated = $this->shouldBeActivated();
            $user = new User();
            $user->username = $this->username;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if(!$user->save()) {
                throw new Exception("User couldn't be  saved");
            };
            $user->afterSignup();
            
            return $user;
        }

        return null;
    }
}