<?php
class user extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //默认收货地址
    public function GetUserDefaultAddress()
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADDRESS." "
            ." WHERE userid='".$_SESSION['userid']."' AND default_select=0");
    }
    //评论列表
    public function GetCommentList()
    {
        $where = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_COMMENT." AS C LEFT JOIN ".TABLE_PRODUCT." AS P ON "
            ." C.product_id=P.product_id WHERE C.userid='".$_SESSION['userid']."'");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,P.product_name,P.product_img,"
            ." P.product_desc FROM ".TABLE_COMMENT." AS C LEFT JOIN ".TABLE_PRODUCT." AS "
            ." P ON C.product_id=P.product_id WHERE C.userid='".$_SESSION['userid']."' "
            ." ORDER BY C.id DESC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'pages'=>$count['total']/$page_size);
    }

    //我的收藏
    public function GetProductColle()
    {
        $where = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT_COLLE." "
            ." WHERE userid='".$_SESSION['userid']."' ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_PRODUCT_COLLE." WHERE "
            ."userid='".$_SESSION['userid']."' ".$where." ORDER BY id DESC LIMIT ".($page-1)*$page_size.",".$page_size."");
        return array('data'=>$data,'pages'=>$count['total']/$page_size);
    }


}