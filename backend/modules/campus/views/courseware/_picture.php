<?php
    $userName = isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username :Yii::$app->user->identity->phone_number;
    $watermark = "?watermark/2/text/";
    $watermark .= base64_encode($userName)."/findsize/100/fill/";
    $watermark .= base64_encode('white').'/dissolve/80/gravity/SouthEast/dx/20/dy/20';
    $files .= $watermark; 
   // var_dump($files);
    $this->title = Yii::t('backend', '图片');
    //$this->params['breadcrumbs'][] = 
    $this->params['breadcrumbs'][] = $this->title;
   echo '<div align="center">';
   echo  '<img style = "" class="img-thumbnail" src="'.$files.'?imageView2/1/w/100/h/100" />';
   echo "</div>";
?>