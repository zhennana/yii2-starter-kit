<?php 
use yii\helpers\Html;
use backend\modules\campus\models\CourseSchedule;

$url = Yii::getAlias('@backendUrl/js/doc/');

// 档案标题
$course_title = isset($model->course->title) ? $model->course->title  : '';

// 模版路径
$template_url = 'http://static.v1.wakooedu.com/template_001.docx';
// $template_url = $url.'template/template_001.docx';


// 数据格式化
$data = $model->recordFormat();
$data['time']         = getTime($model->course_schedule_id);
$data['record_title'] = '《'.$category_name.'》：'.$course_title;
$data['student_name'] = Yii::$app->user->identity->getUserName($model->user_id);
$data['filename']     = '【瓦酷-学员档案】['.$course_title.']_'.$data['student_name'].'_'.date("Y-m-d").'.docx';

$this->title = Yii::t('backend', '档案导出');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学员档案管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', '导出');

?>


<!-- Mandatory js for the library to work -->
<script src="<?php echo $url ?>docxtemplater-latest.min.js"></script>
<script src="<?php echo $url ?>jszip.min.js"></script>
<script src="<?php echo $url ?>file-saver.min.js"></script>
<script src="<?php echo $url ?>jszip-utils.js"></script>

<!-- Mandatory in IE 6, 7, 8 and 9. -->
<!--[if IE]>
<script type="text/javascript" src="<?php echo $url ?>jszip-utils-ie.js"></script>
<![endif]-->


<div>
    <div id="tips">
        <h2 class="text-center">
            <?= Yii::t('backend', '请稍等，正在生成文件...') ?>
        </h2>
        <p class="text-center text-red">
            <?= Yii::t('backend', '提示：如果未弹出下载提示，请刷新页面。') ?>
        </p>
    </div>
    <hr>
    <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
</div>

<script type="text/javascript">
 
    function loadFile(url, callback) {
        JSZipUtils.getBinaryContent(url, callback);
    }

    loadFile("<?= $template_url ?>",function(err,content){
        if (err == null) {
            var zip = new JSZip(content);
            var doc = new Docxtemplater().loadZip(zip)
            //set the templateVariables
            doc.setData({
                "record_title":"<?= $data['record_title'] ?>",
                "student_name":"<?= $data['student_name'] ?>",
                "target":"<?= $data['target']; ?>",
                "process":"<?= $data['process'] ?>",
                "expression":"<?= $data['expression'] ?>",
                "date":"<?= $data['time'] ?>",
            });

            //apply them (replace all occurences of {first_name} by Hipp, ...)
            doc.render();

            //Output the document using Data-URI
            var out=doc.getZip().generate({type:"blob"});
            saveAs(out,"<?= $data['filename'] ?>");
        }else{
            var msg = '';
            msg += "<?= Yii::t('backend', '发生了一个错误，请联系系统管理员。') ?> \r\n";
            msg += err;
            alert(msg);
        }
    });

</script>

<?php
    function getTime($course_schedule_id){
        $date = 0;
        $time = '';
        $numToWeek = [
            1 => '星期一',
            2 => '星期二',
            3 => '星期三',
            4 => '星期四',
            5 => '星期五',
            6 => '星期六',
            7 => '星期日',
        ];

        $course_schedule = CourseSchedule::findOne($course_schedule_id);
        if ($course_schedule) {
            $date = $course_schedule->which_day;
        }
        
        $num = date('N',strtotime($date));
        $time .= $date.' '.$numToWeek[$num];

        return $time;
    }
?>