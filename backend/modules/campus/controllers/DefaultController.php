<?php

namespace backend\modules\campus\controllers;

use yii\web\Controller;

/**
 * Default controller for the `edu-campus` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
