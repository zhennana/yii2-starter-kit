<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\ApplyToPlay;

/**
* ApplyToPlaySearch represents the model behind the search form about `backend\modules\campus\models\ApplyToPlay`.
*/
class ApplyToPlaySearch extends ApplyToPlay
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['apply_to_play_id', 'phone_number', 'auditor_id', 'status', 'created_at', 'updated_at'], 'integer'],
[['username', 'age','email','province_id', 'school_id','guardian','birth','nation','body','gender'], 'safe'],
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
$query = ApplyToPlay::find();

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
            'apply_to_play_id' => $this->apply_to_play_id,
            'phone_number' => $this->phone_number,
            'auditor_id' => $this->auditor_id,
            'status' => $this->status,
            'gender' => $this->gender,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'guardian', $this->guardian]);
        $query->andFilterWhere(['like', 'nation', $this->nation])
            ->andFilterWhere(['like', 'age', $this->age])
            ->andFilterWhere(['like', 'province_id', $this->province_id])
            ->andFilterWhere(['like', 'school_id', $this->school_id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'body', $this->body]);

return $dataProvider;
}
}