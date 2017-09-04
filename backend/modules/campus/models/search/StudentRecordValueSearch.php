<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\StudentRecordValue;

/**
* StudentRecordValueSearch represents the model behind the search form about `backend\modules\campus\models\StudentRecordValue`.
*/
class StudentRecordValueSearch extends StudentRecordValue
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['student_record_value_id', 'student_record_key_id', 'user_id', 'school_id', 'grade_id', 'student_record_id', 'status', 'sort', 'updated_at', 'created_at','exam_type'], 'integer'],
[['total_score', 'score'],'number'],
            [['body'], 'safe'],
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
$query = StudentRecordValue::find();

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
            'student_record_value_id' => $this->student_record_value_id,
            'student_record_key_id' => $this->student_record_key_id,
            'user_id' => $this->user_id,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            'student_record_id' => $this->student_record_id,
            'total_score' => $this->total_score,
            'score' => $this->score,
            'status' => $this->status,
            'sort' => $this->sort,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'exam_type' => $this->exam_type,
        ]);

        $query->andFilterWhere(['like', 'body', $this->body]);

return $dataProvider;
}
}