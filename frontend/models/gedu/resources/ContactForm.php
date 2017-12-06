<?php

namespace frontend\models\gedu\resources;

use Yii;
use yii\base\Model;
use frontend\models\gedu\resources\UsersToUsers;
use frontend\models\gedu\resources\User;
use frontend\models\gedu\resources\Notice;
use backend\modules\campus\models\UserToGrade;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $email;
    public $subject;
    public $body;
    private $teacher_info;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [[ 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
            // verifyCode needs to be entered correctl
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'subject' => Yii::t('frontend', 'Subject'),
            'body' => Yii::t('frontend', 'Body'),
            'email'=> Yii::t('frontend', 'email')
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
       $mailer = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom(Yii::$app->params['robotEmail']);

        if(!empty($this->email)){
            $mailer->setReplyTo([$this->email => Yii::$app->user->identity->realname]);
        }

        $mailer = $mailer->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
        return $mailer;
    }

    public function addCreate(){
        if($this->validate()){
            //获取老师email。
            $this->getTeacher();
            if($this->hasErrors()){
                return $this;
            }
            if(!isset($this->teacher_info->email) || empty($this->teacher_info->email)){
                $this->addError('expire','您的老师此时还没有邮箱！请联系管理员');
                return $this;
            }
            if($this->contact($this->teacher_info->email)){
                $notice =  $this->addNotice();
                if($notice->hasErrors()){
                    $this->addErrors($notice->getErrors());
                    return $this;
                }
            }else{
                $this->addError('expire','邮件发送失败');
                return $this;
            }
        }else{
            return $this;
        }
    }
//添加消息列表
    public function addNotice(){
        $model = new Notice;
        $data['sender_id']         = Yii::$app->user->identity->id;
        $data['receiver_id']       = $this->teacher_info->id;
        $data['title']             = $this->subject;
        $data['message']           = $this->body;
        $data['message_hash']      = md5($this->body);
        $data['school_id']         = 0;
        $data['category']          = Notice::CATEGORY_THREE;
        $data['status_send']       = Notice::STATUS_SEND_SENT;
        $data['status_check']       = Notice::STATUS_CHECK_NOT_LOOK;
        $model->load($data,'');
        $model->save();
        return $model;

    }
//获取用户id,根据用户id获取班级id根，
//根据班级id，获取老师id。
    public function getTeacher(){
        $data = [];
        //获取学生这id
        $user_id = Yii::$app->user->identity->id;
        $parents = UsersToUsers::find()->andWhere([
            'user_right_id' => Yii::$app->user->identity->id,
        ])->andWhere(['status'=> UsersToUsers::UTOU_STATUS_OPEN])
        ->one();
        if($parents){
            $user_id = $parents->user_left_id;
        } 
        //获取学生班级id
        $user_to_grade = UserToGrade::find()
                ->andwhere(['user_id'=>$user_id])
                ->andWhere(['status'=>UserToGrade::USER_GRADE_STATUS_NORMAL])
                ->andWhere(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT])
                ->one();
        if($user_to_grade){
            //获取班主任id
            if(isset($user_to_grade->grade->owner_id) && !empty($user_to_grade->grade->owner_id)){
                $this->teacher_info = User::findOne($user_to_grade->grade->owner_id);
                return true;
            }else{
                $this->addError('expire','未找到您的班主任,请联系管理员');
                return NULL;
            }
        }else{
             $this->addError('expire','未找到你所在的班级,请联系管理员');
             return NULL;
        }
    }
}