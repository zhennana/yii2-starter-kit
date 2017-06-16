<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
$this->title = $master['title'];
$this->params['breadcrumbs'][] = $this->title;

$img = 'http://orfaphl6n.bkt.clouddn.com/Unit1-Classroom-commands.png';

?>
<div id="article-index">
    <div class="course_info">
        <h1><?= $master['title'].' Lessons for Kids'; ?></h1>
        <br/>
        <div class="courseware_download">
            <?php
                if (isset($master['files']) && !empty($master['files'])) {
                    foreach ($master['files'] as $key => $value) { 
                        $url = $value['url'].$value['file_name'];
                        $filename = $value['original'];
            ?>
            <p>
                <img src="http://orfaphl6n.bkt.clouddn.com/courseware_icon.png?imageView2/3/w/32/h/32" alt="Download Course Manual">
                <a class="download" href="<?= $url ?>" target="_blank" title="<?= $filename ?>">
                    Download <?= $master['title'] ?> Course Manual
                </a>
            </p>
                <?php } ?>
            <?php } ?>
        </div>
        <p>
            <br/>
            Welcome to starter 1 online English Lessons for children - This is an absolute beginner course for ESL kids. It is a good place to start for kids who have little to zero English learning experience. It teaches basic English sentences, new words and grammar. The course is perfect for preschoolers and kindergartners. The following English lessons are covered:
            <br/><br/>
            <?= $master['body']; ?>
        </p>
    </div>
    
    <div class="box course_list">
        <ul>

        <?php
            if ($model) {
                foreach ($model as $key => $value) { 
                    if (!empty(getImgs($value->body))) {
                        $img = getImgs($value->body);
                    }
        ?>
                <li class="row">
                    <div class="col-xs-5 col-sm-3 col-md-2">
                        <?= Html::a(
                            '<img class="img-circle img-responsive" src="'.$img.'?imageView2/3/w/110/h/110" >',
                            [
                                'article/view',
                                'courseware_id' => $value->courseware_id
                            ]
                        ); ?>
                    </div>
                    <div class="course_title col-xs-7 col-sm-9 col-md-10">
                        <?= Html::a(
                            '<h1>'.$value->title.'</h1>',
                            [
                                'article/view',
                                'courseware_id' => $value->courseware_id
                            ]
                        ); ?>
                    </div>
                </li>
                <hr/>

            <?php } ?>
        <?php } ?>
            
        </ul>
    </div>

    <div class="text-center">
        <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>