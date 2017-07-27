<!-- /.box-header -->
<?php
/*
<!-- 
兼容浏览器定义为数组，不在其范围提示警示框

后台支持范围: https://github.com/almasaeed2010/AdminLTE 
IE 9+
Firefox (latest)
Chrome (latest)
Safari (latest)
Opera (latest)

bootstrap Browser and device support 前台支持范围	http://getbootstrap.com/getting-started/
IE 8-11
Firefox (latest)
Chrome (latest)
Safari (latest)
Opera (latest)
-->
*/
?>
<div class="box-body" id="tip-compatible" style="padding:0;display:none">
  <div class="alert alert-danger alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4><i class="fa fa-warning"></i>  敬告!</h4>
	<i class="icon fa fa-ban"></i>本站只对IE8/9提供有限兼容。为了解决安全隐患、获得更好的体验，请使用
	<a title="安全下载Chrome" href="http://www.haosou.com/s?ie=utf-8&q=chrome" target="_blacnk" >Chrome</a>、
	<a title="安全下载Firefox" href="http://www.haosou.com/s?ie=utf-8&q=Firefox" target="_blacnk" >Firefox</a> 或
	<a title="安全下载360浏览器" href="http://www.haosou.com/s?ie=utf-8&q=360浏览器" target="_blacnk" >360浏览器（极速模式）</a>、
	<a href="http://www.haosou.com/s?ie=utf-8&q=IE9+" target="_blacnk" >IE9+</a>。
  </div>
</div>
<script type="text/javascript">
var browser=navigator.appName;
var b_version=navigator.appVersion;

var version=b_version.split(";");
var trim_Version;
//console.log(b_version,version);
if(typeof version[1] != 'undefined'){
	trim_Version=version[1].replace(/[ ]/g,"");
}
var tipCompatible=document.getElementById('tip-compatible');
if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE6.0" || trim_Version=="MSIE7.0" || trim_Version=="MSIE8.0" || trim_Version=="MSIE9.0"){
	tipCompatible.style.display="block";
	setTimeout(function(){tipCompatible.style.display="none";},30*1000)
}
</script>
<!-- /.box-body -->