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
<div style="width: 60%;margin:0 auto;">
    <div align="left">
        <img src="http://www.wakooedu.com/img/top_logo.png">
    </div>

        <span style="color:#e61d4d;">
            <h1 align="center">学员档案</h1>
        </span>

        <h2 align="center"><?= $recordTitle?></h2>
        
        <br>

        <h4><?= $studentName ?>的家长您好：</h4>

        <p style="text-indent:2em;">
            以下是本次课程《<?=$course_title?>》知识点以及<?=$studentName?>上课的表现。
        </p>

        <br>

        <?php foreach ($model->studentRecordValue as $key => $value) : ?>

        <span>
            <h3>
            <?= numToWord($key+1).'、'.(isset($value->studentRecordKey->title) ? $value->studentRecordKey->title : ''); ?>
            </h3>
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

            <br>

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

    <?php endforeach;?>
    
</div>
<?php
function numToWord($num) {
    $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
    $chiUni = array('','十', '百', '千', '万', '亿', '十', '百', '千');
      
    $chiStr = '';
      
    $num_str = (string)$num;
      
    $count     = strlen($num_str);
    $last_flag = true; //上一个 是否为0
    $zero_flag = true; //是否第一个
    $temp_num  = null; //临时数字
      
    $chiStr = '';//拼接结果
    if ($count == 2) {//两位数
        $temp_num = $num_str[0];
        $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num].$chiUni[1];
        $temp_num = $num_str[1];
        $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num]; 
    }else if($count > 2){
        $index = 0;
        for ($i=$count-1; $i >= 0 ; $i--) { 
            $temp_num = $num_str[$i];
            if ($temp_num == 0) {
                if (!$zero_flag && !$last_flag ) {
                    $chiStr    = $chiNum[$temp_num]. $chiStr;
                    $last_flag = true;
                }
            }else{
                $chiStr = $chiNum[$temp_num].$chiUni[$index%9] .$chiStr;
                  
                $zero_flag = false;
                $last_flag = false;
            }
            $index ++;
        }
    }else{
        $chiStr = $chiNum[$num_str[0]]; 
    }
    return $chiStr;
}

?>