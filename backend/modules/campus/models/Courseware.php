<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Courseware as BaseCourseware;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\FileStorageItem;
use backend\modules\campus\models\CoursewareToFile;
use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\UploadManager;
use common\components\Qiniu\Storage\BucketManager;
use yii\web\UploadedFile;

/**
 * This is the model class for table "courseware".
 */
class Courseware extends BaseCourseware
{

// 获取插入文件后的id
private $storage_ids = [];
private $error       = [];

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

    public function AddCollection($data)
    {
        if(!isset($data['Courseware']) && !isset($data['FileStorageItem'])){
            $this->addErrors(['error'=>'数据不能为空']);
            return $this;
        }

        $transaction = $this->db->beginTransaction();
        $this->load($data['Courseware'],'');
        if($this->save() === false){
            $transaction->rollBack();
            return $this;
        }

        //创建文件
        $storage = $this->AddFileStorageItem($data['FileStorageItem']);
//var_dump($storage);exit;
        if(isset($this->error['FileStorageItem'])){
            $transaction->rollBack();
            return $storage;
        }

        //创建文件课件关系
       $CoursewareToFile = $this->addCoursewareToFile($this->courseware_id);

        if(isset($this->error['CoursewareToFile'])){
            $transaction->rollBack();
            return $CoursewareToFile;
        }
 
//var_dump($this);exit;
        $transaction->commit();
        return $this;

    }

    public function AddFileStorageItem($data){
        foreach ($data as $key => $value) {
           $model = new FileStorageItem();
           $value['user_id']   = Yii::$app->user->identity->id;
           $value['url']       = Yii::$app->params['qiniu']['wakooedu']['domain'].'/';
           $value['status']    = 1;
           $value['upload_ip'] = Yii::$app->request->getUserIP();
           $model->load($value,'');
           if(!$model->save()){
                $this->error['FileStorageItem'] = $model->getErrors();
                return $model;
           }
           $this->storage_ids[$key] = $model->file_storage_item_id;
        }

    }

    public function addCoursewareToFile($courseware_id)
    {
        foreach ($this->storage_ids as $key => $value) {
            $model = new CoursewareToFile();
            $model->file_storage_item_id = $value;
            $model->courseware_id        = $courseware_id;
            $model->status               = 1;
            if(!$model->save()){
                $this->error['CoursewareToFile'] = $model->getErrors();
                return $model;
            }
        }
    }
/*
    public function CreateData(){
      $info = [
        'errorno' => '0',
        'error'   => [],
        'message'=>'',
      ];
      $transaction = $this->db->beginTransaction();
      // if(!$this->save()){
      //     $info['errorno'] = __LINE__;
      //     $info['error']   = $this->Strings($this->getErrors());
      //     return $info ;
      // }

     $file = UploadedFile::getInstances($this,'image');
     // var_dump($file);exit;
     
     if(!$file){
        $info['errorno'] = __LINE__;
        $info['error'] = ['文件不能为空'];
        return  $info;
     }
    $qinniu_file = $this->QiniuUpload($file);
    if($qinniu_file['errorno'] !== 0){
        $info['errorno'] = __LINE__;
        $info['error'] = $this->Strings($qinniu_file);
        return $info;
    }
    $storage = $this->AddStorage($qinniu_file['message']);
    if($storage['errorno'] !== 0){
        $info['errorno'] = __LINE__;
        $info['error'] =  $this->Strings($storage);
        return $info;
    } 
    if($storage['message'] && $this->courseware_id){
        $courseware_to_file  =   $this->addCoursewareToFile($storage['message'],$this->courseware_id);
        if($courseware_to_file['errorno'] !== 0){
            $info['errorno'] = __LINE__;
            $info['error'] = $this->Strings($courseware_to_file);
            return $info;
        }

    }

    if($info['errorno'] == 0){
        $transaction->commit();
    }else{
        $transaction->rollBack();
    }

       return $info;

    }

    /**
     * 上传七牛云
     * @param [type] $file [description]
     */
    /*
    public function QiniuUpload($file){

        $info = [
            'errorno'=>0,
            'error'  =>'',
            'message'=>[],
        ];
        */
        //七牛返回的参数
        // $err = NULL;
        // $ret =[
        //   'name'=>  "banner5.jpg",
        //   'size'=>'579739',
        //   'type'=> 'image/jpeg',
        //   'hash'=> 'FpdRVA7lP9ojO9rfY7q6qSv0FOBq',
        //   'key' => 'banner5.jpg'
        // ];
        // $info['message'] = $ret;
        /*
        foreach ($file as $key => $value) {

            $auth = new Auth(\Yii::$app->params['qiniu']['wakooedu']['access_key'], \Yii::$app->params['qiniu']['wakooedu']['secret_key']);
            $policy['returnBody'] = '{"name": $(fname),"size": $(fsize),"type": $(mimeType),"hash": $(etag),"key":$(key)}';
            $token = $auth->uploadToken(\Yii::$app->params['qiniu']['wakooedu']['bucket'],null,3600,$policy);
            $filePath = $value->tempName;
            $key      = $value->name;
            $uploadMgr = new UploadManager();
            list($ret, $err) = $uploadMgr->putFile ($token, $key, $filePath);
            if($err !== NULL){
                $info['error'][$key] = $err;
                //$info['errorno'] = __LINE__;
            }else{
               //var_dump($ret);exit;
                $info['message'][$key] = $ret;
                 
            }
            
        }
            return $info;
           
        }
        */
    
     /**
      *课件关系表入库
      */
     /*
     public function addCoursewareToFile($storage_ids,$courseware_id){
            $info = [
                'errorno'=>0,
                'error'  =>'',
                'message'=>''
            ];
            $model = new CoursewareToFile;
            foreach ($storage_ids as $key => $value) {
                $model->file_storage_item_id = $value['file_storage_item_id'];
                $model->courseware_id        = $courseware_id;
                $model->status               = 1;
                if($model->save()){
                     $info['message'][$key] = $model->attributes;   
                }else{
                    $info['errorno'] = __LINE__;
                    $info['error'][$key]   = $model->getErrors();
                }
            }
            return $info;
     }*/

    /**
     * 图片添加
     * @param [type] $qinniu_file [description]
     */
    /*
    public function AddStorage($qinniu_file){
        $info = [
            'errorno'=>0,
            'error'  =>'',
            'message'=>''
        ];
        foreach ($qinniu_file as $key => $value) {
            $model = new FileStorageItem;
            //var_dump('<pre>',$model->attributes);exit;
            $model->user_id   = Yii::$app->user->identity->id;
            $model->type      = $value['type'];
            $model->size      = $value['size'];
            $model->file_name = $value['key'];
            $model->url       = \Yii::$app->params['qiniu']['wakooedu']['domain'].'/';
            $model->grade_id  = '0';
            $model->school_id = '0';  
            $model->component = '0';
            $model->ispublic  = '0';
            if(!$model->save()){
                $info['errorno'] = __LINE__;
                $info['error']   = $model->getErrors();
            }else{
                $info['message'][$key] = $model->attributes;
            } 
        }
         return $info;
    }*/

    /**
     * 错误信息转一维数组
     */
    /*
    public  function Strings($error){
        //var_dump($error);exit;
            static $data = [];
            if(is_string($error) || is_int($error)){
                //echo $error;
                $data[] = $error;
            }
            if(is_array($error)){
                foreach ($error as  $key =>$value) {
                    if(empty($value) || $key === 'errorno'){
                        continue;
                    }
                  
                    $data = $this->Strings($value);
                }
            } 
            return $data;
    }
    */
 }
