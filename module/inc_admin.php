<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/conf/database_table_admin.php';
include RPC_DIR .'/module/mobile/admin/comm.php';
if (!isset($_SESSION['admin_id']))
{
    if ((isset($_GET['action'])) && ($_GET['action']=='ajaxLogin'))
    {
        //判断是否为 ajax 请求
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            if ((!isset($_POST['code'])) or ($_POST['code']=="") or (strtolower($_POST['code'])<>strtolower($_SESSION['code'])))
            {
                echo json_encode(array("code"=>1,"msg"=>"验证码不正确"));
                exit;
            }
            $admin=new comm($_REQUEST);
            echo json_encode($admin->AdminLogin());
            exit;
        }
    }
    include RPC_DIR .TEMPLATEPATH.'/admin/login_tpl.php';
    exit;
}
$_action='';
$_index=daddslashes(isset($_GET['_index']) && (!empty($_GET['_index']))?trim($_GET['_index']):'');
if (isset($_GET['_action']) && regExp::checkNULL($_GET['_action']))
{
    $_action=$_GET['_action'];
}
if(is_file(RPC_DIR .'/module/mobile/admin/'.$v_mod.'.php'))
{
    include RPC_DIR .'/module/mobile/admin/'.$v_mod.'.php';
}else
{
    redirect('/?mod=admin&_index=_nofound');
}
$obj=new $v_mod($_REQUEST);
$obj->CheckAdminAuth($_SESSION['admin_id'],trim($mod.'#'.$v_mod.'#'.$_index.'#'.$_action));
if ($_action<>"")
{
    $v_mod_action=ucfirst($v_mod).'Action';
    if (is_file(RPC_DIR .'/module/mobile/admin/Action/'.$v_mod_action.'.php'))
    {
        include RPC_DIR .'/module/mobile/admin/Action/'.$v_mod_action.'.php';
        $obj_action=new $v_mod_action($_REQUEST);
        if (method_exists($obj_action,$_action))
        {
            $_return=$obj_action->$_action();
        }
    }elseif(method_exists($obj,$_action))
    {
        $_return=$obj->$_action();
    }
}
$temp = RPC_DIR .TEMPLATEPATH.'/admin/'.$v_mod.$_index.'_tpl.php';
if(is_file($temp))
{
    include $temp;
}else
{
    redirect('/?mod=admin&_index=_nofound');
}
?>