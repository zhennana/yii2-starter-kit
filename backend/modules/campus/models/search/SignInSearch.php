<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\SignIn as SignInModel;

/**
* SignIn represents the model behind the search form about `backend\modules\campus\models\SignIn`.
*/
class SignInSearch extends SignInModel
{
      public $school_title;
      public $grade_name;
      public $course_title;
      public $student_name;
      public $teacher_name;

      /**
      * @inheritdoc
      */
      public function rules()
      {
            return [
            [['signin_id', 'school_id', 'grade_id', 'course_id', 'student_id', 'teacher_id', 'auditor_id', 'status', 'updated_at', 'created_at','type_status'], 'integer'],
            [['school_title','student_name','teacher_name','grade_name', 'course_title','describe'], 'safe'],
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
            $query->joinWith(['school','grade','course'])->all();
            // $query->LeftJoin('edu_dev.user as user','student_id = user.id');
            // $query->LeftJoin('edu_dev.user as user','student_id = user.id');
      //$query->LeftJoin('edu_dev.user as user1','student_id = user1.id');
      //$query->LeftJoin('edu_dev.user as user1','teacher_id = user.id');

            $dataProvider = new ActiveDataProvider([
                  'query' => $query,
            ]);

            $userquery = [];
            $teacher_id = [];
            $student_id = [];
            if(isset($params['SignInSearch']['teacher_name']) && !empty($params['SignInSearch']['teacher_name'])){
                  $userquery = $params['SignInSearch']['teacher_name'];
                  //$params['SignInSearch']['teacher_name'] = NULL;
                  $teacher_id = Yii::$app->user->identity->getUserIds($userquery);
                 // var_Dump($user_id);
            }
            if(isset($params['SignInSearch']['student_name']) && !empty($params['SignInSearch']['student_name'])){
                  $userquery = $params['SignInSearch']['student_name'];
                  //$params['SignInSearch']['student_name'] = NULL;
            $student_id = Yii::$app->user->identity->getUserIds($userquery);
                  //$user_id[] =3;
            }
            $student_id = ArrayHelper::map($student_id,'id','id');
            $teacher_id = ArrayHelper::map($teacher_id,'id','id');
          //  var_dump($user_id);exit;
           // var_dump($user_id);exit;
          //  var_dump($user_id);exit;
// var_dump($dataProvider->getModels());exit;
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
                  'sign_in.student_id' => $student_id,
                  'sign_in.teacher_id' => $teacher_id,
                  'sign_in.auditor_id' => $this->auditor_id,
                  'sign_in.status'     => $this->status,
                  'sign_in.updated_at' => $this->updated_at,
                  'sign_in.created_at' => $this->created_at,
            ]);
            $query->andFilterWhere(['like', 'school.school_title', $this->school_title])
                  ->andFilterWhere(['like', 'grade.grade_name', $this->grade_name])
                  ->andFilterWhere(['like', 'course.title', $this->course_title]);
                  // ->andFilterWhere([
                  //             'or',
                  //             ['like','user.username',$this->student_name],
                  //            // ['like','user.nickname',$this->user_name],
                  //             ['like','user.realname',$this->student_name],
                  //             ['like','user.phone_number',$this->student_name]
                  //             ])
                  // ->andFilterWhere([
                  //             'or',
                  //             ['like','user.username',$this->teacher_name],
                  //            // ['like','user.nickname',$this->user_name],
                  //             ['like','user.realname',$this->teacher_name],
                  //             ['like','user.phone_number',$this->teacher_name]
                  //             ]);
            return $dataProvider;
      }
}