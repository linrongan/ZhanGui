<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
session_start();
include RPC_DIR .'/inc/form_input_valid.php';
$mod=isset($_GET['mod']) && (!empty($_GET['mod']))?$_GET['mod']:'index';
$v_mod=isset($_REQUEST['v_mod']) && (!empty($_REQUEST['v_mod']))?$_REQUEST['v_mod']:$mod;
$Sys_Order_Status =array(-1=>"已退款",0=>"已取消",1=>"未付款",2=>"处理中",3=>"已支付",4=>'已发货',5=>'已收货',6=>'待评价',7=>'已评价',8=>"已完成");
$msg_array = array(0=>'余额充值',1=>'支付订单',2=>'充值赠送');
$prize_array = array(1=>'实物',2=>'积分',3=>'谢谢参与');
define('ADMIN_ERROR','?mod=admin&_index=_nofound');
function daddslashes($string, $force = 0) {
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC || $force)
    {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);}
        }else {
            $string = trim(addslashes($string));
        }
    }
    return $string;
}
function redirect($url, $delay = 0, $js = false, $jsWrapped = true, $return = false)
	{
    $delay = (int)$delay;
    if (!$js) {
      if (headers_sent() || $delay > 0) {
            echo'
   <html>
       <head>
       <meta http-equiv="refresh" content="'.$delay.';URL='.$url.'" />
       </head>
       </html>';
            exit;
        } else {
            header("Location:".$url."");
            exit;
        }
    }
    $out = '';
    if ($jsWrapped) {
        $out .= '<script language="JavaScript" type="text/javascript">';
    }
    $url = rawurlencode($url);
    if ($delay > 0) {
        $out .= "window.setTimeOut(function () { document.location='{$url}'; }, {$delay});";
    } else {
        $out .= "document.location='{$url}';";
    }
    if ($jsWrapped) {
        $out .= '';
   }
    if ($return) {
        return $out;
    }
    echo $out;
	    exit;
	}
/* 中文字符截取 */
function utf_substr($str,$len)
{
    $ostr=$str;
    for($i=0;$i<$len;$i++)
    {
        $temp_str=substr($str,0,1);

        if(ord($temp_str) > 127)
        {
            $i++;
            if($i<$len)
            {
                $new_str[]=substr($str,0,3);
                $str=substr($str,3);
            }
        }
        else
        {
            $new_str[]=substr($str,0,1);
            $str=substr($str,1);
        }
    }
    $new_str=join($new_str);
    if ($new_str==$ostr)
    {
        return $ostr;
    }
    else
    {
        return $new_str.'...';
    }
}
/*计算字符串的长度(包括中英数字混合情况)*/
function count_string_len($str) {
    $name_len = strlen ( $str );
    $temp_len = 0;
    for($i = 0; $i < $name_len;) {
        if (strpos ( 'abcdefghijklmnopqrstvuwxyz0123456789', $str [$i] ) === false) {
            $i = $i + 3;
            $temp_len += 2;
        } else {
            $i = $i + 1;
            $temp_len += 1;
        }
    }
    return $temp_len;
}

//获取ip地址
function GetIP(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "无法获取！";
    }
    return $cip;
}

/**
 * @desc 封装curl的调用接口，post的请求方式
 */
function doCurlPostRequest($url, $requestString, $timeout = 5) {
    if($url == "" || $requestString == "" || $timeout <= 0){
        return false;
    }

    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
    curl_setopt($con, CURLOPT_POST, true);
    curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
    curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    return curl_exec($con);
}

/**
 * @desc 封装curl的调用接口，get的请求方式
 */
function doCurlGetRequest($url, $data = array(), $timeout = 10) {
    if($url == "" || $timeout <= 0){
        return false;
    }
    if($data != array()) {
        $url = $url . '?' . http_build_query($data);
    }
    //echo $url;
    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
    curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    return curl_exec($con);
}





?>