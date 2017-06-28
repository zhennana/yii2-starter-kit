<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "notice".
 *
 * @property string $notice_id
 * @property string $title
 * @property string $message
 * @property string $message_hash
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property string $receiver_phone_numeber
 * @property string $receiver_name
 * @property integer $is_sms
 * @property integer $is_wechat_message
 * @property string $wechat_message_id
 * @property integer $times
 * @property integer $status_send
 * @property integer $status_check
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Notice extends \yii\db\ActiveRecord
{

    CONST STATUS_CHECK_LOOK = 10; //查看；
    CONST STATUS_CHECK_NOT_LOOK = 20; //未查看；

    CONST CATEGORY_ONE     = 1; //消息通知；
    CONST CATEGORY_TWO     = 2; //老师对学生说的话；

    CONST STATUS_SEND_SENT   = 10;    // 发送
    CONST STATUS_SEND_UNSENT = 20;    // 未发送

    // CONST STATUS_SENT  = 10; //正常
    // CONST STATUS_CLOSE = 20; //关闭
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public static function getDb(){
        return Yii::$app->get('campus');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','message','school_id','category', 'sender_id'], 'required'],
            [['message'], 'string'],
            [['sender_id', 'grade_id','receiver_id', 'is_sms', 'is_wechat_message', 'times', 'status_send', 'status_check'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['message_hash', 'receiver_name', 'wechat_message_id'], 'string', 'max' => 32],
            [['receiver_phone_numeber'], 'string', 'max' => 11],
            ['grade_id','required','on'=>['grade','student']],
            [['receiver_id'],'required','on'=>['teacher','student']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
      
     //    $scenarios['grade'] = [];
     //    $scenarios['teacher'] = ['grade_id','sender_id','receiver_id'];
     // var_dump('<pre>',$scenarios);exit;
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_id'              => Yii::t('backend', '消息ID'),
            'title'                  => Yii::t('backend', '消息标题'),
            'message'                => Yii::t('backend', '消息内容'),
            'school_id'                => Yii::t('backend', '学校'),
            'grade_id'                => Yii::t('backend', '班级'),
            //'message'                => Yii::t('backend', '消息内容'),
            'message_hash'           => Yii::t('backend', 'Message Hash'),
            'sender_id'              => Yii::t('backend', '发送者ID'),
            'receiver_id'            => Yii::t('backend', '接收者ID'),
            'receiver_phone_numeber' => Yii::t('backend', '接收者手机号'),
            'receiver_name'          => Yii::t('backend', '接受者称谓'),
            'is_sms'                 => Yii::t('backend', '短信息类型'),
            'wechat_message_id'      => Yii::t('backend', 'Wechat Message ID'),
            'is_wechat_message'      => Yii::t('backend', '微信消息类型'),
            'times'                  => Yii::t('backend', '发送次数'),
            'status_send'            => Yii::t('backend', '发送状态'),
            'status_check'           => Yii::t('backend', '查看状态'),
            'created_at'             => Yii::t('backend', '创建时间'),
            'updated_at'             => Yii::t('backend', '更新时间'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'notice_id'              => Yii::t('backend', '消息ID'),
            'title'                  => Yii::t('backend', '消息标题，不作为消息发送'),
            'message'                => Yii::t('backend', '接收者可以看到的消息内容'),
            'sender_id'              => Yii::t('backend', '发送者ID'),
            'receiver_id'            => Yii::t('backend', '接收者，可多选'),
            'receiver_phone_numeber' => Yii::t('backend', '接收者手机号'),
            'receiver_name'          => Yii::t('backend', '接受者称谓'),
            'is_sms'                 => Yii::t('backend', '10：发送短信，发送消息标题；11：发送短信，发送消息体'),
            'is_wechat_message'      => Yii::t('backend', '1：发送微信消息'),
            'times'                  => Yii::t('backend', '发送次数'),
            'status_send'            => Yii::t('backend', '默认发送'),
            'status_check'           => Yii::t('backend', '状态：10查看'),
        ]);
    }

    public static function optsStatusSend()
    {
        return [
            self::STATUS_SEND_SENT   => Yii::t('backend','发送'),
            self::STATUS_SEND_UNSENT => Yii::t('backend','未发送')
        ];
    }

    public static function getStatusSendLabel($value)
    {
        $labels = self::optsStatusSend();
        if(isset($labels[$value])){
            return $labels[$value];
        }
        return $value;
    }
    
    public static function getUserName($id)
    {
        $user = \common\models\User::findOne($id);
        $name = '';
        if(isset($user->realname) && !empty($user->realname)){
            return $user->realname;
        }
        if(isset($user->username) && !empty($user->username)){
           return $user->username;
        }
        // if(isset($user->phone_number) && !empty($user->phone_number)){
        //     return $user->phone_number;
        // }
        return $name;
    }
    
    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\query\NoticeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\campus\models\query\NoticeQuery(get_called_class());
    }


}
