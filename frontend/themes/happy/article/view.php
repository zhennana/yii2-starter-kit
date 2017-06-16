<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Article */
// dump($files);exit;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $to_courseware->coursewareMaster->title, 'url' => ['course','master_id' => $to_courseware->courseware_master_id]];
$this->params['breadcrumbs'][] = $this->title;
$img = 'http://orfaphl6n.bkt.clouddn.com/Unit1-Classroom-commands.png';

?>
<div id="article-index">
    <div class="course_info">
        <p>Welcome to starter 1 online English Lessons for children - This is an absolute beginner course for ESL kids. It is a good place to start for kids who have little to zero English learning experience. It teaches basic English sentences, new words and grammar. The course is perfect for preschoolers and kindergartners. The following English lessons are covered:</p>
    </div>

    <article class="article-item box course_list">

    <div class="row course_title">
        <div class="col-xs-6 col-sm-3 col-md-2">
            <img class="img-circle img-responsive" src="<?= $img.'?imageView2/3/w/110/h/110' ?>">
        </div>
        <div class="col-xs-6 col-sm-9 col-md-10">
            <h1><?= $model->title ?></h1>
        </div>
    </div>

        <p>
            <?= $model->body ?>
        </p>

    <?php
        foreach ($files as $key => $value) {
            // http://orkp7ug0b.bkt.clouddn.com/o_1bil3b195fl6do19rbrdi1ocfg.mp4
            // http://orfaphl6n.bkt.clouddn.com/bofang_icon.png 播放
            // dump($value);
            $html = '';

            $str = strstr($value['original'], '.', TRUE);
            if ($value['type'] == 'application/x-shockwave-flash' && !is_mobile()) {
                $html .= '<div class="flash">';
                $html .= '<h1>'.$str.'</h1><br/>';
                $html .= '<embed width="100%" height="600px" src="';
                $html .= $value['url'].$value['file_name'].'"/>';
                $html .= '</div>';
            }elseif ($value['type'] == 'video/mp4') {
                $html .= '<hr/><br/>';
                $html .= '<h1>'.$str.'</h1><br/>';
                $html .= '<video id="yjzxVideo" controls >';
                $html .= '<source src="'.$value['url'].$value['file_name'].'" type="'.$value['type'].'">';
                $html .= '<p>您的浏览器不支持该视频播放</p></video>';
            }
    ?>
        <div class="container videoBox file_<?= $key ?>">
            <?= $html; ?>
        </div>
        <br/>
    <?php } ?>

    </article>

</div>
<script type="text/javascript"></script>



