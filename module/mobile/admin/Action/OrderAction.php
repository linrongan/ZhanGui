<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class OrderAction extends order
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //发放门票
    function ActionSentPiao()
    {
        //效验是否可用
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_HEXIAO." "
            ." WHERE id='".$this->data['id']."' "
            ." AND get_status=0");
        if (empty($data))
        {
            return array("code"=>1,"msg"=>"已领取或找不到该信息");
        }
        //记录发放
        $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_HEXIAO." "
            ." SET get_status=1,get_status_who='".$_SESSION['admin_id']."',"
            ." get_status_date='".date("Y-m-d H:i:s")."' "
            ." WHERE id='".$this->data['id']."' "
            ." AND get_status=0");
        return array("code"=>0,"msg"=>"门票发放成功!");
    }
    //删除普通订单
    public function ActionDelOrder()
    {
        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'参数错误');
        }
        //是否存在该订单
        $data = $this->GetOneOrder($this->data['id'],TABLE_ORDER);
        if(!$data)
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_ORDER." WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
    //编辑收货人信息
    public function ActionEditAddressInfo(){
        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['shop_name'])){
            return array('code'=>1,'msg'=>'收货人必填');
        }
        if(!regExp::checkNULL($this->data['shop_phone'])){
            return array('code'=>1,'msg'=>'收货人电话必填');
        }
        if(!regExp::checkNULL($this->data['shop_address'])){
            return array('code'=>1,'msg'=>'收货地址必填');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." "
            ." SET order_ship_name='".$this->data['shop_name']."',"
            ." order_ship_phone='{$this->data['shop_phone']}',"
            ." order_ship_address='".$this->data['shop_address']."',"
            ." wuliu_com='".$this->data['logistics_name']."',"
            ." wuliu_no='".$this->data['logistics_number']."'"
            ." WHERE id = '".$this->data['id']."'");
        if($res){
            return array('code'=>0,'msg'=>'订单数据更新成功');
        }
        return array('code'=>1,'msg'=>'订单数据没有发生改变');
    }
    //编辑订单状态信息
    function EditOrderStatus()
    {

        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'参数错误');
        }
        $status = $this->GetDBSlave1()->queryrow("SELECT order_status FROM ".TABLE_ORDER." WHERE id=".$this->data['id']);
        if(!regExp::checkNULL($this->data['order_status'])||
            $this->data['order_status']<$status['order_status'])
        {
            return array('code'=>1,'msg'=>'请正确选择订单状态');
        }
        $order_status = $this->data['order_status'];
        $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET "
            ." order_status='".$order_status."' WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'订单状态已更新');
    }

}
