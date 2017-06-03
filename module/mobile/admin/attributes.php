<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class attributes extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //产品属性类型列表
    public function GetAttributesList()
    {
        $where = $canshu = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_ATTR_TYPE." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ."WHERE 1 ".$where." ORDER BY attr_type_id DESC LIMIT ".($curpage-1)*$page_size.","
            ." ".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'page_size'=>$page_size,'canshu'=>$canshu,'curpage'=>$curpage);
    }


    //取一条产品属性类型
    public function GetAttrType($attr_type)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$attr_type."'");
    }

    //获取产品属性类型详情
    public function GetAttrTypeDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetAttrType($this->data['id']);
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        return $data;
    }


    //产品属性模板列表
    public function GetAttrValueList()
    {
        $where = $canshu  = '';
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_ATTR_TEMP." AS TE "
            ."WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT TE.*,T.attr_type_name FROM ".TABLE_ATTR_TEMP." AS "
            ."TE LEFT JOIN ".TABLE_ATTR_TYPE." AS T ON TE.attr_type_id=T.attr_type_id WHERE 1 ".$where." "
            ."ORDER BY TE.attr_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'total'=>$count['total'],'page_size'=>$page_size,'canshu'=>$canshu,'curpage'=>$curpage);
    }


    //全部属性类别
    public function GetAllAttrType()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR_TYPE." "
            ."WHERE 1 ORDER BY attr_sort DESC");
        return $data;
    }

    //属性模板取一条
    public function GetOneAttrValue($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR_TEMP." "
            ." WHERE attr_id='".$id."'");
    }

    //属性模板详情
    public function GetAttrValueDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data = $this->GetOneAttrValue($this->data['id']);
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        return $data;
    }
}