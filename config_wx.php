<?php
date_default_timezone_set('Asia/Shanghai');
define('RUOYWCOM','1');
define('RPC_DIR', str_replace("\\", '/', dirname(__FILE__)) );
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
?>