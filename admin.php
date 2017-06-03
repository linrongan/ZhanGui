<?php
/**
 *		这不是一个开源和免费软件,使用前请获得作者授权
 */
//error_reporting(0);
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
define('RUOYWCOM','1');
define('ROOT_DIR', str_replace("\\", '/', substr(dirname(__FILE__), 0, -23)) );
define('RPC_DIR', str_replace("\\", '/', dirname(__FILE__)) );
define('SAVE_IMG_SMALL','/upload/small/' );
define('SAVE_IMG_LARGER','/upload/larger/' );
include RPC_DIR .'/conf/conf.php';
require RPC_DIR . '/conf/config.php';
require RPC_DIR . '/module/inc_'.$mod.'.php';
exit;
?>