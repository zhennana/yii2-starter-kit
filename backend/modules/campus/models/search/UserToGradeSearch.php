<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\UserToGrade;

/**
* UserToGradeSearch represents the model behind the search form about `backend\modules\campus\models\UserToGrade`.
*/
class UserToGradeSearch extends UserToGrade
{

      public $user_label;
      public $start_time;
      public $end_time;
      public $time_filter = 'created_at';
      /**
      * @inheritdoc
      */
      public function rules()
      {
            return [
            [['user_to_grade_id', 'user_id', 'school_id', 'grade_id', 'user_title_id_at_grade', 'status', 'sort', 'grade_user_type', 'updated_at', 'created_at'], 'integer'],
            [['user_label','start_time','end_time','time_filter'],'safe'],
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
            $query = UserToGrade::find();

            $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);

            $this->load($params,'');

            if (!$this->validate()) {
                  // uncomment the following line if you do not want to any records when validation fails
                  // $query->where('0=1');
                  return $dataProvider;
            }

            $query->andFilterWhere([
                  'user_to_grade_id' => $this->user_to_grade_id,
                  'user_id' => $this->user_id,
                  'school_id' => $this->school_id,
                  'grade_id' => $this->grade_id,
                  'user_title_id_at_grade' => $this->user_title_id_at_grade,
                  'status' => $this->status,
                  'sort' => $this->sort,
                  'grade_user_type' => $this->grade_user_type,
                  'updated_at' => $this->updated_at,
                  'created_at' => $this->created_at,
            ]);

            return $dataProvider;
      }

      public function searchApi($params){
            $query = UserToGrade::find();

            $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);

            $this->load($params,'');

            if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
            }
            $query->rightJoin('edu_dev.user','edu_dev.user.id = users_to_grade.user_id');
            $query->andFilterWhere(['like','edu_dev.user.username',$this->user_label]);
            $query->andFilterWhere([
                  'user_to_grade_id' => $this->user_to_grade_id,
                  'user_id' => $this->user_id,
                  'school_id' => $this->school_id,
                  'grade_id' => $this->grade_id,
                  'user_title_id_at_grade' => $this->user_title_id_at_grade,
                  'users_to_grade.status' => $this->status,
                  'sort' => $this->sort,
                  'grade_user_type' => $this->grade_user_type,
                  //'updated_at' => $this->updated_at,
                  //'created_at' => $this->created_at,
            ]);
            if(!empty($this->start_time) && !empty( $this->end_time)){
                   $query->andFilterWhere([
                        'between',
                        'users_to_grade.'. $this->time_filter,
                        $this->start_time,
                        $this->end_time
                  ]);  
            }
           
            return $dataProvider;
      }
}