<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>管理后台</title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
</head>
<body class="signin">
<section>
    <div class="signinpanel">
        <div class="row">
            <div class="col-md-7">
                <div class="signin-info">
                    <div class="logopanel">
                        <h1><span>[</span> <?php echo WEBNAME; ?> <span>]</span></h1>
                    </div><!-- logopanel -->
                    <div class="mb20"></div>
                    <h5><strong>访问管理后台</strong></h5>
                    <ul>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> 请妥善保管您的登陆信息</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> 请不要在公共场所设定计算机记住您的个人信息。</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> 在公共场所使用本产品后请务必退出系统。</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> 尽量避免多人使用同一账号。</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> 当前版本1.10版本</li>
                    </ul>
                    <div class="mb20"></div>
                </div><!-- signin0-info -->
            </div><!-- col-sm-7 -->
            <div class="col-md-5">
                    <h4 class="nomargin">登陆</h4>
                    <input type="text" name="name" id="name" class="form-control uname" placeholder="请输入账号" />
                    <input type="password" name="pwd" id="pwd" class="form-control pword" placeholder="请输入密码" />
                    <span style="position: relative;height: 40px;width: 100%;display: block">
                    <img style="cursor: pointer;position: absolute;right:0" id="authcode" height="40px" width="80px" src="<?php echo WEBURL."/tool/"?>authcode.php" alt="看不清楚，换一张"  onclick="javascript:newgdcode(this,'<?php echo WEBURL."/tool/"?>authcode.php');" />
                    <input type="text" id="code" name="code" class="form-control" placeholder="请输入验证码" />
                    </span>
                    <div style="height: 10px;width: 100%"></div>
                    <a id="submitForm" class="btn btn-success btn-block">立即登陆</a>
            </div><!-- col-sm-5 -->

        </div><!-- row -->

        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2014. All Rights Reserved. 广州市若宇网络科技有限公司
            </div>
            <div class="pull-right">
                Created By: <a href="http://www.ruoyw.com/" target="_blank">若宇网络</a>
            </div>
        </div>
    </div><!-- signin -->
</section>
<script src="/template/source/js/jquery-1.10.1.min.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<script>
    function newgdcode(obj,url) {
        obj.src = url+ '?nowtime=' + new Date().getTime();
    }
    $(function(){
        $(document).keydown(function(){
            if(event.keyCode==13){
                ajaxLogin();
            }
        });
        $("#submitForm").click(
            function(){
                ajaxLogin();
                return false;
            }
        );
    });

    function ajaxLogin()
    {
        var name = $('#name').val();
        var password = $('#pwd').val();
        var code=$('#code').val();
        if(name.length == 0 || password.length == 0)
        {
            layer.msg('请输入账号或密码', {icon: 5});
            return false;
        }else if(code==''){
            layer.msg('请输入验证码', {icon: 5});
            return false;
        }
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        var data = 'admin='+name;
        data += '&pwd='+password;
        data += '&code='+code;
        //alert(data);
        $.ajax({
            type: 'POST',
            url:  '/?mod=admin&action=ajaxLogin',
            data: data,
            cache:false,
            dataType:"json",
            success: function(res)
            {
                layer.close(index);
                if(res.code==0)
                {
                    window.location.href='/?mod=admin';
                }
                else
                {
                    $("#authcode").attr("src",'<?php echo WEBURL."/tool/"?>authcode.php?nowtime=' + new Date().getTime());
                    layer.msg(res.msg, {icon: 5});
                }
                return false;
            },
            error:function(result) {
                layer.msg('网络超时,请重试!', {icon: 5});
                layer.close(index);
                return false;
            }
        });
    }

</script>
</body>
</html>