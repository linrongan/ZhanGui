<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>操作提示</title>
</head>
<body style="background: #f0f3fa">
<div id="container" class="container">
    <div class="msg" style="margin-top: 20%">
        <div class="weui_msg">
            <div class="weui_icon_area" style="text-align: center">
                <i class="weui_icon_msg"><img src="/template/source/images/tip_smile.png" /> </i>
            </div>
            <div class="weui_text_area">

                <p class="weui_msg_desc" style="color: #b5b8bf;text-align: center">
                    <?php echo isset($_GET['msg'])?$_GET['msg']:"操作失败,请检查重试!"; ?>
                </p>
            </div>
        </div>
    </div></div>
</body>
</html>