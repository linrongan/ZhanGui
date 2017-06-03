<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class search extends common
{
    function __construct($data)
    {
        $this->data = $data;
    }



    //搜索推荐
    public function GetSearchText($page_size)
    {
        include 'product.php';
        $pro = new product($this->data);
        return $pro->GetProduct($page_size);
    }
}