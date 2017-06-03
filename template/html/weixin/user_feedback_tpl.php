<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>意见反馈</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">


        .weui-cells{background:none;}
        .weui-cell {
            padding: .2rem 3%;
            border: 1px solid #D9D9D9;
            border-radius: 5px;
            background: #FFF;
        }
    </style>
</head>

<body>

<div id="gg-app" style="padding:1.06rem 0 0 0">

    <div class="gg-detail-header">
        <span class="gg-detail_title sz16r">意见反馈</span>
        <div class="return-back" onclick="javascript :history.back(-1);"></div>
    </div>

    <div class="fanGui">

        <div class="weui-cells__title blackColor">联系邮箱 <span>（选填）</span></div>

        <div class="weui-cells mtr02">

            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input sz12r" id="contact" maxlength="20" type="text" placeholder="给出你的邮箱，我们会在第一时间回复你">
                </div>
            </div>

        </div>

        <div class="weui-cells__title blackColor">你的意见</div>

        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea sz12r" id="message" maxlength="200" placeholder="把你想要对我们说的，都写在这里。" rows="5"></textarea>
                    <div class="weui-textarea-counter sz12r"><span id="count">0</span>/200</div>
                </div>
            </div>
        </div>
    </div>

    <div style="padding:.8rem 10%;">
        <a href="javascript:;" id="submit" class="weui-btn weui-btn_primary sz16r">提交</a>
    </div>
</div>
</body>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/template/source/js/textarea.js"></script>

<script>
    $(function () {

        $("#message").keyup(function(event){
            var lenValue = $(this).val().length;
            if(lenValue <= 120){
                $("#count").html(lenValue);
                if(lenValue == 120){
                    $(this).siblings(".weui-textarea-counter").css("color","#000");
                }else{

                    $(this).siblings(".weui-textarea-counter").css("color","#b2b2b2");
                }
            }
        })


        $("#submit").click(function () {
            var contact = $("#contact").val();
            var message = $("#message").val();
            if(message=='')
            {
                alert('请输入您的意见');
                return false;
            }
            if(message.length<5 || message.length>120)
            {
                alert('长度5-120字符之间');
                return false;
            }
            var data = {
                contact:contact,
                message:message
            };
            $.ajax({
                type:"post",
                url:"/?mod=weixin&v_mod=user&_action=ActionNewMessage",
                data:data,
                success:function (res) {
                    alert(res.msg);
                    if(res.code==0)
                    {
                        $("#contact").val('');
                        $("#message").val('');
                        $("#count").html(0);
                    }
                },
                dataType:"json"
            });
        });

    })
</script>
</html>