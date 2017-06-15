<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Article */
// dump($files);exit;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $to_courseware->coursewareMaster->title, 'url' => ['course','master_id' => $to_courseware->courseware_master_id]];
$this->params['breadcrumbs'][] = $this->title;
$img = Yii::getAlias('@frontendUrl').'/img/fredisalearns_index_03.png';

?>
<div id="article-index">
    <div class="course_info">
        <p>Welcome to starter 1 online English Lessons for children - This is an absolute beginner course for ESL kids. It is a good place to start for kids who have little to zero English learning experience. It teaches basic English sentences, new words and grammar. The course is perfect for preschoolers and kindergartners. The following English lessons are covered:</p>
    </div>

    <article class="article-item box course_list">

    <div class="row course_title">
        <div class="col-xs-3 col-sm-3 col-md-2">
            <img class="img-responsive" src="<?= $img ?>">
        </div>
        <div class="col-xs-9 col-sm-9 col-md-10">
            <h1><?= $model->title ?></h1>
        </div>
    </div>

        <?= $model->body ?>

    </article>
    <?php
        foreach ($files as $key => $value) {
            $html = '';
            if ($value['type'] == 'application/x-shockwave-flash') {
                $html .= '<embed class="pull-left" width="100%" height="600px" src="';
                $html .= $value['url'].$value['file_name'].'"/>';
            }elseif ($value['type'] == 'video/mp4') {
                $html .= '<video width="100%" height="100%" id="video" controls >';
                $html .= '<source src="'.$value['url'].$value['file_name'].'">';
                $html .= '您的浏览器不支持该视频播放</video>';
            }
    ?>

    <div class="container videoBox file_<?= $key ?>">
        <?= $html; ?>
    </div>
<?php } ?>

</div>



