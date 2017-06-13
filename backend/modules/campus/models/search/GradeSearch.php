<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\Grade;

/**
* GradeSearch represents the model behind the search form about `backend\modules\campus\models\Grade`.
*/
class GradeSearch extends Grade
{

    public $school_title;
    public $group_category_name;
    public $owner_label;
    public $creater_label;
    /**
    * @inheritdoc
    */
    public function rules()
    {
    return [
            [['grade_id', 'school_id', 'grade_title', 'owner_id', 'creater_id', 'updated_at', 'created_at', 'sort', 'status', 'graduate', 'time_of_graduation', 'time_of_enrollment','group_category_id'], 'integer'],
            [['grade_name','owner_label','creater_label','school_title','group_category_name'], 'safe'],
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
    $query = Grade::find();
    if(Yii::$app->user->can('manager')){

    }elseif(Yii::$app->user->can('leader') || Yii::$app->user->can('director') ) {
            $school_id = ArrayHelper::map(Yii::$app->user->identity->userToSchool,'school_id','school_id');
            $query->andWhere(['school_id'=>$school_id]);
    }elseif(Yii::$app->user->can('teacher')){
             $grade_id = ArrayHelper::map(Yii::$app->user->identity->userToGrade,'grade_id','grade_id');
            $query->andWhere(['grade_id'=>$grade_id]);
    }
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
                'grade_id'      => $this->grade_id,
                'school_id'     => $this->school_id,
                'group_category_id'=>$this->group_category_id,
                //'classroom_group_levels' => $this->classroom_group_levels,
                'grade_title'   => $this->grade_title,
                'owner_id'      => $this->owner_id,
                'creater_id'    => $this->creater_id,
                'updated_at'    => $this->updated_at,
                'created_at'    => $this->created_at,
                'sort'          => $this->sort,
                'status'        => $this->status,
                'graduate'      => $this->graduate,
                'time_of_graduation' => $this->time_of_graduation,
                'time_of_enrollment' => $this->time_of_enrollment,
            ]);

            $query->andFilterWhere(['like', 'grade_name', $this->grade_name]);
            return $dataProvider;
}

    /**
     * api 接口搜索
     * @param [type] $params [description]
     */
    public function Apisearch($params)
    {
        $query = Grade::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize'=>2,
            ]
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->rightJoin('edu_dev.user','edu_dev.user.id = grade.creater_id');
        $query->rightJoin('edu_dev.user as c','c.id = grade.owner_id');
        //$query->rightJoin('edu.user','user.id = creater_id');
        $query->joinWith(['school','gradeCategory']);
        //var_dump($this->owner_label,$this->creater_label);exit;
        $query->andFilterWhere([
                'grade_id'      => $this->grade_id,
                'school_id'     => $this->school_id,
                'group_category_id'=>$this->group_category_id,
                //'classroom_group_levels' => $this->classroom_group_levels,
                'grade_title'   => $this->grade_title,
                'owner_id'      => $this->owner_id,
                'grade.creater_id'    => $this->creater_id,
                'updated_at'    => $this->updated_at,
                'created_at'    => $this->created_at,
                'sort'          => $this->sort,
                'status'        => $this->status,
                'graduate'      => $this->graduate,
                'time_of_graduation' => $this->time_of_graduation,
                'time_of_enrollment' => $this->time_of_enrollment,
            ]);

            $query->andFilterWhere(['like', 'grade_name', $this->grade_name]);
            $query->andFilterWhere(['like','c.username',$this->owner_label]);
            $query->andFilterWhere(['like','school.school_title',$this->school_title]);
            $query->andFilterWhere(['like','grade_category.name',$this->group_category_name]);
            $query->andFilterWhere(['like','edu_dev.user.username',$this->creater_label]);
//var_dump($dataProvider);exit;
        return $dataProvider;
    }
}