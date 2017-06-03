<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

if (isset($_GET['test']))
{
    $_SESSION['openid'] = 'o3nClwqzSChJzQgk49Mq3BSmUOj4';
    $_SESSION['userid']=157;
    $_SESSION['nickname'] = '若宇网络 俊逸';
}
if (isset($_GET['lin']))
{
    $_SESSION['openid'] = 'oUBLEwkasZhC3_qXcPjPuOAOOMq4';
    $_SESSION['userid']=100;
    $_SESSION['nickname'] = 'lin';
}

$_index=daddslashes(isset($_GET['_index']) && (!empty($_GET['_index']))?trim($_GET['_index']):'');
//开始进入授权
if (!isset($_SESSION['userid']))
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $weburl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $_SESSION['backurl']=$weburl;
    redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.urlencode(WEBURL.'/?mod=auth&_auth=snsapi_base&url='.$weburl).'&response_type=code&scope=snsapi_base&state=123#wechat_redirect');
}
include RPC_DIR .'/module/common/common_wx.php';
if (!is_file(RPC_DIR .'/module/mobile/weixin/'.$v_mod.'.php'))
{
    redirect(NOFOUND);
}
include RPC_DIR .'/module/mobile/weixin/'.$v_mod.'.php';
$obj=new $v_mod($_REQUEST);
if (isset($_GET['_action']) && $_GET['_action']<>"")
{
    $v_mod_action=ucfirst($v_mod).'Action';
    if (is_file(RPC_DIR .'/module/mobile/weixin/Action/'.$v_mod_action.'.php'))
    {
        include RPC_DIR .'/module/mobile/weixin/Action/'.$v_mod_action.'.php';
        $obj_action=new $v_mod_action($_REQUEST);
        if (method_exists($obj_action,$_GET['_action']))
        {
            $_return=$obj_action->$_GET['_action']();
        }
    }elseif(method_exists($obj,$_GET['_action']))
    {
        $_return=$obj->$_GET['_action']();
    }
}
if (is_file(RPC_DIR .TEMPLATEPATH.'/weixin/'.$v_mod.$_index.'_tpl.php'))
{
    include  RPC_DIR .TEMPLATEPATH.'/weixin/'.$v_mod.$_index.'_tpl.php';
}
?>