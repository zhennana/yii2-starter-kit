<?php
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
            <div class="col-md-3 course_box">
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title">Starter 1 Course</h4>
                    </div>
                    <div class="box-body">
                    <p>
                        <a href="#">
                            <img class="hmieff" src="https://S5KE86-a.akamaihd.net/thumbs/levelimg/Starter1.png" alt="English Starter 1">
                        </a>
                    This is the absolute beginner basic English course for ESL kids.
                    </p>
                    <a class="btn btn-default" href="https://www.fredisalearns.com/starter-1-english/">Browse Lessons</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
