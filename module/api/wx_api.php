<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include_once RPC_DIR .'/module/common/common_wx.php';
class wx_api extends wx
{
    function __construct($data)
    {
        $this->data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_MERCHANT." WHERE id=1");
        $this->current=time();
    }
    private function GetValidAccessToken()
    {
        //检查一下数据库中最access_token是否过期
        $token = $this->data['access_token'];
        $expire =$this->data['expire'];
        $addTimestamp = $this->data['addtimestamp'];
        $current = time();
        if($addTimestamp + $expire - 30 > $current){
            //有效的
            return array("code"=>0,"access_token"=>$token);
        }else
        {
            return $this->Get_access_token();
        }
    }

    //获取jsapi配置权限开始------------------------------------
    private  function jsapi_ticket()
    {
        //首先判断ticket是否过期
        if (!empty($this->data['jsapi_ticket']) &&
            ($this->data['jsapi_ticket_time'] + $this->data['expire'] - 30 > $this->current)) {
            //有效范围内直接返回
            return $this->data['jsapi_ticket'];
        }
        else
        {
            //没有要去远程获取
            $access_token=$this->GetValidAccessToken();
            $url = WX_API_URL . "ticket/getticket?access_token=".$access_token['access_token']."&type=jsapi";
            $ret = doCurlGetRequest($url);
            $retData = json_decode($ret, true);
            if(!$retData || (isset($retData['errcode']) && $retData['errcode']))
            {
                //此处记录下为什么还是不能获取到，是否有其他干扰到了或者配置信息问题
                return false;
            }else{
                $jsapi_ticket=$retData['ticket'];
                //更新数据库
                $this->GetDBMaster()->query("UPDATE ".TABLE_MERCHANT." "
                    ." SET jsapi_ticket='".$jsapi_ticket."',"
                    ." jsapi_ticket_time='".$this->current."' "
                    ." WHERE id=1");
                return $retData['ticket'];
            }
        }
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function config($url) {
        $jsapi_ticket=$this->jsapi_ticket();
        if ($jsapi_ticket)
        {
            //$url=urldecode($this->post['url']);
            $noncestr=$this->createNonceStr();
            $str="jsapi_ticket=".$jsapi_ticket."&noncestr=".$noncestr."&timestamp=".$this->current."&url=".$url;
            $signature=sha1($str);
            $array=array(
                "code"=>0,
                "appId"=>APPID,
                "signature"=>$signature,
                "timestamp"=>$this->current,
                "noncestr"=>$noncestr
            );
            return $array;
        }
        return array("code"=>1);
    }
    //获取jsapi配置权限结束------------------------------------
}
?>






