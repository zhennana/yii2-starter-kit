<?php
use yii\helpers\Html;
?>
<style>
  .wrap > .container{
    padding:0 0 40px;
  }
   .main-6{
//      margin-left: 18%;
//      margin-right:17.5%;
      position: relative;
      margin-top: 35px; 
      margin-bottom: 35px;
     }
  .left1 { 
     border-color: gray;
     width: 20%; 
     float: left;
     text-align: center;
     font-weight: bold;
     }
     .box{
      border: 1px solid #ddd;
      width:98%;
      padding:10% 5% 20% 5%;
      text-align: center;
      font-size: 18px;
     }
     
     .main-7{
      text-align: center;
      margin-bottom: 35px;
     } 
     .main-8{
      position: relative;
      text-align: center; 
     }
     
     .main-10{
     position: relative;
      margin-top: 35px;
     }

     .img-bg{
        position: relative;
     }
      .ask-que1{
        position:absolute;
        top:32%;
        height:20px;
        line-height:20px;
    }
      .ask-que2{
        position:absolute;
        top:49%;
        height:20px;
        line-height:20px;
    }
      .ask-que3{
        position:absolute;
        top:65%;
        height:20px;
        line-height:20px;
    }
     .row{
//      padding-left: 18.5%;
//      padding-right: 18.5%;
      margin-top: 6px;
     }
     .font1{
      float:right;
      margin-top: 7px;
      margin-right: 10px;
      font-size: 15px;
      color:white;
     }
     .font2{
      text-align: center;
      margin-top: 7px;
      font-size: 15px;
     }
     .font3{
      float:left;
      margin-top: 7px;
      margin-left: 10px;
      font-size: 15px;
      color:white;
     }
     .text{
      color: red;
      margin-top:  26%;
      margin-left: -20px;
      top:0%;
      left:73%;
     }
     .text11{
      color: red;
      position: absolute;
      top:0%;
      left:72.3%;
     }
     .text12{
      color: red;
      position: absolute;
      top:33%;
      right:2%;
      height:20px;
      width:80px;
      display: -webkit-box;  
      display: -moz-box;  
      overflow: hidden;  
      text-overflow: ellipsis;  
      word-break: break-all;  
      -webkit-box-orient: vertical;  
      -webkit-line-clamp:3;
     }
      .text13{
      color: red;
      position: absolute;
      top:49%;
      left:43%;
      height:20px;
      width:80px;
      display: -webkit-box;  
      display: -moz-box;  
      overflow: hidden;  
      text-overflow: ellipsis;  
      word-break: break-all;  
      -webkit-box-orient: vertical;  
      -webkit-line-clamp:3;
     }
     .text14{
      color: red;
      position: absolute;
      top:65%;
      left:43%;
      height:20px;
      width:80px;
      display: -webkit-box;  
      display: -moz-box;  
      overflow: hidden;  
      text-overflow: ellipsis;  
      word-break: break-all;  
      -webkit-box-orient: vertical;  
      -webkit-line-clamp:3;
     } 
     .text15{
      color: red;
      position: absolute;
      top:33%;
      right:2%;
      height:20px;
      width:80px;
      display: -webkit-box;  
      display: -moz-box;  
      overflow: hidden;  
      text-overflow: ellipsis;  
      word-break: break-all;  
      -webkit-box-orient: vertical;  
      -webkit-line-clamp:3;
     }
     .text16{
      color: red;
      position: absolute;
      top:49%;
      left:73%;
      height:20px;
      width:80px;
      display: -webkit-box;  
      display: -moz-box;  
      overflow: hidden;  
      text-overflow: ellipsis;  
      word-break: break-all;  
      -webkit-box-orient: vertical;  
      -webkit-line-clamp:3;
     }
     .text17{
      color: red;
      position: absolute;
      top:65%;
      left:73%;
      height:20px;
      width:80px;
      display: -webkit-box;  
      display: -moz-box;  
      overflow: hidden;  
      text-overflow: ellipsis;  
      word-break: break-all;  
      -webkit-box-orient: vertical;  
      -webkit-line-clamp:3;
     }
   .text9{
       font-size: 14px;
       position: absolute;  
       top: 33%;
       left: 12%;
       bottom:47%;
       right:49%; 
       width: 350px;
       height:20px;
       margin-left: 0%;
       display: -webkit-box;  
       display: -moz-box;  
       overflow: hidden;  
       text-overflow: ellipsis;  
       word-break: break-all;  
       -webkit-box-orient: vertical;  
       -webkit-line-clamp:3;
     }
     .text2{
       font-size: 14px;
       position: absolute;  
       top: 49%;
       left: 24%;
       width: 17%;
       height:20px;
       display: -webkit-box;  
       display: -moz-box;  
       overflow: hidden;  
       text-overflow: ellipsis;  
       word-break: break-all;  
       -webkit-box-orient: vertical;  
       -webkit-line-clamp:3;
     }
     .text3{
       font-size: 14px;
       position: absolute;  
       top: 65%;
       left: 24%;
       width: 19%;
       height:20px;
       display: -webkit-box;  
       display: -moz-box;  
       overflow: hidden;  
       text-overflow: ellipsis;  
       word-break: break-all;  
       -webkit-box-orient: vertical;  
       -webkit-line-clamp:3;
     }
     .text4{
       font-size: 14px;
       position: absolute;  
       top: 33%;
       left: 14%;
       width: 310px;
       height:20px;
       display: -webkit-box;  
       display: -moz-box;  
       overflow: hidden;  
       text-overflow: ellipsis;  
       word-break: break-all;  
       -webkit-box-orient: vertical;  
       -webkit-line-clamp:3;
     }
     .text5{
       font-size: 14px;
       position: absolute;  
       top: 49%;
       left: 54.4%;
       width: 19%;
       height:20px;
       display: -webkit-box;  
       display: -moz-box;  
       overflow: hidden;  
       text-overflow: ellipsis;  
       word-break: break-all;  
       -webkit-box-orient: vertical;  
       -webkit-line-clamp:3;
     }
     .text6{
       font-size: 14px;
       position: absolute;  
       top: 65%;
       left: 54.4%;
       width: 17%;
       height:20px;
       display: -webkit-box;  
       display: -moz-box;  
       overflow: hidden;  
       text-overflow: ellipsis;  
       word-break: break-all;  
       -webkit-box-orient: vertical;  
       -webkit-line-clamp:3;
     }
     .text7{
       font-size: 23px;
       position: absolute;
       color:white;  
       top: 82%;
       left: 43.5%;
       width: 17%;
       height:28px;
       display: -webkit-box;  
       display: -moz-box;  
       overflow: hidden;  
       text-overflow: ellipsis;  
       word-break: break-all;  
       -webkit-box-orient: vertical;  
       -webkit-line-clamp:3;
     }
     .text8{
       font-size: 20px;
       position: absolute;  
       top: 28%;
       left: 12%;
       width: 45%;
       height:50%;
       text-indent:2rem;
     }     
     .button{
      display:inline-block;
//      background-color:#FFED97 ;
      cursor:pointer;
      width: 100%;
      height:20px;
      line-height:20px;
     }
    .container-fluid{
        width:1000px;
        margin:0 auto;
    }
    .c-left{
        background:#00caca;
        height:40px;
        line-height:40px;
        padding:0;
    }
    .c-right{
        background:#EAC100;
        height:40px;
        line-height:40px;
        padding:0;
    }
    .c-center{
        background:#fff;
        height:40px;
        line-height:40px;
        padding:0;
    }
    .modal-content{
        border-radius:8px;
        background-color:#eeeaef;
    }
       @media screen and (max-width:600px)  {
         html,body,button,input,select,textarea,text,p{  
         font-size:10px         
       }
       }
       @media screen and (max-width:1000px)  {
        .main-6{  
         margin-left: 0px;
         width:100%;
       }
        .container-fluid{
                width:100%;
                margin:0 auto;
            }
       }
        @media screen and (max-width:800px)  {  
        .row{  
         padding-left: 0;
         padding-right: 0;
       }
       .text7{
        font-size:14px;
       }
       .text8{
               top:22%;
               left:5%;
               font-size:10px;
               width:65%;
              }
       }
       @media screen and (max-width:500px) {
        .box{
            font-size:12px;
            width:95%;
            color:#333;
            font-weight:normal;
        }
        .font3{
            font-size:12px;
            text-align:left;
            margin:0;
        }
        .font1{
            font-size:12px;
            text-align:right;
            margin:0;
        }
        .font2{
            font-size:12px;
            margin:0;
        }
       }
        @media screen and (min-width:768px) {
        .modal-dialog{
        margin:200px auto;
        }
        }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
  <style type="text/css">  
 </style>
 <div>              
         <img src="http://otdndy0jt.bkt.clouddn.com/banne1.png" class="img-responsive" >
       
   
     <div class="main">
     
        <div class="main-6">
            <div class="container-fluid"> 
              <h2>名扬全球的德国教育</h2>              
                 <div class="left1">                    
                     <div class="box">
                        <div class="img1">
                           <img src="http://otdndy0jt.bkt.clouddn.com/chip.png" width="80%">
                           
                        </div>                   
                          <p>世界范围内<br>发放奖学金</p>
                     </div>
                 </div>
                    
                 <div class="left1">
                     <div class="box">
                        <div class="img1">
                            <img src="http://otdndy0jt.bkt.clouddn.com/money-bag.png" width="80%">
                            
                        </div>
                        <p>教育经费是<br>国防部的3倍</p>
                     </div>
                 </div>
                 
                 <div class="left1">
                     <div class="box">
                           <div class="img1">
                               <img src="http://otdndy0jt.bkt.clouddn.com/bank.png" width="80%">
                               
                             </div>
                          <p>德国大学<br>学费全免</p> 
                     </div>
                 </div>
             
                 <div class="left1">
                     <div class="box">
                         <div class="img1"> 
                              <img src="http://otdndy0jt.bkt.clouddn.com/friends-list.png" width="80%"> 
                              
                         </div>
                         <p>教育界<br>人才荟萃</p> 
                     </div>
                 </div>
             
                 <div class="left1">
                      <div class="box">
                          <div class="img1">
                              <img src="http://otdndy0jt.bkt.clouddn.com/chuizi.png" width="80%"> 
                                 
                          </div>
                          <p>设施发达<br>气氛浓郁</p>
                      </div>
                 </div>              
            </div>
        </div>
        <div class="main-6">
         <div class="container-fluid"> 
            <img src="http://otdndy0jt.bkt.clouddn.com/youshi1.png"  width="100%">
            <img src="http://otdndy0jt.bkt.clouddn.com/youshi2.png"  width="100%">
            <img src="http://otdndy0jt.bkt.clouddn.com/youshi3.png"  width="100%">
         </div>
        </div>
        <div class="main-8">
          <div class="container-fluid">
            <div class="row">
                <div class="col-xs-5 col-md-5 c-left"><div class="font1">公立：0欧元</div></div>
                <div class="col-xs-2 col-md-2 c-center"><div class="font2">本科段学费</div></div>
                <div class="col-xs-5 col-md-5 c-right"><div class="font3">平均最低2万美金</div></div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 c-left" ><div class="font1">3年</div></div>
                <div class="col-xs-2 col-md-2 c-center" ><div class="font2">本科学制</div></div>
                <div class="col-xs-5 col-md-5 c-right" ><div class="font3">3至4年</div></div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 c-left" ><div class="font1">8万人民币/每学年</div></div>
                <div class="col-xs-2 col-md-2 c-center" ><div class="font2">生活费（含住宿）</div></div>
                <div class="col-xs-5 col-md-5 c-right" ><p class="font3">平均最低20万人民币/每学年</p></div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 c-left" ><div class="font1">0欧元/0人民币</div></div>
                <div class="col-xs-2 col-md-2 c-center" ><div class="font2">本科阶段学费</div></div>
                <div class="col-xs-5 col-md-5 c-right" ><div class="font3">6至8万美金/40~54万人民币</div></div>
            </div>
            <div class="row">
                <div class="col-xs-5 col-md-5 c-left" ><div class="font1">24万人民币</div></div>
                <div class="col-xs-2 col-md-2 c-center" ><div class="font2">总花费</div></div>
                <div class="col-xs-5 col-md-5 c-right" ><div class="font3">100~134万人民币</div></div>
            </div>
          </div>
        </div>  
       <div class="main-10">
           <div class="container-fluid">
              <div class="row col-xs-12" style="padding:0;">
                  <img src="http://otdndy0jt.bkt.clouddn.com/tianchuang.png" width="100%" height="auto" class="img-responsive img-bg" alt="Responsive image">

                 <div class="ask-que1 col-xs-12">
                     <div class="col-xs-6" style="position:relative">
                        <div class="text9"> 德国热门专业有哪些？</div>
                        <div class="text12"><a class="button"  data-toggle="modal" data-target="#myModal">详情解答>></a></div>
                     </div>
                     <div class="col-xs-6" style="position:relative">
                        <div class="text4">德国名校如何申请？ </div>
                        <div class="text15"><a class="button"  data-toggle="modal" data-target="#myModa2">详情解答>></a></div>
                     </div>
                 </div>

                 <div class="ask-que2 col-xs-12">
                    <div class="col-xs-6" style="position:relative">
                        <div class="text9"> 去德国留学有什么条件？</div>
                        <div class="text12"><a class="button"  data-toggle="modal" data-target="#myModa3">详情解答>></a></div>
                    </div>
                    <div class="col-xs-6" style="position:relative">
                        <div class="text4">为什么去德国留学读本科预备课程是必不可少的？</div>
                        <div class="text15"><a class="button"  data-toggle="modal" data-target="#myModa4">详情解答>></a></div>
                    </div>
                 </div>

                 <div class="ask-que3 col-xs-12">
                    <div class="col-xs-6" style="position:relative">
                        <div class="text9">去德国留学的费用（学杂费、生活费）有多少？</div>
                        <div class="text12"><a class="button"  data-toggle="modal" data-target="#myModa5">详情解答>></a></div>
                    </div>
                    <div class="col-xs-6" style="position:relative">
                        <div class="text4"> 为什么选择在光大读预备课程？ </div>
                        <div class="text15"><a class="button"  data-toggle="modal" data-target="#myModa6">详情解答>></a></div>
                    </div>
                 </div>



                    
                    <div class="text7"><?php echo  Html::a("更多问题资讯",["site/apply-to-play"])?></div>
                
                  </div>
              </div>
           </div>
        </div>
      
       <div class="main-10">
           <div class="container-fluid">
              <div class="row" style="position:relative;">
                  <img src="http://otdndy0jt.bkt.clouddn.com/yuke.png" width="100%" height="auto" class="img-responsive" alt="Responsive image">
                    <p class="text8">
                      由于德国基础教育体制是13年制，与我国12年制基础教育体系不同，因此中国大陆地区高中毕业生进入德国高校
                             攻读本科之前，必须完成德语登记考核和德国针对非欧洲生源设计的本科预备课程，通过相应测评考核后即可进入德国高校攻读本科课程，同时可享与欧洲生源同等的留学政策待遇。
                    </p>
              </div>
           </div>
        </div>
 </div>
 </div>
<!--模态框1-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					德国热门专业有哪些？
				</h4>
			</div>
			<div class="modal-body">
				1、经济师 <br>  2、工程技术<br>    3、法学<br>    4、医学 <br>  5、经济信息<br>    6、信息工程 <br>   7、自然科学 <br>    8、企业经济
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!--模态框2-->
<div class="modal fade" id="myModa2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					德国名校如何申请？
				</h4>
			</div>
			<div class="modal-body">
				1、申请一个德国长期留学签证;<br>
				2、所有计划在德国学习超过3个月的学生，都必须在申请签证前参加留德人员审核部APS的 一项认证程序;<br>
				3、德国留学的经济来源证明，大多数的中国学生都会在德国的银行开立一个限制提款账户,作为有足够经济来源的证明，并在申请签证时递交。账户上必须至少存入8640欧元;
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!--模态框3-->
<div class="modal fade" id="myModa3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					去德国留学有什么条件？
				</h4>
			</div>
			<div class="modal-body">
				1、德国大学为学生提供众多国际化的学习项目，并且在大多数联邦州的公立大学攻读第一个学位都免学费;<br>
				2、生活费8万人民币/学年账户上必须至少存入8640欧元;
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!--模态框4-->
<div class="modal fade" id="myModa4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					为什么去德国留学读本科预备课程是必不可少的？
				</h4>
			</div>
			<div class="modal-body">
				1、参加一项APS认证程序。如果通过审核，您将会得到一张APS证书，这是申请签证的必须材料;<br>
				2、如果已有国外高校的毕业学位，想去德国深造，可以向DAAD进行免费专业的咨询;<br>
				3、确保您能尽早拿到录取通知书，并及时递交签证申请– 至少提前6到8周，以保证开学时能按时赴德;
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!--模态框5-->
<div class="modal fade" id="myModa5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					去德国留学的费用（学杂费、生活费）有多少？
				</h4>
			</div>
			<div class="modal-body">
				由于德国基础教育体制是13年制，与我国12年制基础教育体系不同，因此中国大陆地区高中毕业生进入德国高校攻读本科之前，必须完成德语登记考核和德国针对非欧洲生源设计的本科预备课程，通过相应测评考核后即可进入德国高校攻读本科课程，同时可享与欧洲生源同
				等的留学政策待遇。
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!--模态框6-->
<div class="modal fade" id="myModa6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					为什么选择在光大读预备课程？
				</h4>
			</div>
			<div class="modal-body">
				&nbsp;&nbsp;课程优势：德国国际课程实验班得到中、德两国政府部门的大力支持，是国内中学对接德国大学的绿色通道；项目班学生学习德国项目课程的同时也学习国内中学文化课程。中学毕业后既可选择德国一流大学继续深造，又可就读国内名校。对于尚未下定决心是否去国外留学的学生和家庭来说是首选。培养目标：借鉴德国优秀教育模式，融合中国基础教育优势，注重中国传统文化的渗透，培养具有国际视野，及创新精神的未来人才。
				优势特点:<br>1、可选择用德语或英语作为高考外语;<br>2、中学阶段同时接受传统教育以及国外对接课程;<br>3、就读德国大学专业，学费全免;<br>4、德语泰斗级教授、海归名师、专业外教共同组成强大的教学师资团队; <br>
				            5、德国实验班学生注重素质、特长、个性等多方面的全面教育;
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
