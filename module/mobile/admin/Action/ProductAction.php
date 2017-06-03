<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class ProductAction extends product
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //添加产品
    public function ActionNewProduct()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['product_name']))
        {
            return array('msg'=>'请输入产品名');
        }
        if(!regExp::checkNULL($this->data['category_id']))
        {
            return array('msg'=>'请选择产品分类');
        }
        if(!regExp::checkNULL($this->data['product_price']))
        {
            return array('msg'=>'请输入产品售价');
        }
        $category = $this->GetDBSlave1()->queryrow("SELECT category_name FROM ".TABLE_CATEGORY." "
            ." WHERE category_id='".$this->data['category_id']."'");
        if(!$category)
        {
            return array('msg'=>'无此分类');
        }
        $parent = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE parent_id='".$this->data['category_id']."'");
        if($parent)
        {
            return array('msg'=>'请选择最底层分类');
        }
        if(isset($this->data['product_details_img'])
            && is_array($this->data['product_details_img'])
            && count($this->data['product_details_img'])>0)
        {
            $product_details_img = serialize($this->data['product_details_img']);
        }else{
            $product_details_img = '';
        }


        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT." "
            ."(category_id,category_name,product_name,product_desc,"
            ."product_price,product_fake_price,freight,reminder,product_img,"
            ."product_details_img,product_text,product_param,is_tuijian,product_sort,product_status)"
            ."VALUES('".$this->data['category_id']."',"
            ."'".$category['category_name']."',"
            ."'".$this->data['product_name']."',"
            ."'".$this->data['product_desc']."',"
            ."'".$this->data['product_price']."',"
            ."'".$this->data['product_fake_price']."',"
            ."'".$this->data['freight']."',"
            ."'".$this->data['reminder']."',"
            ."'".$this->data['product_img']."',"
            ."'".$product_details_img."',"
            ."'".$this->data['product_text']."',"
            ."'".$this->data['product_param']."',"
            ."'".$this->data['is_tuijian']."',"
            ."'".$this->data['product_sort']."',1)");
        if($id)
        {
            return array('msg'=>'新增成功');
        }
        return array('msg'=>'新增失败');
    }

    //编辑商品
    public function ActionEditProduct()
    {
        if(!isset($this->data['submit'])){
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $product = $this->GetThisProduct($this->data['id']);
        if(!$product)
        {
            return array('msg'=>'产品已被删除');
        }
        if(!regExp::checkNULL($this->data['product_name']))
        {
            return array('msg'=>'请输入产品名');
        }

        if(!regExp::checkNULL($this->data['category_id']))
        {
            return array('msg'=>'请选择产品分类');
        }
        if(!regExp::checkNULL($this->data['product_price']))
        {
            return array('msg'=>'请输入产品售价');
        }
        $category = $this->GetDBSlave1()->queryrow("SELECT category_name FROM ".TABLE_CATEGORY." "
            ." WHERE category_id='".$this->data['category_id']."'");
        if(!$category)
        {
            return array('msg'=>'无此分类');
        }
        $parent = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE parent_id='".$this->data['category_id']."'");
        if($parent)
        {
            return array('msg'=>'请选择最底层分类');
        }
        if(isset($this->data['product_details_img'])
            && is_array($this->data['product_details_img'])
            && count($this->data['product_details_img'])>0)
        {
            $product_details_img = serialize($this->data['product_details_img']);
        }else{
            $product_details_img = '';
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
            ."category_id='".$this->data['category_id']."',"
            ."category_name='".$category['category_name']."',"
            ."product_name='".$this->data['product_name']."',"
            ."product_desc='".$this->data['product_desc']."',"
            ."product_price='".$this->data['product_price']."',"
            ."product_fake_price='".$this->data['product_fake_price']."',"
            ."freight='".$this->data['freight']."',"
            ."reminder='".$this->data['reminder']."',"
            ."product_img='".$this->data['product_img']."',"
            ."product_details_img='".$product_details_img."',"
            ."product_text='".$this->data['product_text']."',"
            ."product_param='".$this->data['product_param']."',"
            ."is_tuijian='".$this->data['is_tuijian']."',"
            ."product_sort='".$this->data['product_sort']."',"
            ."product_status='".$this->data['product_status']."' "
            ."WHERE product_id='".$this->data['id']."'");
        return array('msg'=>'编辑成功');
    }
    //删除商品
    function ActionDelProduct()
    {
        $product = $this->GetThisProduct($this->data['id']);
        if(!$product){
            redirect(ADMIN_ERROR);
        }

        $this->GetDBMaster()->query("DELETE FROM ".TABLE_PRODUCT." "
            ." WHERE product_id='".$this->data['id']."'");
        return array("code"=>0,"msg"=>"操作成功!");
    }


    //新增产品属性
    public function ActionNewProductAttr()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['product']))
        {
            return array('msg'=>'产品参数错误');
        }
        if(!regExp::checkNULL($this->data['attr_temp_id']))
        {
            return array('msg'=>'请选择属性');
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT AT.attr_name,A.attr_type_name FROM "
            ." ".TABLE_ATTR_TEMP." AS AT LEFT JOIN ".TABLE_ATTR_TYPE." AS A "
            ." ON AT.attr_type_id=A.attr_type_id WHERE AT.attr_id='".$this->data['attr_temp_id']."'");
        if(!$res)
        {
            return array('msg'=>'属性不存在或已删除');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ATTR." "
            ."(product_id,attr_temp_id,attr_type_name,attr_temp_name,attr_price,"
            ."product_attr_sort) VALUES('".$this->data['product']."',"
            ."'".$this->data['attr_temp_id']."','".$res['attr_type_name']."',"
            ."'".$res['attr_name']."','".$this->data['attr_price']."',"
            ."'".$this->data['product_attr_sort']."')");
        if($res)
        {
            redirect('/?mod=admin&v_mod=product&_index=_attr_list&id='.$this->data['product']);
        }
        return array('msg'=>'添加失败');
    }

    //删除属性
    public function ActionDelProductAttr()
    {
        if(!regExp::checkNULL($this->data['product']) ||
            !regExp::checkNULL($this->data['id']))
        {
            return array('msg'=>'参数错误');
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE id='".$this->data['id']."' AND product_id='".$this->data['product']."' "
            ." AND is_del=0");
        if(!$res)
        {
            return false;
        }
        $row = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR." SET is_del=1 WHERE id='".$this->data['id']."'");
        redirect('/?mod=admin&v_mod=product&_index=_attr_list&id='.$this->data['product']);
    }

    //编辑产品评论
    function ActionEditProductComment()
    {
        if(!regExp::checkNULL($this->data['is_show']) ||
            !regExp::checkNULL($this->data['id']))
        {
            return array('msg'=>'参数错误');
        }
        $comment = $this->GetProductCommentDetails();
        $this->GetDBMaster()->query("UPDATE ".TABLE_COMMENT." SET is_show='".$this->data['is_show']."'"
            ." WHERE id='".$this->data['id']."'");
        //redirect('/?mod=admin&v_mod=product&_index=comment_list&id='.$this->data['id']);
        return array('msg'=>'编辑成功');
    }
    //删除评论
    function ActionDelComment()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array("code"=>1,'msg'=>'参数错误');
        }
        $comment = $this->GetProductCommentDetails();
        $id = $this->GetDBMaster()->query("DELETE FROM ".TABLE_COMMENT." "
            ." WHERE id='".$this->data['id']."'");
        if(!empty($id))
        {
            return array("code"=>0,'msg'=>'已删除');
        }
        return array("code"=>1,'msg'=>'删除失败');

    }


}
