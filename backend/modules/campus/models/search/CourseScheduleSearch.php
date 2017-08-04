<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\CourseSchedule;

/**
* CourseScheduleSearch represents the model behind the search form about `backend\modules\campus\models\CourseSchedule`.
*/
class CourseScheduleSearch extends CourseSchedule
{
/**
* @inheritdoc
*/
public $school_id;
public $grade_id;
public $title;
public function rules()
{
    return [
    [['course_schedule_id', 'course_id', 'status'], 'integer'],
    [['start_time', 'end_time', 'which_day','school_id','grade_id','title'], 'safe'],
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
$query = CourseSchedule::find();
$query->from(['course_schedule as s']);
$query->RightJoin('course as c', 'c.course_id = s.course_id');
$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            's.course_schedule_id' => $this->course_schedule_id,
            's.course_id' => $this->course_id,
            's.start_time' => $this->start_time,
            's.end_time' => $this->end_time,
            's.which_day' => $this->which_day,
            's.status' => $this->status,
        ]);
$query->andFilterWhere([
        'like','c.title',$this->title
    ]
    );
return $dataProvider;
}
}