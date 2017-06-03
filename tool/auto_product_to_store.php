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
Class auto_product_to_store extends wx
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //开始操作
    function SetProductToStore()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_D_ORDER." "
            ." WHERE is_to_store=0 ORDER BY id DESC LIMIT 0,1");
        if (!empty($data))
        {
            $detail=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_D_ORDER_DETAIL.""
                ." WHERE orderid='".$data['orderid']."'");
            //获取我的所有商品id
            $product=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_STORE_PRODUCT.""
                ." WHERE userid='".$data['userid']."'");
            $store_array=array();
            if (!empty($product))
            {
                foreach($product as $item)
                {
                    $store_array[]=$item['product_id'];
                }
            }
            $this->GetDBMaster()->StartTransaction();
            foreach($detail as $item)
            {
                if (in_array($item['product_id'],$store_array))
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_STORE_PRODUCT." "
                        ." SET product_count=product_count+".$item['product_count']." "
                        ." WHERE product_id='".$item['product_id']."' AND userid='".$data['userid']."'");
                }else
                {
                    $this->GetDBMaster()->query("INSERT INTO ".TABLE_STORE_PRODUCT." (userid,product_id,product_sold,product_count,addtime,product_status)"
                        ." VALUES('".$data['userid']."','".$item['product_id']."',0,"
                        ." '".$item['product_count']."','".date("Y-m-d H:i:s")."',0)");
                }
            }
            $this->GetDBMaster()->query("UPDATE ".TABLE_D_ORDER." "
                ." SET is_to_store=1,to_store_date='".date("Y-m-d H:i:s")."' "
                ." WHERE id='".$data['id']."'");
            $this->GetDBMaster()->SubmitTransaction();
        }
    }
}

$auto=new auto_product_to_store(array());
echo $auto->$_GET['obj']();
