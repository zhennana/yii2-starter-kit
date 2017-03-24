<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\SignIn as SignInModel;

/**
* SignIn represents the model behind the search form about `backend\modules\campus\models\SignIn`.
*/
class SignInSearch extends SignInModel
{
      public $school_title;
      public $grade_name;
      public $course_title;

      /**
      * @inheritdoc
      */
      public function rules()
      {
            return [
            [['signin_id', 'school_id', 'grade_id', 'course_id', 'student_id', 'teacher_id', 'auditor_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['school_title', 'grade_name', 'course_title'], 'safe'],
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
            $query = SignInModel::find();
            $query->joinWith(['school','grade','course']);

            $dataProvider = new ActiveDataProvider([
                  'query' => $query,
            ]);

            $dataProvider->setSort([
                  'attributes' => [
                        'school_title' => [
                              'asc'   => ['school.school_title' => SORT_ASC],
                              'desc'  => ['school.school_title' => SORT_DESC],
                        ],
                        'grade_name' => [
                              'asc'   => ['grade.grade_name' => SORT_ASC],
                              'desc'  => ['grade.grade_name' => SORT_DESC],
                        ],
                        'course_title' => [
                              'asc'   => ['course.title' => SORT_ASC],
                              'desc'  => ['course.title' => SORT_DESC],
                        ],
                        'student_id' => [
                              'asc'   => ['sign_in.student_id' => SORT_ASC],
                              'desc'  => ['sign_in.student_id' => SORT_DESC],
                        ],
                        'teacher_id' => [
                              'asc'   => ['sign_in.teacher_id' => SORT_ASC],
                              'desc'  => ['sign_in.teacher_id' => SORT_DESC],
                        ],
                        'auditor_id' => [
                              'asc'   => ['sign_in.auditor_id' => SORT_ASC],
                              'desc'  => ['sign_in.auditor_id' => SORT_DESC],
                        ],
                        'status' => [
                              'asc'   => ['sign_in.status' => SORT_ASC],
                              'desc'  => ['sign_in.status' => SORT_DESC],
                        ],
                  ]
            ]);

            $this->load($params);

            if (!$this->validate()) {
                  // uncomment the following line if you do not want to any records when validation fails
                  // $query->where('0=1');
                  return $dataProvider;
            }

            $query->andFilterWhere([
                  'sign_in.signin_id'  => $this->signin_id,
                  // 'sign_in.school_id'  => $this->school_id,
                  // 'sign_in.grade_id'   => $this->grade_id,
                  // 'sign_in.course_id'  => $this->course_id,
                  'sign_in.student_id' => $this->student_id,
                  'sign_in.teacher_id' => $this->teacher_id,
                  'sign_in.auditor_id' => $this->auditor_id,
                  'sign_in.status'     => $this->status,
                  'sign_in.updated_at' => $this->updated_at,
                  'sign_in.created_at' => $this->created_at,
            ]);
            $query->andFilterWhere(['like', 'school.school_title', $this->school_title])
                  ->andFilterWhere(['like', 'grade.grade_name', $this->grade_name])
                  ->andFilterWhere(['like', 'course.title', $this->course_title]);

            return $dataProvider;
      }
}