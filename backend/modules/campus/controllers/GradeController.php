<?php

namespace backend\modules\campus\controllers;

use Yii;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\UserToGrade;
/**
* This is the class for controller "GradeController".
*/
class GradeController extends \backend\modules\campus\controllers\base\GradeController
{
    /**
     *  [actionUpgrade description]
     *  @param  [type] $grade_id [原班级ID]
     *  @return [type]           [description]
     */
    public function actionUpgrade($grade_id)
    {
        $info = ['error' => []];
        $newModel         = new Grade;
        $userToGradeModel = new UserToGrade;
        
        // 开启事务
        $transaction = $newModel->db->beginTransaction();
        if (Yii::$app->request->post() && $newModel->load(Yii::$app->request->post())) {

            // 更新新班级入学时间,并建立升班关系
            $originalGrade = Grade::findOne($grade_id);
            $newModel->time_of_enrollment = $originalGrade->time_of_enrollment;
            $newModel->original_grade_id  = $grade_id;

            if ($newModel->save() && Grade::gradeToGraduate($grade_id)) {
                $student_ids = isset($_POST['UserToGrade']['user_id']) ? $_POST['UserToGrade']['user_id'] : [];
                // 复制班级关系
                $info = UserToGrade::copyRelations($grade_id, $newModel->grade_id, $student_ids);

                if (empty($info['error'])) {
                    // 提交事务
                    $transaction->commit();
                    return $this->redirect(['view','grade_id' => $newModel->grade_id]);
                }
            }else{
                $info['error'] = $newModel->getErrors();
            }
        }
        // 回滚
        $transaction->rollBack();

        return $this->render('upgrade',[
            'grade_id'         => $grade_id,
            'model'            => $newModel,
            'userToGradeModel' => $userToGradeModel,
            'info'             => $info
        ]);
    }
}
