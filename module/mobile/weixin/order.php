<?php
class order extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //订单
    public function GetMyOrder()
    {
        $where = $canshu = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page'])){
            $curpage = $this->data['page'];
        }else{
            $curpage = 1;
        }
        $status = 0;
        if(isset($this->data['type']) && is_numeric($this->data['type']))
        {
            switch ($this->data['type'])
            {
                case 1:
                    $status = 1;
                    $where .= " AND O.order_status='".$this->data['type']."'";
                    break;
                case 2:
                    $status = 2;
                    $where .= " AND O.order_status=3";
                    break;
                case 3:
                    $status = 3;
                    $where .= " AND O.order_status=4";
                    break;
                case 4:
                    $status = 4;
                    $where .= " AND O.order_status=6";
                    break;
                case 5:
                    $status = 4;
                    $where .= " AND O.order_status=8";
                    break;
                default:
                    $status = 0;
                    break;

            }
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ORDER." "
            ." AS O WHERE O.userid='".$_SESSION['userid']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT O.*,P.expiry_date FROM ".TABLE_ORDER." "
            ." AS O LEFT JOIN ".TABLE_PAY." AS P ON O.orderid=P.orderid WHERE"
            ." O.userid='".$_SESSION['userid']."' ".$where." ORDER BY O.id DESC LIMIT "
            ." ".($curpage-1)*$page_size.",".$page_size." ");
        if(regExp::is_ajax())
        {
            $url = array(0=>'/?mod=weixin&v_mod=product&_index=_details&id=',1=>'/?mod=weixin&v_mod=group&id=');
            $Sys_Order_Status =array(-1=>"已退款",0=>"已取消",1=>"未付款",2=>"处理中",3=>"已支付",4=>'已发货',5=>'已收货',6=>'待评价',7=>'已评价',8=>"已完成");
            $li = '';
            if(!empty($data))
            {
                foreach($data as $item)
                {
                    $details = $this->GetOrderDetails($item['orderid']);
                    $li .= '<li>';
                    $li.='                <div class="porduct_hd" onclick="location.href=\'?mod=weixin&v_mod=order&_index=_view&orderid='.$item['orderid'].'\'">';
                    $li.='                 <div class="fl porduct_hd_left">';
                    $li.=                             '订单号：'.$item['orderid'];
                    $li.='                       </div>';
                    if($item['order_type'])
                    {
                        $li.=' <img src="/template/source/images/group-'.($item['order_type'] == 1 ? 2 : 1). '.png" alt="">';
                    }
                    if($item['store_id'])
                    {
                        $li.='                            <img src="/template/source/images/dl.png" alt="">';
                    }
                    $li.='                         <div class="fr cldb3652">'.$Sys_Order_Status[$item['order_status']].'</div>';
                    $li.='                         <div class="clearfix"></div>';
                    $li.='                     </div>';
                    if($details) {
                        foreach ($details as $p) {
                            $li .= '   <div class="porduct_jshao">';
                            $li .= '         <div class="fl l_porpic" onclick="location.href=\'' . $url[$item['order_type']] . $p['product_id'] . '\'">';
                            $li .= '                 <img src="' . $p['product_img'] . '">';
                            $li .= '   </div>';
                            $li .= '   <div class="fl r_porname">';
                            $li .= '         <p class="porduct_name tlie sz14r">' . $p['product_name'] . '</p>';
                            $li .= '         <div class="mtr01 sz12r">';
                            $li .= '         价格：<span class="redColor">￥' . $p['product_price'] . '</span>';
                            $li .= '         </div>';
                            $li .= '  <div class="sz12r">';
                            if ($p['product_attr_name'])
                            {
                                if (strpos($p['product_attr_name'], ';'))
                                {
                                    $arr = explode(';', $p['product_attr_name']);
                                } else {
                                    $arr[] = $p['product_attr_name'];
                                }
                                $arr = array_filter($arr);
                                for ($i = 0; $i < count($arr); $i++)
                                {
                                    $li .= ' <span class="redColor">' . $arr[$i] . '  </span>';
                                }
                            }
                            $li .= '    </div>';
                            $li .= '    </div>';
                            $li .= ' <div class="clearfix"></div>';
                            $li .= '<div class="Npricenum sz14r redColor">×' . $p['product_count'] . '</div>';
                            $li .= '</div>';
                        }
                    }
                    $li.='            <div class="select_gmai">';
                    $li.='            <div class="fl sz14r lhr06">合计：<span class="redColor">￥'.$item['order_total'].'</span></div>';
                    if($item['order_status']==1)
                    {
                        if($item['expiry_date']>time())
                        {
                            if($item['store_id']==0)
                            {
                                $li.='                     <a class="gmai_btn" href="?mod=weixin&v_mod=checkout&_index=_pay&orderid='.$item['orderid'].'">付款</a>';
                            }else{
                                $li.='                    <a class="gmai_btn" href="/?mod=weixin&v_mod=direct_checkout&_index=_pay&type=3&orderid='.$item['orderid'].'">付款</a>';
                            }
                        }
                        $li.='             <a class="gmai_btn romove_order" oid="'.$item['id'].'" href="javascript:;">删除订单</a>';
                    }elseif($item['order_status']==4)
                    {
                        $li.='               <a class="gmai_btn delivery" oid="'.$item['id'].'" href="javascript:;">确认收货</a>';
                        $li.='               <a class="gmai_btn" href="/?mod=weixin&v_mod=order&_index=_wuliu&no='.$item['wuliu_no'].'">查看物流</a>';
                    }elseif($item['order_status']==6)
                    {
                        $li.='              <a class="gmai_btn" href="?mod=weixin&v_mod=product&_index=_comment&orderid='.$item['orderid'].'">评价</a>';
                    }
                    $li.='        <div class="clearfix"></div>';
                    $li.='    </div>';
                    $li.='</li>';
                }
            }
            echo json_encode(array('data'=>$li,'status'=>$status,'pages'=>ceil($count['total']/$page_size)));exit;
        }
        return array('data'=>$data,'status'=>$status,'pages'=>ceil($count['total']/$page_size));
    }
    public function GetOrderDetails($orderid)
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_DETAIL." "
            ." WHERE orderid='".$orderid."'");
    }

    function GetViewOrder()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            redirect(NOFOUND.'&msg=error');
        }
        $order =$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." WHERE orderid='".$this->data['orderid']."' "
            ." AND userid='".$_SESSION['userid']."'");
        if(empty($order))
        {
            redirect(NOFOUND.'&msg=订单不存在');
        }
        return $order;
    }

}