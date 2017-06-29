<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

?>
<div class="gdu-content">
  <div class="">
   
    <!-- 文章内容部分 -->
    <div class="col-md-12 ">
    <div class="box box-widget geu-content">
            <div class="box-header with-border" >
              <ol class="breadcrumb">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <li class="activeli">联系我们</li>
              </ol>
            </div>
            <div class="box-body contacborder">
                <div class="with-borderleft"><a href="#" style="margin-left: 10px;">联系方式</a></div> 
                <div class="with-bordersm" ></div>  
              <p>学校地址：河北省三河市燕郊开发区燕灵路236号（三河二中西门路北）
               <p>邮编：065201</p>
               <p>电话：     办公室：      0316-5997070   转6009</p>
               <p> 小学部办公室                 转6003</p>
               <p>中学部办公室                 转6013</p>
               <p>国际部办公室                 转2599</p>
               <p>招生办公室                     转6688</p>
               <p>董老师:13363653072, 杨老师:18034265209,马老师:18103165099
                </p>

               <p>招生咨询时间：（周一至周日8:00-20:00）</p>
               <p>网址：<a href="http://www.guangdaxuexiao.com/">www.guangdaxuexiao.com</a></p>
                </p>
            </div>
      </div>
    </div>
    <div class="col-md-12 ">
        <div class="box box-widget geu-content" >
        <div class="box-header contacborder" >
                <div class="with-borderleft"><a href="#" style="margin-left: 10px;">光大学校地图</a></div> 
                <div class="with-bordersm" ></div>  
        </div>
        <div id="wrap" class="my-map">
            <div id="mapContainer"></div>
        </div>
        </div>
    </div>
  </div>

</div>

<script src="//webapi.amap.com/maps?v=1.3&key=8325164e247e15eea68b59e89200988b"></script>
<script>
    !function(){
        var infoWindow, map, level = 14,
            center = {lng: 116.808186, lat: 39.950858},
            features = [{type: "Marker", name: "光大学校", desc: "河北省三河市燕郊开发区燕灵路236号（三河二中西门路北）", color: "red", icon: "cir", offset: {x: -9, y: -31}, lnglat: {lng: 116.802006, lat: 39.940791}}];

        function loadFeatures(){
            for(var feature, data, i = 0, len = features.length, j, jl, path; i < len; i++){
                data = features[i];
                switch(data.type){
                    case "Marker":
                        feature = new AMap.Marker({ map: map, position: new AMap.LngLat(data.lnglat.lng, data.lnglat.lat),
                            zIndex: 3, extData: data, offset: new AMap.Pixel(data.offset.x, data.offset.y), title: data.name,
                            content: '<div class="icon icon-' + data.icon + ' icon-'+ data.icon +'-' + data.color +'"></div>' });
                        break;
                    case "Polyline":
                        for(j = 0, jl = data.lnglat.length, path = []; j < jl; j++){
                            path.push(new AMap.LngLat(data.lnglat[j].lng, data.lnglat[j].lat));
                        }
                        feature = new AMap.Polyline({ map: map, path: path, extData: data, zIndex: 2,
                            strokeWeight: data.strokeWeight, strokeColor: data.strokeColor, strokeOpacity: data.strokeOpacity });
                        break;
                    case "Polygon":
                        for(j = 0, jl = data.lnglat.length, path = []; j < jl; j++){
                            path.push(new AMap.LngLat(data.lnglat[j].lng, data.lnglat[j].lat));
                        }
                        feature = new AMap.Polygon({ map: map, path: path, extData: data, zIndex: 1,
                            strokeWeight: data.strokeWeight, strokeColor: data.strokeColor, strokeOpacity: data.strokeOpacity,
                            fillColor: data.fillColor, fillOpacity: data.fillOpacity });
                        break;
                    default: feature = null;
                }
                if(feature){ AMap.event.addListener(feature, "click", mapFeatureClick); }
            }
        }

        function mapFeatureClick(e){
            if(!infoWindow){ infoWindow = new AMap.InfoWindow({autoMove: true}); }
            var extData = e.target.getExtData();
            infoWindow.setContent("<h5>" + extData.name + "</h5><div>" + extData.desc + "</div>");
            infoWindow.open(map, e.lnglat);
        }

        map = new AMap.Map("mapContainer", {center: new AMap.LngLat(center.lng, center.lat), level: level});
        
        loadFeatures();

        map.on('complete', function(){
            map.plugin(["AMap.ToolBar", "AMap.OverView", "AMap.Scale"], function(){
                map.addControl(new AMap.ToolBar);
            map.addControl(new AMap.OverView({isOpen: true}));
            map.addControl(new AMap.Scale);
            }); 
        })
        
    }();
    </script>