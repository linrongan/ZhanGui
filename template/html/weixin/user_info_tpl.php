<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo($_SESSION['userid']);
$default_address = $obj->GetUserDefaultAddress();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>个人资料</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">

        .weui-cells:before {
            border-top:none;
        }
    </style>
</head>

<body>

<div id="gg-app" style="padding:1.06rem 0 0 0">

    <div class="gg-detail-header">
        <span class="gg-detail_title sz16r">个人资料</span>
        <div class="return-back" onclick="javascript :history.back(-1);"></div>
    </div>

    <div class="weui-cells" style="margin-top:0">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
                <p class="sz14r omit">头像</p>
            </div>
            <div class="weui-cell__tf top-pic"><img src="<?php echo $user['headimgurl']; ?>"></div>
        </a>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label sz14r">账号名称</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input sz12r" id="username" onkeyup="reg_change()" value="<?php echo $user['username']; ?>" type="text"  placeholder="请输入账号名称">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label sz14r">绑定手机号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input sz12r" id="phone" onkeyup="reg_change()" type="number" value="<?php echo $user['phone']; ?>" placeholder="请绑定手机号">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label sz14r">用户ID</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input sz12r" disabled value="<?php echo $user['userid']+1987; ?>" type="text"  placeholder="请输入账号名称">
            </div>
        </div>
        <a class="weui-cell weui-cell_access" href="?mod=weixin&v_mod=address&_index=_list">
            <div class="weui-cell__bd">
                <label class="weui-label sz14r">收件地址</label>
            </div>
            <div class="weui-cell__ft top-pic txtl " style="width: 63%">
                <p class="sz12r omit cl999 "><?php if($default_address)
                    {echo $default_address['shop_name'].'&nbsp;&nbsp;'.$default_address['shop_phone'];} ?></p>
            </div>
        </a>
    </div>
    <div style="padding:.8rem 10%;">
        <a href="javascript:;" id="submit" class="weui-btn weui-btn_primary sz16r weui-btn_disabled">保存修改</a>
    </div>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
</body>
<script>
    var old_username = '<?php echo $user['username']; ?>';
    var old_phone = '<?php echo $user['phone']; ?>';
    var is_change = false;
    function reg_change() {
        var username = $("#username").val();
        var phone = $("#phone").val();
        if(username==old_username &&
            phone==old_phone)
        {
            if($("#submit").hasClass('weui-btn_disabled'))
            {

            }else{
                $("#submit").addClass('weui-btn_disabled');
            }
            is_change = false;
        }else{
            if($("#submit").hasClass('weui-btn_disabled'))
            {
                $("#submit").removeClass('weui-btn_disabled');
            }
            is_change = true;
        }
    }

    $("#submit").click(function () {
        if($(this).hasClass('weui-btn_disabled') || is_change==false)
        {
            return false;
        }
        var data = {
            username:$("#username").val(),
            phone:$("#phone").val()
        };
        if(data.username=='')
        {
            alert('请输入姓名');
            return false;
        }
        if(data.phone=='')
        {
            alert('请输入手机号码');
            return false;
        }else if(isNaN(data.phone) ||
            data.phone.length!=11)
        {
            alert('请输入正确的手机号码');
            return false;
        }
        is_change = false;
        $.ajax({
            type:"post",
            url:"/?mod=weixin&v_mod=user&_index=_info&_action=ActionEditUserInfo",
            data:data,
            dataType:"json",
            success:function (res) {
                is_change = true;
                alert(res.msg);
                if(res.code==0)
                {
                    old_username = data.username;
                    old_phone = data.phone;
                    $("#submit").addClass('weui-btn_disabled');
                    is_change = false;
                }else{
                    is_change = true;
                }
            },
            error:function () {
                alert('网络超时!');
                is_change = true;
            }
        });
    });
</script>
</html>