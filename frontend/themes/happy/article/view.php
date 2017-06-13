<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = 'Unit 1 - Classroom Commands';
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
            <h1><?= $model->title.' - '.$model->slug ?></h1>
        </div>
    </div>

        <?php if ($model->thumbnail_path): ?>
            <?php echo \yii\helpers\Html::img(
                Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => $model->thumbnail_path,
                    'w' => 200
                ], true),
                ['class' => 'article-thumb img-rounded pull-left']
            ) ?>
        <?php endif; ?>

        <?php echo $model->body ?>

        <?php if (!empty($model->articleAttachments)): ?>
            <h3><?php echo Yii::t('frontend', 'Attachments') ?></h3>
            <ul id="article-attachments">
                <?php foreach ($model->articleAttachments as $attachment): ?>
                    <li>
                        <?php echo \yii\helpers\Html::a(
                            $attachment->name,
                            ['attachment-download', 'id' => $attachment->id])
                        ?>
                        (<?php echo Yii::$app->formatter->asSize($attachment->size) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </article>
<!--
    <div class="course_title">
        <div class="col-xs-3 col-sm-3 col-md-2">
            <img class="img-responsive" src="<?php //echo Yii::getAlias('@frontendUrl') ?>/img/fredisalearns_index_03.png">
        </div>
        <div class="col-xs-9 col-sm-9 col-md-10">
            <h1>Unit 1: Classroom Commands</h1>
        </div>
    </div>

    <div class="container videoBox">
        <video width="100%" height="100%" id="yjzxVideo" controls >
            <source src="http://oqwgb2sml.bkt.clouddn.com/Level%201%20Watch%20the%20Dialogue%20Video%20-%20Birthday%20-%20How%20old.mp4?attname=&e=1497250285&token=N_Co-3Awz-PyQcmaFGVQgeVJwCDvVGnm_6f9nK4m:Rvgg_78KVwugIkGplkrr76wnBLA">
            您的浏览器不支持该视频播放
        </video>
        <div class="videoBg">
            <div class="videoBtn">
            </div>
        </div>
    </div>
-->
</div>



