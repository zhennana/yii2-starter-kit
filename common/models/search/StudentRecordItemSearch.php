<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\school\StudentRecordItem;

/**
 * StudentRecordItemSearch represents the model behind the search form about `common\models\school\StudentRecordItem`.
 */
class StudentRecordItemSearch extends StudentRecordItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_record_item_id', 'student_record_title_id', 'student_record_id', 'status', 'sort', 'updated_at', 'created_at'], 'integer'],
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
        $query = StudentRecordItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'student_record_item_id' => $this->student_record_item_id,
            'student_record_title_id' => $this->student_record_title_id,
            'student_record_id' => $this->student_record_id,
            'status' => $this->status,
            'sort' => $this->sort,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
