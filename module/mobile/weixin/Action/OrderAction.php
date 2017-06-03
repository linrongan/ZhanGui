<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

class OrderAction extends order
{
    function __construct($data)
    {
        $this->data = $data;
    }

    public function Cpanelorder()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,',msg'=>'未知订单');
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." "
            ." WHERE id='".$this->data['id']."' AND userid='".$_SESSION['userid']."'");
        if(!$order)
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }elseif($order['order_status']!=1){
            return array('code'=>1,'msg'=>'非处理状态无法取消');
        }
        $this->GetDBMaster()->StartTransaction();
        $res1 = $this->GetDBMaster()->query("DELETE FROM ".TABLE_ORDER." "
            ." WHERE id='".$this->data['id']."' AND userid='".$_SESSION['userid']."'");
        $res2 = $this->GetDBMaster()->query("DELETE FROM ".TABLE_ORDER_DETAIL." "
            ." WHERE orderid='".$order['orderid']."' AND userid='".$_SESSION['userid']."'");
        if($res1 && $res2)
        {
            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'已取消');
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'取消失败，请稍后再试');
    }
    public function ActionCpanelorder()
    {
        echo json_encode($this->Cpanelorder());exit;
    }

    //收货
    public function DeliveryOrder()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,',msg'=>'未知订单');
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." "
            ." WHERE id='".$this->data['id']."' AND userid='".$_SESSION['userid']."'");
        if(!$order)
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }elseif($order['order_status']!=4)
        {
            return array('code'=>1,'msg'=>'订单无法进行收货操作');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET "
            ." order_status=6 WHERE id='".$this->data['id']."' "
            ." AND userid='".$_SESSION['userid']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'订单状态已更新');
        }
        return array('code'=>1,'msg'=>'订单收货操作失败');
    }

    public function ActionDeliveryOrder()
    {
        echo json_encode($this->DeliveryOrder());exit;
    }
}