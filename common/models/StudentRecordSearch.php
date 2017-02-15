<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\school\StudentRecord;

/**
* StudentRecordSearch represents the model behind the search form about `common\models\school\StudentRecord`.
*/
class StudentRecordSearch extends StudentRecord
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['student_record_id', 'user_id', 'school_id', 'grade_id', 'status', 'sort', 'updated_at', 'created_at'], 'integer'],
            [['title'], 'safe'],
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
$query = StudentRecord::find();

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
            'student_record_id' => $this->student_record_id,
            'user_id' => $this->user_id,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            'status' => $this->status,
            'sort' => $this->sort,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

return $dataProvider;
}
}