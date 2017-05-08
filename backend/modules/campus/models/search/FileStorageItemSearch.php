<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\FileStorageItem;

/**
* FileStorageItemSearch represents the model behind the search form about `backend\modules\campus\models\FileStorageItem`.
*/
class FileStorageItemSearch extends FileStorageItem
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['file_storage_item_id', 'user_id', 'school_id', 'grade_id', 'file_category_id', 'size', 'ispublic', 'updated_at', 'created_at', 'status', 'page_view', 'sort_rank'], 'integer'],
            [['type', 'component', 'upload_ip', 'file_name', 'url', 'original'], 'safe'],
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
$query = FileStorageItem::find();

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
            'file_storage_item_id' => $this->file_storage_item_id,
            'user_id' => $this->user_id,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            'file_category_id' => $this->file_category_id,
            'size' => $this->size,
            'ispublic' => $this->ispublic,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'page_view' => $this->page_view,
            'sort_rank' => $this->sort_rank,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'component', $this->component])
            ->andFilterWhere(['like', 'upload_ip', $this->upload_ip])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'original', $this->original]);

return $dataProvider;
}
}