<?php

namespace backend\modules\campus\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use backend\models\UserForm;
use common\models\User;
use backend\modules\campus\models\School;
use backend\modules\campus\models\UserToSchool;
use backend\modules\campus\models\UserToGrade;

/**
 * This is the model class for table "users_to_school".
 */
class UserToSchoolForm extends Model
{

  public $school_id;
  public $grade_id;
  public $roles;
  public $school_user_type;
  public $grade_user_type;
  public $body;
  //public $email;


/**
 * return [
 
            ['username', 'filter', 'filter' => 'trim'],
            [['username','phone_number','gender','birth'], 'required'],
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
            ['school_id', 'required'],
            ['school_id','in', 'range' =>ArrayHelper::getColumn(
                        $this->getSchool(),
                        'school_id'
                    )
            ]
        ];
 */

    public function rules()
    {
       return [
        [
          [
          'school_id','grade_id','roles','school_user_type','grade_user_type'],'required'
          ],
        [['body','roles'],'string'],

        [
          ['school_id','grade_id','school_user_type','grade_user_type'],
          'integer'
          ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'school_id' => Yii::t('common', '学校'),
            'body' => Yii::t('common', '添加用户'),
            'grade_id' => Yii::t('common', '班级'),
            'roles' => Yii::t('common', '权限分配'),
        ];
    }

    public function batch_create($data){
     //var_dump($data['UserToSchoolForm']['body']);exit;
      if($data['UserToSchoolForm']['body'] && is_string($data['UserToSchoolForm']['body'])){
          $this->dataInit($data['UserToSchoolForm']);
      }
    }
/**
 * 初始化数据
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
    public function dataInit($data){
        $users = [];
        $info = [];
        $userString = trim($data['body']);
        $userString = explode("\r\n",$userString);
        foreach ($userString as $key => $value) {
            $value = preg_replace("/\s+|\t+/",' ',$value);
            $temp = explode(" ",$value);
          //  var_dump($temp);exit;
            $users['realname'] = isset($temp[0]) && !empty($temp[0]) ?trim($temp[0]):NULL;
            $users['phone_number'] = isset($temp[1]) && !empty($temp[1]) ?trim($temp[1]):NULL;
            $users['email'] = isset($temp[2]) && !empty($temp[2]) ? trim($temp[2]):'';
            $users['password'] = substr($users['phone_number'], 5);

            //添加用户
            $user_model = $this->AddUser($users);

            if(!empty($user_model->getErrors() && !isset($user_model->id))){
              continue;
            }
            //查询用户自身权限
            $rules = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
            $auth =  Yii::$app->authManager;
            foreach ($rules as $rule) {
                 $auth->revoke($rule,$user_model->id);
            }
            //删除添加用户的最高权限跟字权限
            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                     $auth->assign($auth->getRole($role),Yii::$app->user->identity->id);
                }
            }
            /**
             * 创建学校
             */
            $user_to_school = $this->addUserToSchool(
                  [
                    'school_id'               => $this->school_id,
                    'user_title_id_at_school' => $this->school_user_type,
                    'status'                  => 1,
                    'school_user_type'        => $this->school_user_type,
                  ]
              );
           if(!empty($user_to_school->getErrors() && !isset($user_to_school->school_id))){
              continue;
            }

            $userToGrade = $this->addUserToGrade(
                  [
                    'school_id'               => $this->school_id,
                    'grade_id'                => $this->grade_id,
                    'user_title_id_at_grade' => $this->grade_user_type,
                    'status'                  => 1,
                    'grade_user_type'        => $this->grade_user_type,
                  ]
              );
            if(!empty($userToGrade->getErrors() && !isset($userToGrade->grade_id))){
              continue;
            }
          }
    return false;

    }

    /**
     * 添加用户
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function AddUser($user){
      $model = User::find()
      ->where(['phone_number'=> $user['phone_number']])
      ->one();

      if($model){
          return  $model;
      }else{
        $model = new  User;
        $user['status'] = 2;
        $model->load($user,'');
        $model->save();
        $model->afterSignup();
        return $model;
      }
    }
    /**
     * 添加学校关系
     * @param array $data [description]
    */
    public function addUserToSchool($data = []){
      if(empty($data)){
          return false;
      }

        $model = UserToSchool::find()->where($data)->all();
        if($model){
          return $model;
        }else{
          $model = new UserToSchool;
          $model->load($data,'');
          $model->save();
          return $model;
        }
    }
  /**
   * 添加班级管理
   * @param array $data [description]
   */
    public function addUserToGrade($data = []){
      // var_dump($data);exit;
        $model = UserToGrade::find()->where($data)->all();
        if($model){
          return $model;
        }else{
          $model = new UserToGrade;
          $model->load($data,'');
          $model->save();
          return $model;
        }
    }
}
