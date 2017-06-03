<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class CartAction extends cart
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    public function ActionEditCartCount()
    {
        echo json_encode($this->EditCartCount());exit;
    }

    public function ActionSelectOneCart()
    {
        echo json_encode($this->SelectOneCart());exit;
    }

    public function ActionSelectAllCart()
    {
        echo json_encode($this->SelectAllCart());exit;
    }

    public function ActionAddCart()
    {
        echo json_encode($this->AddCart());exit;
    }

    public function EditCartCount(){
        if(!isset($this->data['cart_id']) || !is_numeric($this->data['cart_id'])){
            return array('code'=>1,'msg'=>'请选择产品');
        }
        $cart=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CART." "
            ." WHERE id='".$this->data['cart_id']."' "
            ." AND userid='".$_SESSION['userid']."'");
        if(!$cart){
            return array('code'=>1,'msg'=>'购物车没有该产品');
        }
        if(!$this->data['nums'] || empty($this->data['nums']) || $this->data['nums']<1 ||
            !is_numeric($this->data['nums'])){
            return array('code'=>1,'msg'=>'请选择数量');
        }
        if($this->data['nums']!=$cart['product_count']){
            $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET "
                ." product_count='".intval($this->data['nums'])."' "
                ." WHERE id='".$this->data['cart_id']."'");
            if($res){
                return array('code'=>0,'msg'=>'操作成功');
            }
            return array('code'=>1,'msg'=>'添加失败');
        }
        return array('code'=>1,'msg'=>'相同数量');
    }


    //全选、全不选
    public function SelectAllCart(){
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_CART." "
            ." WHERE userid='".$_SESSION['userid']."' AND select_status=1");
        if($count['total'])
        {
            $all_status = 0;
        }else{
            $all_status = 1;
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET "
            ." select_status='".$all_status."' WHERE userid='".$_SESSION['userid']."'");
        if($res){
            return array('code'=>0,'msg'=>'操作成功');
        }
        return array('code'=>1,'msg'=>'操作失败');
    }



    public function SelectOneCart()
    {
        if(!isset($this->data['cart_id']) || !is_numeric($this->data['cart_id']) ||
            $this->data['cart_id']==0){
            return array('code'=>1,'msg'=>'操作失败');
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CART." "
            ." WHERE id='".$this->data['cart_id']."' AND userid='".$_SESSION['userid']."'");
        if(!$res){
            return array('code'=>1,'msg'=>'购物车无此商品');
        }
        $select_status = $res['select_status']?0:1;
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET select_status='{$select_status}' "
            ." WHERE id='".$this->data['cart_id']."'");
        if($res){
            return array('code'=>0,'msg'=>'操作成功');
        }
        return array('code'=>1,'msg'=>'操作失败,服务器繁忙');
    }

    //删除
    public function ActionDel(){
        $sel_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) as nums FROM ".TABLE_CART." "
            ." WHERE userid='{$_SESSION['userid']}' AND select_status=1");
        if($sel_count['nums']<=0){
            echo json_encode(array('code'=>1,'msg'=>'请中需要删除的产品'));exit;
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_CART." WHERE "
            ." userid='{$_SESSION['userid']}' AND select_status=1");
        if($res){
            echo json_encode(array('code'=>0,'msg'=>'已删除'));exit;
        }
        echo json_encode(array('code'=>1,'msg'=>'删除失败'));exit;
    }


    //添加到购物车
    public function AddCart()
    {
        if(!regExp::checkNULL($this->data['product_id']))
        {
            return array('code'=>1,'msg'=>'请选择产品');
        }
        if(!regExp::checkNULL($this->data['product_count']) ||
            !regExp::is_positive_number($this->data['product_count']))
        {
            return array('code'=>1,'msg'=>'数量不正确');
        }
        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$this->data['product_id']."'");
        if(!$product)
        {
            return array('code'=>1,'msg'=>'产品不存在');
        }elseif($product['product_status']!=0)
        {
            return array('code'=>1,'msg'=>'产品已下架');
        }
        $attr = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE product_id='".$this->data['product_id']."' AND is_del=0");
        if($attr && !regExp::checkNULL($this->data['attr_id']))
        {
            return array('code'=>1,'msg'=>'请选择产品参数');
        }
        $cart = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CART." "
            ." WHERE product_id='".$this->data['product_id']."' AND "
            ." userid='".$_SESSION['userid']."' AND attr_id='".$this->data['attr_id']."'");
        $product_count = $this->data['product_count']?$this->data['product_count']:1;
        if($cart)
        {
            $count = $cart['product_count']+$product_count;
            $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CART." SET product_count='".$count."' "
                ." WHERE product_id='".$this->data['product_id']."' AND userid='".$_SESSION['userid']."' "
                ." AND attr_id='".$this->data['attr_id']."'");
        }else
        {
            $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_CART." "
                ." SET userid='".$_SESSION['userid']."',"
                ." product_id='".$this->data['product_id']."',"
                ." attr_id='".$this->data['attr_id']."',"
                ." product_count='".$product_count."',"
                ." select_status=0,"
                ." update_date='".date("Y-m-d H:i:s",time())."'");
        }
        if($res)
        {
            return array('code'=>0,'msg'=>'已添加到购物车');
        }
        return array('code'=>1,'msg'=>'加入购物车失败');
    }
    //移除购物车
    public function DelProduct()
    {
        $check = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CART." "
            ." WHERE select_status=0");
        if($check)
        {
            $row = $this->GetDBMaster()->query("DELETE FROM ".TABLE_CART." WHERE "
                ."userid='".$_SESSION['userid']."' AND select_status=0");
            if($row)
            {
                return array('code'=>0,'msg'=>'操作成功');
            }
            return array('code'=>0,'msg'=>'删除失败');
        }
        return array('code'=>1,'msg'=>'未选择删除的产品');
    }

    public function ActionDelProduct()
    {
        echo json_encode($this->DelProduct());exit;
    }
}