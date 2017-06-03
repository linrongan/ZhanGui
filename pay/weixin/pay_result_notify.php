<?php
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
include '../../config_wx.php';
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR.'/module/common/common.php';
include RPC_DIR.'/module/mobile/weixin/pay.php';
$pay  = new pay(array());
$pay->pay_result();exit;