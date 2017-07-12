    <div align="center">
    <div align="center">
         <div id = 'watermark'> <?php  echo isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username  : Yii::$app->user->identity->phone_number ?></div>
        <video src="<?php echo $files?>" controls="controls" id="video1">
                        您的浏览器不支持 video 标签。
        </video>
       
    </div>
    </div>

    <script>
         var v = document.getElementById("video1");

         var watermark = document.getElementById("watermark");
        /*各浏览器fullscreenchange 事件处理*/  
        v.addEventListener('fullscreenchange', function(){  
            //屏幕改变模式时，执行的代码  
            //退出全屏执行的代码  
            if(fullscreenElement()==""||fullscreenElement()==null){  
                //退出全屏或者全屏状态下点击ESC键时执行
                //return false;
            }
        });
        v.addEventListener('webkitfullscreenchange', function(){  
         
        });

        v.addEventListener('mozfullscreenchange', function(){  
            //屏幕改变模式时，执行的代码
           
        });

        v.addEventListener('MSFullscreenChange', function(){  
            //屏幕改变模式时，执行的代码
            
        }); 
        v.addEventListener('onmozfullscreenchange', function(){  
            //屏幕改变模式时，执行的代码
           
        }); 
    $('#video1').bind('contextmenu',function() { return false; }); 
    </script>
    <style type="text/css">
     /*   video:-webkit-full-screen {  
            position: fixed; 
        }  */
        video::-internal-media-controls-download-button {
            display:none;
        }
        video::-webkit-media-controls-enclosure {
            overflow:hidden;
        }
        video::-webkit-media-controls-panel {
            width: calc(100% + 30px);
        }
        #watermark{
            z-index:133333;
            color:  red;
            position: absolute;
            right:  50%;
            top: 20px;
        }
    }
   
    </style>

<!--  /*
<div id="box">
    <input type="button" value="放大">
    <input type="button" value="缩小">
    <input type="button" value="播放">
    <input type="button" value="音量+">
    <input type="button" value="音量-">
    <input type="button" value="静音">
    <input type="button" value="快进">
    <input type="button" value="快退">


</div>
<video  id="v1"  poster="dbg.jpg" width="500" height="300">
    <source src="<?php //echo $files ?>" >
    <source src="1.ogg" >
</video>
<div id="bar">
    <div id="slider"></div>
</div>


    <style>

        #bar{
            width: 600px;
            height: 30px;
            background: #ccc;
            position: relative;
        }
        #bar #slider{
            width: 0%;
            position: absolute;
            left: 0;
            top: 0;
            background: red;
            height: 30px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            var aBtn = document.querySelectorAll('#box input');
            var oV = document.getElementById('v1');
            var oS = document.getElementById('slider');
            //放大
            aBtn[0].onclick = function () {
                oV.style.position = 'fixed';
                oV.width = window.screen.width;
                oV.height = window.screen.height;
            };
            //缩小
            aBtn[1].onclick = function () {
                oV.width = 300;
                oV.height = 200;
            };
            //播放
            aBtn[2].onclick = function () {
                if(oV.paused){
                    this.value = '暂停';
                    oV.play();
                }else{
                    oV.pause();
                    this.value = '播放';

                }
            };
            //音量加
            aBtn[3].onclick = function () {
                oV.volume+=0.1;
            };
            //音量减小
            aBtn[4].onclick = function () {
                oV.volume-=0.1;
            };
            //静音
            var bSign = true;
            aBtn[5].onclick = function () {
                if(bSign){
                    oV.muted = true;
                    this.value = '正常';
                }else{
                    oV.muted = false;
                    this.value = '静音';
                }
                bSign = !bSign;
            };

            //快进
            aBtn[6].onclick = function () {
                oV.currentTime++;
            };
            //快退
            aBtn[7].onclick = function () {
                oV.currentTime--;
            };
            //进度
            oV.ontimeupdate = function(){
                oS.style.width = oV.currentTime/oV.duration*100+'%';
            };
            
            oV.onended = function(){
                alert('啥也不说了，交钱吧');
            };
            
        },false);
    </script>*/ -->
<?php
    //echo $files;
?>