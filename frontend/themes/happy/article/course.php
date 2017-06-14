<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
$this->title = $category->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="article-index">
    <div class="course_info">
        <p>Welcome to starter 1 online English Lessons for children - This is an absolute beginner course for ESL kids. It is a good place to start for kids who have little to zero English learning experience. It teaches basic English sentences, new words and grammar. The course is perfect for preschoolers and kindergartners. The following English lessons are covered:</p>
    </div>
    
    <div class="box course_list">
        <ul>

        <?php
            $img = Yii::getAlias('@frontendUrl').'/img/fredisalearns_index_03.png';
            foreach ($model as $key => $value) {
        ?>
            <li class="row">
                <div class="col-xs-3 col-sm-3 col-md-2">
                    <?= Html::a(
                        '<img class="img-responsive" src='.$img.'>',
                        [
                            'article/view',
                            'id' => $value->id
                        ]
                    ); ?>
                </div>
                <div class="course_title col-xs-9 col-sm-9 col-md-10">
                    <?= Html::a(
                        '<h1>'.$value->title.' - '.$value->slug.'</h1>',
                        [
                            'article/view',
                            'id' => $value->id
                        ]
                    ); ?>
                </div>
            </li>
            <hr/>
        <?php } ?>
            
        </ul>
    </div>

    <div class="text-center">
        <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>