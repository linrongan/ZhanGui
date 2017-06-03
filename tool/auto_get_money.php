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
Class auto_get_money extends wx
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //查找需要返佣的人
    function GetGainsPeople()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_D_ORDER." "
            ." WHERE gains_status=0 "
            ." AND store_id=0 "
            ." AND order_status=3"
            ." ORDER BY id ASC LIMIT 0,1");
        if (!empty($data))
        {
            $x=0;
            $userid=$data['userid'];
            $this->GetDBMaster()->StartTransaction();
            do
            {
                $userid=$this->findparent($userid,$data['orderid']);
                $x++;
            }while ($x<=8 || $userid>0);
            if ($x>0)
            {
                $this->GetDBMaster()->query("UPDATE ".TABLE_D_ORDER." SET gains_status=1 WHERE id='".$data['id']."'");
                $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GAINS." SET start_status=1 WHERE orderid='".$data['orderid']."'");
                $this->GetDBMaster()->SubmitTransaction();
            }
        }
    }

    private function findparent($userid=0,$orderid=0)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT parent_id FROM ".TABLE_AUTHORIZE_USER_DETAIL." "
            ." WHERE auth_status=3 "
            ." AND userid='".$userid."'");
        if (!empty($data['parent_id']))
        {
            //插入
            $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ORDER_GAINS."(orderid,userid,from_userid,gains_status,addtime)"
                ."VALUES('".$orderid."','".$data['parent_id']."','".$userid."',0,'".date("Y-m-d H:i:s")."')");
            echo 'user('.$data['parent_id'].'):success|';
            return $data['parent_id'];
        }
        return 0;
    }


    //返佣计算正式开始
    function StartGainsAction()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_D_ORDER." "
            ." WHERE gains_status=1 "
            ." ORDER BY id ASC LIMIT 0,1");
        if (!empty($data))
        {
            //找出需要返佣的用户
            $user=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_GAINS." "
                ." WHERE orderid='".$data['orderid']."' AND gains_status=0");
            if (!empty($user))
            {

                $this->GetDBMaster()->StartTransaction();
                $detail=$this->GetDBSlave1()->queryrows("SELECT D.*,P.product_price,P.json_price FROM ".TABLE_D_ORDER_DETAIL." AS D "
                    ." LEFT JOIN ".TABLE_PRODUCT." AS P ON D.product_id=P.product_id"
                    ." WHERE P.product_type=0 AND D.orderid='".$data['orderid']."'");
                //获取所有用户的级别关系
                $user_level_array[$data['userid']]=$this->GetDailiLevel($data['userid']);
                foreach($user as $item)
                {
                    $user_level_array[$item['userid']]=$this->GetDailiLevel($item['userid']);
                }
                foreach($user as $item)
                {
                    $total=0;
                    foreach($detail as $p)
                    {
                        $last=$this->GetRealPrice($p['product_price'],$user_level_array[$item['from_userid']],$p['json_price'],$p['product_id']);
                        $top=$this->GetRealPrice($p['product_price'],$user_level_array[$item['userid']],$p['json_price'],$p['product_id']);
                        $sub_total=(($last-$top)*$p['product_count']);
                        if ($sub_total>0)
                        {
                            $total+=$sub_total;
                        }
                    }
                    echo 'user:('.$item['userid'].'):￥:'.$total;
                    if($total>0)
                    {
                        $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GAINS." SET total='".$total."',start_status=2 "
                            ." WHERE orderid='".$data['orderid']."' "
                            ." AND userid='".$item['userid']."'");
                    }
                }
                $this->GetDBMaster()->query("UPDATE ".TABLE_D_ORDER." "
                    ." SET gains_status=2 "
                    ." WHERE id='".$data['id']."'");
                $this->GetDBMaster()->SubmitTransaction();
            }
        }

    }
}

$auto=new auto_get_money(array());
echo $auto->$_GET['obj']();
