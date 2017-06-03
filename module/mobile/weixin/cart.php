<?php
class cart extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    public function GetCart()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,P.product_name,P.product_img,"
            ."IFNULL(C.product_count*(P.product_price+A.attr_price),C.product_count*P.product_price) AS total,"
            ."P.product_desc,P.product_price FROM ".TABLE_CART." AS C "
            ."LEFT JOIN ".TABLE_PRODUCT." AS P ON C.product_id=P.product_id "
            ."LEFT JOIN ".TABLE_ATTR." AS A ON C.attr_id=A.id "
            ."WHERE C.userid='".$_SESSION['userid']."' "
            ."ORDER BY C.id ASC");
        return $data;
    }
    //产品属性
    public function GetProductAttr($attr_id)
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE id IN (".$attr_id.")");
    }

}