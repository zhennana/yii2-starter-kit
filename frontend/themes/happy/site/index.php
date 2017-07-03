<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
$this->title = Yii::$app->name;
$box_color = [
    1 => 'box-success',
    2 => 'box-warning',
    3 => 'box-info',
    4 => 'box-danger',
    5 => 'box-primary',
    6 => 'box-darkpink',
    7 => 'box-cornsilk',
];
$images =[
    1 => 'http://orkp7ug0b.bkt.clouddn.com/starter1.png?imageView2/3/w/140/h/140',
];
$image = 'http://orfaphl6n.bkt.clouddn.com/Starter1.png?imageView2/3/w/140/h/140';
?>
<div class="site-index">

    <?php echo \common\widgets\DbCarousel::widget([
        'key'=>'happy',
        'options' => [
            'class' => 'slide', // enables slide effect
        ],
    ]) ?>

    <div class="jumbotron">
        <div class="row">
            <?php
                foreach ($model as $key => $value) {
                    if ($key > 8) {
                        break;
                    }
                    if (isset($value->banner_src) && !empty($value->banner_src)) {
                        $image = $value->banner_src.'?imageView2/3/w/140/h/140';
                    }
            ?>

            <div class="col-md-3 col-sm-4 course_box">
                <div class="box <?php echo $box_color[rand(1,7)] ?> box-solid">

                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <?php if (isset($value['title']) && !empty($value['title'])) {
                            echo substr_auto(strip_tags($value['title']),25);
                        } ?>
                        </h4>
                    </div>

                    <div class="box-body">
                        <?php 
                        if (isset($value['courseware_id']) && !empty($value['courseware_id'])) {
                            echo Html::a(
                                '<img class="img-responsive center-block" src='.$image.'/><h4>'.'</h4>',
                                ['article/course','master_id'=>$value['courseware_id']]
                            );
                        }
                        ?>

                        <div>
                            <p>
                                <?php 
                                    if (isset($value['body']) && !empty($value['body'])) {
                                        $course_body = substr_auto(strip_tags($value['body']),70);
                                    }else{
                                        $course_body = 'This is the absolute beginner Engilsh course for young learners.';
                                    }

                                    if (isset($value['courseware_id']) && !empty($value['courseware_id'])) {
                                        echo Html::a($course_body,
                                            [
                                                'article/course',
                                                'master_id' => $value['courseware_id']
                                            ],
                                            ['class' =>'intr']
                                        );
                                    }
                                ?>
                            </p>

                            <?php
                            if (isset($value['courseware_id']) && !empty($value['courseware_id'])) {
                                echo Html::a('Begin Learning', [
                                    'article/course',
                                    'master_id'=>$value['courseware_id']
                                ],
                                ['class' =>'btn btn-sm btn_begin']
                                );
                            }
                            ?>
                        </div>

                    </div>
                    
                </div>
            </div>

            <?php } ?>

        </div>
    </div>

    <div class="text-center">
        <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>

</div>
