<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\ShareStreamToGrade;

/**
* ShareStreamToGradeSearch represents the model behind the search form about `backend\modules\campus\models\ShareStreamToGrade`.
*/
class ShareStreamToGradeSearch extends ShareStreamToGrade
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['share_stream_id', 'status', 'updated_at', 'created_at', 'auditor_id'], 'integer'],
            [['school_id', 'grade_id'], 'safe'],
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
$query = ShareStreamToGrade::find();

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
            'share_stream_id' => $this->share_stream_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'auditor_id' => $this->auditor_id,
        ]);

        $query->andFilterWhere(['like', 'school_id', $this->school_id])
            ->andFilterWhere(['like', 'grade_id', $this->grade_id]);

return $dataProvider;
}
}