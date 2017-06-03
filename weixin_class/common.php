<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

include_once RPC_DIR .'/module/common/common.php';
Class wx_common {
    function __construct($data,$db) {
        $this->data=daddslashes($data);
        $this->db=$db;
    }
    //验证请求
    function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
?>