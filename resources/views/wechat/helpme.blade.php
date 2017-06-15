@include('wechat_head')
</head>

<body>
<div class="container">
	<header data-am-widget="header" class="am-header am-header-default my-header">
      <h1 class="am-header-title">
    <a href="#title-link" class="">拍卖规则</a>
      </h1>
    </header>
    <!-- banner -->
    <div class="g-body">
        <div class="m-help">
            <div class="g-wrap">
                <div class="m-help-main">
                    <h3>什么是拍卖</h3>
                    <div class="m-help-main-txt">
                        <p class="m-help-main-intro">以委托寄售为业的商行当众出卖寄售的货物，由许多顾客出价争购，到没有人再出更高一些的价时，或者特定时间内没有人出价，就拍板，表示成交。</p>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="m-help-ext">
                    <h4>保证金规则</h4>
                    <ol>
                        <li><span class="index">1</span><strong class="txt-red">缴纳次数：</strong>参加一笔拍卖交易，不管拍卖的价格和该宝贝想要竞拍的件数，都只需缴纳一次保证金。</li>
                        <li><span class="index">2</span><strong class="txt-red">缴纳金额：</strong>我们为每一款拍品单独设置了保证金，在出价时，系统会冻结该保证金，若成功获得拍品，付款金额会自动扣除保证金，若竞拍失败，保证金会在竞拍结束后统一返还到您的账户。若得拍不付款，则保证金不返还。</li>
                        <li><span class="index">3</span><strong class="txt-red">缴纳方式：</strong>在对拍品第一次确认出价竞拍前，您需要缴纳保证金，如您的账户中有足够的余额支付拍卖保证金，系统会自动冻结该笔款项。</li>
                    </ol>
                    <h4>拍卖成交规则</h4>
                    <ol>
                        <li><span class="index">1</span>至少2人报名。</li>
                        <li><span class="index">2</span>至少1人出价。</li>
                    </ol></div>
            </div>
            <div style="height: 50px;"></div>
        </div>
    </div>
    <!--底部-->
    @include('wechat_nav')
