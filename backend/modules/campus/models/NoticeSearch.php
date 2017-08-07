<?php

namespace backend\modules\campus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\Notice;

/**
* NoticeSearch represents the model behind the search form about `backend\modules\campus\models\Notice`.
*/
class NoticeSearch extends Notice
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['notice_id', 'category', 'sender_id', 'receiver_id', 'is_sms', 'is_wechat_message', 'times', 'status_send', 'school_id','grade_id','status_check', 'created_at', 'updated_at','type'], 'integer'],
            [['title', 'message', 'message_hash', 'receiver_phone_numeber', 'receiver_name', 'wechat_message_id'], 'safe'],
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
$query = Notice::find();

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
            'notice_id' => $this->notice_id,
            'category' => $this->category,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'is_sms' => $this->is_sms,
            'is_wechat_message' => $this->is_wechat_message,
            'times' => $this->times,
            'status_send' => $this->status_send,
            'status_check' => $this->status_check,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type'       =>$this->type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'message_hash', $this->message_hash])
            ->andFilterWhere(['like', 'receiver_phone_numeber', $this->receiver_phone_numeber])
            ->andFilterWhere(['like', 'receiver_name', $this->receiver_name])
            ->andFilterWhere(['like', 'wechat_message_id', $this->wechat_message_id]);

return $dataProvider;
}
}