<?php
use yii\helpers\Html; 
$imgsize = '?imageView2/1/w/300/h/300';
?>

<div class="main-3-school">
    <div class="banner-bottom-left-grids full-length campus-top">
        <?php foreach ($sights as $key => $value) {
            if ($key > 3) break;
        ?>
        <li class="banner-bottom-left-grid iusto">
            <div class="port-4 effect-1">
                <div style="overflow:hidden;">
                  <img src="<?= getImgs($value['body'])[0].$imgsize; ?>" alt=" " class="img-responsive" />
                </div>
                <div class="text-desc">
                    <h3 class="img-introduct"><?= $value['title'] ?></h3>
                    <p><?= strip_tags($value['body']) ?></p>
                    <?php echo Html::a('了解更多',['site/sights','category_id'=>37],['class'=>'btn'])?>
                </div>
            </div>
        </li>
        <?php } ?>
        <div class="clearfix"></div>
    </div>
    <div class="banner-bottom-left-grids full-length campus-bottom">
        <?php foreach ($sights as $key => $value) {
            if ($key <= 3) continue;
        ?>
        <li class="banner-bottom-left-grid iusto">
            <div class="port-4 effect-1">
               <div style="overflow:hidden">
                   <img src="<?= getImgs($value['body'])[0].$imgsize; ?>" alt=" " class="img-responsive" />
                </div>
                <div class="text-desc">
                    <h3 class="img-introduct"><?= $value['title'] ?></h3>
                    <p><?= strip_tags($value['body']) ?></p>
                    <?php echo Html::a('了解更多',['site/sights','category_id'=>37],['class'=>'btn'])?>
                </div>
            </div>
        </li>
        <?php } ?>
        
        <div class="clearfix"></div>
    </div>
</div> 
      
