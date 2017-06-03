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
    </head><body>
<div class="mainpanel">
<div class="pageheader">
    <h2><i class="fa fa-windows"></i> 管理首页 <span>  </span></h2>
    <div class="breadcrumb-wrapper">
        <span class="label">当前导航:</span>
        <ol class="breadcrumb">
            <li><a href="">导航</a></li>
            <li class="active">首页</li>
        </ol>
    </div>
    <div class="contentpanel">
        <div class="row">
            <h1>欢迎使用后台管理系统</h1>
            <table class="table table-striped" id="table2">
                <thead>
                </thead>
                <tbody>
                <tr class="odd gradeX">
                    <td>服务器域名</td>
                    <td><?php echo $_SERVER["HTTP_HOST"]; ?></td>
                </tr>
                <tr class="odd gradeX">
                    <td>服务器IP地址</td>
                    <td><?php echo $_SERVER["SERVER_ADDR"]; ?></td>
                </tr>
                <tr class="odd gradeX">
                    <td>客户端地址</td>
                    <td><?php echo $_SERVER["REMOTE_ADDR"]; ?></td>
                </tr>
                <tr class="odd gradeX">
                    <td>服务器端口</td>
                    <td><?php echo $_SERVER["SERVER_PORT"]; ?></td>
                </tr>
                <tr class="odd gradeX">
                    <td>服务器版本</td>
                    <td><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></td>
                </tr>
                <tr class="odd gradeX">
                    <td>浏览器版本</td>
                    <td><?php echo $_SERVER["HTTP_USER_AGENT"]; ?></td>
                </tr>
                <tr class="odd gradeX">
                    <td>时间</td>
                    <td><?php echo date("Y-m-d h:i:s",$_SERVER["REQUEST_TIME"]); ?></td>
                </tr>
                <tr class="odd gradeX">
                    <iframe width="100%" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=38&icon=1&num=5"></iframe>
                </tr>
                </tbody>
            </table>

        </div><!-- contentpanel -->

    </div><!-- mainpanel -->
</div>
<div class="contentpanel">
</div>
</div>
</body>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
</html>