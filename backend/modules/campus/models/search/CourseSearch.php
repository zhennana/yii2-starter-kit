<?php

namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\Course;

/**
* CourseSearch represents the model behind the search form about `backend\modules\campus\models\Course`.
*/
class CourseSearch extends Course
{
    public $school_title;
    public $grade_name;
    public $courseware_title;

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['course_id', 'school_id', 'teacher_id','grade_id', 'courseware_id', 'creater_id', 'start_time', 'end_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'intro','courseware_title'], 'safe'],
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
        $query = Course::find();
        $query->joinWith(['courseware']);

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
                    'course.course_id'     => $this->course_id,
                    // 'course.school_id'     => $this->school_id,
                    // 'course.grade_id'      => $this->grade_id,
                    // 'course.courseware_id' => $this->courseware_id,
                    'course.teacher_id'    => $this->teacher_id,
                    'course.creater_id'    => $this->creater_id,
                    'course.start_time'    => $this->start_time,
                    'course.end_time'      => $this->end_time,
                    'course.status'        => $this->status,
                    'course.created_at'    => $this->created_at,
                    'course.updated_at'   => $this->updated_at,
                ]);

        $query->andFilterWhere(['like', 'course.title', $this->title])
            ->andFilterWhere(['like', 'course.intro', $this->intro])
            // ->andFilterWhere(['like', 'school.school_title', $this->school_title])
            // ->andFilterWhere(['like', 'grade.grade_name', $this->grade_name])
            ->andFilterWhere(['like', 'courseware.title', $this->courseware_title]);

        return $dataProvider;
    }
}