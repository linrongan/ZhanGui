<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
sleep(2);
$data = $obj->GetUserPayOrder();
if($data['code'])
{
    redirect(NOFOUND.'&msg='.$data['msg']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>支付结果</title>
    <link rel="stylesheet" type="text/css" href="/template/source/css/font.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/template/source/css/rest.css?6666">
    <link rel="stylesheet" type="text/css" href="/template/source/css/main.css?7asdasd777">
</head>
<body>

<?php
if($data['data']['order_status']>=3)
{
    ?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">订单支付成功</h2>
            <p class="weui-msg__desc">
                本次订单号：<?php echo $data['data']['orderid']; ?>
            </p>
        </div>
    </div>
    <div class="page preview js_show">
        <div class="page__bd">
            <div class="weui-form-preview">
                <div class="weui-form-preview__bd">
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">账单金额</label>
                        <span class="weui-form-preview__value">￥<?php echo $data['data']['order_total']; ?></span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">实际支付</label>
                        <span class="weui-form-preview__value">￥<?php echo $data['data']['pay_money']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="" style="padding:.4rem 10%;">
        <a class="weui-btn weui-btn_default" href="/?mod=weixin&v_mod=_order">返回</a>
    </div>
<?php
}else{
    ?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-waiting weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">暂未收到付款信息</h2>
            <p class="weui-msg__desc">
                如果您确认已经支付，请点击下面的刷新按钮，如果多次刷新不成功，请联系客服人员反馈问题！
            </p>
        </div>
    </div>
    <div class="" style="padding:.4rem 10%;">
        <a class="weui-btn weui-btn_default" href="/?mod=weixin&v_mod=checkout&_index=_pay_result&orderid=<?php echo $_GET['orderid']; ?>">刷新页面</a>
    </div>
<?php
}
?>
<script type="text/javascript" src="/template/source/js/zepto.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
</body>
</html>