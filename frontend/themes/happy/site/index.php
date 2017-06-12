<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::$app->name;
$box_color = [
    1 => 'box-success',
    2 => 'box-warning',
    3 => 'box-info',
    4 => 'box-danger',
];
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
            <?php foreach ($model as $key => $value) {
                if ($key > 8) {
                    break;
                }
                $images = [];
                $images[0] = 'http://orfaphl6n.bkt.clouddn.com/Starter1.png';
                if (isset($value['body']) && !empty($value['body'])) {
                    $images = getImgs($value['body']);
                }

                if(!empty($images)){
                    $image = $images[0].'?imageView2/3/w/140/h/140';
                }
            ?>

            <div class="col-md-3 col-sm-4 course_box">
                <div class="box <?php echo $box_color[rand(1,4)] ?> box-solid">

                    <div class="box-header with-border">
                        <h4 class="box-title"><?= substr_auto(strip_tags($value['title']),25) ?></h4>
                    </div>

                    <div class="box-body">
                        <?= Html::a(
                            '<img class="img-responsive center-block" src='.$image.'/><h4>'.'</h4>',
                            ['article/course','category_id'=>$value['id']]
                        ); ?>

                        <div>
                            <p>
                                <?php 
                                    if ($value['body']) {
                                        $course_category = substr_auto(strip_tags($value['body']),70);
                                    }else{
                                        $course_category = 'This is the absoulut beginner Engilsh course for young learners.';
                                    }
                                    echo Html::a($course_category
                                        ,[
                                            'article/course',
                                            'category_id' => $value['id']
                                        ],
                                        ['class' =>'intr']
                                    );
                                ?>
                            </p>
                            <?= Html::a('Begin Learning', [
                                'article/course',
                                'category_id'=>$value['id']
                            ],
                            ['class' =>'btn btn-sm btn_begin']
                            ); ?>
                        </div>

                    </div>
                    
                </div>
            </div>

            <?php } ?>

        </div>
    </div>

</div>
