<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\UsersToUsers;

/**
 * UsersToUsersSearch represents the model behind the search form about `backend\modules\campus\models\UsersToUsers`.
 */
class UsersToUsersSearch extends UsersToUsers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_to_users_id', 'user_left_id', 'user_right_id', 'status', 'type'], 'integer'],
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
        $query = UsersToUsers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'users_to_users_id' => $this->users_to_users_id,
            'user_left_id' => $this->user_left_id,
            'user_right_id' => $this->user_right_id,
            'status' => $this->status,
            'type' => $this->type,
        ]);

        return $dataProvider;
    }
}
