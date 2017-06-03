<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?php echo WEBNAME; ?></title>
<link href="/template/html/admin/css/style.default.css" rel="stylesheet">
<script src="/template/source/js/jquery.js"></script>
<script src="/template/html/admin/js/custom.js"></script>
<script src="/template/html/admin/js/html5shiv.js"></script>
<script src="/template/html/admin/js/respond.min.js"></script>
    <script>
        function reinitIframe(id){
            var iframe = document.getElementById(id);
            try{
                iframe.height = 700;
            }catch (ex){}
        }
    </script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr><td>
    <div id="div_header" style="height:50px;">
    <iframe style="margin:0px; padding:0px;" width="100%" height="50px" allowtransparency="true" frameborder="0" src="?mod=admin&_index=_top_menu" onload="reinitIframe('main')"></iframe>
    </div></td>
    </tr>
    <tr><td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
    <td id="leftframe"  style="width:240px; overflow:hidden;vertical-align: top">
        <div style="position:relative; z-index:105">
        <iframe style="margin:0px; padding:0px;" width="240px" allowtransparency="true" frameborder="0" src="?mod=admin&_index=_left_menu" id="menu"  name="menu" onload="reinitIframe('menu')"></iframe>
        </div></td>
    <td valign="top">
        <div><iframe style="margin:0px; padding:0px;" width="100%" allowtransparency="true" frameborder="0" src="?mod=admin&_index=_default" id="main" name="main" onload="reinitIframe('main')"></iframe>
        </div>
    </td>
</tr>
</table>
 </td>
</tr>
</table>
</body>
<script src="/template/source/js/jquery.js"></script>
</html>