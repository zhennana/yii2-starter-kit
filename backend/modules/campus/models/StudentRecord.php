<?php

namespace backend\modules\campus\models;

use Yii;
use yii\helpers\ArrayHelper;
use \backend\modules\campus\models\base\StudentRecord as BaseStudentRecord;
use \backend\modules\campus\models\Course;

/**
 * This is the model class for table "student_record".
 */
class StudentRecord extends BaseStudentRecord
{

	//检测老师是否已经上传的课程
  public static function studentRecouedCount($course_id,$course_schedule_id){
    $RecouedCount = self::find()
            ->from('student_record as s')
            ->JoinWith(['studentRecordValue as v'=>function($query){
                  //$query->select('count(v.student_record_id)');
                  $query->andwhere(['v.status'=> StudentRecordValue::STUDENT_VALUE_STATUS_OPEN]);
                  $query->groupBy('v.student_record_id');
            }])
            ->andwhere(['s.course_id'=>$course_id,'course_schedule_id'=>$course_schedule_id])
            ->count();
    return $RecouedCount;
  }
	public function create($data){
		$info = [
			'errorno' =>0,
			'error'	  =>[]
		];
		foreach ($data['user_id'] as $key => $value) {
			$model = StudentRecord::find()->where(
				[
				'school_id'	=> $data['school_id'],
				'grade_id'	=> $data['grade_id'],
                'user_id'   => $value,
				'course_id'	=> $data['course_id'],
				])->one();
			if(!$model){
				$model = new StudentRecord;
			}
			$model->user_id   = $value;
			$model->school_id = $data['school_id'];
			$model->grade_id  = $data['grade_id'];
			$model->course_id = $data['course_id'];
			$model->title     = $data['title'];
			$model->sort      = $data['sort'];
			if(!$model->save()){
				$info['errorno'] =__FILE__;
				$info['error'][$key] = $model->getErrors();
			}
		}
		$info['error'] = $this->Strings($info['error']);
		return $info;
	}

	public function Strings($parameter){
		static $data = [];
		if( empty($parameter) || is_string($parameter) || is_int($parameter) ){
			 $data[] = $parameter;
		}
		foreach ($parameter as $key => $value) {
			$this->Strings($value);
		}
		return $data;
	}

    public function recordFormat()
    {
        $body = '';
        $data = [
            'target'    =>'',
            'expression'=>'',
            'process'   =>'',
        ];

        $recordModel = Course::getStudentRecord($this->student_record_id);
        if (!$recordModel) {
            return $data;
        }


        if($recordModel['course']['courseware']['body']){
            $body = json_decode($recordModel['course']['courseware']['body'],true);
        }

        $data['title'] = isset($recordModel['course']['title']) ? $recordModel['course']['title'] : '' ;

        //这是教学目标
        $data['target'] =isset($body['target']) ? $body['target'] : $body ;
        $data['target'] =str_replace("\r\n", '', $data['target']);
        //教学过程
        $data['process'] = isset($body['process']) ? $body['process'] : '';
        if(isset($recordModel['studentRecordValue'])){
            $recordModel['studentRecordValue'] = ArrayHelper::index($recordModel['studentRecordValue'],'student_record_key_id');
            //孩子的表现
            $data['expression'] = isset($recordModel['studentRecordValue'][1]['body']) ? $recordModel['studentRecordValue'][1]['body']:'';
        }
        return $data;
    }
}
