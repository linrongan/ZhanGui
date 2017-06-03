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
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
</head>
<body>

<div class="headerbar">
    <div class="logopanel">
        <h1><span>[</span> <?php echo WEBNAME; ?> <span>]</span></h1>
    </div>
    <a class="menutoggle"><i class="fa fa-bars"></i></a>
    <form class="searchform" action="" method="post">
        <input type="text" class="form-control" name="keyword"
               placeholder="关键字搜索..."
               value=""/>
    </form>

    <div class="header-right">
        <ul class="headermenu">
            <li>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                        <img src="/template/html/admin/images/photos/loggeduser.png" alt="" />
                        <?php echo $_SESSION['admin_name']; ?>
                        <span class="caret"></span>
                    </button>
                </div>
            </li>

            <li class="btn-group">
                <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle">
                    <a href=""><i class="glyphicon glyphicon-user"></i> 账户设置</a>
                </button>
                </div>
            </li>

            <li class="btn-group">
                <a href="?mod=admin&_action=AdminLogout" target="_parent">
                <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle">
                    <i class="glyphicon glyphicon-log-out"></i> 退出登陆
                </button>
                </div>
                </a>
            </li>

        </ul>
    </div>
</div>
</body>
<script src="/template/source/js/jquery.js"></script>
<script>
    $(function(){
        $(".menutoggle").click(function()
        {
            if($('.logopanel').is(':hidden'))
            {
                $(".logopanel").show();
                $('#menu', window.parent.document).css("width","240px");
                $('#leftframe', window.parent.document).css("width","240px");
            }else
            {
                $(".logopanel").hide();
                $('#menu', window.parent.document).css("width","58px");
                $('#leftframe', window.parent.document).css("width","58px");
            }
        })
    })
</script>
</html>