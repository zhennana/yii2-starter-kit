<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="content clear-fix">
    <div id="news" class="col-sm-8">
        <h1>WAKOO NEWS</h1>
        <div class="news-list">
        <?php foreach ($model as $key => $value) {
            $imageUrl = getImgs($value->body);
            $imageUrl = $imageUrl[0] ? $imageUrl[0] : 'http://static.v1.wakooedu.com/top_logo.png';
        ?>
            <ul>
                <li v-for="item in newsList" class="clear-fix">
                    <a href="<?php echo Url::to(['article/view','id'=>$value->id]) ?>">
                        <img src="<?php echo $imageUrl; ?>?imageView2/3/w/400/h/400"  />
                        <div class="news-info">
                            <h3><?php echo $value->title ?></h3>
                            <span>
                                <?php
                                    $timeInfo = '';
                                    $timeInfo .= date('Y-m-d H:i:s', $value->published_at);
                                    $timeInfo .= ' 瓦酷创客空间';
                                    echo $timeInfo;
                                ?>
                            </span>
                            <p><?php echo substr_auto(strip_tags($value->body),200) ?></p>
                        </div>  
                    </a>
                </li>
            </ul>
        <?php } ?>
        </div>
        <div id="pager_u">
            <?= LinkPager::widget(['pagination' => $pages]); ?>
        </div>
    </div>
</div>

<script>
/*    var news = new Vue({
        el:'#news',
        data:{
            newsList:'',
            cur:1,
            totalPage:1,
            pageSize:5,//分页最多展示多少页可点击
            pageNum:5,
            // pages:[1,2,3,4,5],
        },
        created:function () {
        },
        mounted:function () {
            this.loadData();
        },
        methods:{
            loadData:function () {
                //加载数据
                var _that = this;
                $.ajax({
                    url: '<?php //echo Url::to(['article/get-news']) ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {pager: _that.cur-1,limit:_that.pageNum},
                })
                .done(function(responseData) {
                    
                    _that.newsList = responseData.data;
                    _that.totalPage = responseData.totalPage;
                    console.log(_that);
                    console.log("success");
                })
                .fail(function(e) {
                    console.log("error");
                     console.log(e);
                })
                .always(function() {
                    console.log("complete");
                });
                
            },
            pageClick:function(page){
                if(this.cur!=page){
                    this.cur = page;
                    this.loadData();
                }
                console.log(page);
            },
            preClick:function(){
                if(this.cur>1){
                    this.cur--;
                    this.loadData();
                }
                 console.log("preClick");
            },
            nextClick:function(){
                if(this.cur<this.totalPage){
                    this.cur++;
                    this.loadData();
                }
                 console.log("nextClick");
            },
            firstClick:function(){
                if(this.cur>1){
                    this.cur = 1;
                    this.loadData();
                }
                console.log("firstClick");
            },
            lastClick:function(){
                if(this.cur<this.totalPage){
                    this.cur = this.totalPage;
                    this.loadData();
                }
                console.log("lastClick");
            },

            
        },
        computed:{
            pages:function(){
                var factor = Math.floor(this.pageSize/2);
                var leftSize,rightSize;
                if(this.pageSize%2==0){
                    leftSize =factor;
                    rightSize = factor-1;
                }else{
                    leftSize  = factor; 
                    rightSize = factor;
                }
                var arr = [];
                var leftNumber = this.cur - 1;
                var rightNumber = this.totalPage - this.cur;
                var leftStart,rightEnd;
                if(leftNumber <= leftSize){
                    leftStart = 1;
                    if(this.totalPage<this.pageSize){
                       rightEnd = this.totalPage; 
                   }else{
                        rightEnd = this.pageSize;
                   }
                    
                }else{
                    
                    if(rightNumber<=rightSize){
                        rightEnd = this.totalPage;
                        leftStart = this.totalPage -this.pageSize + 1;
                    }else{
                        leftStart = this.cur - leftSize;
                        rightEnd = this.cur + rightSize;
                    }
                }
                console.log('leftStart：'+leftStart);
                console.log('rightEnd:'+rightEnd);
                for(var i = leftStart;i<=rightEnd;i++){
                    arr.push(i);
                }
                return arr;
            }
        }
    });

    // 课程体系页面 列表百分比适配  
    $(window).load(function(){
         var width = $(window).width();
         // var imgs = $('course-list').find('li').find('img');
         if(width<1000){
          
            $('#news ul li img').css('width','100%');
            $('#news ul li .news-info').css('width','100%');
            $('#news ul li .news-info').css('margin-top','10px');
         }else{
            $('#news ul li img').css('width','35%');
            $('#news ul li .news-info').css('width','60%');
            $('#news ul li .news-info').css('margin-top','');
         }
    });


    $(window).resize(function(){
         var width = $(window).width();
         // var imgs = $('course-list').find('li').find('img');
          if(width<1000){
            $('#news ul li img').css('width','100%');
            $('#news ul li .news-info').css('width','100%');
            $('#news ul li .news-info').css('margin-top','10px');
         }else{
            $('#news ul li img').css('width','35%');
            $('#news ul li .news-info').css('width','60%');
            $('#news ul li .news-info').css('margin-top','');
         }
    });

    /** 
     * 时间对象的格式化; 
       
    Date.prototype.format = function(format) {  
        /* 
         * eg:format="yyyy-MM-dd hh:mm:ss"; 
           
        var o = {  
            "M+" : this.getMonth() + 1, // month  
            "d+" : this.getDate(), // day  
            "h+" : this.getHours(), // hour  
            "m+" : this.getMinutes(), // minute  
            "s+" : this.getSeconds(), // second  
            "q+" : Math.floor((this.getMonth() + 3) / 3), // quarter  
            "S" : this.getMilliseconds()  
            // millisecond  
        }  
      
        if (/(y+)/.test(format)) {  
            format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4  
                            - RegExp.$1.length));  
        }  
      
        for (var k in o) {  
            if (new RegExp("(" + k + ")").test(format)) {  
                format = format.replace(RegExp.$1, RegExp.$1.length == 1  
                                ? o[k]  
                                : ("00" + o[k]).substr(("" + o[k]).length));  
            }  
        }  
        return format;  
    }*/
</script>