<?php

namespace backend\modules\campus;

/**
 * edu-campus module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\campus\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
        //var_dump($this);exit;
        // dump(\Yii::$app->modules);exit;
        // var_dump(\Yii::$app->get('campus'));
        //$this->layout = 'main.php';
        // custom initialization code goes here
    }
}
