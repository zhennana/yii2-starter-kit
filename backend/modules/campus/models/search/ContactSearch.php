<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\Contact;

/**
* ContactSearch represents the model behind the search form about `backend\modules\campus\models\Contact`.
*/
class ContactSearch extends Contact
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['contact_id', 'auditor_id', 'phone_number', 'status', 'updated_at', 'created_at'], 'integer'],
            [['username', 'email', 'body'], 'safe'],
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
$query = Contact::find();

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
            'contact_id' => $this->contact_id,
            'auditor_id' => $this->auditor_id,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'body', $this->body]);

return $dataProvider;
}
}