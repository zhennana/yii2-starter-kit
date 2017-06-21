<?php

namespace backend\modules\campus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\ShareStream;

/**
* ShareStreamSearch represents the model behind the search form about `backend\modules\campus\models\ShareStream`.
*/
class ShareStreamSearch extends ShareStream
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['share_stream_id', 'school_id','author_id', 'status', 'updated_at', 'created_at'], 'integer'],
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
$query = ShareStream::find();

// $query->JoinWith('shareToGrade as  t');
// $query->andWhere(['NOT',['t.share_stream_id'=> NULL]]);
// $query->groupBy(['t.share_stream_id']);

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
            'author_id' => $this->author_id,
            'share_stream.school_id' => $this->school_id,
            'share_stream.status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'body', $this->body]);

return $dataProvider;
}
}