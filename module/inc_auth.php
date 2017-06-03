<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if (!isset($_SESSION['openid']))
{
    include RPC_DIR .'/module/mobile/auth/login_'.$_GET['_auth'].'.php';
}
exit;
?>