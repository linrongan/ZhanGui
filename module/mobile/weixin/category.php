<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class category extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //获取分类
    public function GetCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE 1 ORDER BY category_id,ry_order ASC");
        $category = array();
        foreach($data as $item)
        {
            $category[$item['parent_id']][$item['category_id']] = $item;
        }
        return array('category'=>$category,'data'=>$data);
    }

    //获取指定分类信息
    function GetTheCategory($category_id=0)
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE show_status=0 AND category_id='".$category_id."'");
        if (empty($data))
        {
            redirect(NOFOUND.'&msg=找不到该商品分类');
        }
        return $data;
    }
}

