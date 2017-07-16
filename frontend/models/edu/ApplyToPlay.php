<?php

namespace  frontend\models\edu;

use Yii;
use  frontend\models\base\ApplyToPlay as BaseApplyToPlay;
use yii\helpers\ArrayHelper;
use common\models\PhoneValidator;

/**
 * This is the model class for table "apply_to_play".
 */
class ApplyToPlay extends BaseApplyToPlay
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
        return [
            [['username', 'phone_number', 'age','gender','email'], 'required'],
            ['phone_number', 'string', 'min' => 11, 'max' => 11],
            [['phone_number'], PhoneValidator::className()],
            ['status','default','value'=>ApplyToPlay::APPLY_TO_PLAY_STATUS_AUDIT],
            ['email','email'],
            [['auditor_id', 'status', 'province_id', 'school_id', 'age'], 'integer'],
            [['username'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'apply_to_play_id' => Yii::t('common', 'Apply To Play ID'),
            'username'         => Yii::t('common', '姓名'),
            'phone_number'     => Yii::t('common', '电话'),
            'age'              => Yii::t('common', '年龄'),
            'province_id'      => Yii::t('common', '地区'),
            'school_id'        => Yii::t('common', '校区'),
             'email'            => Yii::t('common', '邮件'),
             'gender'            => Yii::t('common', '性别'),
             'guardian'            => Yii::t('common', '监护人'),
            'address'             => Yii::t('common', '详细地址'),
            'nation'         => Yii::t('common', '民族'),
            'auditor_id'       => Yii::t('common', '审核人'),
             'body'           => Yii::t('common', '个人简历'),
            'verifyCode'       =>Yii::t('common','验证码'),
            'created_at'       => Yii::t('common', 'Created At'),
            'updated_at'       => Yii::t('common', 'Updated At'),
        ];
    }
    public function apply($data){
        if ($this->load($data) && $this->validate()) {
            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }
}