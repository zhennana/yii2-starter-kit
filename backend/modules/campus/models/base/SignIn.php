<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "sign_in".
 *
 * @property integer $signin_id
 * @property integer $school_id
 * @property integer $grade_id
 * @property integer $course_id
 * @property integer $student_id
 * @property integer $teacher_id
 * @property integer $auditor_id
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $aliasModel
 */
abstract class SignIn extends \yii\db\ActiveRecord
{

    const STATUS_UNREAD = 0;    // 未查看
    const STATUS_READ   = 10;   // 已查看
    const TYPE_STATUS_MORMAL = 10; //正常
    const TYPE_STATUS_ABSENTEEISM  = 20; //缺勤
    //repair
    const TYPE_STATUS_REPAIR_CLASS = 30; //补课
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sign_in';
    }

    public static function getDb(){
        //return \Yii::$app->modules['campus']->get('campus');
        return Yii::$app->get('campus');
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id','course_schedule_id','grade_id', 'course_id','status','type_status', 'student_id','teacher_id'], 'required'],
            ['teacher_id','default','value'=>isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0],
            [['school_id', 'grade_id', 'type_status','course_id', 'student_id', 'teacher_id', 'auditor_id', 'status'], 'integer'],
            ['describe','string','max' => '32'],
            ['school_id','filter','filter'=>function(){
                return (int)$this->school_id;
            }],
             ['school_id','filter','filter'=>function(){
                return (int)$this->school_id;
            }],
            ['school_id','filter','filter'=>function(){
                return (int)$this->school_id;
            }],
            ['grade_id','filter','filter'=>function(){
                return (int)$this->grade_id;
            }],
            ['student_id','filter','filter'=>function(){
                return (int)$this->student_id;
            }],
            ['course_id','filter','filter'=>function(){
                return (int)$this->course_id;
            }],
            ['type_status','filter','filter'=>function(){
                return (int)$this->type_status;
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'signin_id'  => Yii::t('common', '签到记录ID'),
            'school_id'  => Yii::t('common', '学校'),
            'grade_id'   => Yii::t('common', '班级'),
            'course_id'  => Yii::t('common', '课程'),
            'student_id' => Yii::t('common', '学员'),
            'teacher_id' => Yii::t('common', '教师'),
            'auditor_id' => Yii::t('common', '审核人'),
            'status'     => Yii::t('common', '状态'),
            'describe'   => Yii::t('common','缺勤原因'),
            'type_status'=> Yii::t('common','签到类型'),
            'updated_at' => Yii::t('common', '更新时间'),
            'created_at' => Yii::t('common', '签到时间'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'signin_id'  => Yii::t('common', '签到记录ID'),
            // 'school_id'  => Yii::t('common', '学校'),
            // 'grade_id'   => Yii::t('common', '班级'),
            // 'course_id'  => Yii::t('common', '课程'),
            // 'student_id' => Yii::t('common', '学员'),
            // 'teacher_id' => Yii::t('common', '教师'),
            'auditor_id' => Yii::t('common', '创建后不可变更'),
            
            // 'status'     => Yii::t('common', '默认已被查看'),
            'updated_at' => Yii::t('common', '更新时间'),
            'created_at' => Yii::t('common', '签到时间'),
        ]);
    }
    public static function optsTypeStatus()
    {
        return [
            self::TYPE_STATUS_MORMAL        => Yii::t('common', '正常'),
            self::TYPE_STATUS_ABSENTEEISM   => Yii::t('common', '缺勤'),
            self::TYPE_STATUS_REPAIR_CLASS  => Yii::t('common','补课')
        ];
    }
    public static function optsSignInStatus()
    {
        return [
            self::STATUS_READ   => Yii::t('common', '已查看'),
            self::STATUS_UNREAD => Yii::t('common', '未查看'),
        ];
    }
    
    public function getSignInStatusLabel($value)
    {
        $labels = self::optsSignInStatus();
        if(isset($labels[$value])){
            return $labels[$value];
        }
        return $value;
    }
    /**
     * 一共签到多少人，
     * @param  [type] $course_id [description]
     * @return [type]            [description]
     */
    public static function singInCount($course_id,$params = NULL){
        $modelQuery =  self::find()->where(['course_id'=>$course_id]);
        if($params != NULL){
            $modelQuery = $modelQuery->andWhere(['type_status'=>[
                self::TYPE_STATUS_MORMAL,self::TYPE_STATUS_REPAIR_CLASS]]);
        }
        return $modelQuery->count();
    }
    /**
     * 用户上了多少节课时
     * @return [type] [description]
     */
    public static function UserSignCount($user_id){
        $modelQuery =  self::find()->where(['student_id'=>$user_id]);
        $modelQuery = $modelQuery->andWhere(['type_status'=>[
                self::TYPE_STATUS_MORMAL,self::TYPE_STATUS_REPAIR_CLASS]]);
        return $modelQuery->count();
    }

    public function getSchool()
    {
        return $this->hasOne(\backend\modules\campus\models\School::className(),['id' => 'school_id']);
    }

    public function getGrade()
    {
        return $this->hasOne(\backend\modules\campus\models\Grade::className(),['grade_id' => 'grade_id']);
    }

    public function getCourse()
    {
        return $this->hasOne(\backend\modules\campus\models\Course::className(),['course_id' => 'course_id']);
    }

    public function getCourseSchedule(){
        return $this->hasOne(\backend\modules\campus\models\CourseSchedule::className(),['course_schedule_id' => 'course_schedule_id']);
    }
    public function getCourseOrder()
    {
        return $this->hasOne(\backend\modules\campus\models\CourseOrderItem::className(),['user_id' => 'student_id']);
    }
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(),['id' => 'student_id']);
    }

    public function getSignIns(){
        return $this->hasOne(\backend\modules\campus\models\SignIn::className(),['student_id' => 'student_id']);
    }
    public static function getUserName($id)
    {
        $user = \common\models\User::findOne($id);
        $name = '';
        if(isset($user->realname) && !empty($user->realname)){
            return $user->realname;
        }
        if(isset($user->username) && !empty($user->username)){
           return $user->username;
        }
        // if(isset($user->phone_number) && !empty($user->phone_number)){
        //     return $user->phone_number;
        // }
        return $name;
    }
    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\query\SignInQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\campus\models\query\SignInQuery(get_called_class());
    }


}
