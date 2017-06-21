<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'logged_at'], 'integer'],
            [['username', 'phone_number', 'auth_key', 'password_hash', 'email'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        //   $query->select(['u.*'])->from('user as u');
        // if(!Yii::$app->user->can('manager')){
        //     $query->Joinwith('userToSchool as s');
        //     $query->Andwhere(['not',['s.user_id'=>NULL]]);
        //     $query->groupBy(['s.user_id']);
        //     if(Yii::$app->user->can('leader')){
        //         $ids = Yii::$app->authManager->getUserIdsByRole(['administrator']);
        //     }elseif(Yii::$app->user->can('director')){
        //         $ids = Yii::$app->authManager->getUserIdsByRole(['administrator','leader']);
        //     }
        //     $query->andFilterWhere(['not',['id'   => $ids]]);
        // }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
         //$commandQuery = clone $query; echo $commandQuery->createCommand()->getRawSql();exit();
        //var_dump($dataProvider->getModels());exit;
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'u.status' => $this->status,
            'u.created_at' => $this->created_at,
            'u.updated_at' => $this->updated_at,
            'logged_at' => $this->logged_at
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }
}
