<?php
namespace frontend\controllers\wedu\v1;

use Yii;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use frontend\models\wedu\resources\SignIn;
use frontend\models\wedu\resources\StudentRecord;
use backend\modules\campus\models\UserToGrade;
use yii\data\Pagination;
use common\models\UserProfile;
class CourseController extends \common\rest\Controller
{
     public $modelClass = 'frontend\models\wedu\resources\Course'; 
    /**
     * @var array
     */
    public $serializer = [
        'class' => 'common\rest\Serializer',    // 返回格式数据化字段
        'collectionEnvelope' => 'result',       // 制定数据字段名称
        'errno' => 0,                           // 错误处理数字
        'message' => 'OK',                      // 文本提示
    ];

    /**
     * @param  [action] yii\rest\IndexAction
     * @return [type]
     */
    public function beforeAction($action)
    {
        $format = \Yii::$app->getRequest()->getQueryParam('format', 'json');

        if($format == 'xml'){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        }else{
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }

        // 移除access行为，参数为空全部移除
        // Yii::$app->controller->detachBehavior('access');
        return $action;
    }

    /**
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function afterAction($action, $result){
        $result = parent::afterAction($action, $result);

        return $result;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['crete']);
        return $actions;
    }

   


    /**
     * @SWG\Get(path="/course/index",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="以上过课的课程列表",
     *     description="课程列表",
     *     produces={"application/json"},
     *
     *     @SWG\Response(
     *         response = 200,
     *         description = "已上过的课程"
     *     ),
     * )
     *
    **/

    /**
     * 
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function actionIndex()
    {
    	if(!isset(Yii::$app->user->identity->id)){
    		$this->serializer['errno'] 		= '300';
    		$this->serializer['message'] 	= '请先登录';
    		return [];
    	}

        $studentRecord = StudentRecord::find()->where(['user_id'=>Yii::$app->user->identity->id,'status'=>StudentRecord::STUDEN_RECORD_STATUS_VALID
            ]);
        //var_dump($studentRecord);exit;
        $pages = new Pagination(['totalCount' =>$studentRecord->count(), 'pageSize' => '12']);
        $studentRecord =  $studentRecord->offset($pages->offset)->limit($pages->limit)->all();
        if(!$studentRecord){
            $this->serializer['errno'] = 300;
            $this->serializer['message'] = '数据是空的';
            return [];
        }
        foreach ($studentRecord as $key => $value) {

                if($value->studentRecordValue){
                        if($value->course){
                            $data[$key] = $value->course->toArray(['course_id','title','created_at','courseware_id']);
                            $data[$key]['course_schedule_id'] = isset($value->courseSchedule->course_schedule_id) ? (int)$value->courseSchedule->course_schedule_id : '';
                            //$data[$key]['image_url'] = Yii::$app->params['user_avatar'];
                    }
                $data[$key]['student_record_id'] = $value['student_record_id'];
            }
        }

        /*
    	$signin = SignIn::find()->where(['student_id'=>Yii::$app->user->identity->id,'type_status'=>SignIn::TYPE_STATUS_MORMAL]);
    	$pages = new Pagination(['totalCount' =>$signin->count(), 'pageSize' => '12']);
    	$signin =  $signin->offset($pages->offset)->limit($pages->limit)->all();
    	if(!$signin){
    		$this->serializer['errno'] = 300;
    		$this->serializer['message'] = '数据是空的';
    		return [];
    	}
    	foreach ($signin as $key => $value) {
    		if($value->course){
    			$data[$key] = $value->course->toArray(['course_id','title','created_at','courseware_id']);
    			$data[$key]['image_url'] = Yii::$app->params['user_avatar'];
    		}
    	}*/
    	//添加分页
    	$data['pages'] = $pages;
    	return $data;
    }

     /**
     * @SWG\Get(path="/course/details",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="每节课学生课程表现",
     *     description="课程列表",
     *     produces={"application/json"},
     
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "student_record_id",
     *        description = "学员档案id",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "已上过的课程"
     *     ),
     * )
     *
    **/
    public function actionDetails($student_record_id){
    	if(!isset(Yii::$app->user->identity->id)){
    		$this->serializer['errno'] 		= '300';
    		$this->serializer['message'] 	= '请先登录';
    		return [];
    	}
        $modelClass = $this->modelClass;
    	$studentRecord = $modelClass::getStudentRecord($student_record_id);
//var_dump($studentRecord);exit;
	    $data = [];
        $data = [
            'target'    => '',
            'expression'=>'',
            'process'   =>'',
            'image_url' =>[]
        ];
        $body = '';
        if($studentRecord['course']['courseware']['body']){
            $body = json_decode($studentRecord['course']['courseware']['body'],true);
        }

	    $data['title'] = isset($studentRecord['course']['title']) ? $studentRecord['course']['title'] : '' ;

        //这是教学目标
	    $data['target'] =isset($body['target']) ? $body['target'] : $body ;
        //教学过程
        $data['process'] = isset($body['process']) ? $body['process'] : '';
        if(isset($studentRecord['studentRecordValue'])){
            $studentRecord['studentRecordValue'] = ArrayHelper::index($studentRecord['studentRecordValue'],'student_record_key_id');
            //孩子的表现
            $data['expression'] = isset($studentRecord['studentRecordValue'][1]['body']) ? $studentRecord['studentRecordValue'][1]['body']:'';
        //图片
            if(isset($studentRecord['studentRecordValue'][4]['studentRecordValueToFile'])){
                $file = $studentRecord['studentRecordValue'][4]['studentRecordValueToFile'];
                    foreach ($file as $key => $value) {
                        $data['image_url'][] = [
                                   'image_original' =>$value['fileStorageItem']['url'].$value['fileStorageItem']['file_name'].Yii::$app->params['image']['image_original_size'],
                                    'image_shrinkage'=>$value['fileStorageItem']['url'].$value['fileStorageItem']['file_name'].Yii::$app->params['image']['image_shrinkage_size'],
                         ];
                    }
            }

        }

	    return $data;
    }

    /**
     * @SWG\Get(path="/course/my-photos",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="我的照片",
     *     description="我的照片",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "已上过的课程,我发布的照片的全部图片"
     *     ),
     * )
     *
    **/
    public function actionMyPhotos(){
    	if(!isset(Yii::$app->user->identity->id)){
    		$this->serializer['errno'] 		= '300';
    		$this->serializer['message'] 	= '请先登录';
    		return [];
    	}
            $studentRecord = new  StudentRecord;
            //$studentRecord->imageSqlTwo();
        return new ArrayDataProvider([
                 'allModels'=>$studentRecord->image_merge(),
                 'pagination'=>[
                    'pageSize'=> 12
                ]]);
    }

    /**
     * @SWG\Get(path="/course/course-sign-in-list",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="(老师)课程签到需要的学生列表",
     *     description="课程签到的所有学生列表",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "school_id",
     *        description = "学校id",
     *        required = true,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "班级id",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "所需要签到的学生"
     *     ),
     * )
     *
    **/
    public function actionCourseSignInList($school_id,$grade_id){
        $model = new $this->modelClass;
        return $model->userCourseSignInData($school_id,$grade_id);
    }
    /**
     * @SWG\Post(path="/course/create-sign-in",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="(老师)创建签到",
     *     description="创建签到",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "学校id",
     *        required = true,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "formData",
     *        name = "course_id",
     *        description = "课程ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "formData",
     *        name = "course_schedule_id",
     *        description = "排课id",
     *        required = true,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "formData",
     *        name = "grade_id",
     *        description = "班级id",
     *        required = true,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "formData",
     *        name = "SignIn[0][student_id]",
     *        description = "学生id",
     *        required = true,
     *        type = "integer"
     *     ),
     * @SWG\Parameter(
     *        in = "formData",
     *        name = "SignIn[0][describe]",
     *        description = "缺勤原因 字符32",
     *        required = false,
     *        type = "string"
     *     ),
     *  @SWG\Parameter(
     *        in = "formData",
     *        name = "SignIn[0][type_status]",
     *        description = "10:正常；20 ：缺勤",
     *        required = true,
     *        type = "string",
     *        default = "10",
     *        type = "integer",
     *        enum = {10,20}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建签到学生"
     *     ),
     * )
     *
    **/
    public function actionCreateSignIn(){

        $model = new SignIn;
        if($_POST){
            $info =  $model->batch_add($_POST);
            if(empty($info['error']) && isset($info['error'])){
                $this->serializer['errno']      = '300';
                $this->serializer['message']    = $info['error'];
                return [];
            }else{
                return $info['message'];
            }
        }
    }

    /**
     * @SWG\Get(path="/course/user-details",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="(老师)学生详情",
     *     description="详情",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "school_id",
     *        description = "学校id",
     *         default  = 3,
     *        required = true,
     *        type = "integer"
     *     ),
     *   @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "班级id",
     *        default  = 2,
     *        required = true,
     *        type = "integer"
     *     ),
     *   @SWG\Parameter(
     *        in = "query",
     *        name = "user_id",
     *        description = "用户id",
     *        required = true,
     *        default  = 1,
     *        type = "integer"
     *     ),
     *  @SWG\Response(
     *         response = 200,
     *         description = "签到详情"
     *     ),
     * )
     *
    **/
    public function actionUserDetails($school_id,$grade_id,$user_id){
            $model = UserToGrade::find()
                    ->with([
                        'school',
                        'grade',
                        'courseOrder'=>function($model){
                            $model->select(['updated_at','sum(presented_course + total_course ) as total_course']);
                        },
                        'user'=>function($model){
                            $model->select(['id','username','phone_number']);
                            $model->with(['userProfile']);
                        },
                        'signIn'=>function($model){
                            $model->select(['count(signin_id) as obove_count']);
                            $model->andWhere(['type_status'=>SignIn::TYPE_STATUS_MORMAL]);
                        }
                        ])
                    ->where([
                        'user_id'   =>(int)$user_id,
                        'school_id' =>(int)$school_id,
                        'grade_id'  =>(int)$grade_id
                    ])
                    ->asArray()
                    ->one();
        //return $model;
            $data = [];
            $gender = isset($model['user']['userProfile']['gender']) ? UserProfile::gradeLabel($model['user']['userProfile']['gender']) : '';
            if($model){
                $data = [
                    'user_id'       =>(int)$model['user_id'],
                    'username'      => Yii::$app->user->identity->getUserName($model['user_id']),
                    'gender'        => $gender,
                    'birth'         =>isset($model['user']['userProfile']['birth']) ? $model['user']['userProfile']['birth'] : 0,
                    'phone_number'  =>$model['user']['phone_number'],
                    'schoo_id'      =>(int)$model['school_id'],
                    'school_title'  => $model['school']['school_title'],
                    'grade_id'      =>(int)$model['grade_id'],
                    'grade_name'    =>$model['grade']['grade_name'],
                    'total_course'  => isset($model['courseOrder']['total_course']) ? (int)$model['courseOrder']['total_course'] : 0,
                    'created_at'    =>isset($model['courseOrder']['updated_at']) ? $model['courseOrder']['updated_at'] : 0,
                    'obove_count'   =>isset($model['signIn']['obove_count']) ? (int)$model['signIn']['obove_count'] : 0,
                ];
                $data['surplus_course'] = $data['total_course'] - $data['obove_count'];
            }
            return $data;
    }

    /**
     * @SWG\Get(path="/course/school-to-grades",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="(老师)老师下边的所有班级",
     *     description="老师下边的所有班级",
     *     produces={"application/json"},
     *  @SWG\Response(
     *         response = 200,
     *         description = "签到详情"
     *     ),
     * )
     *
    **/

    public function actionSchoolToGrades(){
        if(!isset(Yii::$app->user->identity->id)){
            $this->serializer['errno']      = '300';
            $this->serializer['message']    = '请先登录';
            return [];
        }
        $user_id = Yii::$app->user->identity->id;
        $models = Yii::$app->user->identity->getSchoolToGrade($user_id);
        $data = [];
        foreach ($models as $key => $value) {
            $data[$value->school_id]['school_id'] =  $value->school_id;
            $data[$value->school_id]['school_label'] = $value->toArray(['school_label'])['school_label'];
            $data[$value->school_id]['grade'][]   =[
                    'grade_id'=>$value->grade_id,
                    'grade_label'=>$value->toArray(['grade_label'])['grade_label'],
            ];
        }
          sort($data);
          return $data;
    }

    /**
     * @SWG\Get(path="/course/users-to-grades",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="(老师)老师下边的所有学生{花名册}",
     *     description="老师下边的所有班级",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "school_id",
     *        description = "学校id",
     *        required = false,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "班级id",
     *        required = false,
     *        type = "integer"
     *     ),
     *  @SWG\Response(
     *         response = 200,
     *         description = "老师班级下边的所有学生"
     *     ),
     * )
     *
    **/
    public function actionUsersToGrades(){
        if(!isset(Yii::$app->user->identity->id)){
            $this->serializer['errno']      = '300';
            $this->serializer['message']    = '请先登录';
            return [];
        }
        $user_id = Yii::$app->user->identity->id;
        return UserToGrade::getStudents($user_id);
    }

    /**
     * @SWG\Get(path="/course/sign-in-record",
     *     tags={"WEDU-Course-课程课表"},
     *     summary="(老师)缺勤记录",
     *     description="缺勤记录表",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "school_id",
     *        description = "学校id",
     *        required = true,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "班级id",
     *        required = true,
     * 
     *        type = "integer"
     *     ),
     *  @SWG\Response(
     *         response = 200,
     *         description = "老师班级下边的所有学生"
     *     ),
     * )
     *
    **/

    /**
     * 签到记录
     * @return [type] [description]
     */
    public function actionSignInRecord($school_id, $grade_id){
        if(!isset(Yii::$app->user->identity->id)){
            $this->serializer['errno']      = '300';
            $this->serializer['message']    = '请先登录';
            return [];
        }
        $model = new SignIn;
        $mdoelQuery = $model::find()
                ->where(['school_id'=>$school_id,'grade_id'=>$grade_id])
                ->andWhere(['type_status'=>SignIn::TYPE_STATUS_ABSENTEEISM])
                //->asArray()
                ->all();
      //  return $model;
        return $model->formatData($mdoelQuery);
    }
}