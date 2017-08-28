<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\GradeCategory;

/**
* GradeCategorySearch represents the model behind the search form about `backend\modules\campus\models\GradeCategroy`.
*/
class GradeCategorySearch extends GradeCategory
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['grade_category_id', 'parent_id', 'updated_at', 'created_at', 'status'], 'integer'],
            [['name','creater_id'], 'safe'],
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
    $query = GradeCategory::find();

    $dataProvider = new ActiveDataProvider([
    'query' => $query,
    ]);

    $this->load($params);
    $userquery = '';
    if($this->creater_id){
        $creater_id = Yii::$app->user->identity->getUserIds($this->creater_id);
        $ids = ArrayHelper::map($creater_id,'id','id');
        $query->andWhere([
            'creater_id'=>$ids,
        ]);
    }
    if (!$this->validate()) {
    // uncomment the following line if you do not want to any records when validation fails
    // $query->where('0=1');
    return $dataProvider;
    }

    $query->andFilterWhere([
                'grade_category_id' => $this->grade_category_id,
                'parent_id' => $this->parent_id,
                //'creater_id' => $this->creater_id,
                'updated_at' => $this->updated_at,
                'created_at' => $this->created_at,
                'status' => $this->status,
            ]);

    $query->andFilterWhere(['like', 'name', $this->name]);

    return $dataProvider;
    }
}