<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}


$a=$db->queryforobject("select count(*) as count from wx_merchant where id=1");
echo $a;exit;
?>