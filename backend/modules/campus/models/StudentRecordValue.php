<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\StudentRecordValue as BaseStudentRecordValue;
use yii\helpers\ArrayHelper;
use \backend\modules\campus\models\FileStorageItem;
use \backend\modules\campus\models\Grade;
use \backend\modules\campus\models\StudentRecordValueToFile;
use \backend\modules\campus\models\UserToGrade;

/**
 * This is the model class for table "student_record_value".
 */
class StudentRecordValue extends BaseStudentRecordValue
{
 public  $_storage_ids = [] ;
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
/**
 * 添加学生档案详情详情
 * @param  [type] $params [description]
 * @return [type]         [description]
 */

    public function batchAdd($params,$student_record_id){
      $info = [];
      //var_dump();exit;
      foreach ($params as $k => $v) {
          if(empty($v['body'])){continue;}
          if($k == 4 && (!isset($v['FileStorageItem']) || empty($v['FileStorageItem']))){
              continue;
          }

          $modelvalue = StudentRecordValue::find()->where([
                            'student_record_key_id'=>$v['student_record_key_id'],
                            'student_record_id'=> $student_record_id
                        ])->one();
          $modelvalue =  isset($modelvalue) ? $modelvalue : new  StudentRecordValue();
          $modelvalue->load($v,'');
          $transaction = $this->db->beginTransaction();
          if(!$modelvalue->save()){
              $info[$k] = $modelvalue;
              $transaction->rollBack();
              continue;
          };
          /**
           * 添加附件
           */
          if(isset($v['FileStorageItem']) && !empty($v['FileStorageItem'])){
              $this->_storage_ids = [];
              $FileStorageItem = $this->addFileStorageItem($v['FileStorageItem']);
              if(!empty($FileStorageItem)){
                  $info[$k] = $FileStorageItem;
                  $transaction->rollBack();
                  continue;
               }
           }
           /**
            * 附件与档案关系表
            */
          if(!empty($this->_storage_ids) && isset($modelvalue->student_record_value_id) ){
              $stundent_to_file = $this->addStudentRecordToFile($modelvalue->student_record_value_id);
              if(!empty($stundent_to_file)){
                   $info[$k] = $stundent_to_file;
                   $transaction->rollBack();
                   continue;
              }
          }
          if(!isset($info[$k])){
              $transaction->commit();
          }
      }

      return $info;
    }
/**
 * 添加图片
 * @param [type] $data [description]
*/
  public function addFileStorageItem($data){
      foreach ($data as $key => $value) {
         $model = new FileStorageItem();
         if(isset($value['key'])){
              $value['file_name'] = $value['key'];
         }
         if(isset($value['name'])){
              $value['original'] = $value['name'];
         }
         $value['file_category_id'] = 3;
         $value['user_id']   = Yii::$app->user->identity->id;
         $value['url']       = Yii::$app->params['qiniu']['wakooedu']['domain'].'/';
         $value['status']    = 1;
         $value['upload_ip'] = Yii::$app->request->getUserIP();
         $model->load($value,'');
         if(!$model->save()){
          //$model->addError('123','在这里出错了');
             return $model;
         }
         $this->_storage_ids[$key] = $model->file_storage_item_id;
      }
      return [];
  }
  /**
   * 关系表添加
   */
  public function addStudentRecordToFile($student_record_value_id){
        foreach ($this->_storage_ids as $key => $value) {
          $model = new StudentRecordValueToFile();
          $model->file_storage_item_id   = $value;
          $model->student_record_value_id        = $student_record_value_id;
          if(!$model->save()){
            //$model->addError('123','我这里出错了');
            return $model;
          }
      }
      return [];
  }

    public function getList($params)
    {
        if ($params['type'] == 'school_id') {
            $grades = Grade::find()
                ->where(['school_id' => $params['value'], 'status' => Grade::GRADE_STATUS_OPEN])
                ->all();
            return $grades;
        }elseif($params['type'] == 'grade_id'){
          //这里只获取有效的
            $users = Yii::$app->user->identity->getGradeToUser($params['value'],10,UserToGrade::USER_GRADE_STATUS_NORMAL);
            $data_user = [];
            foreach ($users as $key => $value) {
                if(!empty($value['realname'])){
                    $data_user[$value['id']] = $value['realname'];
                    continue;
                }
                if(!empty($value['username'])){
                    $data_user[$value['id']] = $value['username'];
                    continue;
                }
                if(!empty($value['phone_number'])){
                    $data_user[$value['id']] = $value['phone_number'];
                }
            }
            return $data_user;
        }elseif($params['type'] == 'key'){
            $keys = StudentRecordKey::find()->where(['status'=>StudentRecordKey::STUDENT_KEY_STATUS_OPEN])
            ->andWhere(
              [
              'or',
              ['school_id'=>$params['value']],
              ['school_id'=>0]
          ])
            ->all();
            $keys = ArrayHelper::map($keys,'student_record_key_id','title');
           // var_dump($keys);
            return $keys;
        }
    }
//创建学生成绩
    public function  batchCreate($params){
      $model = $this;
      if(!isset($params['student_record_key_id']) || empty($params['student_record_key_id'])){
          $model->addError('em','成绩科目不能为空');
          return $model;
      }
      foreach ($params['student_record_key_id'] as $key => $value) {
            $models = self::find()->where([
                      'school_id'=> $params['school_id'],
                      'grade_id'=> $params['grade_id'],
                      'user_id'=> $params['user_id'],
                      'exam_type'=> $params['exam_type'],
                      'student_record_key_id'=> $value,
                    ])
            ->one();
            if(!$models){
                $models = new self;

            }
            $models->scenario = 'score';
            $models->school_id = $params['school_id'];
            $models->grade_id = $params['grade_id'];
            $models->user_id = $params['user_id'];
            $models->exam_type = $params['exam_type'];
            $models->student_record_key_id = $value;
            $models->total_score = $params['results'][$value]['total_score'];
            $models->score = $params['results'][$value]['score'];
            $models->status = self::STUDENT_VALUE_STATUS_OPEN;
            if(!$models->save()){
                $model->addErrors($models->getErrors());
                break;
            }
      }
      return $model;
    }
}
