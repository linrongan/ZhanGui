<?php
class weixin extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //首页图片
    //0轮播图  1图标
    public function GetPicture($type)
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_FIELDS." "
            ." WHERE fields_type='".$type."' AND fields_show=0 ORDER BY fields_order ASC");
    }
    //获取分类
    public function GetHomeCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE parent_id=0 AND show_status=1 ORDER BY ry_order,category_id ASC "
            ." LIMIT 8");
        return $data;
    }
    //获取产品
    public function getHomeProduct($page_size)
    {
        include 'product.php';
        $pro = new product($this->data);
        return $pro->GetProduct($page_size);
    }
}