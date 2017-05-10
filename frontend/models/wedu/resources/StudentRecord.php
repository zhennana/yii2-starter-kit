<?php

namespace frontend\models\wedu\resources;

use Yii;
use frontend\models\base\StudentRecord as BaseStudentRecord;
use frontend\models\wedu\resources\SignIn;
use frontend\models\wedu\resources\StudentRecord;
use frontend\models\wedu\resources\ShareStream;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "student_record".
 */
class StudentRecord extends BaseStudentRecord
{
	/**
	 * 获取我的档案全部图片
	 */
	public static function imageSqlOne(){
		   	$studentRecord = StudentRecord::find()
		     ->select(['i.url','i.file_name','s.created_at'])
		   	->from('student_record as s ')
		   	->leftJoin(['v'=>'student_record_value'], ' s.student_record_id = v.student_record_id ')
		   	->leftJoin(['f'=>'student_record_value_to_file'],' v.student_record_value_id =f.student_record_value_id ')
		   	->leftJoin(['i'=>'file_storage_item'],' f.file_storage_item_id = i.file_storage_item_id ')
	    	->where(['s.user_id'=>Yii::$app->user->identity->id])
	    	->asArray()
	    	->all();
	
//$commandQuery = clone $studentRecord; echo $commandQuery->createCommand()->getRawSql();exit();
	    	return $studentRecord;
	}
	/**
	 * 获取我的分享全部图片
	 * @return [type] [description]
	 */
	public static function imageSqlTwo(){
		$SharaStream = ShareStream::find()
				->select(['i.url','i.file_name','s.created_at'])
				->from('share_stream as s')
				->leftJoin(['f'=>'share_to_file'],'f.share_stream_id = s.share_stream_id')
				->leftJoin(['i'=>'file_storage_item'],'f.file_storage_item_id = i.file_storage_item_id')
				->where(['s.author_id'=>Yii::$app->user->identity->id])
				->asArray()
				->all();
		return $SharaStream;
	}
	/**
	 * 获取所有我的照片
	 * @return [type] [description]
	 */
	public function image_merge($limit = NULL){
		$studentRecord = self::imageSqlOne();
		$sharaStream = self::imageSqlTwo();
		//var_dump($studentRecord);exit;
		$file = array_merge($studentRecord,$sharaStream);
		ArrayHelper::multisort($file,'created_at',[SORT_DESC]);
		$image_url = [];
		foreach ($file as $key => $value) {
			if(empty($value['url']) || empty($value['file_name'])){
				continue;
			}
			if(isset($limit) && $key > $limit){
				break;
			}
			$image_url[] = [
	    			 'image_original'=>$value['url'].$value['file_name'].'?imageView2/3/w/400/h/400',
	    			 'image_shrinkage'=>$value['url'].$value['file_name'],
	    		];
		}
		return $image_url;

	}


}
