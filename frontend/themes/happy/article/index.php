<?php
/* @var $this yii\web\View */
$this->title = Yii::t('frontend', 'Articles')
?>
<div id="article-index">
    <div class="course_info">
        <p>Welcome to starter 1 online English Lessons for children - This is an absolute beginner course for ESL kids. It is a good place to start for kids who have little to zero English learning experience. It teaches basic English sentences, new words and grammar. The course is perfect for preschoolers and kindergartners. The following English lessons are covered:</p>
    </div>
    
    <div class="box course_list">
        <ul>
            <li class="row">
                <div class="col-xs-3 col-sm-3 col-md-2">
                    <a href="<?php echo Yii::getAlias('@frontendUrl') ?>/article/view?id=1">
                        <img class="img-responsive" src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/fredisalearns_index_03.png">
                    </a>
                </div>
                <div class="course_title col-xs-9 col-sm-9 col-md-10">
                    <a href="<?php echo Yii::getAlias('@frontendUrl') ?>/article/view?id=1">
                        <h1>Unit 1 - Classroom Commands</h1>
                    </a>
                </div>
            </li>

            <li class="row">
                <div class="col-xs-3 col-sm-3 col-md-2">
                    <a href="<?php echo Yii::getAlias('@frontendUrl') ?>/article/view?id=1">
                        <img class="img-responsive" src="<?php echo Yii::getAlias('@frontendUrl') ?>/img/fredisalearns_index_03.png">
                    </a>
                </div>
                <div class="course_title col-xs-9 col-sm-9 col-md-10">
                    <a href="<?php echo Yii::getAlias('@frontendUrl') ?>/article/view?id=1">
                        <h1>Unit 1 - Classroom Commands</h1>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>