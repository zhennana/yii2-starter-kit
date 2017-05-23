<?php
namespace frontend\models\wedu\resources;


use Yii;
use frontend\models\base\Course as BaseCourse;
use backend\modules\campus\models\UserToGrade;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "course".
 */
class Course extends BaseCourse
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
    /**
     * 需要签到的学生列表
     * @param  [type] $school_id [description]
     * @param  [type] $grade_id  [description]
     * @return [type]            [description]
     */
   public function userCourseSingInData($school_id,$grade_id){
        $course_id = $this->course_id($school_id,$grade_id);
        if(empty($course_id->course_id)){
            return [];
        }
        $user_ids = $this->SignInToUser($course_id);
        $user_ids = ArrayHelper::map($user_ids,'student_id','student_id');
        $model = UserToGrade::find()->select([])
        ->with([
          'grade',
          'school',
          'courseOrder',
          'signIn'=>function($model){
              $model->select(['count(signin_id) as above_course','student_id']);
          },
          'user'=>function($model){
              $model->select(['id','username']);
          }])
        ->where([
          'school_id'=>$school_id , 'grade_id'=>$grade_id,
          'status'   => UserToGrade::USER_GRADE_STATUS_NORMAL,
          'grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT,
          ])
       // ->andWhere(['not',['user_id'=>$user_ids]])
        ->asArray()
        ->all();
       //var_dump($model);exit;
       return $this->serializations($model, $course_id->course_id);
   }
   /**
    * 格式化数据
    * @return [type] [description]
    */
   public function serializations($model,$course_id){
        $data = [];
       foreach ($model as $key => $value) {
          $data[$key] = [
                'course_id'     =>    (int)$course_id,
                'user_id'       =>    (int)$value['user_id'],
                'username'      =>    $value['user']['username'],
                'school_id'     =>    (int)$value['school_id'],
                'school_title'  =>    $value['school']['school_title'],
                'grade_id'      =>    (int)$value['grade']['grade_id'],
                'grade_name'    =>    $value['grade']['grade_name'],
                'presented_course' => isset($value['courseOrder']['presented_course']) ? (int)$value['courseOrder']['presented_course'] : 0,
                'above_course'    => isset($value['signIn']['above_course']) ? (int)$value['signIn']['above_course'] : 0,
                'created_at'       => isset($value['courseOrder']['created_at']) ? $value['courseOrder']['created_at'] : 0,
           ];
          $data[$key]['total_course'] = isset($value['courseOrder']['total_course']) ? (int)$value['courseOrder']['total_course'] + (int)$data[$key]['presented_course']  : 0;
          $data[$key]['surplus_course'] = (int)$data[$key]['total_course'] - (int)$data[$key]['above_course'];
       }
       return $data;
   }


   /**
    * 获取当前教师所要上的课程
    * @return [type] [description]
    */
   public function course_id($school_id,$grade_id){
      $start_time = time()-60*15;
      $end_time   = time()+60*15;
      //var_dump(date('Y m d h i s',$start_time));exit();
      return self::find()->select('course_id')
      ->andwhere([
          'school_id'=>$school_id,'grade_id'=>$grade_id,
          'status'   => self::COURSE_STATUS_OPEN
        ])
      ->andwhere(['between','start_time',$start_time,$end_time])
      ->one();
   }
   /**
    * 课程下边的所有用户id
    * @return [type] [description]
    */
   public function SignInToUser($course_id){
        return  SignIn::find()->select('student_id')
        ->where(['course_id'=>$course_id])
        ->all();
   }
  
}
