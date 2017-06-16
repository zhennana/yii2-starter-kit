<?php
namespace common\components;
use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\UserToSchool;

class Controller extends \yii\web\Controller
{

    public $schoolCurrent   = NULL;
    public $schoolIdCurrent =  NULL;
    public $gradeCurrent    = NULL;
    public $gradeIdCurrent  = NULL;
    public function init() {
        parent::init();
        if(!Yii::$app->user->isGuest){
            $this->getInitSchoolAndGrade();
        }
    }

    public function getInitSchoolAndGrade(){
       $post = Yii::$app->request->post();
       $select_school_grade = isset($post['select_school_grade']) ? $post['select_school_grade'] : NULL;
        $flush = false;
        // 学校
        $schools = Yii::$app->user->identity->getSchool(
            Yii::$app->user->identity->id,
            $limit = 10,
            $flush
        );
        if(isset($post['school_id']) && !empty($post['school_id']) && !empty($select_school_grade))
        {
            $users_to_school = 0;
            foreach ($schools as $key => $value) {
                if($value['school_id'] == $post['school_id']){
                    $this->schoolCurrent = $schools[$key];
                    //$user_to_school_id = (int)$value['user_to_school_id'];
                    $this->schoolIdCurrent = (int)ArrayHelper::getValue($this->schoolCurrent, 'school_id');
                    break;
                }
            }
        }else{
            $this->schoolCurrent = current($schools);
            $this->schoolIdCurrent = (int)ArrayHelper::getValue($this->schoolCurrent, 'school_id');
        }

        Yii::$app->user->identity->setCurrentSchoolId($this->schoolIdCurrent);
        Yii::$app->user->identity->setCurrentSchool($this->schoolCurrent);

            //获取班级
            $grades = Yii::$app->user->identity->getGrades(
                Yii::$app->user->identity->id,
                $this->schoolIdCurrent,
                $limit = 100,
                $flush
            );
        if(isset($post['grade_id']) && !empty($post['grade_id']) && !empty($select_school_grade)){

            foreach ($grades as $key => $value) {
                if($value['grade_id'] == $post['grade_id']){
                    $this->gradeCurrent = $value;
                    $this->gradeIdCurrent = (int)ArrayHelper::getValue($this->gradeCurrent, 'grade_id');
                    break;
                }
            }

            if($this->gradeIdCurrent == NULL){
                $this->gradeCurrent = current($grades);
                $this->gradeIdCurrent = (int)ArrayHelper::getValue($this->gradeCurrent, 'grade_id');
            }
        }else{
            $this->gradeCurrent = current($grades);
            $this->gradeIdCurrent = (int)ArrayHelper::getValue($this->gradeCurrent, 'grade_id');
        }

        Yii::$app->user->identity->setCurrentGradeId($this->gradeIdCurrent);
        Yii::$app->user->identity->setCurrentGrade($this->gradeCurrent);
        // 初始化学校班级数据
        Yii::$app->user->identity->setSchoolsInfo($schools);
        Yii::$app->user->identity->setGradesInfo($grades);
    }

}
?>