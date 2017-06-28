<?php

namespace backend\modules\campus\models\search;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    public $time_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'logged_at'], 'integer'],
            [['username', 'realname','phone_number', 'auth_key', 'password_hash', 'email'], 'safe'],
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
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        $id = ArrayHelper::merge(Yii::$app->authManager->getUserIdsByRole('manager'),Yii::$app->authManager->getUserIdsByRole('administrator'));
        $query->andFilterWhere(['not',[
            'id'=> $id]]);
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
        if(isset($params['UserSearch']['item_name']) && !empty($params['UserSearch']['item_name'])){
            $params['UserSearch']['id'] = Yii::$app->authManager->getUserIdsByRole($params['UserSearch']['item_name']);
            $query->andFilterWhere([
                'id'        => $params['UserSearch']['id'],
            ]);
        }


        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like','realname',$this->realname])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }
}
