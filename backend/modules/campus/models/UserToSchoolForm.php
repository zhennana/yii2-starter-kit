<?php

namespace backend\modules\campus\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use backend\modules\campus\models\UserForm;
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


    public function rules()
    {
       return [
        [
          [
          'school_id','body','roles'],'required'
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
      if($data['UserToSchoolForm']['body'] && is_string($data['UserToSchoolForm']['body'])){
          return $this->dataInit($data['UserToSchoolForm']);
      }else{
        return [];
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
          //var_dump($temp);exit;
            $users['username'] = isset($temp[0]) && !empty($temp[0]) ?trim($temp[0]):NULL;
            $users['phone_number'] = isset($temp[1]) && !empty($temp[1]) ?trim($temp[1]):NULL;
            $users['email'] = isset($temp[2]) && !empty($temp[2]) ? trim($temp[2]):NULL;
            $users['gender'] = isset($temp[3]) && !empty($temp[3]) ? trim($temp[3]) : NULL;
            $users['birth'] = isset($temp[4]) && !empty($temp[4]) ? trim($temp[4]) : NULL;
            $users['password'] = substr($users['phone_number'], 5);
            $users['roles'] = $this->roles;

            if(empty($users['username'])){
                $info['error'][$key] = [['用户名不能为空']];
                continue;
            }

            if(empty($users['phone_number'])){
                $info['error'][$key] = [['手机号不能为空']];
                continue;
            }
            if(!is_phone($users['phone_number'])){
                $info['error'][$key] = [['手机号格式不正确']];
                continue;
            }
            if(empty($users['email'])){
                $info['error'][$key] = [['邮箱不能为空']];
                continue;
            }
            if(empty($users['email'])){
              $info['error'][$key] = [[ $users['username'] .'性别不能为空']];
                continue;
            }
            //var_dump($users['gender']);exit;
            if($users['gender'] == '男'){
              $users['gender'] = 1;
            }
            if($users['gender'] == '女'){
              $users['gender']  = 2;
            }
            if(!in_array($users['gender'],[1,2])){
                $info['error'][$key] = [[$users['username'] .'性别格式不正确']];
                continue;
            }
            if(empty($users['birth'])){
                $info['error'][$key] = [[ $users['username'] .'出生年月不能为空']];
                continue;
            }
            //匹配时间格式
            $patten = "/^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3])\:(0?[0-9]|[1-5][0-9])\:(0?[0-9]|[1-5][0-9]))?$/";
            // var_dump($users['birth'],preg_match($patten,$users['birth']));exit;
            if(!preg_match($patten,$users['birth'])){
              $info['error'][$key] = [[ $users['username'] .'出生年月格式不正确']];
                continue;
            }

            //添加用户/或者更新
            $user_model = $this->AddUser($users);
            //!$model->hasErrors()
         //   var_dump($user_model->getErrors());exit;
            
            if(!empty($user_model->getErrors())){
              $info['error'][$key] = $user_model->getErrors();
              continue;
            }


            /**  
             * 添加关系或者跟新关系
             */
           
            $user_to_school = $this->addUserToSchool(
                  [
                    'school_id'               => $this->school_id,
                    'user_id'                 => $user_model->getModel()->id,
                    'user_title_id_at_school' => $this->school_user_type,
                    'status'                  => 1,
                    'school_user_type'        => $this->school_user_type,
                  ]
              );
            /*
            if($this->school_user_type != 10 ){
                $user_to_school = $this->addUserToSchool(
                  [
                    'school_id'               => $this->school_id,
                    'user_id'                 => $user_model->getModel()->id,
                    'user_title_id_at_school' => 10,
                    'status'                  => 1,
                    'school_user_type'        => 10,
                  ]
              );
                //var_dump('<pre>',$user_to_school);exit;
            }
         */
// var_dump( $user_to_school);exit;
            if(!empty($user_to_school->getErrors())){
               $info['error'][$key] = $user_to_school->getErrors();
               continue;
            }
            //添加学校或者跟新学校
            if($this->grade_id && !empty($this->grade_id) && $this->grade_id != '0'){
              if($this->school_user_type ==  10 && $this->grade_user_type != 10){
                $info['error'][$key] = [[$users['username'].'在学校职称是学生,班级职称就不能是老师']];
                continue;
            }
              $userToGrade = $this->addUserToGrade(
                  [
                    'school_id'               => $this->school_id,
                    'user_id'                 => $user_model->getModel()->id,
                    'grade_id'                => $this->grade_id,
                    'user_title_id_at_grade' => $this->grade_user_type,
                    'status'                  => 1,
                    'grade_user_type'        => $this->grade_user_type,
                  ]
              );
              if(!empty($userToGrade->getErrors())){
                $info['error'][$key] = $userToGrade->getErrors();
                continue; 
              }
            }
            
          }
      return $info;

    }

    /**
     * 添加用户/或者更新
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function AddUser($users){
      //var_dump($users);exit;
      //$users['email'] = 'web@126.com';
      $user = User::find()
      ->where(['phone_number'=> $users['phone_number']])
      ->one();
      $model = new UserForm; 
      if($user){
        unset($users['password']);
        $model->setModel($user);

      }
      $users['status'] = 2;
      $model->load($users,'');
      $model->save();
      return $model;
    }
    /**
     * 添加学校关系
     * @param array $data [description]
    */
    public function addUserToSchool($data = []){
      if(empty($data)){
          return false;
      }

        $model = UserToSchool::find()->where($data)->one();
         // var_dump($model);exit;
        if(!$model){
          $model = new UserToSchool;
        } 
        $model->load($data,'');
        $model->save();
        return $model;
    }
  /**
   * 添加班级管理
   * @param array $data [description]
   */
    public function addUserToGrade($data = []){
      //var_dump($data);exit;
        $model = UserToGrade::find()->where($data)->one();
        if(!$model){
           $model = new UserToGrade;
        }
          $model->load($data,'');
          $model->save();
          return $model;
    }
}
