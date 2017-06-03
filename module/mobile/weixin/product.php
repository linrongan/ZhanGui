<?php
class product extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //产品详情
    public function GetProductDetails()
    {
        if(!regExp::checkNULL($this->data['product']))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }
        $data = $this->GetOneProduct($this->data['product']);
        if(empty($data))
        {
            redirect(NOFOUND.'&msg=参数错误');
        }elseif($data['product_status']!=0)
        {
            redirect(NOFOUND.'&msg=产品已下架');
        }
        return $data;
    }
    public function GetOneProduct($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$id."'");
    }
    //获取产品的属性
    public function GetProductAttr($product_id)
    {
        $array = array();
        $data = $this->GetDBSlave1()->queryrows("SELECT A.*,T.attr_type_id FROM "
            ." ".TABLE_ATTR." AS A LEFT JOIN ".TABLE_ATTR_TEMP." AS T ON "
            ." A.attr_temp_id=T.attr_id WHERE A.product_id='".$product_id."' "
            ." AND is_del=0 ORDER BY A.attr_price ASC");
        if($data){
            foreach($data as $item)
            {
                $array[$item['attr_type_id']]['attr_type'] = $item['attr_type_name'];
                $array[$item['attr_type_id']]['attr'][] = $item;
            }
        }
        return $array;
    }
    //产品收藏
    public function GetOneProductColle($id,$type)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM "
            ." ".TABLE_PRODUCT_COLLE." WHERE product_id='".$id."' "
            ." AND userid='".$_SESSION['userid']."' AND "
            ." product_type='".$type."'");
    }
    //产品评论
    public function GetProductComment($id)
    {
        $where = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $where .= " AND C.product_id=".$id;
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_COMMENT." "
            ." AS C LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid LEFT JOIN ".TABLE_ORDER_DETAIL." "
            ." AS OD ON C.orderid=OD.orderid AND C.product_id=OD.product_id WHERE C.product_type=0 AND "
            ." C.is_show=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,U.nickname,U.headimgurl,OD.product_name,"
            ." OD.product_attr_name FROM ".TABLE_COMMENT." AS C LEFT JOIN ".TABLE_USER." AS U ON "
            ." C.userid=U.userid LEFT JOIN ".TABLE_ORDER_DETAIL." AS OD ON C.orderid=OD.orderid AND "
            ." C.product_id=OD.product_id WHERE C.product_type=0 AND C.is_show=0 ".$where." "
            ." ORDER BY C.id ASC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        $array = array('data'=>$data,'pages'=>ceil($count['total']/$page_size));
        if(regExp::is_ajax())
        {
            echo json_encode($array);exit;
        }
        return $array;
    }
    //订单详情
    public function GetOrderDetails()
    {
        if(!regExp::checkNULL($this->data['orderid']))
        {
            redirect(NOFOUND);
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." "
            ." WHERE orderid ='".$this->data['orderid']."' AND userid='".$_SESSION['userid']."'");
        if(!$order)
        {
            redirect(NOFOUND);
        }
        $details = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_DETAIL." "
            ." WHERE orderid='".$this->data['orderid']."'");
        return array('order'=>$order,'details'=>$details);
    }
    //产品列表
    public function GetProduct($page_size=0)
    {
        $where = $param = $order = '';
        if(isset($this->data['page_size']) && !empty($this->data['page_size']))
        {
            $page_size = $this->data['page_size'];
        }else{
            if($page_size==0)
            {
                $page_size = 4;
            }
        }
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $start = ($page-1)*$page_size;
        $title  = false;
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $category = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." "
                ." WHERE category_id='".$this->data['category']."'");
            if($category)
            {
                $where .= " AND P.category_id='".$this->data['category']."'";
                $title = $category['category_name'];
                $param .= "&category=".$this->data['category'];
            }
        }

        $order = ' ORDER BY P.product_sort,P.product_id ';

        if(isset($this->data['search']) && !empty($this->data['search']))
        {
            $where .= " AND P.product_name LIKE '%".$this->data['search']."%'  OR P.product_desc LIKE '%".$this->data['search']."%'";
            $param .= "&search=".$this->data['search'];
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_PRODUCT." AS P WHERE P.product_status=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.product_id,P.product_name,P.product_desc,P.product_img,"
            ."  P.product_price FROM ".TABLE_PRODUCT." AS P"
            ."  WHERE P.product_status=0 "
            ." ".$where." ".$order." LIMIT ".$start.",".$page_size."");
        $array = array(
            'data'=>$data,
            'pages'=>ceil($count['total']/$page_size),
            'title'=>$title,
            'param'=>$param,
            'sql'=>$start.'|'.$page_size
        );
        if(regExp::is_ajax())
        {
            echo json_encode($array);exit;
        }
        return $array;
    }
}