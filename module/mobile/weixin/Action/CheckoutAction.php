<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class CheckoutAction extends checkout
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    public function ActionNewOrder()
    {
        echo json_encode($this->NewOrder());exit;
    }

    public function NewOrder()
    {

        $data = $this->GetCartData();
        if(empty($data))
        {
            return array('code'=>1,'msg'=>'购物车是空的!');
        }

        $address = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADDRESS." "
            ." WHERE userid='".$_SESSION['userid']."' AND default_select=0");
        if(!$address)
        {
            return array('code'=>1,'msg'=>'无默认收货地址');
        }
        $attr_id = '';
        $notice_product = '';
        $arr = array();
        $product_total = 0;
        $product_count = 0;
        foreach($data as $item)
        {
            $product_total += $item['total'];
            $product_count += $item['product_count'];
            if($item['product_status']==1)
            {
                if(!in_array($item['product_id'],$arr))
                {
                    $notice_product .= $item['product_name'].'已下架'.',';
                }
                $arr[] = $item['product_id'];
            }
            if(!empty($item['attr_id']))
            {
                $attr_id .= $item['attr_id'].',';
            }
        }
        if($notice_product)
        {
            return array('code'=>1,'msg'=>rtrim($notice_product,','));
        }
        $attr_array = array();
        if($attr_id)
        {
            $check_attr = $this->GetDBSlave1()->queryrows("SELECT A.*,P.product_name  FROM ".TABLE_ATTR." AS A "
                ."LEFT JOIN ".TABLE_PRODUCT." AS P ON A.product_id=P.product_id WHERE A.id IN (".rtrim($attr_id,',').")");
            $notice_attr = '';
            foreach($check_attr as $item)
            {
                if($item['is_del']==1)
                {
                    $notice_attr.=$item['product_name'].$item['attr_type_name'].$item['attr_temp_name'].'已下架'.',';
                }
                $attr_array[$item['product_id']][$item['id']] = $item;
            }
            if($notice_attr)
            {
                return array('code'=>1,'msg'=>rtrim($notice_attr,','));
            }
        }
        $orderid = $this->OrderMakeOrderId();
        $fee = $this->GetShipFee($product_total);
        $expiry_date = time()+3600*24*3;
        $money_total = $product_total+$fee;
        $date = date("Y-m-d H:i:s",time());
        $status = 1;

        $this->GetDBMaster()->StartTransaction();
        $order_detail = array();


        $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ORDER." (orderid,userid,order_total,order_pro_money,"
            ."order_ship_name,order_ship_phone,order_ship_sheng,order_ship_shi,order_ship_qu,order_ship_address,"
            ."order_img,order_addtime,order_status,liuyan,order_ship_fee,order_pro_count,expiry_date) VALUES('".$orderid."','".$_SESSION['userid']."',"
            ."'".$money_total."','".$product_total."','".$address['shop_name']."','".$address['shop_phone']."',"
            ."'".$address['provice_name']."','".$address['city_name']."','".$address['area_name']."','".$address['address']."',"
            ."'".$data[0]['product_img']."','".$date."','".$status."','".$this->data['liuyan']."','".$fee."','".$product_count."',"
            ."'".$expiry_date."')");
        foreach($data as $item)
        {
            $product_attr_name = '';
            if($item['attr_id'])
            {
                if(strpos($item['attr_id'],','))
                {
                    $str = explode(',',$item['attr_id']);
                    for($i=0;$i<count($str);$i++)
                    {
                        $product_attr_name .= $attr_array[$item['product_id']][$str[$i]]['attr_type_name'].
                            ':'.$attr_array[$item['product_id']][$str[$i]]['attr_temp_name'].';';
                    }
                }else{
                    $str = $item['attr_id'];
                    $product_attr_name .= $attr_array[$item['product_id']][$str]['attr_type_name'].
                        ':'.$attr_array[$item['product_id']][$str]['attr_temp_name'].';';
                }
                //var_dump($product_attr_name);exit;

                $product_attr_name = trim($product_attr_name,',');
                $product_attr_name = rtrim($product_attr_name,';');
            }

            $order_detail[] = $this->GetDBMaster()->query("INSERT INTO ".TABLE_ORDER_DETAIL."(orderid,product_id,"
                ."product_count,product_name,product_price,product_sum_price,userid,product_img,addtime,"
                ."product_attr_name,product_attr_id) VALUES('".$orderid."','".$item['product_id']."',"
                ."'".$item['product_count']."','".addslashes($item['product_name'])."','".$item['product_price']."',"
                ."'".$item['total']."','".$_SESSION['userid']."','".$item['product_img']."','".$date."',"
                ."'".$product_attr_name."','".$item['attr_id']."')");
        }

        //订单3天有效
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PAY."(orderid,userid,"
            ."expiry_date,addtime,pay_status,money_total) VALUES('".$orderid."','".$_SESSION['userid']."',"
            ."'".$expiry_date."','".$date."','".($status==3?3:0)."','".$money_total."') ");

        if($status==3)
        {
            $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET pay_money='".$money_total."',"
                ." pay_datetime='".date("Y-m-d H:i:s",time())."' WHERE orderid='".$orderid."'");
            $is_pay = 0;
        }else{
            $is_pay = 1;
        }
        if( $id && count($order_detail)==count($data) && $res)
        {
            $this->GetDBMaster()->SubmitTransaction();
            $this->GetDBMaster()->query("DELETE FROM ".TABLE_CART." WHERE select_status=0 AND userid='".$_SESSION['userid']."'");
            return array('code'=>0,'msg'=>'订单提交成功','orderid'=>$orderid,'is_pay'=>$is_pay);
        }else
        {
            $this->GetDBMaster()->RollbackTransaction();
            return array('code'=>1,'msg'=>'订单提交失败');
        }
    }

    //生成订单号
    protected function OrderMakeOrderId()
    {
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0',STR_PAD_LEFT);
    }

}