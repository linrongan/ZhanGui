<?php
class classify extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //获取分类
    public function GetCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE parent_id=0 ORDER BY ry_order,category_id ASC "
            ." LIMIT 8");
        return $data;
    }
    //获取分类下的产品
    private  function getCategoryProduct($category=1)
    {
        $where = '';
        $page_size = 10;
        if(isset($this->data['page']) && !empty($this->data['page']))
        {
            $page = $this->data['page'];
        }else{
            $page = 1;
        }
        $title  = false;
        if(isset($this->data['category']) && !empty($this->data['category']))
        {
            $category = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." "
                ." WHERE category_id='".$this->data['category']."'");
            if($category)
            {
                $where .= " AND category_id='".$this->data['category']."'";
                $title = $category['category_name'];
            }
        }
        if(isset($this->data['search']) && !empty($this->data['search']))
        {
            $where .= " AND product_name LIKE '%".$this->data['search']."%' AND product_type<5";
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM "
            ." ".TABLE_PRODUCT." WHERE product_status=0 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM "
            ." ".TABLE_PRODUCT." WHERE product_status=0 ".$where." ORDER BY product_id "
            ." DESC LIMIT ".($page-1)*$page_size.",".$page_size." ");
        return array('data'=>$data,'pages'=>$count['total']/$page_size,'title'=>$title);
    }
    //获取分类详情
    public function GetCategoryDetails($id,$page_size)
    {
        include 'product.php';
        $pro = new product($this->data);
        $products = $pro->GetProduct($page_size);
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE category_id = '".$id."'");
        //$products = $this->getCategoryProduct($id);
        return array('category'=>$data,'products'=>$products);
    }
}