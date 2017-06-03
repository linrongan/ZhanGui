<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
include '../config_wx.php';
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR .'/module/common/common.php';
include RPC_DIR .'/module/common/common_wx.php';
Class resent_auth_apply extends wx
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //获取需要重发的订单
    function GetNeedReSent()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_AUTHORIZE_USER_DETAIL." "
            ." WHERE sent_status1<3 "
            ." OR sent_status2<3"
            ." OR sent_status3<3"
            ." ORDER BY sent_status1,sent_status2,sent_status3 ASC LIMIT 0,3");
        if (!empty($data))
        {
            foreach($data as $item)
            {
                if ($item['sent_status1']<3 && $item['auth_status']==1)
                {
                    //发送模板消息给上级代理
                    $array = array(
                        'touser'=>$item['openid'],
                        'template_id'=>TEMPLATE_MSG1,
                        'url'=>WEBURL.'/?mod=weixin&v_mod=auth&_index=_apply_to_parent&id='.$item['id'],
                        'data'=>array(
                            "first"=>array("value"=>"您收到一个新代理申请"),
                            "keyword1"=>array("value"=>addslashes($item['username'])),
                            "keyword2"=>array("value"=>addslashes($item['wechat'])),
                            "keyword3"=>array("value"=>addslashes($item['phone'])),
                            "keyword4"=>array("value"=>'点击进入可见'),
                            "keyword5"=>array("value"=>addslashes($item['ship_address'])),
                            "remark"=>array("value"=>'请勿通过不完整和不真实的申请信息',"color"=>"#ff4546"),
                        ));
                    $return=$this->SentTemplateMsg($array);
                    if ($return['code']==0)
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_AUTHORIZE_USER_DETAIL." "
                            ." SET sent_status1=100 WHERE id='".$item['id']."'");
                        echo $item['id'].'sent_status1:success';
                    }else
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_AUTHORIZE_USER_DETAIL." "
                            ." SET sent_status1=sent_status1+1 WHERE id='".$item['id']."'");
                        if ($return['errcode']==40001)
                        {
                            $this->Reload_Access_Token();
                        }
                    }
                }
                if ($item['sent_status2']<3 && $item['auth_status']==2)
                {
                    //代理发送消息给管理员
                    $openid=$this->GetMerchant();
                    //发送模板消息给管理员
                    $array = array(
                        'touser'=>$openid['apply_admin'],
                        'url'=>WEBURL.'/?mod=weixin&v_mod=auth&_index=_apply_to_admin&id='.$item['id'],
                        'template_id'=>TEMPLATE_MSG2,
                        'data'=>array(
                            "first"=>array("value"=>"您收到一个终审通知"),
                            "keyword1"=>array("value"=>addslashes($item['username'])),
                            "keyword2"=>array("value"=>addslashes($item['phone'])),
                            "keyword3"=>array("value"=>date("Y/m/d H/i")),
                            "remark"=>array("value"=>'代理已经通过初审，请尽快审核',"color"=>"#ff4546"),
                        ));

                    $return=$this->SentTemplateMsg($array);
                    if ($return['code']==0)
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_AUTHORIZE_USER_DETAIL." "
                            ." SET sent_status2=100 WHERE userid='".$item['userid']."'");
                        echo $item['id'].'sent_status2:success';
                    }else
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_AUTHORIZE_USER_DETAIL." "
                            ." SET sent_status2=sent_status2+1 WHERE id='".$item['id']."'");
                        if ($return['errcode']==40001)
                        {
                            $this->Reload_Access_Token();
                        }
                    }
                }

                if ($item['sent_status3']<3 && $item['auth_status']==3)
                {
                    //发送模板消息给用户
                    $array = array(
                        'touser'=>$item['openid'],
                        'url'=>WEBURL.'/?mod=weixin&v_mod=daili&_index=_store_open',
                        'template_id'=>TEMPLATE_MSG3,
                        'data'=>array(
                            "first"=>array("value"=>"恭喜您成为我们的代理"),
                            "keyword1"=>array("value"=>date("Y/m/d H/i")),
                            "keyword2"=>array("value"=>'成功通过代理申请'),
                            "remark"=>array("value"=>'您已经通过代理的申请，赶快去申请开启代理专属店铺吧！',"color"=>"#ff4546"),
                        ));
                    $return=$this->SentTemplateMsg($array);
                    if ($return['code']==0)
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_AUTHORIZE_USER_DETAIL." "
                            ." SET sent_status3=100 WHERE userid='".$item['userid']."'");
                        echo $item['id'].'sent_status3:success';
                    }else
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_AUTHORIZE_USER_DETAIL." "
                            ." SET sent_status3=sent_status3+1 WHERE id='".$item['id']."'");
                        if (isset($return['errcode']) && $return['errcode']==40001)
                        {
                            $this->Reload_Access_Token();
                        }
                    }
                }
            }

        }else
        {
            return false;
        }
    }
}
$auto=new resent_auth_apply(array());
echo $auto->$_GET['obj']();