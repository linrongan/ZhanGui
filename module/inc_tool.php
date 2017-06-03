<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$tool_array=array('authcode','notify','feedback','chat_admin','chat_admin_list','chat_user','chat_module');
if (!in_array($v_mod,$tool_array))
{
    exit;
}
include  RPC_DIR .'/tool/'.$v_mod.'.php';
exit;
?>