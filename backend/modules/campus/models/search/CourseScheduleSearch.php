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
public function rules()
{
return [
[['course_schedule_id', 'course_id', 'status'], 'integer'],
            [['start_time', 'end_time', 'which_day'], 'safe'],
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
            'course_schedule_id' => $this->course_schedule_id,
            'course_id' => $this->course_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'which_day' => $this->which_day,
            'status' => $this->status,
        ]);

return $dataProvider;
}
}