<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\Grade;

/**
* GradeSearch represents the model behind the search form about `backend\modules\campus\models\Grade`.
*/
class GradeSearch extends Grade
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['grade_id', 'school_id', 'classroom_group_levels', 'grade_title', 'owner_id', 'creater_id', 'updated_at', 'created_at', 'sort', 'status', 'graduate', 'time_of_graduation', 'time_of_enrollment'], 'integer'],
            [['grade_name'], 'safe'],
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
$query = Grade::find();

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
            'grade_id' => $this->grade_id,
            'school_id' => $this->school_id,
            'classroom_group_levels' => $this->classroom_group_levels,
            'grade_title' => $this->grade_title,
            'owner_id' => $this->owner_id,
            'creater_id' => $this->creater_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'sort' => $this->sort,
            'status' => $this->status,
            'graduate' => $this->graduate,
            'time_of_graduation' => $this->time_of_graduation,
            'time_of_enrollment' => $this->time_of_enrollment,
        ]);

        $query->andFilterWhere(['like', 'grade_name', $this->grade_name]);

return $dataProvider;
}
}