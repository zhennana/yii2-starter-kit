<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\ShareStream as BaseShareStream;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "share_stream".
 */
class ShareStream extends BaseShareStream
{

  private  $_storage_ids = [];
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
    // //修改发布消息
    // public function batchUpdate($data){
    //     $transaction = $this->db->beginTransaction();
    //     if(isset($data['ShareStreamToGrade']['school_id']) && !empty($data['ShareStreamToGrade']['school_id'])){
    //         //var_dump(4153);exit;
    //           $data['ShareStream']['school_id'] = $data['ShareStreamToGrade']['school_id'];
    //           $data['ShareStream']['grade_id']  = $data['ShareStreamToGrade']['grade_id'];
    //     }
    //     $this->load($data['ShareStream'],'');
    // }
    public function batch_create($data){
      if(isset($data['FileStorageItem']) && count($data['FileStorageItem']) > 9 ){
           $this->addErrors(['图片不能大于9张']);
           return $this;
      }

    
          $transaction = $this->db->beginTransaction();
          if(isset($data['ShareStreamToGrade']['school_id']) && !empty($data['ShareStreamToGrade']['school_id'])){
            //var_dump(4153);exit;
              $data['ShareStream']['school_id'] = $data['ShareStreamToGrade']['school_id'];
              $data['ShareStream']['grade_id']  = $data['ShareStreamToGrade']['grade_id'];
          }

          $this->load($data['ShareStream'],'');
          if($this->save() == false){
              $transaction->rollBack();
              return $this;
          }

          $data['ShareStream']['share_stream_id'] =  $this->share_stream_id;
          if(isset($data['ShareStream']['school_id'])){
              $share_to_grade = $this->addShareStreamToGrade($data['ShareStream']);
              if(isset($share_to_grade) && $share_to_grade->hasErrors()){
                  $transaction->rollBack();
                  return $share_to_grade;
              }
          }
          if(isset($data['FileStorageItem'])){
              $storage = $this->addFileStorageItem($data['FileStorageItem']);
              if(isset($storage) && $storage->hasErrors()){
                  $transaction->rollBack();
                  return $storage;
              }
          }
          $share_to_file = $this->addShareToFile($this->share_stream_id);
          if(isset($share_to_file) && $share_to_file->hasErrors()){
              $transaction->rollBack();
              return $share_to_file;
          }

          $transaction->commit();
          return $this;
  }

  public function addShareStreamToGrade($data){
  
        if(is_array($data['grade_id']) && !empty($data['grade_id'])){
          // var_dump($data['school_id']);exit;
            ShareStreamToGrade::deleteAll(
                  ['share_stream_id'=>$data['share_stream_id']]
            );

              foreach ($data['grade_id'] as $key => $value) {
                    $share_to_grade = [];
                    $share_to_grade['grade_id'] = $value;
                    $share_to_grade['school_id'] = $data['school_id'];
                    $share_to_grade['status']    = $data['status'];
                   //$share_stream['grade_id']  = $value;
                    $share_to_grade['share_stream_id']   = $data['share_stream_id'];
                    $model = new ShareStreamToGrade;
                    $model->load($share_to_grade,'');
                    if(!$model->save()){
                      return $model;
                    };
              }
            }else{
              $model = new ShareStreamToGrade;
              $model->load($data,'');
              $model->save();
              return $model;
            }
      }

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
             return $model;
         }
         $this->_storage_ids[$key] = $model->file_storage_item_id;
      }
  }

  public function addShareToFile($share_stream_id){
      foreach ($this->_storage_ids as $key => $value) {
          $model = new ShareToFile();
          $model->file_storage_item_id = $value;
          $model->share_stream_id        = $share_stream_id;
          $model->status               = 1;
          if(!$model->save()){
              return $model;
          }
      }
  }


}
