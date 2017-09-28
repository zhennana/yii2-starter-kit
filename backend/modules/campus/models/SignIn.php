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

    public $buke_teacher_id;//补课老师id
    public $buke_course_schedule_id;//补课id
    public $is_a_push = true;
//public $buke_course_title;//补课title
//  public $buke_teacher_name;//补课老师名

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
                ['is_a_push','safe'],
             ]
        );
    }
     public function beforeSave($insert){
      //echo '<pre>';
      //var_dump(parent::beforeSave($insert));exit;
      if(parent::beforeSave($insert)){
        $this->buke_teacher_id = isset($_POST['SignIn']['buke_teacher_id']) ? $_POST['SignIn']['buke_teacher_id'] : NULL;
        $this->buke_course_schedule_id = isset($_POST['SignIn']['buke_course_schedule_id']) ? $_POST['SignIn']['buke_course_schedule_id'] : NULL;
        // var_dump($this->teacher_id,$this->buke_teacher_id,$this->buke_course_schedule_id);exit;
        //var_dump($this->buke_teacher_id);exit;
        return true;
      }else{

      }
    }
    //$this->addStudentRecord([
                //     'user_id'   => $model->student_id,
                //     'school_id' => $model->school_id,
                //     'grade_id'  => $model->grade_id,
                //     'course_id' => $model->course_id,
                //     'course_schedule_id'=>$model->course_schedule_id,
                //     'title'     => '',
                //     'status'    => 1,
                // ]);
    public function afterSave($insert,$changedAttributes){
        //var_dump($this->isNewRecord);exit;
      if(parent::beforeSave($insert)){
        $status = isset($changedAttributes['type_status']) ? $changedAttributes['type_status'] : NULL;
        if($status != $this->type_status){

          if($this->type_status == self::TYPE_STATUS_MORMAL || $this->type_status == self::TYPE_STATUS_REPAIR_CLASS){
            if($this->type_status == self::TYPE_STATUS_MORMAL){
                //var_dump(1123123);exit;
                $this->addStudentRecord([
                    'user_id'   => $this->student_id,
                    'school_id' => $this->school_id,
                    'grade_id'  => $this->grade_id,
                    'course_id' => $this->course_id,
                    'teacher_id'=> $this->teacher_id,
                    'course_schedule_id'=>$this->course_schedule_id,
                    'title'     => '',
                    'status'    => 1,
                ]);
            }else{
                if($this->type_status == self::TYPE_STATUS_REPAIR_CLASS && $this->buke_course_schedule_id && $this->buke_teacher_id){
                    $this->addStudentRecord([
                        'user_id'   => $this->student_id,
                        'school_id' => $this->school_id,
                        'grade_id'  => $this->grade_id,
                        'course_id' => $this->course_id,
                        'teacher_id'=> $this->buke_teacher_id,
                        'course_schedule_id'=>$this->course_schedule_id,
                        'new_course_schedule_id'=>$this->buke_course_schedule_id,
                        'title'     => '',
                        'status'    => 1,
                        ]);

                }
            }
            if($this->is_a_push){
                //发送推送消息
                $userProfile = Yii::$app->user->identity->getUserProfile($this->student_id);
                $message = [
                    'client_source_type'=> $userProfile->client_source_type,
                    'cid'               => $userProfile->clientid,
                    'message'           => [
                    'title' =>'上课通知',
                    'body'  =>'家长您好！您的孩子在瓦酷机器人已开始上课啦！'
                          ]
                    ];
                $notice =[
                    'type'=>Notice::TYPE_PUSH_SIGN_IN,
                    'category'=>0,
                    'school_id'=>$this->school_id,
                    'receiver_id'=>$this->student_id,
                    'grade_id'   =>$this->grade_id,
                    'sender_id'  =>Yii::$app->user->identity->id,
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
           $model = new Course;
           $data = [
                'grade_id'     => $id,
                'status'       => 20,
            ];
            $dataProvider =$model->CourseSchedule($data,false,false);
        return ArrayHelper::map($dataProvider,'course_id','title');
        }
        if($type_id == 5){
            $gradeUser = UserToGrade::find()->where([
                'grade_id' => $id,
                'status'=>UserToGrade::USER_GRADE_STATUS_NORMAL,
                'grade_user_type'=> UserToGrade::GRADE_USER_TYPE_TEACHER
            ])->asArray()->all();
            $users = [];
            foreach ($gradeUser as $key => $value) {
                $users[$key]['user_id'] = $value['user_id'];
                $users[$key]['username'] = SignIn::getUserName($value['user_id']);
            }
            return ArrayHelper::map($users,'user_id','username');
        }
        return false;
    }

    public function getSignedStudent($grade_id,$course_id){
        $signed = self::find()->where([
            'grade_id'  => $grade_id,
            'course_id' => $course_id,
        ])->asArray()->all();
        $signed = ArrayHelper::map($signed,'student_id','student_id');

        $grade = UserToGrade::find()->where([
            'grade_id'        => $grade_id,
            'status'          => UserToGrade::USER_GRADE_STATUS_NORMAL,
            'grade_user_type' => UserToGrade::GRADE_USER_TYPE_STUDENT
        ])
        ->andWhere(['NOT',['user_id' => $signed]])
        ->asArray()->all();
        $users = [];
        foreach ($grade as $key => $value) {
            $users[$key]['user_id'] = $value['user_id'];
            $users[$key]['username'] = self::getUserName($value['user_id']);
        }
        return ArrayHelper::map($users,'user_id','username');
    }

    /**
     * 学生档案
     * @param [type] $data [description]
     */
    public function addStudentRecord($data){
        $studentRecord  = \backend\modules\campus\models\StudentRecord::find()->where($data)->one();
        if(!$studentRecord){
            $studentRecord = new \backend\modules\campus\models\StudentRecord;
            $studentRecord->load($data,'');
            $studentRecord->save();
           // var_dump($studentRecord->getErrors());exit;
        }
        return true;
    }
    public function batch_add($param){
        $courseSchedule = CourseSchedule::find()->select('course_schedule_id')->where(['course_id'=>$param['course_id']])->asArray()->one();
        $param['course_schedule_id'] = $courseSchedule['course_schedule_id'];
       if(is_array($param['student_id'])){
            $student_ids = $param['student_id'];
            unset($param['student_id']);
            foreach ($student_ids as $key => $value) {
                 $model = self::find()->where([
                    'course_schedule_id'=> $param['course_schedule_id'],
                    'course_id'         => $param['course_id'],
                    'student_id'        => $value,
                    'grade_id'          => $param['grade_id']
                    ])
                 ->one();
                 if($model){
                    $model->addError('message','学员'.Yii::$app->user->identity->getUserName($model->student_id).'本次课程已签到过');
                    $data['error'][$key] = $model;
                }else{
                    $model = new self;
                    $param['student_id']= $value;
                    $model->load($param,'');
                    $model->save();
                    if(!$model->save()){
                        $data['error'][$key] = $model;
                    }
                    $data['message'][$key] = $model;
                }
            }
       }
       return $data;
    }
}
