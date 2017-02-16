<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\courseware\Courseware;

/**
 * CoursewareSearch represents the model behind the search form about `common\models\courseware\Courseware`.
 */
class CoursewareSearch extends Courseware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseware_id', 'category_id', 'level', 'creater_id', 'parent_id', 'access_domain', 'access_other', 'status', 'items', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'title', 'body'], 'safe'],
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

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'courseware_id' => $this->courseware_id,
            'category_id' => $this->category_id,
            'level' => $this->level,
            'creater_id' => $this->creater_id,
            'parent_id' => $this->parent_id,
            'access_domain' => $this->access_domain,
            'access_other' => $this->access_other,
            'status' => $this->status,
            'items' => $this->items,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
