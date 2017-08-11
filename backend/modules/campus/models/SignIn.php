<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\SignIn as BaseSignIn;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use \common\components\APush\APush;
use backend\modules\campus\models\Notice;


/**
 * This is the model class for table "sign_in".
 */
class SignIn extends BaseSignIn
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
     public function beforeSave($insert){
      //echo '<pre>';
      //var_dump(parent::beforeSave($insert));exit;
      if(parent::beforeSave($insert)){
        // custom code here...
        return true;
      }else{

      }
    }

    public function afterSave($insert,$changedAttributes){
      if(parent::beforeSave($insert)){
          if($this->type_status == 10){
            //发送推送消息
            $userProfile = Yii::$app->user->identity->getUserProfile($this->student_id);
            $message = [
                'client_source_type'=> $userProfile->client_source_type,
                'cid'               => $userProfile->clientid,
                'message'           => [
                'title' =>'上课通知',
                'body'  =>'您的孩子上课了：'.$this->course->title
                      ]
                ];
            $notice =[
                'type'=>Notice::TYPE_PUSH_SIGN_IN,
                'category'=>0,
                'school_id'=>$this->school_id,
                'receiver_id'=>$this->student_id,
                'grade_id'   =>$this->grade_id,
                'sender_id'  =>$this->teacher_id,
                'message_hash'=> md5($message['message']['body']),
                'title'       => $message['message']['title'],
                'message'     => $message['message']['body'],
                'time'        =>0,
                'is_a_push'   =>1,
            ];
            $APush = new APush;
            $rep = $APush->pushMessageToSingle($message);
            if($rep['result'] == "ok"){
                $notice['status_send'] = 10;
            }else{
                $notice['status_send'] = 20;
            }
            $notice_model = new Notice;
            $notice_model->load($notice,'');
            $notice_model->save();
          }
        }
      }
    public function getlist($type_id,$id =false){
        if($type_id == 1){
            $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
            return ArrayHelper::map($school,'school_id','school_title');
        }
        if($type_id == 2){
            $grade = Grade::find()->where(['status'=>Grade::GRADE_STATUS_OPEN, 'school_id'=>$id])->asArray()->all();
            //var_dump($grade);exit;
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }

        if($type_id == 3){
            $course = Course::find()->where(['grade_id'=>$id])->asArray()->all();
            return ArrayHelper::map($course,'course_id','title');
        }
        if(($type_id == 4) || ($type_id == 5)){
            $gradeUser = UserToGrade::find()->where(['grade_id' => $id,'status'=>UserToGrade::USER_GRADE_STATUS_NORMAL]);
            if($type_id == 4){
                $gradeUser->andWhere(['grade_user_type'=> UserToGrade::GRADE_USER_TYPE_STUDENT]);
            }else{
                $gradeUser->andWhere(['grade_user_type'=> UserToGrade::GRADE_USER_TYPE_TEACHER]);
            }

            $gradeUser =  $gradeUser->asArray()->all();
            $users = [];
            foreach ($gradeUser as $key => $value) {
                    $users[$key]['user_id'] = $value['user_id'];
                    $users[$key]['username'] = SignIn::getUserName($value['user_id']);
                }
            return ArrayHelper::map($users,'user_id','username');
        }

        return false;
    }
}
