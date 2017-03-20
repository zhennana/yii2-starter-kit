<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\Course;

/**
* CourseSearch represents the model behind the search form about `backend\modules\campus\models\Course`.
*/
class CourseSearch extends Course
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['course_id', 'school_id', 'grade_id', 'courseware_id', 'creater_id', 'start_time', 'end_time', 'status', 'created_at', 'updeated_at'], 'integer'],
            [['title', 'intro'], 'safe'],
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
$query = Course::find();

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
            'course_id' => $this->course_id,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            'courseware_id' => $this->courseware_id,
            'creater_id' => $this->creater_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updeated_at' => $this->updeated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro]);

return $dataProvider;
}
}