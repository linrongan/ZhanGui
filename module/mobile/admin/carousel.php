<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class carousel extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //轮播图列表
    public function GetCarouselList()
    {
        $where = $canshu = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $count =$this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_FIELDS." "
            ." WHERE fields_type=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_FIELDS." WHERE "
            ."fields_type=0 ".$where."  ORDER BY id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'page_size'=>$page_size,'canshu'=>$canshu,'curpage'=>$curpage);
    }


    //取一条数据
    public function GetOneCarousel($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_FIELDS." WHERE id='".$id."' "
            ." AND fields_type=0");
    }


    //编辑
    public function GetSetCarousel()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetOneCarousel($this->data['id']);
        if($data)
        {
            return $data;
        }
        redirect(ADMIN_ERROR);
    }



}