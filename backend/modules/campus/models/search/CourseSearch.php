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
            [['course_id', 'school_id', 'teacher_id','grade_id', 'courseware_id', 'creater_id', 'start_time', 'end_time', 'status', 'created_at', 'updeated_at'], 'integer'],
            [['title', 'intro', 'school_title','grade_name','courseware_title'], 'safe'],
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
        //$query->joinWith(['school','grade','courseware']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'course_id' => [
                      'asc'  => ['course.course_id' => SORT_ASC],
                      'desc' => ['course.course_id' => SORT_DESC],
                ],
                'school_title' => [
                      'asc'  => ['school.school_title' => SORT_ASC],
                      'desc' => ['school.school_title' => SORT_DESC],
                ],
                'grade_name' => [
                      'asc'  => ['grade.grade_name' => SORT_ASC],
                      'desc' => ['grade.grade_name' => SORT_DESC],
                ],
                'teacher_id' => [
                      'asc'  => ['course.course_id' => SORT_ASC],
                      'desc' => ['course.course_id' => SORT_DESC],
                ],
                'courseware_title' => [
                      'asc'  => ['courseware.title' => SORT_ASC],
                      'desc' => ['courseware.title' => SORT_DESC],
                ],
                'title' => [
                      'asc'  => ['course.title' => SORT_ASC],
                      'desc' => ['course.title' => SORT_DESC],
                ],
                'intro' => [
                      'asc'  => ['course.intro' => SORT_ASC],
                      'desc' => ['course.intro' => SORT_DESC],
                ],
                'creater_id' => [
                      'asc'  => ['course.creater_id' => SORT_ASC],
                      'desc' => ['course.creater_id' => SORT_DESC],
                ],
                'start_time' => [
                      'asc'  => ['course.start_time' => SORT_ASC],
                      'desc' => ['course.start_time' => SORT_DESC],
                ],
                'end_time' => [
                      'asc'  => ['course.end_time' => SORT_ASC],
                      'desc' => ['course.end_time' => SORT_DESC],
                ],
                'status' => [
                      'asc'  => ['course.status' => SORT_ASC],
                      'desc' => ['course.status' => SORT_DESC],
                ],
                'created_at' => [
                      'asc'  => ['course.created_at' => SORT_ASC],
                      'desc' => ['course.created_at' => SORT_DESC],
                ],
                'updeated_at' => [
                      'asc'  => ['course.updeated_at' => SORT_ASC],
                      'desc' => ['course.updeated_at' => SORT_DESC],
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
                    'course.updeated_at'   => $this->updeated_at,
                ]);

        $query->andFilterWhere(['like', 'course.title', $this->title])
            ->andFilterWhere(['like', 'course.intro', $this->intro])
            ->andFilterWhere(['like', 'school.school_title', $this->school_title])
            ->andFilterWhere(['like', 'grade.grade_name', $this->grade_name])
            ->andFilterWhere(['like', 'courseware.title', $this->courseware_title]);

        return $dataProvider;
    }
}