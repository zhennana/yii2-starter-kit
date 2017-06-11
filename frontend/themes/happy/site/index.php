<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <?php echo \common\widgets\DbCarousel::widget([
        'key'=>'index',
        'options' => [
            'class' => 'slide', // enables slide effect
        ],
    ]) ?>

    <div class="jumbotron">
        <div class="row">
            <?php foreach ($model['zuopin'] as $key => $value) { 
                $images = [];
                $images = getImgs($value['body']);
                if(!empty($images)){
                    $image = $images[0].'?imageView2/3/w/140/h/140';
                }
            ?>

            <div class="col-md-3 col-sm-4 course_box">
                <div class="box box-success box-solid">

                    <div class="box-header with-border">
                        <h4 class="box-title"><?= $value['title'] ?></h4>
                    </div>

                    <div class="box-body">
                        <?= Html::a(
                            '<img class="img-responsive center-block" src='.$image.'/><h4>'.'</h4>',
                            ['article/view','id'=>$value['id']]
                        ); ?>

                        <div>
                            <p>
                                <?= Html::a(
                                    substr_auto(strip_tags($value['body']),70),[
                                        'article/view',
                                        'id' => $value['id']
                                    ],
                                    ['class' =>'intr']
                                );?>
                            </p>
                            <a class="btn btn-sm btn-success" href="#">Begin Learning</a>
                        </div>

                    </div>
                    
                </div>
            </div>

            <?php } ?>

        </div>
    </div>

</div>
