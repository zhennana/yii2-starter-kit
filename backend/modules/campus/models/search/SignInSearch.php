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
/**
* @inheritdoc
*/
public function rules()
{
return [
[['signin_id', 'school_id', 'grade_id', 'course_id', 'student_id', 'teacher_id', 'auditor_id', 'status', 'updated_at', 'created_at'], 'integer'],
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
            'signin_id' => $this->signin_id,
            'school_id' => $this->school_id,
            'grade_id' => $this->grade_id,
            'course_id' => $this->course_id,
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
            'auditor_id' => $this->auditor_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

return $dataProvider;
}
}