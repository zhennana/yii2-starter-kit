    <div align="center">
    <div align="center">
         <div id = 'watermark'> <?php echo isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username  : Yii::$app->user->identity->phone_number ?></div>
        <video src="<?php echo $files?>" controls="controls" id="video1">
                        您的浏览器不支持 video 标签。
        </video>
       
    </div>
    </div>

    <script>
         var v = document.getElementById("video1");
         var watermark = document.getElementById("watermark");
       //  //var c = document.getElementById("myCanvas");
       // // ctx = c.getContext('2d');

       //  v.addEventListener('play', function() {
       //      var i = window.setInterval(function() {
       //      }, 20);
       //  }, false);
  

        /*各浏览器fullscreenchange 事件处理*/  
        v.addEventListener('fullscreenchange', function(){  
            //屏幕改变模式时，执行的代码  
            //退出全屏执行的代码  
            if(fullscreenElement()==""||fullscreenElement()==null){  
                //退出全屏或者全屏状态下点击ESC键时执行
                return false;
            }
        });
        v.addEventListener('webkitfullscreenchange', function(){  
            //屏幕改变模式时，执行的代码 
            //  color:  white;
            // position: absolute;
            // right:  25%;
            // top: 20px;
            //return false;
             watermark.style.color="white";
             watermark.style.position="absolute";
             watermark.style.right="25%";
             watermark.style.top="20px";
        });

        v.addEventListener('mozfullscreenchange', function(){  
            //屏幕改变模式时，执行的代码
            console.log(333);

        });

        v.addEventListener('MSFullscreenChange', function(){  
            //屏幕改变模式时，执行的代码
            console.log(55);
        }); 
        v.addEventListener('onmozfullscreenchange', function(){  
            //屏幕改变模式时，执行的代码
            console.log(6655);
        }); 
   
    </script>
    <style type="text/css">
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
            z-index:400;
            color:  white;
            position: absolute;
            right:  25%;
            top: 20px;
        }
    }
    </style>
