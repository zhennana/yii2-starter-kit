<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\ShareToFile;

/**
* ShareToFileSearch represents the model behind the search form about `backend\modules\campus\models\ShareToFile`.
*/
class ShareToFileSearch extends ShareToFile
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['share_to_file_id', 'share_stream_id', 'file_storage_item_id', 'status', 'updated_at', 'created_at'], 'integer'],
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
$query = ShareToFile::find();

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
            'share_to_file_id' => $this->share_to_file_id,
            'share_stream_id' => $this->share_stream_id,
            'file_storage_item_id' => $this->file_storage_item_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

return $dataProvider;
}
}