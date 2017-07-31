<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Course as BaseCourse;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\CourseSchedule;


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
                  [['start_time','end_time','intro'],'safe','on'=>'course_batch'],
                  [
                    ['school_id','grade_id','category_id','start_date','which_day','start_times','end_times','teacher_id'],'required','on'=>'course_batch'
                  ],
                  [
                    'end_times','required','when'=>function($model,$attribute){
                        if($model->end_times <= $model->start_times){
                          var_Dump($model->end_times);exit;
                            return $model->addError($attribute,'课程开始时间不能大于开始时间');
                        }
                    },'on'=>'course_batch'
                  ],

             ]
        );
    }

  public function scenarios()
  {
    $scenarios = parent::scenarios();
    //批量检测值
    $scenarios['course_view'] = [
          'category_id','school_id','grade_id','teacher_id','start_date','which_day','start_times','end_times'];
    $scenarios['create_batch'] = [
          'school_id','grade_id','teacher_id','courseware_id','title','status'
    ];
    //var_dump($scenarios);exit;
    return $scenarios;
  }
  public function getlist($type_id = false,$id =false){
        if($type_id == 1){
            $grade = Grade::find()->where(['status'=>Grade::GRADE_STATUS_OPEN, 'school_id'=>$id])->asArray()->all();
            //var_dump($grade);exit;
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }
        if($type_id == 2){
              $UserToGrade = UserToGrade::find()
                        ->where([
                          'grade_id'=>$id,
                          'grade_user_type'=>20
                          ])
                        ->with('user')
                        ->all();
            $data = [];
            foreach ($UserToGrade as $key => $value) {
                if($value['user']['username']){
                  $data[$value['user_id']] = $value['user']['username'];
                  continue;
                }
                if($value['user']['realname']){
                  $data[$value['user_id']] = $value['user']['realname'];
                }
            }
        }
          return $data;
        }
        /*
        $school_id = Yii::$app->user->identity->getSchoolOrGrade();
        $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN]);
        if($school_id != 'all'){
            $school->andwhere(['school_id'=>$school_id]);
        }
        $school = $school->asArray()->all();
        return ArrayHelper::map($school,'school_id','school_title');*/

        public function CourseBatch($data){
         // var_Dump('<pre>',$data);exit;
            foreach ($data['Course'] as $key => $value) {
               $model = self::find()->where([
                      'school_id'=>$value['school_id'],
                      'grade_id' => $value['grade_id'],
                ]);
               if(isset($value['course_id'])){
                  $model = $model->andWhere(['course_id'=>$value['course_id']])->one();
               }else{
                  $model->andwhere(['courseware_id'=>$value['courseware_id']]);
                  $model = $model->one();
               }
               if(!$model){
                  $model = new $this;
                  $model->scenario = 'create_batch';
                  $model->load($value,'');
                  if(!$model->save()){
                     return $model->getErrors();
                  }
               }
               if(isset($value['CourseSchedule']['course_schedule_id'])){
                  $schedule_model = CourseSchedule::find()
                  ->where(['course_schedule_id'=>$value['CourseSchedule']['course_schedule_id']])
                  ->one();
                  if($schedule_model == null){
                     $schedule_model = new CourseSchedule;
                     $schedule_model->course_id = $model->course_id;
                  }

               }else{
                  $schedule_model = new CourseSchedule;
                  $schedule_model->course_id = $model->course_id;

               }
               
                $schedule_model->load($value['CourseSchedule'],'');
                $schedule_model->load($value['CourseSchedule'],'');
                  if(!$schedule_model->save()){
                      return $schedule_model->getErrors();
                  }
            }
            return true;
        }
//排课验证并返回正确数据
    public function Datavalidations($data){
      //$i = 0;$j=0;
      $info = [
          'is_commit'      =>true,//是否提交
          'is_record'      => true,//默认新数据
          'schedule_count' =>0,//本次将要排的课程数
          'schedule_start_time'=>'',//本次排课正式上课时间
          'message'=> [],
          'NewRecord'=>[]
      ];
      $shijian = 0;

      //本次将要排课的内容
      $coursewareModel = $this->Courseware($data['category_id']);
      if(empty($coursewareModel)){
        return [];
      }
      $data['count'] = count($coursewareModel);
      //算出本次要排课的时间段。算出要排课的时间
      $info['schedule_time'] = $this->TimeCalculate($data);
      $info['paike']  =  $this->is_checkout_course($data,$coursewareModel);
                foreach ($info['schedule_time'] as $key => $value) {
                  //排课之间必须大于15分钟
                  $start_time = date('H:i',(strtotime($value['date'].$data['start_times'])-15*60));
                  $end_time   = date('H:i',(strtotime($value['date'].$data['end_times'])+15*60));
                  $teacher_query = [
                        'teacher_id'=>$data['teacher_id'],
                        'end_time'  =>$end_time,
                        'start_time'=>$start_time,
                        'which_day' =>$value['date'],
                        'status'    =>10,
                    ];
                   $teacher_model_schedule =  $this->CourseSchedule($teacher_query);
//var_dump('<pre>',$teacher_query,$teacher_model_schedule);
                  if($teacher_model_schedule != NULL){
                      if($teacher_model_schedule['grade_id'] == $data['grade_id'] ){
                          continue;
                      }
                        $info['is_commit'] = false;//不可提交
                        $info['message'][] = [
                                'isConflict'=>true,
                                'override'  =>false,
                                'NewRecord'=>$this->Record($data,$value['date'],$coursewareModel,$key),
                                'OldRecord'=>$this->Record($teacher_model_schedule),
                        ];
                  }
                if($info['paike']['is_schedule'] == false){
                  $info['NewRecord'][] = $this->NewCourse($data,$coursewareModel,$key,$value['date']);
                  $info['message'][] = [
                                'isConflict'=>false,
                                'override'  =>true,
                                'NewRecord'=>$this->Record($data,$value['date'],$coursewareModel,$key),
                                'OldRecord'=>'',
                        ];
                }
            } 
            //var_dump($info['message']);
     //老师排课冲突返回，或者老师不冲突但是新数据也直接返回
      if($info['is_commit'] == false){
          return $info;
      }
    //查看班级是否是第一次排课
    if($info['paike']['is_schedule'] == true){
        $info['is_record']  = false;
        foreach ($info['schedule_time'] as $key => $value) {
            if(!empty($info['NewRecord'])){
                $shijian = count($info['NewRecord']);
            }
            $start_time = date('H:i',strtotime($value['date'].$data['start_times'])-15*60);
            $end_time   = date('H:i',strtotime($value['date'].$data['end_times'])+15*60);
            $grade_query = [
                'school_id' =>$data['school_id'],
                'grade_id'  =>$data['grade_id'],
                'end_time'  =>$end_time,
                //'courseware_id' =>$coursewareModel[$key]['courseware_id'],
                'start_time'=>$start_time,
                'which_day' =>$value['date'],
                'status'    =>10,
            ];
           //班级冲突,检测是否是同一课程类如果是过滤掉以完玩的课程，顺延。
          $grade_model_schedule = $this->CourseSchedule($grade_query);
//var_dump($shijian);
          if($grade_model_schedule != NULL){
              if($grade_model_schedule['courseware']['category_id'] == $data['category_id']
                ){
                    //检查本次排课是否已结束
                    $OldRecord = [
                        'school_id' =>$data['school_id'],
                        'grade_id'  =>$data['grade_id'],
                        'courseware_id'=>$coursewareModel[$key]['courseware_id'],
                        'status'    =>20,
                    ];
                    $OldRecord = $this->CourseSchedule($OldRecord);
                    if($OldRecord){
                      $info['message'][] = [
                        //'123'=> 123,
                        'isConflict'=>true,
                        'override'  =>false,
                        'NewRecord'=>'',
                        'OldRecord'=>$this->Record($OldRecord),
                      ];

                    $info['NewRecord'][] = $this->NewCourse(
                            $data,$coursewareModel,$key,
                            $info['schedule_time'][$shijian]['date'],
                            $OldRecord['course_schedule_id'],
                            $OldRecord['course_id']
                      );

                      //$shijian++;
                      continue;
                    }else{
                       $info['NewRecord'][] = $this->NewCourse(
                            $data,$coursewareModel,$key,
                            $info['schedule_time'][$shijian]['date'],
                            $grade_model_schedule['course_schedule_id'],
                            $grade_model_schedule['course_id']
                        );
                       $info['message'][] = [
                          'isConflict'=>true,
                          'override'  =>true,
                          'NewRecord'=>$this->Record($data,$info['schedule_time'][$shijian]['date'],$coursewareModel,$key),
                          'OldRecord'=>$this->Record($grade_model_schedule),
                      ];
                     // $shijian++;
                      continue;
                    }
                }
                //echo 123;
                $info['message'][] = [
                      'isConflict'=>true,
                      'override'  =>true,
                      'NewRecord'=>$this->Record($data,$info['schedule_time'][$shijian]['date'],$coursewareModel,$key),
                      'OldRecord'=>$this->Record($grade_model_schedule),
                ];
                $info['NewRecord'][] = $this->NewCourse(
                              $data,$coursewareModel,
                              $key,
                              $info['schedule_time'][$shijian]['date'],
                              $grade_model_schedule['course_schedule_id'],
                              $grade_model_schedule['course_id']
                );
            }else{
               //班级不冲突。是否是同一类型排课 如果是过滤上过的课程。
              $OldRecord = [
                    'school_id' =>$data['school_id'],
                    'grade_id'  =>$data['grade_id'],
                    'courseware_id'=>$coursewareModel[$key]['courseware_id'],
                    'status'    =>[10,20,30,0],
              ];
              $OldRecord = $this->CourseSchedule($OldRecord);
              //班级时间不冲突检测 是否是同一课程 如果不是直接创建。负责覆盖
              if($OldRecord == NULL ){
                  $info['NewRecord'][] =$this->NewCourse($data,$coursewareModel,$key,$value['date']);
                  $info['message'][] = [
                          'cunzai'=>'纯在',
                          'isConflict'=>false,
                          'override'  =>true,
                          'NewRecord'=>$this->Record($data,$value['date'],$coursewareModel,$key),
                          'OldRecord'=>'',
                    ];
                    //$shijian++;
              }else{
                  if($OldRecord['status'] == 20){
                    $info['message'][$key] = [
                          'zouzhe'=>'zouzhe', 
                          'isConflict'=>true,
                          'override'  =>false,
                          'NewRecord'=>'',
                          'OldRecord'=>$this->Record($OldRecord),
                    ];
                   // $shijian++;
                    //continue;
                  }else{
                    $info['message'][] = [
                        'isConflict'=>true,
                        'override'  =>true,
                        'NewRecord'=>$this->Record($data,$info['schedule_time'][$shijian]['date'],$coursewareModel,$key,$shijian),
                        'OldRecord'=>$this->Record($OldRecord),
                  ];
                  $info['NewRecord'][] = $this->NewCourse(
                                  $data,$coursewareModel,
                                  $key,
                                  $info['schedule_time'][$shijian]['date'],
                                  $OldRecord['course_schedule_id'],
                                  $OldRecord['course_id']
                  );
                  //$shijian++;
                 // $j++;
                  }
              }
            }
        }
    }
      unset($info['paike'],$info['schedule_time']);
      //  'schedule_count' =>0,//本次将要排的课程数
      // 'schedule_start_time'=>'',//本次排课正式上课时间
      $info['schedule_count'] ='本次将要排课'. count($info['NewRecord']);
      $info['schedule_start_time']  ='正式开课开课时间是'. $info['NewRecord'][0]['CourseSchedule']['which_day'];
      //var_dump($info['message']);
      return $info;
    }
    //新课程
    public function Record($data,$date = false,$coursewareModel = false ,$key = false){
        if($coursewareModel){
           return  [
                'teacher_name' =>Yii::$app->user->identity->getUserName($data['teacher_id']),
                'grade_name'    =>'燕郊在线',
                'course'        =>isset($coursewareModel[$key]['title'])? $coursewareModel[$key]['title']: '',
                'time'          =>$date .' '.$data['start_times'].'--'.$data['end_times'],
            ];
        }else{
            return  [
               'teacher_name'=> Yii::$app->user->identity->getUserName($data['teacher_id']),
                'grade_name'    =>$data['grade']['grade_name'],
                'course'        =>$data['title'],
                'time'          =>$data['which_day'].' '.$data['start_time'] .'--'.$data['end_time'],
            ];
        }
    }
    //比较课程是否已经上过课
    public function compare_course(){

    }
    //本次需要排课纪录
    public function NewCourse($data,$coursewareModel,$key,$date = false, $course_schedule_id = false,$course_id = false,$status = false){
          $info = [
              //'course_id' =>   $grade_model_schedule['course_id'],
              'school_id' =>   $data['school_id'],
              'teacher_id'=>   $data['teacher_id'],
              'grade_id'  =>   $data['grade_id'],
              'title'     =>   $coursewareModel[$key]['title'],
              'courseware_id'=>$coursewareModel[$key]['courseware_id'],
              'status'       => 10,
              'CourseSchedule'=>[
                  //'course_schedule_id'=>$data['course_schedule_id'],
                  'end_time'   => $data['end_times'],
                  'teacher_id' => $data['teacher_id'],
                  'which_day'  =>$date,
                  'start_time'=> $data['start_times'],
                  'status'       => 10,
                 
                  //'course_id'  => $grade_model_schedule['course_id'],
          ]];
          if($course_id){
            $info['course_id'] = $course_id;
            $info['CourseSchedule']['course_id'] = $course_id;

          }
          if($course_schedule_id){
            $info['CourseSchedule']['course_schedule_id'] = $course_schedule_id;
          }
          if($date){
            $info['CourseSchedule']['which_day'] = $date;
          }
          
          return $info;
    }
//检测排课是否存在,并且上过多少节课,剩余多少节课程
      public function is_checkout_course($param,$courseware){
          $info = [
              'is_schedule'=>false,//判断是否排过课程
              'complete'   =>[],//以上排过
              'unfinished' =>'',//未上没排过
          ];
          //$courseware = ArrayHelper::index($courseware,'courseware_id');
          //$courseware_ids =Array_keys($courseware);
          $course_schedule = self::find()
                        ->from('course as c')
                        ->JoinWith(['courseSchedule as s'])
                        ->with(['school','grade'])
                        ->andWhere([
                          //'c.courseware_id'=>$courseware_ids,
                          'c.grade_id'   =>$param['grade_id'],
                          'c.school_id'  =>$param['school_id'],
                          ])
                        ->andWhere(['not',[
                            'c.status'  => Course::COURSE_STATUS_DELECT,
                            's.status'  => Course::COURSE_STATUS_DELECT,
                            ]])
                        ->asArray()->all();
          if(empty($course_schedule)){
             return $info;
          }
          $data = [
              'unfinished'     =>[],//未上过课程的详情
              'achieve'     =>[],//以上过课程详情
          ];

          foreach ($course_schedule as $key => $value) {
                foreach ($value['courseSchedule'] as $k => $v) {
                  if($v['status'] == Course::COURSE_STATUS_FINISH){
                      $data['unfinished'][$key] = $v;
                      $data['unfinished'][$key]['courseware_id'] = $value['courseware_id'];
                  }
                  if($v['status'] == 0){
                      $data['achieve'][$key] = $v;
                      $data['achieve'][$key]['courseware_id'] = $value['courseware_id'];

                  }
                }
                 $data['school_title']  = $value['school']['school_title'];
                 $data['grade_title']   = $value['grade']['grade_name'];

          }
          $info = $data;
          $info['is_schedule'] = true;
          $info['achieve_count']  = $data['school_title'].$data['grade_title'].'还有'.count($data['unfinished']).'未上课';
          $info['complete']  = $data['school_title'].$data['grade_title'].'以上'.count($data['achieve']).'节';

          return $info;
      }

//根据分类获取课件
      public function Courseware($category_id){
        $coursewareModel = Courseware::find()
              ->select(['courseware_id','title'])
              ->where(['category_id'=>$category_id])
              ->orderBy(['updated_at'=>SORT_ASC])
              ->asArray()
              ->all();
        return $coursewareModel;
      }

//检测班级是否已经排课
      public function CourseSchedule($data,$type = true){

       // if($true != 123 ){
       //    var_dump($data);exit;
       // }
          $model = self::find()->from(['course as c'])->select([
                'c.title','c.teacher_id','c.course_id','s.status','c.course_id',
                'c.grade_id','c.school_id','s.course_schedule_id','c.courseware_id','s.start_time','s.end_time','s.which_day'
            ])->LeftJoin('course_schedule as s' ,'c.course_id = s.course_id')
                  ->with(['school','grade','courseware']);

        if(isset($data['teacher_id']) && !empty($data['teacher_id'])){
            $model->andwhere(['c.teacher_id'=>$data['teacher_id']]);
        }

        if(isset($data['grade_id']) && !empty($data['grade_id'])){
            $model->andwhere(['c.grade_id'=>$data['grade_id']]);
        }

        if(isset($data['school_id']) && !empty($data['school_id'])){
            $model->andwhere(['c.school_id'=>$data['school_id']]);
        }

        if(isset($data['which_day']) && !empty($data['which_day'])){
           //var_Dump($data['which_day']);exit;
            $model->andwhere(['s.which_day'=>$data['which_day']]);
        }

        if(isset($data['courseware_id']) && !empty($data['courseware_id'])){
            $model->andWhere(['c.courseware_id'=>$data['courseware_id']]);
        }
        if(isset($data['status']) && !empty($data['status'])){
            $model->andWhere([
                    'c.status'  => $data['status'],
                    's.status'  => $data['status'],
            ]);
        }
        if(isset($data['start_time']) && 
          !empty($data['start_time']) &&
          isset($data['end_time']) &&
          !empty($data['end_time'])
          ){
          $model->andWhere([
                'or',
                ['between','s.start_time',$data['start_time'],$data['end_time']],
                ['between','s.end_time',$data['start_time'],$data['end_time']]
          ]);
        }
        $model->asArray();
        if($type){
          $model =  $model->one();
        }else{
          $model =  $model->all();
        }
        //var_dump($model);exit;
        return $model;
      }
//时间计算
      public function TimeCalculate($data){
          //var_dump($data);exit;
         //var_dump($data['start_date']);exit;
         //符合课程的开始时间
        $d_time = strtotime(date('Y-m-d'));
        $i = 1;
        $data['start_date']  = strtotime($data['start_date']);

        //根据当天时间算出符合排课要求的某天
        while($d_time < $data['start_date']){
          $d_time = strtotime('+'.$i .' day');
          $i++;
        }
        //算出符合排课要求的某天是周几
        $d_week = date('w',$d_time);
        if($d_week == 0){
            $d_week = 7;
        }

        //符合看看本周时间是否已经过期，如果过期直接从下星期开始
        if($d_week < $data['which_day']){
            $d_time -= ($d_week-$data['which_day'])*24*3600;
        }
        if($d_week > $data['which_day']){
            $d_time += ($d_week-$data['which_day'])*24*3600;
        }
        //同一天时间检测时间段 是否已经过时。
        if($d_week == $data['which_day']){
            $time = time();
            $start_times = strtotime(date('Y').'-'.date('m').'-'.date('d').' '. $data['start_times']);
            if($start_times < $time){
                $d_time +=1*7*3600*24;
            }
        }
        //获取课程的时间排课时间段
        for($a=0;$a<$data['count'];$a++){
            $d_times = $d_time + $a*7*3600*24;
            $m[$a]['time'] = $d_times;
            $m[$a]['date'] = date('Y-m-d',$d_times);
        }
        return $m;
      }
}


?>