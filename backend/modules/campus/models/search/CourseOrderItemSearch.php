<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\CourseOrderItem;

/**
* CourseOrderItemSearch represents the model behind the search form about `backend\modules\campus\models\CourseOrderItem`.
*/
class CourseOrderItemSearch extends CourseOrderItem
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['course_order_item_id', 'parent_id', 'school_id', 'grade_id', 'introducer_id', 'payment', 'presented_course', 'status', 'payment_status', 'total_course', 'created_at', 'updated_at'], 'integer'],
            [['total_price', 'real_price', 'coupon_price'], 'number'],
            [['payment_id','order_sn','user_id'],'string'],
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
$query = CourseOrderItem::find();

      $dataProvider = new ActiveDataProvider([
      'query' => $query,
      ]);

      $this->load($params);
      if(!empty($this->user_id)){
            $userquery = $this->user_id;
            $user_id = Yii::$app->user->identity->getUserIds($userquery);
            $user_id = ArrayHelper::map($user_id,'id','id');
            $query->andWhere([
                'user_id' => $user_id,
        ]);
      }
      if (!$this->validate()) {
      // uncomment the following line if you do not want to any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
      }

      $query->andFilterWhere([
            'course_order_item_id' => $this->course_order_item_id,
            'payment_id' => $this->payment_id,
            'order_sn' => $this->order_sn,
            'parent_id' => $this->parent_id,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            // 'user_id' => $this->user_id,
            'introducer_id' => $this->introducer_id,
            'payment' => $this->payment,
            'presented_course' => $this->presented_course,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'total_price' => $this->total_price,
            'real_price' => $this->real_price,
            'coupon_price' => $this->coupon_price,
            'total_course' => $this->total_course,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

return $dataProvider;
}
}