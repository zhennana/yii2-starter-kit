<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\school\School;

/**
 * SchoolSearch represents the model behind the search form about `common\models\school\School`.
 */
class SchoolSearch extends School
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'school_id', 'province_id', 'city_id', 'region_id', 'created_at', 'updated_at', 'created_id', 'status', 'sort'], 'integer'],
            [['language', 'school_title', 'school_short_title', 'school_slogan', 'school_logo_path', 'school_backgroud_path', 'address'], 'safe'],
            [['longitude', 'latitude'], 'number'],
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
        $query = School::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'school_id' => $this->school_id,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_id' => $this->created_id,
            'status' => $this->status,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'school_title', $this->school_title])
            ->andFilterWhere(['like', 'school_short_title', $this->school_short_title])
            ->andFilterWhere(['like', 'school_slogan', $this->school_slogan])
            ->andFilterWhere(['like', 'school_logo_path', $this->school_logo_path])
            ->andFilterWhere(['like', 'school_backgroud_path', $this->school_backgroud_path])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
