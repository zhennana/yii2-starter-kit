<?php
	namespace common\widgets;
	//use yii;
	use yii\base\widget;
	class Hello extends Widget
	{
		public $mag = '';
		public function init(){
			parent::init();  
		}
		public function run(){
			return $this->mag;
			//return $this->render('index',['mag'=>$this->mag]);
		}
	}
?>
