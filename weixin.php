<?php
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
define('RUOYWCOM','1');
define("HINT_NOT_IMPLEMEMT", "未实现");
define('HINT_TPL', "<xml>
  <ToUserName><![CDATA[%s]]></ToUserName>
  <FromUserName><![CDATA[%s]]></FromUserName>
  <CreateTime>%s</CreateTime>
  <MsgType><![CDATA[%s]]></MsgType>
  <Content><![CDATA[%s]]></Content>
  <FuncFlag>0</FuncFlag>
</xml>
");
include 'conf/conf.php';
include 'conf/config.php';
include 'conf/run_database.php';
?>