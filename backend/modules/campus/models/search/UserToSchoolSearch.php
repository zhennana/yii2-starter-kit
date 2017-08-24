<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\UserToSchool;

/**
 * UserToSchoolSearch represents the model behind the search form about `backend\modules\campus\models\UserToSchool`.
 */
class UserToSchoolSearch extends UserToSchool
{
    /**
     * @inheritdoc
     */
    public $user_label;
    public $phone_number;
    public function rules()
    {
        return [
            [['user_to_school_id', 'user_id', 'school_id', 'user_title_id_at_school', 'status', 'sort', 'school_user_type', 'updated_at','phone_number', 'created_at'], 'integer'],
            ['user_label','safe'],
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
        $query = UserToSchool::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $userquery = '';
        $user_id   = [];
        if((isset($params['UserToSchoolSearch']['user_label']) && 
        !empty($params['UserToSchoolSearch']['user_label']) ))
        {
            $userquery['username'] = $params['UserToSchoolSearch']['user_label'];
        }
        if((isset($params['UserToSchoolSearch']['phone_number']) && 
        !empty($params['UserToSchoolSearch']['phone_number']) ))
        {
            $userquery['username'] = $params['UserToSchoolSearch']['phone_number'];
        }
        if(!empty($userquery)){
            $user_id = Yii::$app->user->identity->getUserIds($userquery);
            $user_id = ArrayHelper::map($user_id,'id','id');
            $query->andwhere([
                'user_id' => $user_id,
            ]);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_to_school_id' => $this->user_to_school_id,
            'school_id' => $this->school_id,
            'user_title_id_at_school' => $this->user_title_id_at_school,
            'status' => $this->status,
            'sort' => $this->sort,
            'school_user_type' => $this->school_user_type,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
