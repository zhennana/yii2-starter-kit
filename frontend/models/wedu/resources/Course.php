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
   public function userCourseSignInData($school_id,$grade_id){
        $course = $this->course($school_id,$grade_id);
        //var_dump($course_id);exit;
        if(!isset($course->course_id)  && empty($course->course_id)  ){
            return [];
        }

        $user_ids = $this->SignInToUser($course->course_id);
        //var_dump($user_ids);exit;
        $user_ids = ArrayHelper::map($user_ids,'student_id','student_id');
        $model = UserToGrade::find()->select([])
        ->with([
          //'grade',
          //'school',
          'courseOrder',
          'signIn'=>function($model){
              $model->select(['count(signin_id) as above_course','student_id']);
              $model->where(['type_status'=>SignIn::TYPE_STATUS_MORMAL]);
              $model->groupby(['student_id']);
          },
          'user'=>function($model){
              $model->select(['id','username','realname']);
          }])
        ->where([
          'school_id'=>$school_id , 'grade_id'=>$grade_id,
          'status'   => UserToGrade::USER_GRADE_STATUS_NORMAL,
          'grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT,
          ])
        ->andWhere(['not',['user_id'=>$user_ids]])
        ->asArray()
        ->all();
 //var_dump($model);exit;
       return $this->serializations($model, $course);
   }
   /**
    * 格式化数据
    * @return [type] [description]
    */
   public function serializations($model,$course){
        $data = [];
        $data['course_id'] = $course->course_id;
        $data['title']     = $course->title;
        //$data['title']     
       foreach ($model as $key => $value) {
          $data['user_list'][$key] = [
                'user_id'       =>    (int)$value['user_id'],
                'username'      =>    empty($value['user']['username']) ? $value['user']['realname'] : $value['user']['username'],
                //'school_id'     =>    (int)$value['school_id'],
                //'school_title'  =>    $value['school']['school_title'],
                //'grade_id'      =>    (int)$value['grade']['grade_id'],
                //'grade_name'    =>    $value['grade']['grade_name'],
                'presented_course' => isset($value['courseOrder']['presented_course']) ? (int)$value['courseOrder']['presented_course'] : 0,
                'above_course'    => isset($value['signIn']['above_course']) ? (int)$value['signIn']['above_course'] : 0,
                'created_at'       => isset($value['courseOrder']['created_at']) ? $value['courseOrder']['created_at'] : 0,
           ];
          $data['user_list'][$key]['total_course'] = isset($value['courseOrder']['total_course']) ? (int)$value['courseOrder']['total_course'] + (int)$data['user_list'][$key]['presented_course']  : 0;
          $data['user_list'][$key]['surplus_course'] = (int)$data['user_list'][$key]['total_course'] - (int)$data['user_list'][$key]['above_course'];

       }
        
       return $data;
   }


   /**
    * 获取当前教师所要上的课程
    * @return [type] [description]
    */
   public function course($school_id,$grade_id){
      if(isset(Yii::$app->user->identity->id)){
          $user_id = Yii::$app->user->identity->id;
      }else{
          return [];
      }
      $time = time();
      $start_time = $time-60*60;
      $end_time   = $time+60*60*2;
      return self::find()->select(['course_id','title'])
      ->andwhere([
          'school_id'   => $school_id,
          'grade_id'    =>    $grade_id,
          'teacher_id'  => $user_id,
          'status'      => self::COURSE_STATUS_OPEN
        ])
      ->orderBy(['start_time'=> SORT_DESC])
      //->asArray()
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
