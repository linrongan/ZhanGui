<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

$_index=daddslashes(isset($_GET['_index']) && (!empty($_GET['_index']))?trim($_GET['_index']):'');
if (is_file(RPC_DIR .'/module/mobile/wap/'.$v_mod.'.php'))
{
    include RPC_DIR .'/module/mobile/wap/'.$v_mod.'.php';
    $obj=new $v_mod($_REQUEST);
    if (isset($_GET['_action']) && $_GET['_action']<>"")
    {
        $v_mod_action=ucfirst($v_mod).'Action';
        if (is_file(RPC_DIR .'/module/mobile/wap/Action/'.$v_mod_action.'.php'))
        {
            include RPC_DIR .'/module/mobile/wap/Action/'.$v_mod_action.'.php';
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

    if (is_file(RPC_DIR .TEMPLATEPATH.'/wap/'.$v_mod.$_index.'_tpl.php'))
    {
        include  RPC_DIR .TEMPLATEPATH.'/wap/'.$v_mod.$_index.'_tpl.php';
    }
}
?>