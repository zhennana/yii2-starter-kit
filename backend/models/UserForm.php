<?php
namespace backend\models;

use common\models\User;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;
use common\validators\PhoneValidator;
/**
 * Create user form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $phone_number;
    //public $realname;
    //public $nickname;
    public $password;
    public $status;
    public $roles;
    public $birth;
    public $gender;
    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        ];
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
                $model->afterSignup($profile);
            }else{
                if($model->userProfile){
                    $model->userProfile->load($profile,'');
                    $model->userProfile->save();
                }
            }
         
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->getId());

            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                    $auth->assign($auth->getRole($role), $model->getId());
                }
            }

            return !$model->hasErrors();
        }

        return null;
    }
}
