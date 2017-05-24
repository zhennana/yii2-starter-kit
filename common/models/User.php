<?php
namespace common\models;

use common\commands\AddToTimelineCommand;
use common\models\query\UserQuery;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\UserToSchool;
use backend\modules\campus\models\Grade;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property string $publicIdentity
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 *
 * @property \common\models\UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMINISTRATOR = 'administrator';

    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'auth_key' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'access_token' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                }
            ]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'oauth_create' => [
                    'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status'
                ]
            ]
        );
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common', 'Username'),
            'email' => Yii::t('common', 'E-mail'),
            'phone_number' => Yii::t('common', '手机号'),
            'status' => Yii::t('common', 'Status'),
            'access_token' => Yii::t('common', 'API access token'),
            'created_at' => Yii::t('common', 'Created at'),
            'updated_at' => Yii::t('common', 'Updated at'),
            'logged_at' => Yii::t('common', 'Last login'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public function getUserToSchool(){
        return $this->hasOne(UserToSchool::className(),['user_id'=>'id'])->orderBy(['created_at'=> 'SORT_SESC']);
    }
    
    /**
     * 用户所在的班级
     * @return [type] [description]
     */
    public function getUserToGrade(){
        return $this->hasOne(UserToGrade::className(),['user_id'=>'id'])->orderBy(['created_at'=>'SORT_SESC']);
    }  
    /**
     * 检测用户是否存在班级学校
     * @param  boolean $type [description]
     * @return boolean       [description]
     */
    public function is_userToGrade($type = false){
        $query = $this->getUserToGrade();

        if($type == 1){
            $query->where(['NOT',['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_TEACHER]]);
        }

        if($type == 2){
            $query->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT]);
        }
        if($query->count() == 0 ){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 获取用户所在的学校
     * @return [type] [description]
     */
    public function getCharacterDetailes(){
        $data = [];
        if($this->is_userToGrade(1)){
            $data['user_type']  = 1;
            $model =  $this->getUserToGrade()
                       ->where(['NOT',['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_TEACHER]])
                       ->one();
        }
        if($this->is_userToGrade(2)){
            $data['user_type'] = 2;
            $model = $this->getUserToGrade()
                        ->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT])
                        ->one();

        }

        if(isset($model)){
            return array_merge($model->toArray(['school_id','school_label','grade_id','grade_label']),$data);
        }
        return false;
    }
    /**
     * 获取所有用户班级信息
     * @param  integer $type [description]
     * @return [type]        [description]
     */
    public function getSchoolToGrade($type = 2){
           // 老师
            if($type == 1){
                $model = $this->getUserToGrade()->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_TEACHER]);
            }
            //家长
            if($type == 2){
                $model = $this->getUserToGrade()->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT]);
            }
            $model = $model->andWhere(['status'=>UserToGrade::USER_GRADE_STATUS_NORMAL])->all();
            return $model;
    }
    // public function getSchoolToGradeUser($school_id,$grade_id){
    //         $grade_ids = ArrayHelper::map($this->getSchoolToGrade(),'grade_id','grade_id');
    //         //var_dump($grade_ids);exit;
    //         return UserToGrade::find()->where(['grade_id'=>$grade_ids])->all();
    // }
    /**
     * [getTeacherGrades 获取教师所辖班级]
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    /*
    public function getTeacherGrades($teacher_id)
    {
        $grades = [];

        $userToGrade = UserToGrade::find()->where([
            'user_id'         => $teacher_id,
            'status'          => UserToGrade::USER_GRADE_STATUS_NORMAL,
            'grade_user_type' => UserToGrade::GRADE_USER_TYOE_TEACHER
        ])->asArray()->all();

        if (isset($userToGrade) && !empty($userToGrade)) {
            foreach ($userToGrade as $key => $value) {
                $grades[] = Grade::find()->where([
                    'grade_id' => $value['grade_id'],
                    'status'   => Grade::GRADE_STATUS_OPEN,
                    'graduate' => Grade::GRADE_NOT_GRADUATE,
                ])->asArray()->one();
            }
        }
        return $grades;
    }
    */
    /**
     * [getStudents 获取教师所辖全部班级学生]
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    /*
    public function getStudents($teacher_id, $isGroup = FALSE)
    {
        $students = [];
        $grades   = $this->getTeacherGrades($teacher_id);

        if ($grades) {
            foreach ($grades as $key => $value) {
                $students[] = UserToGrade::find()->with('user')->where([
                    'grade_id'        => $value['grade_id'],
                    'status'          => UserToGrade::USER_GRADE_STATUS_NORMAL,
                    'grade_user_type' => UserToGrade::GRADE_USER_TYPE_STUDENT
                ])->asArray()->all();
            }
        }
        return $students;
    }
    */

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->active()
            ->andWhere(['id' => $id])
            ->one();
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->active()
            ->andWhere(['access_token' => $token])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->active()
            ->andWhere(['username' => $username])
            ->one();
    }

    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        return static::find()
            ->active()
            ->andWhere(['or', ['username' => $login], ['email' => $login]])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_DELETED => Yii::t('common', 'Deleted')
        ];
    }

    public static function getStatusLabel($value){
        $labels = self::statuses();
        if(isset($labels[$value])){
            return $labels[$value];
        }
        return $value;
    }

    /**
     * Creates user profile and application event
     * @param array $profileData
     */
    public function afterSignup(array $profileData = [])
    {
        $this->refresh();
        Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'category' => 'user',
            'event' => 'signup',
            'data' => [
                'public_identity' => $this->getPublicIdentity(),
                'user_id' => $this->getId(),
                'created_at' => $this->created_at
            ]
        ]));
        $profile = new UserProfile();
        $profile->locale = Yii::$app->language;
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
    }

    /**
     * @return string
     */
    public function getPublicIdentity()
    {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }
        if ($this->username) {
            return $this->username;
        }
        return $this->email;
    }
}
