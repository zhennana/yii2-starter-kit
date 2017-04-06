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


class QiniuCoursewareAction extends Action
{
    public $type = 'upload';
    public $bucket = 'wakooedu';
    public $source_type;
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
        //var_dump($_POST);exit;
        if($_POST){
            $qiniu = [];
            $qiniu[$_POST['url']] = $_POST;
            Yii::$app->session['qiniu'] = $qiniu;
        }
        // $file = new Storage();
        // $file->user_id      = Yii::$app->user->id;
        // $file->type         = Yii::$app->request->post('type');
        // $file->size         = Yii::$app->request->post('size');
        // $file->base_url     = Yii::$app->params['qiniu'][$this->bucket]['domain'];
        // $file->path    = Yii::$app->request->post('url');

        // $file->name     = Yii::$app->request->post('file_name');
        // $file->hash     = Yii::$app->request->post('hash');
        // $file->status     = Yii::$app->request->post('ispublic',1);
        // //$file->file_category_id     = Yii::$app->request->post('file_category_id'); // 分类ID 一对一
        // $file->upload_ip    = Yii::$app->request->getUserIP();
        // $file->component    = 'azure.storage.item';
        // $file->source_type  = $this->source_type;
        // $file->entity_id = 0;

        // $data['errno']=0;
        // $data['message']='';

        // if($file->save()){

        //     //保存相片到标签
            
        //     $folder['TagsToUsers']['tag_id'] = Yii::$app->request->post('tag_id', 0);
        //     $folder['TagsToUsers']['tag_name'] = Yii::$app->request->post('tag_name', '');
        //     $folder['TagsToUsers']['tag_type'] = Yii::$app->request->post('tag_type', 0);
        //     if(!empty($folder['TagsToUsers']['tag_id'])){
        //         $folder['TagsToUsers']['user_id'] = Yii::$app->user->id;
        //         $folder['TagsToUsers']['entity_id'] = $file->id;
        //         $folder['TagsToUsers']['school_id'] = Yii::$app->user->identity->getCurrentSchoolId();
        //         $folder['TagsToUsers']['grade_id'] = Yii::$app->user->identity->getCurrentGradeId();
        //         $tagsToUsers = new \common\models\xwg\TagsToUsers;
        //         if($tagsToUsers->load($folder) && $tagsToUsers->save()){
        //             $data['message'] .= ' folder is done. ';
        //         }
        //     }
        //     $data['message'] .= ' upload is done. ';
        // }else{
        //     $data['message'] = $file->getErrors();
        // }

        // //print_r($file->getErrors());
        // $callback = 'callBackQiniu';
        //
        // return ['callback'=>$callback, 'data'=>$data];
    }

    public function timeline(){
        // 活动时间线
        Yii::$app->response->format = Response::FORMAT_JSON;
        $dataTimeLine = [
            'publicIdentity'    => Yii::$app->user->identity->getPublicIdentity(),
            'userId'            => Yii::$app->user->identity->getId(),
            //'file_id'           => $file->id,
            //'file_type'         => $file->type,
            //'file_size'         => $file->size,
            //'file_original'     => $file->original,
            //'file_url'          => $file->url,
            //'file_file_name'    => $file->file_name,
            'file_ispublic'     => Yii::$app->request->post('ispublic', 0), //1 公开 (班级相册) ; 2 私有 (个人相册)
            'files_length'      => Yii::$app->request->post('files_length', 0), //上传照片数量

            'file_category_id'  => Yii::$app->request->post('file_category_id'), // 分类ID    一对一
            'file_category_title'  => Yii::$app->request->post('file_category_title'), // 分类标题
            'tag_type'          => Yii::$app->request->post('tag_type', 0),
            'tag_id'            => Yii::$app->request->post('tag_id', 0),   // 标签 多对多
            'tag_name'          => Yii::$app->request->post('tag_name', ''),
            'created_at'        => time(),
        ];

        $saveTimeline =   \common\models\Timeline::log(
            'qiniu',
            'upload',
            'image',
            $dataTimeLine
        );
		//var_dump($saveTimeline);exit();
		//$data['s'] = null;
		if($saveTimeline){
			echo 'done';
		}
		//echo $data;
		//return ['data'=>$data];
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
