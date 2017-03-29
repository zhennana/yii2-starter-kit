<?php
    use yii\helpers\Url;
?>

<script src="https://unpkg.com/vue@2.2.6/dist/vue.min.js" type="text/javascript"></script>
<div class="content clear-fix">
    <div id="news" class="col-sm-8">
        <h1>WAKOO NEWS</h1>
        <div class="news-list">
            <ul>
                <li v-for="item in newsList" class="clear-fix">
                    <a :href="item.url">
                        <img v-bind:src="item.image"  />
                        <div class="news-info">
                            <h3>{{item.title}}</h3>
                            <span>{{ new Date( item.published_at * 1000).format('yyyy-MM-dd')}}     瓦酷机器人</span>
                            <p>{{ item.body }}</p>
                        </div>  
                    </a>
                </li>
            </ul>
        </div>
        <div id="pager_u">
            <ul class="pagination">
                <li class="first" v-bind:class="{ 'disabled' : cur==1 }"><span v-on:click="firstClick" >首页</span></li>
                <li v-bind:class="{ 'disabled' : cur==1 }"><span v-on:click="preClick">&laquo;</span></li>
                <li v-for="page in pages" v-bind:class="{ 'active' : cur == page }">
                    <span v-on:click="pageClick(page)">{{page}}</span>
                </li>
                <li v-bind:class="{ 'disabled' : cur==totalPage }"><span v-on:click="nextClick">&raquo;</span></li>
                <li class="end" v-bind:class="{ 'disabled' : cur==totalPage }"><span v-on:click="lastClick"  >尾页</span></li>
            </ul>
        </div>
    </div>
</div>

<script>
    var news = new Vue({
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
                    url: '<?php echo Url::to(['article/get-news']) ?>',
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
     */  
    Date.prototype.format = function(format) {  
        /* 
         * eg:format="yyyy-MM-dd hh:mm:ss"; 
         */  
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
    }
</script>