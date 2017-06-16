<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\UserToGrade as BaseUserToGrade;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * This is the model class for table "users_to_grade".
 */
class UserToGrade extends BaseUserToGrade
{

public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
             parent::rules(),
             [
                  # custom validation rules
             ]
        );
    }
    public function fields(){
      return array_merge(
          parent::fields(),
          [

            'school_label'=>function(){
                return isset($this->school->school_title)? $this->school->school_title : '';
            },
            'grade_label'=>function(){
                return isset($this->grade->grade_name) ?  $this->grade->grade_name : '';
            },
            'status_label'=>function(){
              return self::getStatusLabel($this->status);
            },
            'grade_user_type_label'=>function(){
              return self::UserToTypelable($this->grade_user_type);
            },
            'user_title_id_at_grade_Label'=>function(){
              return self::UserTitleTypelable($this->user_title_id_at_grade);
            },
            'user_label'=>function(){
              return isset($this->user->username) ? $this->user->username : '';
            },
            'updated_at'=>function(){
              return date('Y-m-d H:i:s',$this->updated_at);
            },
            'created_at'=>function(){
              return date('Y-m-d H:i:s',$this->created_at);
            }
          ]
        ) ;
    }

    /**
     * 学生与班级批量创建关系
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function date_save($data){
     //dump($data);exit;
      $info = ['error' => []];
      if(!isset($data) && empty($data) && !is_array($data['user_id']))
      {
            return [];
      }

      foreach ($data['user_id'] as $key => $value) {
              if($value){
                $model            = new UserToGrade;
                $model->user_id   = $value;
                $model->school_id = $data['school_id'];
                $model->grade_id  = $data['grade_id'];
                $model->user_title_id_at_grade = $data['user_title_id_at_grade'];
                $model->status    = $data['status'];
                $model->grade_user_type = $data['grade_user_type'];
                if(!$model->save()){
                    $info['error'][$key] = $model->getErrors();
                    continue;
                }
              }
      }
      return $info;
    }
  /**
   * 
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  public function batch_create($data){
        $info = [
            'message' =>[]
        ];
        $param = [];
        $param = $data['user_id'];
        foreach ($param as $key => $value) {
          //$is_checkout = $this->is_checkout($data);
          //if($is_checkout == 0){
              $model    = new UserToGrade;
              $data['user_id'] = $value;
              $model->load($data,'');
              if(!$model->save()){
                $info['error'][$key] = $model->getErrors();
                continue;
              }else{
                $info['message'][] = $model->attributes;
              }
        //  }
        }
        return $info;
  }

  /**
   * 检查数据是否存在
   * @param  array   $param [description]
   * @param  boolean $value [description]
   * @return boolean        [description]
   */
  public function is_checkout($param = [])
  {
    $count = self::find()->where($param)->count();
    return $count;
  }

/**
 * 状态
 */
  public function DropDownLabel($label){
      $data = [];
      foreach ($label as $key => $value) {
          $data[$key]['key'] = $key;
          $data[$key]['value'] = $value;
      }
      sort($data);
      return $data;
    }
  /**
   * 获取用户
   */
  public function DropDownUser(){
    return User::find()->select(['id','username'])->where(['status'=>2])->all();
  }

  public function DropDownschool(){
    $model =  School::find()->select(['school_id','school_title'])->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
    $data = [];
     foreach ($model as $key => $value) {
        $data[$key]['value'] = (int)$value['school_id'];
        $data[$key]['label'] = $value['school_title'];
        $data[$key]['grade']        = [];
    }
    unset($model);
    return $data;
  }

  /**
   * 返回某学校下的班级
   * @param [type] $school_id [description]
   */
  public function DropDownGrade($school_id){
    $model =  Grade::find()->select(['grade_id','grade_name'])->where(['school_id'=>$school_id,'status'=>Grade::GRADE_STATUS_OPEN])->asArray()->all();
    $data = [];
    foreach ($model as $key => $value) {
        $data[$key]['value'] = (int)$value['grade_id'];
        $data[$key]['label'] = $value['grade_name'];
    }
    unset($model);
    return $data;

  }
  /**
   * 返回所有下拉框集合
   */
  public function DropDownGather(){
    $data = [];
    $data['status']           = $this->DropDownLabel(self::optsStatus());
    $data['user_type']        = $this->DropDownLabel(self::optsUserType());
    $data['user_title_type']  = $this->DropDownLabel(self::optsUserTitleType());
    $data['user']             = $this->DropDownUser();
    $data['school']           = $this->DropDownSchool();
    return $data;
  } 
  
  public function getlist($type_id = false,$id =false){
        if($type_id == 1){
            $grade = Grade::find()->where(['status'=>Grade::GRADE_STATUS_OPEN, 'school_id'=>$id])->asArray()->all();
      //var_dump( ArrayHelper::map($grade,'grade_id','grade_name'));exit;
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }
        if($type_id == 2){
            $UserToGrade = UserToGrade::find()
                      ->where([
                        'grade_id'=>$id,
                        'grade_user_type'=>20
                        ])
                      ->with('user')
                      ->all();
          $data = [];
          foreach ($UserToGrade as $key => $value) {
                $data[$value['user_id']] = $value['user']['username'];
          }
          return $data;
        }
        $school_id = Yii::$app->user->identity->getSchoolOrGrade();
        $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN]);
        if($school_id != 'all'){
            $school->andwhere(['school_id'=>$school_id]);
        }
        $school = $school->asArray()->all();
        
        return ArrayHelper::map($school,'school_id','school_title');
      }
}
