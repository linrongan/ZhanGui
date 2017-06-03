<?php
class checkout extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //订单列表
    public function GetCartData()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT C.id,C.product_count,"
            ."IFNULL(C.product_count*(P.product_price+A.attr_price),C.product_count*P.product_price) AS total,"
            ."C.select_status,C.attr_id,C.product_id,"
            ."P.product_name,P.product_img,P.product_desc,P.product_price,P.product_status "
            ."FROM ".TABLE_CART." AS C "
            ."LEFT JOIN ".TABLE_PRODUCT." AS P ON C.product_id=P.product_id "
            ."LEFT JOIN ".TABLE_ATTR." AS A ON C.attr_id=A.id "
            ."WHERE C.userid='".$_SESSION['userid']."' "
            ."AND select_status=0 ORDER BY C.id ASC");
        return $data;
    }

    //收货地址
    public function GetShopAddress()
    {
        require_once 'address.php';
        $address = new  address($this->data);
        return $address->GetUserAddress();
    }
    //获取订单信息
    function GetTheOrder()
    {
        $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." "
            ." WHERE orderid='".$this->data['orderid']."' "
            ." AND userid='".$_SESSION['userid']."'");
        if(empty($order))
        {
            return array('code'=>1,'msg'=>'订单没有找到');
        }
        return array('code'=>0,'data'=>$order);
    }
    //订单支付
    public function GetUserPayOrder()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            return array('code'=>1,'msg'=>'订单参数错误');
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." WHERE orderid='".$this->data['orderid']."' "
            ." AND userid='".$_SESSION['userid']."'");
        if(empty($order))
        {
            return array('code'=>1,'msg'=>'订单没有找到');
        }
        return array('code'=>0,'data'=>$order);
    }
}