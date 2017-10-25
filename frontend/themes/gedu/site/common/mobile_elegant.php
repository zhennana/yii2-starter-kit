<?php
use yii\helpers\Html;
$imgsize = '?imageView2/1/w/300/h/300';
?>
<div id="fh5co-main">
    <div class="row ">
        <?php foreach ($sights as $key => $value) {
            if ($key > 8) break;
        ?>
        <div class="col-md-3 col-sm-6 col-padding animate-box" >
            <div class="blog-entry">
                <a href="#" class="blog-img" align="center">
                    <img src="<?= getImgs($value['body'])[0].$imgsize; ?>" class="img-responsive" >
                </a>
                <div class="desc">
                    <h3><a href="#"><?= $value['title'] ?></a></h3>
                    
                    <p><?= strip_tags($value['body']) ?></p>
                    
                    <?php echo Html::a('了解更多',['site/sights','category_id'=>37],['class'=>'lead'])?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>