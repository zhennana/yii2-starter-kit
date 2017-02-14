<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\grade\GradeProfile;

/**
 * GradeProfileSearch represents the model behind the search form about `common\models\grade\GradeProfile`.
 */
class GradeProfileSearch extends GradeProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grade_id', 'grade_storage_space', 'student_sum', 'teacher_sum', 'article_sum', 'page_sum', 'album_sum', 'levels'], 'integer'],
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
        $query = GradeProfile::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'grade_id' => $this->grade_id,
            'grade_storage_space' => $this->grade_storage_space,
            'student_sum' => $this->student_sum,
            'teacher_sum' => $this->teacher_sum,
            'article_sum' => $this->article_sum,
            'page_sum' => $this->page_sum,
            'album_sum' => $this->album_sum,
            'levels' => $this->levels,
        ]);

        return $dataProvider;
    }
}
