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

        <div class="box-header row course_title">
            <div class="col-xs-6 col-sm-3 col-md-2">
                <img class="img-circle img-responsive" src="<?= $img.'?imageView2/3/w/110/h/110' ?>">
            </div>
            <div class="col-xs-6 col-sm-9 col-md-10">
                <h1><?= $model->title ?></h1>
            </div>
        </div>

        <div class="course_materials">
            <div>

                <h1>Objectives:</h1>
                <?php
                    $body = json_decode($model->body);
                    if (isset($body)) :
                ?>
                    <div class="note">
                        <ul>
                            <?php foreach ($body->items as $key => $value) : ?>
                                <li><?= $value ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <br />

                        <div class="note_ribbon"></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="materials">
                <h1>Main Lesson Materials:</h1>
                <div class="box-body">
                <?php
                    foreach ($files as $key => $value) :
                        $str = strstr($value['original'], '.', TRUE);
                        $html = '';
                        $html .= '<br/>';
                        $html .= '<h4>'.$str.'</h4>';

                        if ($value['type'] == 'application/x-shockwave-flash' && !is_mobile()) {
                            $html .= '<embed width="100%" height="500" src="';
                            $html .= $value['url'].$value['file_name'].'"/>';
                        }elseif ($value['type'] == 'video/mp4') {
                            $html .= '<video id="yjzxVideo" controls >';
                            $html .= '<source src="'.$value['url'].$value['file_name'].'" type="'.$value['type'].'">';
                            $html .= '<p>Your browser does not support this video play</p></video>';
                        }elseif ($value['type'] == 'audio/mpeg'){
                            $html .= '<audio controls="true">';
                            $html .= '<source src="'.$value['url'].$value['file_name'].'">';
                            $html .= '<p>Your browser does not support this audio play</p></audio>';
                        }/*elseif(strstr($value['type'], '/', TRUE) == 'image') {
                            // dump($value);exit;
                            $html .= '<img class="img-responsive col-xs-4" src="';
                            $html .= $value['url'].$value['file_name'];
                            $html .= '?imageView2/3/w/263/h/307';
                            $html .= '" alt="Download Course Manual">';
                        }*/else{
                            $html .= '<img src=';
                            $html .= '"http://orfaphl6n.bkt.clouddn.com/courseware_icon.png?imageView2/3/w/32/h/32" ';
                            $html .= 'alt="Download Course Manual">';
                            $html .= '<a class="download" href="';
                            $html .= $value['url'].$value['file_name'];
                            $html .= '" target="_blank" title="';
                            $html .= $value['original'];
                            $html .= '"> Download ['.$value['original'];
                            $html .= '] Course Manual</a>';
                        }
                ?>
                    <div class="container media_box file_<?= $key ?>">
                        <?= $html; ?>
                    </div>
                    <hr/>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </article>

</div>
<script type="text/javascript"></script>



