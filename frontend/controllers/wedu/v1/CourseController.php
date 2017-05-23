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
     *     tags={"700-Course-课程课表"},
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
    	$signin = SignIn::find()->where(['student_id'=>Yii::$app->user->identity->id]);
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
    	}
    	//添加分页
    	$data['pages'] = $pages;
    	return $data;
    }

     /**
     * @SWG\Get(path="/course/details",
     *     tags={"700-Course-课程课表"},
     *     summary="每节课学生课程表现",
     *     description="课程列表",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "course_id",
     *        description = "课程id",
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
    public function actionDetails($course_id){
    	if(!isset(Yii::$app->user->identity->id)){
    		$this->serializer['errno'] 		= '300';
    		$this->serializer['message'] 	= '请先登录';
    		return [];
    	}
    	$studentRecord = StudentRecord::find()
    		->select(['course_id','student_record_id'])
	    	->where(['user_id'=>Yii::$app->user->identity->id,'course_id'=>$course_id])
	    	->andWhere(['status'=>StudentRecord::STUDEN_RECORD_STATUS_VALID])
	    	->with(['course','studentRecordValue'=>function($query){
                    $query->select(['student_record_value_id','student_record_id','body']);
	    			$query->with(['studentRecordValueToFile'=>function($query){

                            $query->select(['student_record_value_id','file_storage_item_id']);
	    					$query->with('fileStorageItem');
	    			}]);
	    	}])
	    	->asArray()
	    	->one();
	    $data = [];
	    $data['title'] = isset($studentRecord['course']['title']) ? $studentRecord['course']['title'] : '' ;
	    $data['intro'] = isset($studentRecord['course']['intro']) ? $studentRecord['course']['intro'] : '';
	    $data['expression'] = isset($studentRecord['studentRecordValue'][0]['body']) ? $studentRecord['studentRecordValue'][0]['body']:'';
	    $data['image_url']  = [];
	    if(isset($studentRecord['studentRecordValue'][0]['studentRecordValueToFile'])){
	    	$file = $studentRecord['studentRecordValue'][0]['studentRecordValueToFile'];
	    		foreach ($file as $key => $value) {
	    			 $data['image_url'][] = [
                               'image_original' =>$value['fileStorageItem']['url'].$value['fileStorageItem']['file_name'],
                                'image_shrinkage'=>$value['fileStorageItem']['url'].$value['fileStorageItem']['file_name'].'?imageView2/3/w/400/h/400',
                     ];
	    		}
	    }
	    return $data;
    }

    /**
     * @SWG\Get(path="/course/my-photos",
     *     tags={"700-Course-课程课表"},
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
    	// $studentRecord = StudentRecord::find()
	    // 	->where(['user_id'=>Yii::$app->user->identity->id])
	    // 	->with(['studentRecordValue'=>function($query){
	    // 		$query->with(['studentRecordValueToFile'=>function($query){
        //             //$query->limit(1);
	    // 			$query->with('fileStorageItem');
	    // 		}]);
	    // 	}])
	    // 	->asArray()
	    // 	->all();
	    // //$pages = new Pagination(['totalCount' =>$studentRecord->count(), 'pageSize' => '1']);
    	// //$studentRecord =  $studentRecord->offset($pages->offset)->limit($pages->limit)->asArray()->all();
	    // $data = [];
	    // foreach ($studentRecord as $key => $value) {
	    // 	foreach ($value['studentRecordValue'] as  $studentRecordValue) {
	    // 		foreach ($studentRecordValue['studentRecordValueToFile'] as  $studentRecordValueToFile) {
	    // 			 if($studentRecordValueToFile['fileStorageItem']){
	    // 			 	   $file = $studentRecordValueToFile['fileStorageItem'];
	    // 			 		$data[] = [
	    // 			 			'image_original'=>$file['url'].$file['file_name'],
	    // 			 			'image_shrinkage'=>$file['url'].$file['file_name'],
	    // 			 		];
	    // 			 }
	    // 		}
	    // 	}
	    // }
	   //return $data;
    }

    /**
     * @SWG\Get(path="/course/course-sing-in-list",
     *     tags={"700-Course-课程课表"},
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
    public function actionCourseSingInList($school_id,$grade_id){
        $model = new $this->modelClass;
        return $model->userCourseSingInData($school_id,$grade_id);
    }
    /**
     * @SWG\Post(path="/course/create-sing-in",
     *     tags={"700-Course-课程课表"},
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
    public function actionCreateSingIn(){

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
     * @SWG\Get(path="/course/sing-in-details",
     *     tags={"700-Course-课程课表"},
     *     summary="(老师)学生详情",
     *     description="详情",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "singin_id",
     *        description = "学校id",
     *        required = true,
     *        type = "integer"
     *     ),
     *  @SWG\Response(
     *         response = 200,
     *         description = "签到详情"
     *     ),
     * )
     *
    **/
    public function actionSingInDetails($singin_id){
            $model = new SignIn;
            return $model->details($singin_id);
    }

    /**
     * @SWG\Get(path="/course/school-to-grades",
     *     tags={"700-Course-课程课表"},
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
        $models = Yii::$app->user->identity->getSchoolToGrade();
        $data = [];
        foreach ($models as $key => $value) {
            $data[$value->school_id]['school_id'] =  $value->school_id;
            $data[$value->school_id]['school_label'] = $value->toArray(['school_label'])['school_label'];
            $data[$value->school_id]['grade'][]   =[
                    'school_id'=>$value->school_id,
                    'grade_label'=>$value->toArray(['grade_label'])['grade_label'],
            ];
        }
          sort($data);
          return $data;
    }

    /**
     * @SWG\Get(path="/course/users-to-grades",
     *     tags={"700-Course-课程课表"},
     *     summary="(老师)老师下边的所有学生{花名册}",
     *     description="老师下边的所有班级",
     *     produces={"application/json"},
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "singin_id",
     *        description = "学校id",
     *        required = false,
     *        type = "integer"
     *     ),
     *  @SWG\Parameter(
     *        in = "query",
     *        name = "singin_id",
     *        description = "学校id",
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
        //$model =  new UserToGrade;
        return UserToGrade::getStudents();
    }
}