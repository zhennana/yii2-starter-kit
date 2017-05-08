<?php
namespace common\widgets;
use kartik\file\FileInput as Input;
use common\widgets\Qiniu\AssetCourseware;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;
use yii\web\View;

class FileInput extends Input{
	public $uptoken_url;
	public function init(){
		parent::init();
	}

	public function run(){
		//$this->registerClientScript();
		// dump($this);
		//return;
	}

	 // protected function registerClientScript()
  //   {

  //       $script  = "var uptoken_url = '".$this->uptoken_url."';";
  //       $script .= "var qiniu_domain ='".\Yii::$app->params['qiniu']['wakooedu']['domain'].'/'."';";
  //      // $script .= "var upload_url='".$this->upload_url."'";
  //       $this->view->registerJs($script, View::POS_BEGIN);
  //       AssetCourseware::register($this->view);

  //   }
}
?>