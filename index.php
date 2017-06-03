<?php
/**
 *		这不是一个开源和免费软件,使用前请获得作者授权
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
define('RUOYWCOM','1');
define('ROOT_DIR', str_replace("\\", '/', substr(dirname(__FILE__), 0, -23)) );
define('RPC_DIR', str_replace("\\", '/', dirname(__FILE__)) );
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR .'/module/common/common.php';
require RPC_DIR . '/module/inc_'.$mod.'.php';
//引入module里面的入口文件
?>