<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetTheOrder();
if($data['code'])
{
    redirect(NOFOUND.'&msg='.$data['msg']);
}
if($data['data']['order_status']!=1)
{
    redirect(NOFOUND.'&msg=订单状态错误');
}
if($data['data']['expiry_date']<time())
{
    redirect(NOFOUND.'&msg=订单支付逾期');
}
include RPC_DIR.'/module/common/wechat_pay.php';
$wechat_pay = new wechat_pay();
$array = array(
    'out_trade_no'=>$data['data']['orderid'],
    'total_fee'=>$data['data']['order_total'],
    'notify_url'=>WEBURL.'/pay/weixin/user_pay_product_result.php'
);
$pay_data = $wechat_pay->WeChatPay($array);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>订单支付</title>
    <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/main.css">
    <style type="text/css">
        .left_arrow_new img{margin: 15px 0;}
        .left_arrow_new a,.left_arrow_new a:hover{color: #fff; font-size: 1.2em}
        .pay_select li{ margin-top: 10px; float: left;width: 30%;margin-left: 2%;height: 40px;border: 2px solid #bcbcbc; line-height: 40px;}
        .weui-form-preview{position:absolute; width:100%; height:100%; left:0; bottom:0; background:white;}
        .weui-form-preview__bd{position:relative;}
        .weui-form-preview__bd::after{content: " ";
            position: absolute;
            left: 0;
            bottom: 0;
            right: 0;
            height: 1px;
            border-bottom: 1px solid #D9D9D9;
            color: #D9D9D9;
            -webkit-transform-origin: 0 100%;
            transform-origin: 0 100%;
            -webkit-transform: scaleY(0.5);
            transform: scaleY(0.5);
            left: 0;
        }
        .zd-weui-btn {
            padding: .4rem 10%;
        }
        .weui-label{width:90px;}
        .weui-select,.weui-textarea,.weui-input{font-family:'微软雅黑'}
        .weui-cells{margin-top:0;}
        .weui-btn+.weui-btn{margin-top:1rem;}
        .weui-form-preview__hd:after{left:0}
        .weui-form-preview__ft{margin:20px auto 0; background:#0BB20C; width:90%;}
        .weui-form-preview__btn_primary{color:#FFF; font-family:"微软雅黑";}

        .weui-form-preview:after{border-bottom:none;}
        .weui-form-preview__hd{text-align:center;}
        .weui-form-preview__zdlabel{font-family:"微软雅黑";}
        .weui-form-preview__zdvalue{font-weight:bold; font-size:28px; font-family:"微软雅黑";}
        .weui-form-preview__label,.weui-form-preview__value{font-family:"微软雅黑";}
        .weui-form-preview__value{color:#000;}
        .integral-title{border:none;}
    </style>
    <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
    <script type="text/javascript">
        var link = '/?mod=weixin&v_mod=checkout&_index=_pay_result&orderid=<?php echo $data['data']['orderid']; ?>';
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $pay_data; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg == "get_brand_wcpay_request:ok" )
                    {
                        window.location.href=link;
                    }
                    else
                    {
                        alert(res.err_code+res.err_desc+res.err_msg);
                    }
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }

    </script>
</head>
<body  style="background-color:#f6f6f6;">
<div id="container" class="container">
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__zdlabel">支付订单金额</div>
            <div class="weui-form-preview__zdvalue">
                ￥ <?php echo $data['data']['order_total']; ?>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">订单号码</label>
                <span class="weui-form-preview__value"><?php echo $data['data']['orderid']; ?></span>
            </div>
        </div>
        <div class="weui-form-preview__ft">
            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:" onclick="callpay()">立即支付</a>
        </div>
    </div>
</div>
</body>
</html>