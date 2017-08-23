<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\ActivationCode;

/**
 * ActivationCodeSearch represents the model behind the search form about `backend\modules\campus\models\ActivationCode`.
 */
class ActivationCodeSearch extends ActivationCode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activation_code_id', 'courseware_id', 'course_order_item_id', 'school_id', 'grade_id', 'user_id', 'introducer_id', 'payment', 'status', 'coupon_type', 'expired_at', 'created_at', 'updated_at'], 'integer'],
            [['activation_code'], 'safe'],
            [['total_price', 'real_price', 'coupon_price'], 'number'],
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
        $query = ActivationCode::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'activation_code_id' => $this->activation_code_id,
            'courseware_id' => $this->courseware_id,
            'course_order_item_id' => $this->course_order_item_id,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            'user_id' => $this->user_id,
            'introducer_id' => $this->introducer_id,
            'payment' => $this->payment,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'real_price' => $this->real_price,
            'coupon_price' => $this->coupon_price,
            'coupon_type' => $this->coupon_type,
            'expired_at' => $this->expired_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'activation_code', $this->activation_code]);

        return $dataProvider;
    }
}
