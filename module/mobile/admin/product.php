<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR . '/inc/upload.class.php';
Class product extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //商品列表
    function GetProductList($product_status=0)
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND P.product_name LIKE '%".$this->data['product_name']."%'";
            $canshu .= "&product_name=".$this->data['product_name'];
        }
        if($product_status==1)
        {
            $where .= " AND P.product_status = '".$product_status."'";
        }
        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_CATEGORY." AS C ON P.category_id=C.category_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT P.*,C.category_name FROM ".TABLE_PRODUCT." AS P "
            ." LEFT JOIN ".TABLE_CATEGORY." AS C ON P.category_id=C.category_id "
            ." WHERE 1 ".$where." ORDER BY P.category_id,P.product_sort,P.product_id DESC LIMIT ".($curpage-1)*$page_size.",".$page_size."");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }


    //产品分类
    public function GetCategory()
    {
        require_once 'category.php';
        $category = new category($this->data);
        return $category->GetCategory();
    }



    //取一条产品
    public function GetOneProduct($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$product_id."'");
    }
    //
    public function GetThisProduct($product_id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT P.* FROM ".TABLE_PRODUCT." AS P "
            ." WHERE P.product_id='".$product_id."'");
    }
    //产品详情
    public function GetProductDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $product = $this->GetThisProduct($this->data['id']);
        if(!$product)
        {
            redirect(ADMIN_ERROR);
        }
        return $product;
    }

    //产品属性列表
    public function GetProductAttr()
    {
        $product = $this->GetProductDetails();
        $attr = $this->GetProductAttrList($product['product_id']);
        return array('product'=>$product,'attr'=>$attr);
    }


    //产品属性
    public function GetProductAttrValue()
    {
        return $this->GetDBSlave1()->queryrows("SELECT TE.attr_name,TE.attr_id,TE.attr_type_id,T.attr_type_name FROM ".TABLE_ATTR_TEMP." "
            ." AS TE LEFT JOIN ".TABLE_ATTR_TYPE." AS T ON TE.attr_type_id=T.attr_type_id "
            ." ORDER BY TE.attr_type_id ASC");
    }

    //产品属性列表
    public function GetProductAttrList($product_id)
    {
        $attr = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE product_id='".$product_id."' AND is_del=0 "
            ." ORDER BY attr_type_name ASC");
        return $attr;
    }
    //获取产品评论列表
    public function GetProductComment()
    {
        $where=$canshu="";
        $page_size = 10;
        if(isset($this->data['curpage']) && !empty($this->data['curpage']))
        {
            $curpage = $this->data['curpage'];
        }else{
            $curpage = 1;
        }
        if(isset($this->data['product_name']) && !empty($this->data['product_name']))
        {
            $where .= " AND P.product_name LIKE '%".$this->data['product_name']."%'";
            $canshu .= "&product_name=".$this->data['product_name'];
        }

        $count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS total FROM ".TABLE_COMMENT." AS C "
            ." LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON C.product_id=P.product_id "
            ." WHERE 1 ".$where." ");
        $data = $this->GetDBSlave1()->queryrows("SELECT C.*,U.nickname,U.headimgurl,P.product_name,P.product_img FROM "
            .TABLE_COMMENT." AS C"
            ." LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid "
            ." LEFT JOIN ".TABLE_PRODUCT." AS P ON C.product_id=P.product_id "
            ." WHERE 1".$where." ORDER BY C.addtime DESC LIMIT ".($curpage-1)*$page_size.",".$page_size."");
        return array("data"=>$data,"total"=>$count['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }

    //产品评论详情
    public function GetProductCommentDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $comment = $this->GetDBSlave1()->queryrow("SELECT C.*,U.nickname FROM ".TABLE_COMMENT." AS C "
            ." LEFT JOIN ".TABLE_USER." AS U ON C.userid=U.userid "
            ." WHERE C.id='".$this->data['id']."'");
        if(!$comment)
        {
            redirect(ADMIN_ERROR);
        }
        return $comment;
    }

}
?>