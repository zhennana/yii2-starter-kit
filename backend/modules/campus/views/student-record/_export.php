<?php 

$course_title = isset($model->course->title) ? $model->course->title  : '';
$title        = isset($model->title) ? $model->title  : '';
$recordTitle  = '《'.$course_title.'》：'.$title;

$studentName = Yii::$app->user->identity->getUserName($model->user_id);
$filename = '【瓦酷-学员档案】['.$course_title.']_'.$studentName.'_'.date("Y-m-d");


header("Content-Type: application/msword"); 
header("Content-Disposition: attachment; filename=".$filename.".doc"); //指定文件名称 
header("Pragma: no-cache");
header("Expires: 0");

?>
<table bgcolor="#FFFFFF" cellspacing="20" cellpadding="5" width="60%" align="center">
    <tr><td><img src="http://www.wakooedu.com/img/top_logo.png"></td></tr>

    <tr><td align="center">
        <span style="color:#e61d4d;"><h1>学员档案</h1></span>
    </td></tr>

    <tr><td>
        <h2 align="center"><?= $recordTitle?></h2>

        <h4><?= $studentName ?>的家长您好：</h4>

        <p style="text-indent:2em;">
            以下是本次课程《<?=$course_title?>》知识点以及<?=$studentName?>上课的表现。
        </p>

        <br><br>
    </td></tr>

    <?php foreach ($model->studentRecordValue as $key => $value) : ?>

    <tr><td>
        <span style="color:#fcca10;">
            <h2>
            <?= isset($value->studentRecordKey->title) ? $value->studentRecordKey->title : ''; ?>
            </h2>
        </span>

        <p style="text-indent:2em;">
            <small>
            <?php 
                if (isset($value->body) && is_string($value->body)) {
                    if (strstr($value->body,"\r\n")) {
                        $ol = '';
                        $ol .= '<ol>';
                        foreach (explode("\r\n",$value->body) as $li) {
                            $ol .= '<li>'.$li.'</li>';
                        }
                        $ol .= '</ol>';
                        echo $ol;
                    }else{
                        echo $value->body;
                    }
                }
            ?>

            <br><br>

            <?php
                if (isset($value->studentRecordValueToFile) && !empty($value->studentRecordValueToFile)) {
                    foreach ($value->studentRecordValueToFile as $toFile) {
                        if (isset($toFile->fileStorageItem) && !empty($toFile->fileStorageItem) && strstr($toFile->fileStorageItem->type,'image')) {

                            $url = $toFile->fileStorageItem->url.$toFile->fileStorageItem->file_name;
                            echo '<div align="center"><img src="'.$url.'?imageView2/1/w/500/h/500"></div><br>';
                        }
                    }
                }
            ?>
            </small>
        </p>
    </td></tr>

    <?php endforeach;?>
    
</table>
