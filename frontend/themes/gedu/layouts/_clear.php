<?php
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

// http://static.v1.wakooedu.com/jquery-3.2.0.min.js
// http://static.v1.wakooedu.com/jquery-latest.js
\frontend\assets\FrontendAsset::register($this);
\common\assets\React::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="">
    <script src="http://static.v1.wakooedu.com/jquery-latest.js"></script>
    <script src="<?php echo Yii::getAlias('@frontendUrl') ?>/js/jquery/pdata.js"></script>
    <title>光大学校 - <?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?php echo $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
