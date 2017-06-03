<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
//模块
$mod=daddslashes($_REQUEST['api_mod']);
//文件
$v_mod=daddslashes($_REQUEST['api_class']);
//方法
$api_function=daddslashes($_REQUEST['api_function']);
include RPC_DIR .'/module/common/common.php';
include RPC_DIR .'/module/mobile/admin/comm.php';
include RPC_DIR .'/module/'.$mod.'/'.$v_mod.'.php';
$obj=new $v_mod(empty($_POST)?$_GET:$_POST,$db,$cu='');
$return=json_encode($obj->$api_function());
echo $return;exit;
?>