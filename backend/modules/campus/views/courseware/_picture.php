<?php
    $userName = isset(Yii::$app->user->identity->realname) ? Yii::$app->user->identity->realname :Yii::$app->user->identity->phone_number;
   // $userName = "企业_超管";
   $userName = str_replace(['-','_',''],['/','',''],$userName);
  //var_dump($userName);exit;
  // $userName =  base64_encode($userName);
  // var_dump($userName);exit;
    $watermark = "?watermark/2/text/";
    $watermark .= base64_encode($userName)."/findsize/100/fill/";
    $watermark .= base64_encode('white').'/dissolve/80/gravity/SouthEast/dx/20/dy/20';
    $files .= $watermark; 
    //var_dump($files);
    $this->title = Yii::t('backend', '图片');
    //$this->params['breadcrumbs'][] = 
    $this->params['breadcrumbs'][] = $this->title;

   echo '<div align="center" id = "url">';
   echo  '<img style = "" class="img-thumbnail" src="'.$files.'?imageView2/1/w/100/h/100" />';
   echo "</div>";

?>
<script type="text/javascript">
  document.oncontextmenu=new Function("event.returnValue=false");
  document.onselectstart=new Function("event.returnValue=false");

</script>
  <style>
    #url{

      -moz-user-select: none; /*火狐*/
      -webkit-user-select: none; /*webkit浏览器*/
      -ms-user-select: none; /*IE10*/
      user-select: none;
      cursor: default; 
  } 
  </style>