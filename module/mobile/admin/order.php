<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class order extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //订单列表
    public function GetOrderList(){
        $where = $canshu ='';
        $page_size=10;
        $order = 'ORDER BY O.id DESC';
        if(isset($this->data['order_status']) && is_numeric($this->data['order_status'])){
            $where .= " AND O.order_status ='".$this->data['order_status']."'";
            $canshu = "&order_status=".$this->data['order_status'];
        }
        if(isset($this->data['orderid']) && !empty($this->data['orderid']) && is_numeric($this->data['orderid'])){
            $where .= " AND O.orderid LIKE '%".$this->data['orderid']."%'";
            $canshu = "&orderid=".$this->data['orderid'];
        }
        if(isset($this->data['group_id']) && !empty($this->data['group_id']) && is_numeric($this->data['group_id'])){
            $where .= " AND O.group_id='".$this->data['group_id']."'";
            $canshu = "&group_id=".$this->data['group_id'];
        }
        if ((!isset($_REQUEST['curpage'])) or (!is_numeric($_REQUEST['curpage'])) or ($_REQUEST['curpage']<1))
        {
            $curpage=1;
        }
        else
        {
            $curpage=intval($_REQUEST['curpage']);
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_ORDER." AS O WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT O.*,U.nickname,U.headimgurl FROM "
            ." ".TABLE_ORDER." AS O LEFT JOIN ".TABLE_USER." AS U ON O.userid=U.userid "
            ." WHERE 1 ".$where." ".$order." LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'curpage'=>$curpage,'page_size'=>$page_size,'canshu'=>$canshu);
    }

    //普通订单
    public function GetOrderItem($orderid){
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_DETAIL." WHERE "
            ." orderid='".$orderid."'");
        return $data;
    }


    //获取订单详情
    public function GetOrderDetail(){
        if(!isset($this->data['id']) || empty($this->data['id']) || !is_numeric($this->data['id'])){
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT O.*,U.nickname FROM ".TABLE_ORDER." AS O LEFT JOIN "
            ." ".TABLE_USER." AS U ON O.userid=U.userid WHERE O.id='{$this->data['id']}'");
        if(empty($data)){
            redirect(ADMIN_ERROR);
        }
        return $data;
    }

    //获取一条订单
    public function  GetOneOrder($id,$table)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".$table." WHERE id=".$id);

    }
}
?>