<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Grade as BaseGrade;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\GradeCategory;
use backend\modules\campus\models\School;
use common\models\User;

/**
 * This is the model class for table "grade".
 */
class Grade extends BaseGrade
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
             ]
        );
    }
/**
 * 模型返回添加数据
 * @return [type] [description]
 */
    public function fields()
    {
      return ArrayHelper::merge(
             parent::fields(),
             [
                'school_title'=>function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '';
                },
                'group_category_name'=>function($model){
                    return isset($model->gradeCategory->name) ? $model->gradeCategory->name : '';
                },
                'status_label' => function($model){
                  //var_dump($model->status);exit;
                     return self::getStatusValueLabel($model->status);
                },
                'updated_at'  => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                },
                'created_at'  => function($model){
                  return date('Y-m-d H:i:s',$model->created_at);
                },
                'graduate_label'=>function($model){
                  return self::getGraduateValue($model->graduate);
                },
                'owner_label' =>function($model){
                  return self::getUserName($model->owner_id);
                },
                'creater_label' => function($model){
                  return self::getUserName($model->creater_id);
                },
                // 'school_id' =>function(){
                //       return (int)$this->school_id;
                //  },
                //  'group_category_id'=>function(){
                //       return (int)$this->group_category_id;
                //  }

             ]
        );
    }

    public function extraFields(){
       return ArrayHelper::merge(
                parent::extraFields(),
                [
                'school'=>function(){
                   return '123';
                }
              ]);
    }
    /**
     * 下拉框 数据
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function DropDownGather(){
       $data =[];
       //var_dump($this->DropDownSchool());exit;
       $data['school'] = $this->DropDownSchool();
       $data['grade_category'] = $this->DropDownGradeCategory();
       $data['status'] = $this->DropDownStatus();
       $data['graduate'] = $this->DropDownGraduate();
       $data['user']     = $this->DropDownGradUser();
       return $data;
    }

    /**
     * 获取学校下拉框
     */
    public function DropDownSchool(){
      //$fields = $model->fields();
      $model = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->all();
      return $model;
    }

    
    /**
     * 获取班级
     */
    public function DropDownGradeCategory(){
       return GradeCategory::find()->select(['grade_category_id','name'])->where(['status'=>GradeCategory::CATEGORY_OPEN])->all();
    }

    /**
     * 状态
     */
    public function DropDownStatus(){
      $label = self::optsStatus();
      $data = [];
      foreach ($label as $key => $value) {
          $data[$key]['status_id'] = $key;
          $data[$key]['status_label'] = $value;
      }
      sort($data);
      return $data;
    }
    /**
     * 获取毕业状态
     */
    public function DropDownGraduate(){
      $label = self::optsGraduate();
      $data = [];
      foreach ($label as $key => $value) {
          $data[$key]['graduate_id'] = $key;
          $data[$key]['graduate_label'] = $value;
      }
      sort($data);
      return $data;
    }

    public function DropDownGradUser(){
      $user = User::find()->select(['id','username'])->where(['status'=>2])->all();
      return $user;
    }

    /**
     *  [gradeToGraduate 变更班级状态为毕业]
     *  @param  [type] $grade_id [description]
     *  @return [type]           [description]
     */
    public static function gradeToGraduate($grade_id)
    {
        $model = self::findOne($grade_id);
        if ($model) {
            $model->graduate           = self::GRANE_GRADUATE;
            $model->time_of_graduation = time();
            if ($model->save()) {
                return true;
            }
        }
        return false; 
    }

 }
