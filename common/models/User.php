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
use backend\modules\campus\models\UsersToUsers;
use backend\modules\campus\models\CourseOrderItem;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\School;

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
    const ROLE_DIRECTOR      = 'director';
    const ROLE_TEACHER       = 'teacher';
    const ROLE_LEADER        = 'leader';

    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    // 当前用户班级学校信息
    public $schoolsInfo          = [];
    public $gradesInfo           = [];

    public $currentSchool = []; //当前学校
    public $currentGrade  = []; //当前班级
    public $currentSchoolId = 0; //当前学校班级id
    public $currentGradeId  = 0; //当前班级id
    public $udid;
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
            'realname' => '真实姓名',
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
    public function getUserProfile($user_id = NULL)
    {
        $userProfile = $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
        if($user_id !== NULL){
             $userProfile = [];
             $userProfile =  UserProfile::find();
            $userProfile =  $userProfile->andwhere(['user_id'=>$user_id])->one();
        }
        return $userProfile;
    }
    /**
     * 获取学校
     * @return [type] [description]
     */
    public function getUserToSchool(){
        return $this->hasMany(UserToSchool::className(),['user_id'=>'id'])->orderBy(['created_at'=> SORT_DESC]);
    }
    /**
     * 用户默认所在的班级
     * @return [type] [description]
     */
    public function getUserToGrade(){
        return $this->hasOne(UserToGrade::className(),['user_id'=>'id'])->orderBy(['created_at'=>SORT_DESC]);
    }

    /**
     * 用户所在的班级全部
     * @return [type] [description]
     */
    public function getUsersToGrades(){
        return $this->hasMany(UserToGrade::className(),['user_id'=>'id'])->orderBy(['created_at'=>SORT_DESC]);
    }
    /**
     * 根据权限获取班级id或者学校id
     */
    /*
    public function getSchoolOrGrade(){
        if(Yii::$app->user->can('manager')){
            return 'all';
        }elseif(Yii::$app->user->can('director') || Yii::$app->user->can('leader') ){
            return ArrayHelper::map($this->userToSchool, 'school_id','school_id');
        }elseif(Yii::$app->user->can('teacher')){
            return ArrayHelper::map($this->usersToGrades, 'grade_id','grade_id');
        }else{
            return false;
        }
    }
    */

    /**
     * 获取全部用户信息
     */
    public function getSchool($user_id = 0, $limit = 20, $flush = false){
        if(!empty($this->schoolInfo) && $flush == false){
            return $this->schoolInfo;
        }
        $user_id = empty($user_id) ? $this->id : $user_id ;
        if(Yii::$app->user->can('manager') || Yii::$app->user->can('E_financial')){
            $this->schoolsInfo = School::find()
            //->where(['status'=>School::SCHOOL_STATUS_OPEN])
            ->orderBy(['sort'=>SORT_ASC])
            ->all();
        }else{
            $query = new \yii\db\Query();
            $query->select('s.*')
                ->from('school as s')
                ->leftJoin('users_to_school as t','t.school_id = s.school_id')
                ->andWhere('t.user_id = :user_id',[':user_id'=>$user_id])
                ->andwhere('s.status = :status',[':status'=>School::SCHOOL_STATUS_OPEN])
                ->orderBy('t.sort ASC , t.updated_at DESC')
                ->limit($limit)
                ->groupBy(['s.school_id']);
        $command = $query->createCommand(Yii::$app->get('campus'));
        $this->schoolsInfo = $command->queryAll();
        }
        // $this->schoolsInfo = $school;
        return  $this->schoolsInfo;

    }
    /**
     * 当前用户所在班级全部人员
     * @param  integer $school           [description]
     * @param  integer $school_user_type [description]
     * @return [type]                    [description]
     */
    public function getSchoolToUser($school_id = 0,$school_user_type = 10){

        $user = UserToSchool::find()
                ->with(['user'=>function($query){
                    $query->where(['status' => self::STATUS_ACTIVE]);
                }])
                ->andWhere(['school_id'=> $school_id]);
        if($school_user_type == UserToSchool::SCHOOL_USER_TYPE_TEACHER){
            $user->andwhere(['not',['school_user_type'=>[UserToSchool::SCHOOL_USER_TYPE_STUDENTS,UserToSchool::SCHOOL_USER_TYPE_WORKER]]]);
        }else{
            $user->andWhere(['school_user_type'=>$school_user_type]);
        }
        $user = $user->asArray()->all();
        $data = [];
        foreach ($user  as $key => $value) {
            if(isset($value['user']) && !empty($value['user'])){
                $data[$key] = $value['user'];
            }
        }
        return $data;
    }

    /**
     * $status  学生关系状态;为空全部状态获取
     * *获取班级人员
     */
    public function getGradeToUser($grade_id = 0,$grade_user_type = 20,$status = false){

        $user = UserToGrade::find()
                ->with(['user'=>function($query){
                    $query->where(['status' => self::STATUS_ACTIVE]);
                }])
                ->andWhere(['grade_id'=> $grade_id])
                ->andWhere(['grade_user_type' => $grade_user_type]);
        if($status){
            $user = $user->andwhere(['status'=>$status]);
        }

        $user =  $user->asArray()->all();
        $data = [];
        foreach ($user  as $key => $value) {
            if(isset($value['user']) && !empty($value['user'])){
                $data[$key] = $value['user'];
            }
        }
        return $data;
    }
    /**
     * 获取当前用户下所有班级
     * @return [type] [description]
     */
    public  function getGrades($user_id = 0, $schools_id = 0,  $limit = 100, $flush = false){

        $user_id    = empty($user_id) ? $this->id : $user_id ;
        $schools_id = empty($schools_id) ? $this->getCurrentSchoolId() : $schools_id ;
            $query = new \yii\db\Query();
            $query->select('g.*')
                ->from('users_to_grade as t')
                ->leftJoin('grade as g','t.grade_id = g.grade_id');
            if(Yii::$app->user->can('manager') || Yii::$app->user->can('P_director') || Yii::$app->user->can('E_financial') || Yii::$app->user->can('P_financial')){
            }else{
                $query->andWhere('t.user_id = :user_id',[':user_id'=>$user_id])
                ->andwhere('g.status = :status',[':status'=>Grade::GRADE_STATUS_OPEN])
                ->andwhere(['t.status'=>UserToGrade::USER_GRADE_STATUS_NORMAL]);
            }
                 $query->andwhere(['g.school_id'=>$schools_id])
                ->orderBy('t.sort ASC , t.updated_at DESC')
                ->limit($limit)
                ->groupBy(['g.grade_id']);
            $command = $query->createCommand(Yii::$app->get('campus'));
            $this->gradesInfo = $command->queryAll();
        return $this->gradesInfo;
    }

    // 当前学校班级ID
    public function setCurrentSchoolId($schoolIdCurrent = NULL){
        $this->currentSchoolId = $schoolIdCurrent;
    }
    public function getCurrentSchoolId(){
        return $this->currentSchoolId;
    }

    public function setCurrentGradeId($gradeIdCurrent = NULL){
        $this->currentGradeId = $gradeIdCurrent;
    }
    public function getCurrentGradeId(){
        return $this->currentGradeId;
    }

      // 当前用户的全体学校班级信息
    public function setSchoolsInfo($schoolsInfo){
        $this->schoolsInfo = $schoolsInfo;
    }
    public function getSchoolsInfo(){
        return $this->schoolsInfo;
    }

    public function setGradesInfo($gradesInfo){
        $this->gradesInfo = $gradesInfo;
    }
    public function getGradesInfo(){
        return $this->gradesInfo;
    }

    // 当前学校班级具体信息
    public function setCurrentSchool($schoolCurrent){
        $this->currentSchool = $schoolCurrent;
    }
    public function getCurrentSchool(){
        return $this->currentSchool;
    }

    public function setCurrentGrade($gradeCurrent){
        $this->currentGrade = $gradeCurrent;
    }
    public function getCurrentGrade(){
        return $this->currentGrade;
    }

    /**
     * 检测用户是否存在班级学校
     * @param  boolean $type [description]
     * @return boolean       [description]
     */
    public function is_userToGrade($type = false){
        $query = $this->getUserToGrade();

        if($type == UserToGrade::GRADE_USER_TYPE_STUDENT){
            $query->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT]);
        }

        if($type == UserToGrade::GRADE_USER_TYPE_TEACHER){

            $query->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_TEACHER]);
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
     //   var_dump($this->id);exit;
        if($this->is_userToGrade(UserToGrade::GRADE_USER_TYPE_STUDENT)){
            $data['user_type']  = 1;
            $model =  $this->getUserToGrade()
                       ->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT])
                       ->one();
        }
        if($this->is_userToGrade(UserToGrade::GRADE_USER_TYPE_TEACHER)){
            $data['user_type'] = 2;
            $model = $this->getUserToGrade()
                        ->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_TEACHER])
                        ->one();
        }
        if(isset($model)){
            return array_merge($model->toArray(['school_id','school_label','grade_id','grade_label']),$data);
        }
        return [];
    }
    /**
     * 获取所有用户班级信息
     * 默认获取老师下边的所有班级
     * @param  integer $type [description]
     * @return [type]        [description]
     */
    public function getSchoolToGrade($user_id = NULL,$type = 1){
           // 老师
            if($type == 1){
                $model = $this->getUserToGrade()->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_TEACHER]);
            }
            //学生
            if($type == 2){
                $model = $this->getUserToGrade()->where(['grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT]);
            }
            if($user_id !== NULL){
                $model = $model->andWhere(['user_id'=>$user_id]);
            }
            $model = $model->andWhere(['status'=>UserToGrade::USER_GRADE_STATUS_NORMAL])->all();
           // var_dump($model);exit;
            return $model;
    }

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
            ->andWhere(['or', ['username' => $login], ['email' => $login],['phone_number'=>$login
                ]])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getUdid(){
      return $this->udid;
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
    //用户名信息
    public  function getUserName($id)
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
//根据用户名查找id.
    public function getUserIds($userquery){
      $model = self::find()->active();
      if(is_array($userquery)){
        if(isset($userquery['username']) && !empty($userquery['username'])){
            $model->andWhere([
                'or',
                ['like','username',$userquery['username']],
                ['like','realname',$userquery['username']],
              ]);
        }
        if(isset($userquery['phone_number']) && !empty($userquery['phone_number'])){

            $model->andWhere([
                'like','phone_number',$userquery['phone_number'],
              ]);
        }

        return $model->all();
      }
      if(is_string($userquery)){
        return  $model->andWhere([
                'or',
                ['like','username',$userquery],
                ['like','realname',$userquery],
              // ['like','phone_number',$userquery],

        ])->all();
      }
      return [];
    }

    public function groupId()
    {
        $user_id = $this->id;
        $relevance_group = UsersToUsers::getRelevanceGroup(Yii::$app->user->identity->id);
          if (isset($relevance_group) && !empty($relevance_group)) {
              if (in_array($user_id, $relevance_group)) {
                  $user_id = $relevance_group['user_left_id'];
              }
          }
        return $user_id;
    }

    /**
     *  [getSchoolUserInfo description]
     *  @param  [type] $user [description]
     *  @return [type]       [description]
     */
    public function getSchoolUserInfo()
    {
        $user = [];
        $user['ID'] = $this->id;
        $user['username'] = $this->username;
        $user['realname'] = $this->realname;
        $user['id_number'] = $this->id_number;
        $user['phone_number'] = $this->phone_number;
        $user['email'] = $this->email;
        $user['status'] = $this->status;
        $user['source'] = $this->source;
        $user['safety'] = $this->safety;
        $user['logged_ip'] = $this->logged_ip;
        $user['created_at'] = $this->created_at;
        $user['updated_at'] = $this->updated_at;
        $user['logged_at'] = $this->logged_at;
        $user['avatar'] = '';

        $userProfile = $this->userProfile;

        if(isset($userProfile->avatar_base_url) && !empty($userProfile->avatar_base_url))
        {
            $user['avatar'] = $userProfile->avatar_base_url.'/'.$userProfile->avatar_path;
        }else{
            $fansMpUser = isset($this->fansMp) ? $this->fansMp : '';
            if($fansMpUser){
                $user['avatar'] = $fansMpUser->avatar;
            }else{
                $user['avatar'] = 'http://orh16je38.bkt.clouddn.com/o_1bn7gmjh51nu51dn1k0kimul5n9.jpg';
            }
        }

        $user['grade_name'] = $user['school_title'] = '';
        $user['school_id'] = 0;
        if ($this->getCharacterDetailes()) {
            $user['grade_name'] = $this->getCharacterDetailes()['grade_label'];
            $user['school_title'] = $this->getCharacterDetailes()['school_label'];
            $user['school_id'] = $this->getCharacterDetailes()['school_id'];
        }

        // 家长关系
        $parents = UsersToUsers::find()->where([
            'user_right_id' => $this->id,
            'status'        => UsersToUsers::UTOU_STATUS_OPEN,
        ])->one();

        $student = UsersToUsers::find()->where([
            'user_left_id'  => $this->id,
            'status'        => UsersToUsers::UTOU_STATUS_OPEN,
        ])->one();

        if ($parents) {
            $user['type']    = UsersToUsers::UTOU_TYPE_PARENT;
            $user['parents'] = UsersToUsers::getUserName($parents->user_left_id).'的家长';
        }elseif($student){
            $user['type']    = UsersToUsers::UTOU_TYPE_STUDENT;
            $user['parents'] = '';
        }else{
            $user['type']    = 0;
            $user['parents'] = '';
        }

        // 学校关系
        $user['school_type'] = isset($this->userToSchool[0]->school_user_type) ? UserToSchool::getUserTypeLabel($this->userToSchool[0]->school_user_type) : '';
        
        return $user;
    }

    /**
     *  [getProbationCount 获取体验卡订单数量]
     *  @return [type] [description]
     */
    public function getProbationCount()
    {
        if (!Yii::$app->user->isGuest) {
            $count = CourseOrderItem::find()
                ->where(['status' => CourseOrderItem::STATUS_VALID])
                ->andWhere(['payment_status' => [CourseOrderItem::PAYMENT_STATUS_PAID,CourseOrderItem::PAYMENT_STATUS_PAID_SERVER]])
                ->andwhere(['data' => 'probation','user_id' => Yii::$app->user->identity->id])
                ->count();
            if ($count) {
                return (int)$count;
            }
        }
        return 0;
    }

//获取用户的提送
    // public function getUserClientid($user_id = NULL){
    //     if($user_id == NULL){
    //         $user_id = $this->user_id;
    //     }
    //     $userProfile =  $this->getUserProfile()->where('user_id'=>$user_id)->one();
    //     return $userProfile;

    // }
// //获取用户最后登录手机类型
//     public function getUserClientSourceType($user_id){

//     }
}
