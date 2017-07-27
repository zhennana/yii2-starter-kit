<?php
    $url = Yii::getAlias('@backendUrl/js/player/');
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>视频播放</title>

<link rel="stylesheet" href="<?php echo $url ?>css/main.css">
<style type="text/css">
.demo{
    position: relative;
    width:95%;
    margin:50px auto 10px auto;
    padding:10px;
}
.watermark{
    font-size: 2em;
    position: absolute;
    z-index: 1000;
    top: 8%;
    left: 65%;
    -moz-opacity: 0.7;
    opacity: 0.7;
    color: #FFFFFF;
}
</style>

</head>

<body>
<div id="main">
    <div class="demo">
        <div class="watermark">
        <p><?php  echo isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username  : Yii::$app->user->identity->phone_number ?></p>
        </div>
        <div id="danmup" style="margin:20px auto"></div>
    </div>
</div>

<script src="<?php echo $url ?>js/jquery-2.1.4.min.js"></script>
<script src="<?php echo $url ?>js/jquery.shCircleLoader.js"></script>
<script src="<?php echo $url ?>js/jquery.danmu.js"></script>
<script src="<?php echo $url ?>js/main.js"></script>
<script>
$("#danmup").DanmuPlayer({
    // src: "http://static.v1.wakooedu.com/o_1blcqepq41hgq184o1hug1psd12fsh.mp4",
    src: "<?php echo $files ?>",
    height: "480px", //区域的高度
    width: "800px" //区域的宽度
  });

</script>


</body>
</html>
