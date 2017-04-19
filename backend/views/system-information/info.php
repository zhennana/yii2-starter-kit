<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
use yii\helpers\Html;

$this->title = Yii::t('backend', 'PHP Info');
?>

<iframe  id="frame_content" src="phpinfo" width="100%" height="100%" scrolling="no" frameborder="0" onload="this.height=this.contentWindow.document.documentElement.scrollHeight">
</iframe>

<?php

//phpinfo();
/*
echo Yii::t(
    'backend',
    'Sorry, application failed to collect information about your system. See {link}.',
    ['link' => Html::a('trntv/probe', 'https://github.com/trntv/probe#user-content-supported-os')]
);
*/
