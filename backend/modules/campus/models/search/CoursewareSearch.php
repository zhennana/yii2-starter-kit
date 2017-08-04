<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\Courseware;

/**
* CoursewareSearch represents the model behind the search form about `backend\modules\campus\models\Courseware`.
*/
class CoursewareSearch extends Courseware
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['courseware_id', 'category_id','page_view','file_counts', 'level', 'creater_id', 'parent_id', 'access_domain', 'access_other','sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'body','tags'], 'safe'],
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
$query = Courseware::find();

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
            'courseware_id' => $this->courseware_id,
            'category_id' => $this->category_id,
            'level' => $this->level,
            'sort' => $this->sort,
            'creater_id' => $this->creater_id,
            'parent_id' => $this->parent_id,
            'access_domain' => $this->access_domain,
            'access_other' => $this->access_other,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

return $dataProvider;
}
}