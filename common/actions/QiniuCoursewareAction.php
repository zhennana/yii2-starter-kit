<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace common\actions;

use yii\base\Action;
use yii\base\InvalidParamException;
use Yii;
use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\BucketManager;
use yii\web\Response;
use backend\modules\campus\models\FileStorageItem;
use backend\modules\campus\models\CoursewareTofile;


class QiniuCoursewareAction extends Action
{
    public $type = 'upload';
    public $bucket = 'wakooedu';
    public function run()
    {
        if ($this->type == 'token') 
        {
            $this->createToken();
        } elseif($this->type == 'upload') {
            $this->upload();
        } elseif ($this->type == 'privacy') {
            $this->privacy();
        } elseif ($this->type == 'timeline') {
            $this->timeline();
        } elseif ($this->type == 'delattach') {
            $this->delattach();
        } elseif ($this->type == 'delete') {

            $this->delete();
        }
    }
    /**
     * 生成token
     */
    protected function createToken()
    {
        $auth = new Auth(\Yii::$app->params['qiniu'][$this->bucket]['access_key'], \Yii::$app->params['qiniu'][$this->bucket]['secret_key']);
        $policy['returnBody'] = '{"name": $(fname),"size": $(fsize),"type": $(mimeType),"hash": $(etag),"key":$(key)}';
        $token = $auth->uploadToken(\Yii::$app->params['qiniu'][$this->bucket]['bucket'],null,3600,$policy);
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->data = [
        'uptoken' => $token
        ]; 
        //echo '{"uptoken": "'.$token.'"}';
    }
    /**
     * 文件上传
     */
    protected function upload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//var_dump(Yii::$app->request->post());exit;
        $type      = Yii::$app->request->post('type');
        $url       = Yii::$app->params['qiniu'][$this->bucket]['domain'].'/';
        $file_name = Yii::$app->request->post('url');
        $size      = Yii::$app->request->post('size');
        $user_id   =  Yii::$app->user->identity->id;

        $files = new FileStorageItem();
        $files->school_id        = '0';
        $files->grade_id         = '0';
        $files->file_category_id = 1;
        $files->user_id          = $user_id;
        $files->type             = $type;
        $files->size             = $size;
        $files->url              = $url;
        $files->file_name        = $file_name;
        $files->status           = 1;//1;
        //$file->upload_ip        =  Yii::$app->request->getUserIP();
        $files->component        = 'wakooedu';
//var_dump($files->save(),$files->getErrors());exit;
       if($files->save()){
           $courseware_file = new CoursewareToFile();
           $courseware_file->file_storage_item_id = $files->file_storage_item_id;
           $courseware_file->courseware_id        = $_GET['courseware_id'];
           $courseware_file->status               = 1;
           if($courseware_file->save()){
                return  Yii::$app->response->data = [
                        'status' => $files->file_storage_item_id,
                        'note' => '成功'
                ]; 
           }else{
                return   Yii::$app->response->data = [
                        'status' =>86,
                        'note' =>'失败'
                ]; 
           }
        }else{
            var_dump($files->getErrors());exit;
        }
        return false;
    }
    /**
     * 隐身
     * 公开或者私有
     */
    protected function privacy()
    {

        $id = Yii::$app->request->post('id');
        $policy = Yii::$app->request->post('ispublic');
        Yii::$app->response->format = Response::FORMAT_JSON;

        $item = FileStorageItem::findOne($id);
        if (!$item) 
        {
            Yii::$app->response->data = [
                'status' => 0,
                'note' => '无附件信息'
            ]; 
        }
        $auth = new Auth(\Yii::$app->params['qiniu'][$this->bucket]['access_key'], \Yii::$app->params['qiniu']['secret_key']);
        $bucketMgr = new BucketManager($auth);
        $bucket = \Yii::$app->params['qiniu']['bucket'];
        $key = $item->file_name;
        $key3 = date('YmdHis').$this->GetRandStr().'.'.$this->get_extension($key);

        $err = $bucketMgr->move($bucket, $key, $bucket, $key3);
        if ($err !== null) {
            var_dump($err);
        } else {
            $item->file_name = $key3;
            $item->url = str_ireplace($key, $key3, $item->url);
            $item->ispublic = intval($policy);
            $item->save();
            Yii::$app->response->data = [
                'status' => 1,
                'note' => '修改成功'
            ]; 
        }
    }

    /**
     * 删除附件
     * @return [type] [description]
     */
    protected function delattach()
    {
        $path = Yii::$app->request->post('path');

		Yii::$app->response->format = Response::FORMAT_JSON;
        $item = FileStorageItem::find()->where(['file_name'=>$path])->one();

        if (!$item) 
        {
            Yii::$app->response->data = [
                'status' => 0,
                'note' => '无附件信息'
            ]; 
        }
        else
		{
			$auth = new Auth(\Yii::$app->params['qiniu']['access_key'], \Yii::$app->params['qiniu']['secret_key']);
			$bucketMgr = new BucketManager($auth);
			$bucket = \Yii::$app->params['qiniu']['bucket'];
			$key = $item->file_name;

			$err = $bucketMgr->delete($bucket, $key);
			if ($err !== null) {
				Yii::$app->response->data = [
					'status' => 0,
					'note' => '删除成功',
					'data' => $err
				]; 
			} else {
				$item->status = 1;
				$item->save();
				Yii::$app->response->data = [
					'status' => 1,
					'note' => '删除成功'
				]; 
			}

			$item->delete();
		}
    }

    /**
     * 删除数据库记录，同时删除七牛云
     */
    protected function delete()
    {
       // $id = Yii::$app->request->post('id');
        Yii::$app->response->format = Response::FORMAT_JSON;

        // $item = FileStorageItem::findOne($id);
        // if (!$item) 
        // {
        //     Yii::$app->response->data = [
        //         'status' => 0,
        //         'note' => '无附件信息'
        //     ]; 
        // }
       //var_dump($_POST);exit;
        
        $auth = new Auth(\Yii::$app->params['qiniu']['wakooedu']['access_key'], \Yii::$app->params['qiniu']['wakooedu']['secret_key']);
        $bucketMgr = new BucketManager($auth);
        $bucket = \Yii::$app->params['qiniu'][$this->bucket]['bucket'];
        $key = $_POST['path'];

        $err = $bucketMgr->delete($bucket, $key);
        if ($err !== null) {
            if(isset(Yii::$app->session['qiniu'][$key])){
                unset(Yii::app()->session['qiniu'][$key]);
            }
            Yii::$app->response->data = [
                'status' => 1,
                'note' => '删除成功',
                'data' => $err
            ]; 
        } else {
            //$item->status = 1;
            //$item->save();
            Yii::$app->response->data = [
                'status' => 1,
                'note' => '删除成功'
            ]; 
        }
    }

    protected function GetRandStr($length=10){
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($str)-1;
        $randstr = '';
        for($i=0; $i<$length; $i++){
            $num = mt_rand(0,$len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }

    protected function get_extension($file)
    {
        $info = pathinfo($file);
        return $info['extension'];
    }
}
