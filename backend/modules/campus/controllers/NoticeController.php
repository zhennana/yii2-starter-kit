<?php

namespace backend\modules\campus\controllers;
use Yii;
use backend\modules\campus\models\NoticeSearch;
use backend\modules\campus\models\Notice;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
* This is the class for controller "NoticeController".
*/
class NoticeController extends \backend\modules\campus\controllers\base\NoticeController
{
/*
    public function actionIndex()
    {
        $searchModel  = new NoticeSearch;
        $dataProvider = $searchModel->search($_GET);
        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
*/
    // 学校公告(校长发送)
    public function actionSchoolNotice(){
        $searchModel  = new NoticeSearch;
        $dataProvider = $searchModel->search($_GET);

        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');
//VAR_DUMP(array_keys($schools));exit;
        $dataProvider->query->andWhere([
            'school_id'=> array_keys($schools),
            'grade_id' => 0,
            'type'     =>0,
            'category' => 1,
            'receiver_id'=> NULL,
            ]);
        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];
       //var_dump('<pre>',$dataProvider->getModels());exit;
        return $this->render('school_notice', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'schools'      => $schools,
        ]);
    }
    // 创建学校公告(校长发送)
    public function  actionSchoolNoticeCreate(){
        $model = new Notice;
        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');
        if($model->load($_POST)){
            $_POST['Notice']['status_send']  = Notice::STATUS_SEND_SENT;
            //检测是否推送,如果推送,发送状态改为未发送
            if($_POST['Notice']['is_a_push'] == 1){
                    $_POST['Notice']['status_send']  = Notice::STATUS_SEND_UNSENT;
            }
            $info = $model->batch_save($_POST['Notice']);
            if(!empty($info)){
                return $this->render('_school_notice_form',['model'=>$model,'schools'=>$schools,'info'=>$info]);
            }else{
                return $this->redirect(['school-notice']);
            }
        }
        return $this->render('_school_notice_form',['model'=>$model,'schools'=>$schools]);
    }

    //班级公告(老师发送)
    public function actionGradeNotice(){
       // var_dump(4123);exit;
        $searchModel  = new NoticeSearch;
        $dataProvider = $searchModel->search($_GET);

        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');

        $grades = Yii::$app->user->identity->gradesInfo;
        $grades = ArrayHelper::map($grades,'grade_id','grade_name');
//var_dump($grades);exit;
        $dataProvider->query->andWhere([
            'school_id'=> array_keys($schools),
            'grade_id' => array_keys($grades),
            'category' => 1,
            'type'     =>0,
            'receiver_id'=> NULL,
            ]);
        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];

        return $this->render('grade_notice', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'schools'      => $schools,
            'grades'       => $grades,
        ]);
    }
//班级公告
    public function actionGradeNoticeCreate(){
        $model = new Notice;
        $model->setScenario('grade');
        //默认学校
        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');

        if($model->load($_POST)){
            $_POST['Notice']['status_send']  = Notice::STATUS_SEND_SENT;
            $info = $model->batch_save($_POST['Notice']);
            if(!empty($info)){
                return $this->render('_grade_notice_form',['model'=>$model,'schools'=>$schools,'info'=>$info]);
            }else{
                return $this->redirect(['grade-notice']);
            }
        }
        return $this->render('_grade_notice_form',['model'=>$model,'schools'=>$schools]);
    }

    //老师对学生说的话
    public function actionFamilySchoolNotice(){
        $searchModel  = new NoticeSearch;

        $dataProvider = $searchModel->search($_GET);

        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');

        $grades = Yii::$app->user->identity->getGrades(
            Yii::$app->user->identity->id,
            array_keys($schools)
            );
        $grades = ArrayHelper::map($grades,'grade_id','grade_name');

        $dataProvider->query->andWhere([
            'school_id'=> array_keys($schools),
            'grade_id' => array_keys($grades),
            'type'     =>0,
            'category' => 2,
            ]);
        $dataProvider->query->andWhere([
            'NOT',
            [
            'receiver_id' => NULL,
            ]]);
        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];
        return $this->render('teacher_notice', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'schools'      => $schools,
            'grades'       => $grades,
            'category'     => 2
        ]);
    }
//family-school-notice-create
    public function actionFamilySchoolNoticeCreate(){
        $model = new Notice;
        $model->setScenario('student');
        //默认学校
        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');
        if($model->load($_POST)){
            $_POST['Notice']['status_send']  = Notice::STATUS_SEND_SENT;
            $info = $model->batch_save($_POST['Notice']);
            if(!empty($info)){
                return $this->render('_teacher_notice_form',
                    [
                    'model'=>$model,
                    'schools'=>$schools,
                    'category'=>2,
                    'info'=>$info
                    ]);
            }else{
                return $this->redirect(['family-school-notice']);
            }
        }
        return $this->render('_teacher_notice_form',
            [
            'model'=>$model,
            'schools'=>$schools,
            'category'=>2
            ]);
    }

//教师公告
    public function actionTeacherNotice(){
        $searchModel  = new NoticeSearch;
        $dataProvider = $searchModel->search($_GET);

        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');

        $grades =  [];
        /*Yii::$app->user->identity->getGrades(
            Yii::$app->user->identity->id,
            array_keys($schools)
            );*/
        $grades = ArrayHelper::map($grades,'grade_id','grade_name');

        $dataProvider->query->andWhere([
            'school_id'=> array_keys($schools),
            //'grade_id' => array_keys($grades),
            'category' => 1,
            'type'     =>0,
            ]);
        $dataProvider->query->andWhere([
            'NOT',
            [
            'receiver_id' => NULL,
            ]]);
        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];
        return $this->render('teacher_notice', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'schools'      => $schools,
            'grades'       => $grades
        ]);
    }
//老师公告创建
    public function actionTeacherNoticeCreate(){
        $model = new Notice;
        $model->setScenario('teacher');
        //默认学校
        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');

        if($model->load($_POST)){
             $_POST['Notice']['status_send']  = Notice::STATUS_SEND_SENT;
            //检测是否推送,如果推送,发送状态改为未发送
            if($_POST['Notice']['is_a_push'] == 1){
                    $_POST['Notice']['status_send']  = Notice::STATUS_SEND_UNSENT;
            }
            $info = $model->batch_save($_POST['Notice']);
            if(!empty($info)){
                return $this->render('_teacher_notice_form',
                    [
                    'model'=>$model,
                    'schools'=>$schools,
                    'category'=>1,
                    'info'=>$info
                    ]);
            }else{
                return $this->redirect(['teacher-notice']);
            }
        }
        return $this->render('_teacher_notice_form',
            [
            'model'=>$model,
            'schools'=>$schools,
            'category'=>1
            ]);
    }
    //表单联动
    public function actionAjaxForm(){
        $category = NULL;
        if(isset($_GET['category'])){
            $category = $_GET['category'];
        }
        $model = new Notice;
        if($_GET['type_id'] == 1){
            echo Html::tag('option',Html::encode('请选择'),['value'=>""]);
        }
        $model = $model->getlist($_GET['type_id'],$_GET['id'],$category);
        foreach ($model as $key => $value) {
            echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }

    }

    //反馈意见
    public function actionFeedback(){
        $searchModel  = new NoticeSearch;
        $dataProvider = $searchModel->search($_GET);
        $dataProvider->query->andWhere([
                'category'         =>3,
                'type'     =>0,
                'replay_notice_id' =>NULL
            ]);
        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];
        return $this->render('feedback', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
    public function actionReply($notice_id = false){
        $questions = Notice::findOne($notice_id);
       // var_dump($questions);exit;
        if($questions->reply){
            $answers = $questions->reply;
        }else{
            $answers = new Notice;
        }
        if($answers->load($_POST)){
            $answers->status_check = Notice::STATUS_CHECK_NOT_LOOK;
            $answers->status_send  = Notice::STATUS_SEND_SENT;
            $answers->sender_id    = Yii::$app->user->identity->id;
            $answers->receiver_id  = $questions->sender_id;
            $answers->message_hash = md5($answers->message);
            $answers->school_id    = 0;

            if($answers->save()){
                $questions->status_check = Notice::STATUS_CHECK_LOOK;
                $questions->save();
                return $this->redirect(['feedback']);
            }
        }
        return $this->renderAjax('_reply',[
                'questions'=>$questions,
                'answers'  =>$answers,
            ]);
    }
//个推公告
    public function actionAPush(){
        $searchModel  = new NoticeSearch;
        $dataProvider = $searchModel->search($_GET);

        $schools = Yii::$app->user->identity->schoolsInfo;
        $schools = ArrayHelper::map($schools,'school_id','school_title');

        $grades =  [];
        /*Yii::$app->user->identity->getGrades(
            Yii::$app->user->identity->id,
            array_keys($schools)
            );*/
        $grades = ArrayHelper::map($grades,'grade_id','grade_name');

        $dataProvider->query->andWhere([
            'school_id'=> array_keys($schools),
            'is_a_push'=>1,
            ]);
        $dataProvider->query->andWhere([
            'NOT',
            ['receiver_id' => NULL],
            ]);
         $dataProvider->query->andWhere([
            'NOT',
            ['type' => 0],
            ]);
        $dataProvider->sort = [
            'defaultOrder'=>[
                'updated_at' => SORT_DESC
            ]
        ];
        return $this->render('a_push_notice', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'schools'      => $schools,
            'grades'       => $grades
        ]);
    }

}
