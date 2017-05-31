<?php foreach($dataProvider->getModels() as $key=>$value){
                                        
                                    ?>

                                    <?php }?>
                                        <div class="item active">
                                            <div class="newsBox-news">
                                                <p class="newsBox-news-p1">2016-08-09</p>
                                                <h3 class="newsBox-news-h3"><?php echo $value->title;?></h3>
                                                <img src="http://7xsm8j.com2.z0.glb.qiniucdn.com/main-4-line.png">
                                                <?php echo Html::a(
                                                    substr_auto(strip_tags($value->body),200),
                                                    ['article/view','id'=>$value->id],
                                                    ['class'=>'','data-method'=>'open',]);
                                                ?>
                                            </div>
                                        </div>