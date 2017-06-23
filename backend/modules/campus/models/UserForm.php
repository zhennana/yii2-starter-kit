<?php
namespace backend\modules\campus\models;

use common\models\User;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;
use common\validators\PhoneValidator;
use backend\modules\campus\models\School;
use backend\modules\campus\models\UserToSchool;
/**
 * 批量导入跟校区修改用户用到了
 * Create user form
 */
class UserForm extends Model
{
    public  $username;
    public  $email;
    public  $phone_number;
    //public $realname;
    //public $nickname;
    public  $password;
    public  $status;
    public  $roles;
    public  $birth;
    public  $gender;
    private $model;
  //  public  $school_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username','phone_number'], 'required'],
            ['username', 'unique', 'targetClass' => User::className(), 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id'=>$this->getModel()->id]]);
                }
            }],
           ['phone_number', 'unique', 'targetClass' => User::className(), 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id'=>$this->getModel()->id]]);
                }
            }],
            ['username', 'string', 'min' => 2, 'max' => 32],
            //['nickname', 'string', 'min' => 2, 'max' => 32],
            //['realname', 'string', 'min' => 2, 'max' => 32],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass'=> User::className(), 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id'=>$this->getModel()->id]]);
                }
            }],
            [['phone_number'], PhoneValidator::className()],
            ['password', 'required', 'on'=>'create'],
            ['password', 'string', 'min' => 6],

            [['status'], 'integer'],
            [['roles'], 'each',
                'rule' => ['in', 'range' => ArrayHelper::getColumn(
                    Yii::$app->authManager->getRoles(),
                    'name'
                )]
            ],
            [['gender','birth'],'safe'],
         //  [['gender','birth'],'required','on'=>['']],
            //['school_id', 'required', 'on'=>'create'],
        ];
    }
/**
 * 获取权限
 * @return [type] [description]
 */
/*
    public function getSchool(){
        if(Yii::$app->user->can('manager')){
            return School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->all();

        }else{
          return  UserToSchool::find()
            ->from(['users_to_school as u'])
            ->select(['s.school_id','s.school_title'])
            ->leftJoin('school as s','s.school_id = u.school_id')
            ->where(['s.status'=>School::SCHOOL_STATUS_OPEN])
            ->andWhere(['u.user_id' => Yii::$app->user->identity->id])
            ->asArray()
            ->all();
            // return Yii::$app->user->identity->userToSchool;
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common', '用户名'),
            'phone_number' => Yii::t('common', '手机号'),
             'birth'        => Yii::t('common', '出生年月'),
             'gender'       => Yii::t('common', '性别'),
            // 'school_id'       => Yii::t('common', '学校'),
            //'realname' => Yii::t('common', 'Realname'),
            //'nickname' => Yii::t('common', 'Nickname'),
            'email' => Yii::t('common', '邮箱'),
            'status' => Yii::t('common', 'Status'),
            'password' => Yii::t('common', '密码'),
            'roles' => Yii::t('common', '权限')
        ];
    }



    /**
     * @param User $model
     * @return mixed
     */
    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->phone_number = $model->phone_number;
        //$this->realname = $model->realname;
        //$this->nickname = $model->nickname;
        $this->status = $model->status;
        $this->model = $model;
        $this->roles = ArrayHelper::getColumn(
            Yii::$app->authManager->getRolesByUser($model->getId()),
            'name'
        );
        return $this->model;
    }

    /**
     * @return User
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }
        return $this->model;
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function save()
    {

        if ($this->validate()) {

            $model = $this->getModel();
            $isNewRecord = $model->getIsNewRecord();
            //var_dump($isNewRecord);exit;
            $model->username = $this->username;
            //$model->nickname = $this->nickname;
            //$model->realname = $this->realname;
            $model->email = $this->email;
            $model->phone_number = $this->phone_number;
            $model->status = $this->status;
            if ($this->password) {
                $model->setPassword($this->password);
            }
            if (!$model->save()) {
                throw new Exception('Model not saved');
            }
            $profile = [
                    'birth'=>$this->birth,
                    'gender'=>$this->gender,
            ];
            if ($isNewRecord) {
                $model->afterSignup();
            }else{
                if($model->userProfile){
                    $model->userProfile->load($profile,'');
                    $model->userProfile->save();
                }
            }
            $auth = Yii::$app->authManager;
//查询用户自身权限
        $p_roles = [];
        $e_roles = []; 
        if(Yii::$app->user->can('E_manager')){
            $e_roles =  $auth ->getChildRoles('E_administrator');
        }
//主任
        if(Yii::$app->user->can('P_director')){
            $p_roles = $auth->getChildRoles('P_director');
        }
//校长
        if(Yii::$app->user->can('P_leader')){

            $p_roles = $auth->getChildRoles('P_leader');
        }
//代理管理员
        if(Yii::$app->user->can('P_manager')){
            $p_roles = $auth->getChildRoles('P_manager');
        }
//代理超级管理员
        if(Yii::$app->user->can('P_administrator') || Yii::$app->user->can('manager')){
            $p_roles = $auth->getChildRoles('P_administrator');
        }
        $roles = ArrayHelper::merge($e_roles,$p_roles);
            foreach ($roles as $rule) {
                $auth->revoke($rule,$model->id);
            }
            $user = $auth->getRolesByUser(Yii::$app->user->identity->id); 
            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                    $assignment = $auth->getAssignment($role,$model->getId());
                    if($assignment != NULL){
                        continue;
                    }
                    $auth->assign($auth->getRole($role), $model->getId());
                }
            }
            return !$model->hasErrors();
        }
        return null;
    }
}
