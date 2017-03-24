<?php
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
\common\assets\React::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo Html::encode($this->title) ?></title>
    <script src="<?php echo Yii::getAlias('@frontendUrl') ?>/build/react.js"></script>
    <script src="<?php echo Yii::getAlias('@frontendUrl') ?>/build/react-dom.js"></script>
    <script src="<?php echo Yii::getAlias('@frontendUrl') ?>/build/browser.min.js"></script>
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.0-alpha1/JSXTransformer.js"></script>
    
</head>
<body>
<?php $this->beginBody() ?>
    <?php echo $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
