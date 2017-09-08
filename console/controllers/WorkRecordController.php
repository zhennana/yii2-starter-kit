<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use backend\modules\campus\models\Course;
use backend\modules\campus\models\WorkRecord;
use backend\modules\campus\models\SignIn;
use backend\modules\campus\models\StudentRecord;
use backend\modules\campus\models\StudentRecordValue;
use backend\modules\campus\models\CourseSchedule;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class WorkRecordController extends Controller
{

  public function actionIndex(){

    $start = '00:00:00';
    $end   = '23:59:59';
    $date  = date('Y-m-d');
    //var_dump($date);exit;

    $course = $this->teacherCouese($start,$end,$date,CourseSchedule::COURSE_STATUS_OPEN);
   //检测用是否有课
   if(!empty($course)){
      foreach ($course as $key => $value) {
         $signRecoued =[
              'user_id'   => $value['teacher_id'],
              'course_id' => $value['course_id'],
              'grade_id'  => $value['grade_id'],
              'school_id' => $value['school_id'],
              'course_schedule_id'=>$value['course_schedule_id'],
              'type'      => 2,
              'status'     => 20,
              'title'     => '上正课',
         ];
        $this->addWorkRecord($signRecoued);
      }
    }


    //查询昨天老师是否有课。如果有 检查是否已编辑学生档案。并入库。
    $date  = date("Y-m-d",strtotime("-1 day"));

    $courseYesterday = $this->teacherCouese($start,$end,$date,CourseSchedule::COURSE_STATUS_DELECT);
    if(!empty($courseYesterday)){
        foreach ($courseYesterday as $key => $value) {
          //var_dump($value);
            $studentRecord = [
              'user_id'   => $value['teacher_id'],
              'grade_id'  => $value['grade_id'],
              'course_id' => $value['course_id'],
              'school_id' => $value['school_id'],
              'course_schedule_id'=>$value['course_schedule_id'],
              'type'      => 1,
              'title'     => '上传学生档案',
            ];
            //检测老师签到多少人。
            $signCount = SignIn::singInCount($value['course_id'],true);

            //检测老师已编辑多少人。
            $studentRecordCount  = StudentRecord::studentRecouedCount($value['course_id'],$value['course_schedule_id']);
            if($signCount ==  $studentRecordCount){
              $studentRecord['status'] = 10;
            }else{
              $studentRecord['status'] = 20;
            }
//var_dump($signCount,$studentRecordCount,$studentRecord ,($signCount ==  $studentRecordCount));exit;
            $this->addWorkRecord($studentRecord,true);
            $studentRecord['title'] = '家长访问';
            $studentRecord['type']  = 4 ;
            $this->addWorkRecord($studentRecord,true);
        }
        return true;
    }

  }

  /**
   * 查询老师今天是否有课
   **/
  public function teacherCouese($start,$end,$date,$status){
    $course =   Course::find()
            ->select(['c.course_id','c.grade_id','c.school_id','s.course_schedule_id','s.teacher_id'])
            ->from(['course as c'])
            ->leftJoin('course_schedule as s','c.course_id = s.course_id')
            ->where(['s.which_day'=>$date]);
    if($status == CourseSchedule::COURSE_STATUS_OPEN){
       $course->andwhere(['s.status'=>$status]);
    }else{
       $course->andwhere(['NOT',['s.status'=>$status] ]);
    }

    $course =  $course->andWhere(['between','s.start_time',$start,$end])
            ->asArray()
            ->all();
  //$commandQuery = clone $course; echo $commandQuery->createCommand()->getRawSql();exit;
    return $course;
  }

  public function  addWorkRecord($data,$da = false){
      $start = date('Y-m-d').' 00:00:00';
      $end   = date('Y-m-d')." 23:59:59";
      $start = strtotime($start);
      $end    = strtotime($end);
    //  var_dump($data,$da);exit;
      $WorkRecord = WorkRecord::find()->andwhere(['course_id'=>$data['course_id'],'type'=>$data['type'],'grade_id'=>$data['grade_id']])->andwhere(['between','created_at',$start,$end])->one();
    //  var_dump($WorkRecord,date('Y-m-d H:i:s'),$start);exit;
      if($WorkRecord == NULL){
          $WorkRecord = new WorkRecord;
      }
      //var_dump(22,$data);exit;
      $WorkRecord->load($data,'');
      $WorkRecord->save();
      //var_dump($WorkRecord->attributes);
      return 1;
}
}
