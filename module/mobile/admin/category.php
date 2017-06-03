<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class category extends comm
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    public function GetCategory()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CATEGORY." WHERE 1=1 "
            ." ORDER BY ry_order ASC,category_id DESC");
        $array = array();
        $array1 = array();
        $i = 0;
        foreach($data as $item){
            $array[$item['parent_id']][$i] = $item;
            $array[$item['parent_id']][$i] = $item;
            $array[$item['parent_id']][$i] = $item;
            $array[$item['parent_id']][$i] = $item;
            $array[$item['parent_id']][$i] = $item;
            $array1[$item['category_id']] = $item['category_name'];
            $i++;
        }
        return array('category'=>$array,'type'=>$array1);
    }

    //分类详情
    public function GetCategoryDetail(){
        if(!regExp::checkNULL($this->data['id'])){
            redirect(NOFOUND);
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." WHERE "
            ." category_id='".$this->data['id']."'");
        if(!$data){
            redirect(NOFOUND);
        }
        $str = 0;
        if($data['parent_id']==0){
            $res = $this->GetDBSlave1()->queryrow("SELECT count(*) AS total FROM ".TABLE_CATEGORY." "
                ." WHERE parent_id='{$this->data['id']}'");
            if($res['total']>0){
                $str = 1;
            }
        }
        return array('data'=>$data,'str'=>$str);
    }



    public function GetCategoryBanner()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            exit('404');
        }
        $category = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." WHERE category_id='".$this->data['id']."'");
        if(empty($category))
        {
            exit('404');
        }else if($category['parent_id']){
            exit('非一级分类');
        }
        $result = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_FIELDS." WHERE fields_cid='".$this->data['id']."' "
            ." AND fields_type=2");
        return array('data'=>$result,'category'=>$category);
    }


    //分类轮播图详情
    function GetCategoryBannerDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            exit('404');
        }
        $result = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_FIELDS." WHERE id='".$this->data['id']."' "
            ." AND fields_type=2");
        if(empty($result))
        {
            exit('404');

        }
        return $result;
    }
}