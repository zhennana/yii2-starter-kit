<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\WorkRecord;

/**
* WorkRecordSearch represents the model behind the search form about `backend\modules\campus\models\WorkRecord`.
*/
class WorkRecordSearch extends WorkRecord
{
/**
* @inheritdoc
*/
public function rules()
{
return [
    [['work_record_id', 'user_id', 'auditer_id', 'status', 'created_at', 'updated_at','grade_id','school_id'], 'integer'],
    [['title', 'user_id','body'], 'safe'],
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
    $query = WorkRecord::find();

    $dataProvider = new ActiveDataProvider([
    'query' => $query,
    ]);

    $this->load($params);
    if($this->user_id){
        $user_ids =  Yii::$app->user->identity->getUserIds($this->user_id);
        $user_ids = ArrayHelper::map($user_ids,'id','id');
        $query->andWhere(['user_id'=>$user_ids]);

    }
    if (!$this->validate()) {
    // uncomment the following line if you do not want to any records when validation fails
    // $query->where('0=1');
    return $dataProvider;
    }

    $query->andFilterWhere([
                'work_record_id' => $this->work_record_id,
               // 'user_id' => $this->user_id,
                'auditer_id' => $this->auditer_id,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]);

            $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'body', $this->body]);

    return $dataProvider;
}
}