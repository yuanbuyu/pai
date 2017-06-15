@include('wechat_head')
</head>

<body>
<div class="container">
	<header data-am-widget="header" class="am-header am-header-default my-header">
      <h1 class="am-header-title">
        <a href="#title-link" class="">会员中心</a>
      </h1>
    </header>
	<div class="uchome-info">
    	<div class="uchome-info-uimg">
        	<img src="{{$headimgurl}}" />
        </div>
        <div class="uchome-info-uinfo">
        	<p>尚鼎拍卖，欢迎光临！<span><a href="{{url('logout')}}">[退出]</a></span></p>
            <p>帐号：{{$nickname}}</p>
            <p>余额：<span class="red">￥2531</span>，待付款订单：<a href="#" class="red">12</a></p>
        </div>
    </div>
    <div class="am-cf uchome-apps" style="background: #fff">
    	<ul class="am-avg-sm-3 uchome-apps-ul">
        	<li><a href="buy.html"><p class="imgp"><img src="default/uhomeapp4.png" class="am-img-responsive" /></p><p class="namep">我的订单</p><p class="lastp">0笔</p></a></li>
            <li><a href="#"><p class="imgp"><img src="default/uhomeapp2.png" class="am-img-responsive" /></p><p class="namep">出价记录</p><p class="lastp">0笔</p></a></li>
            <li><a href="myuser.html"><p class="imgp"><img src="default/uhomeapp1.png" class="am-img-responsive" /></p><p class="namep">资料设置</p><p class="lastp">完整度:80%</p></a></li>
            <li><a href="#"><p class="imgp"><img src="default/uhomeapp6.png" class="am-img-responsive" /></p><p class="namep">账户明细</p><p class="lastp">0条</p></a></li>
            <li><a href="#"><p class="imgp"><img src="default/uhomeapp13.png" class="am-img-responsive" /></p><p class="namep">余额充值</p><p class="lastp">￥0</p></a></li>
            <li><a href="withdrawals.html"><p class="imgp"><img src="default/uhomeapp8.png" class="am-img-responsive" /></p><p class="namep">申请提现</p><p class="lastp">￥0</p></a></li>
        </ul>
    </div>
    <!--底部-->
    @include('wechat_nav')
