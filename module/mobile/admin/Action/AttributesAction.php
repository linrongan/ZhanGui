<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class AttributesAction extends attributes
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //新增产品属性类别
    public function ActionNewAttrType()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['attr_type_name']))
        {
            return array('msg'=>'请输入属性内容');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ATTR_TYPE." "
            ." SET attr_type_name='".$this->data['attr_type_name']."',"
            ." attr_sort='".$this->data['attr_sort']."'");
        if($res)
        {
            return array('msg'=>'新增成功');
        }
        return array('msg'=>'新增失败');
    }

    public function ActionEditAttrType()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $check = $this->GetAttrType($this->data['id']);
        if(!$check)
        {
            redirect(ADMIN_ERROR);
        }
        if(!regExp::checkNULL($this->data['attr_type_name']))
        {
            return array('msg'=>'请输入属性内容');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR_TYPE." "
            ." SET attr_type_name='".$this->data['attr_type_name']."',"
            ." attr_sort='".$this->data['attr_sort']."' "
            ." WHERE attr_type_id='".$this->data['id']."'");
        return array('msg'=>'编辑成功');
    }

    //删除属性类型
    public function ActionDelAttrType()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $check = $this->GetAttrType($this->data['id']);
        if(!$check)
        {
            return false;
        }
        $res = $this->GetDBMaster()->queryrow("SELECT * FROM ".TABLE_ATTR_TEMP." "
            ." WHERE attr_type_id='".$this->data['id']."' ");
        if($res)
        {
            return array('msg'=>'属性正在使用，无法删除');
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_ATTR_TYPE." "
            ." WHERE attr_type_id='".$this->data['id']."'");
        return array('msg'=>'删除成功');
    }


    //新增属性模板
    public function ActionNewAttrValue()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['attr_type_id']))
        {
            return array('msg'=>'请选择属性分类');
        }
        $check = $this->GetAttrType($this->data['attr_type_id']);
        if(!$check)
        {
            return array('msg'=>'该分类不存在');
        }
        if(!regExp::checkNULL($this->data['attr_name']))
        {
            return array('msg'=>'请输入属性对应内容');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ATTR_TEMP." "
            ." SET attr_type_id='".$this->data['attr_type_id']."',"
            ." attr_name='".$this->data['attr_name']."'");
        if($res)
        {
            return array('msg'=>'新增成功');
        }
        return array('msg'=>'新增失败');
    }



    //编辑属性模板
    public function ActionEditAttrValue()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data =  $this->GetOneAttrValue($this->data['id']);
        if(!$data)
        {
            redirect(ADMIN_ERROR);
        }
        if(!regExp::checkNULL($this->data['attr_type_id']))
        {
            return array('msg'=>'请选择属性分类');
        }
        $check = $this->GetAttrType($this->data['attr_type_id']);
        if(!$check)
        {
            return array('msg'=>'该分类不存在');
        }
        if(!regExp::checkNULL($this->data['attr_name']))
        {
            return array('msg'=>'请输入属性对应内容');
        }
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ATTR_TEMP." "
            ." SET attr_type_id='".$this->data['attr_type_id']."',"
            ." attr_name='".$this->data['attr_name']."' "
            ." WHERE attr_id='".$this->data['id']."'");
        if($res)
        {
            return array('msg'=>'编辑成功');
        }
        return array('msg'=>'编辑失败');
    }


    //删除属性模板
    public function ActionDelAttrValue()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        $data =  $this->GetOneAttrValue($this->data['id']);
        if(!$data)
        {
            return false;
        }
        $check = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ATTR." "
            ." WHERE id='".$this->data['id']."' LIMIT 1");
        if($check)
        {
            return array('msg'=>'属性模板正在使用，无法删除');
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_ATTR_TEMP." "
            ." WHERE attr_id='".$this->data['id']."'");
        return array('msg'=>'删除成功');
    }
}