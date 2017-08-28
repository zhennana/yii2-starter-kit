<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\StudentRecord;

/**
* StudentRecordSearch represents the model behind the search form about `backend\modules\campus\models\StudentRecord`.
*/
class StudentRecordSearch extends StudentRecord
{
/**
* @inheritdoc
*/
public $student_name;
public $teacher_name;
public $course_title;
public function rules()
{
return [
[['student_record_id', 'user_id', 'course_id', 'status', 'sort', 'updated_at', 'created_at','teacher_id'], 'integer'],
[['title','student_name','teacher_name','course_title'], 'safe'],
];
}

/**
* @inheritdoc
*/
public function scenarios()
{
// bypass scenarios() implementation in the parent class
return Model::scenarios();
}

/**
* Creates data provider instance with search query applied
*
* @param array $params
*
* @return ActiveDataProvider
*/
public function search($params)
{
        $query = StudentRecord::find()
        ->from(['student_record as s'])
        ->joinWith('course as c');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $userquery = [];
        $teacher_id = [];
        $student_id = [];

        if(isset($params['StudentRecordSearch']['teacher_name']) && 
            !empty($params['StudentRecordSearch']['teacher_name']))
        {
          $userquery = $params['StudentRecordSearch']['teacher_name'];
          $teacher_id = Yii::$app->user->identity->getUserIds($userquery);
          $teacher_id = ArrayHelper::map($teacher_id,'id','id');
          $query->andWhere([
                    's.teacher_id'=> $teacher_id,
                ]);
          //$params['StudentRecordSearch']['student_name'] = NULL;
        }

        if(isset($params['StudentRecordSearch']['student_name']) && 
            !empty($params['StudentRecordSearch']['student_name']))
        {
            $userquery = $params['StudentRecordSearch']['student_name'];
            $student_id = Yii::$app->user->identity->getUserIds($userquery);
            //$params['StudentRecordSearch']['student_name'] = NULL;
            $student_id = ArrayHelper::map($student_id,'id','id');
            $query->andWhere([
                    's.user_id'=> $student_id,
                ]);
        }

        $this->load($params);

        if (!$this->validate()) {
        // uncomment the following line if you do not want to any records when validation fails
        // $query->where('0=1');
        return $dataProvider;
        }

        $query->andFilterWhere([
                    's.student_record_id' => $this->student_record_id,
                    's.user_id' => $student_id,
                    //'s.course_id'=>$this->course_id,
                    //'s.school_id' => $this->school_id,
                    's.grade_id' => $this->grade_id,
                    's.status' => $this->status,
                    's.sort' => $this->sort,
                    's.updated_at' => $this->updated_at,
                    's.created_at' => $this->created_at,
                ]);

                $query->andFilterWhere(['like', 's.title', $this->title]);
                $query->andFilterWhere(['like', 'c.title', $this->course_title]);

        return $dataProvider;
    }
}