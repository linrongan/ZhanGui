<?php

class CarouselAction extends carousel{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //新增
    public function ActionNewCarousel()
    {
        if(!regExp::checkNULL($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['fields_image']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_FIELDS." SET  fields_type=0,"
            ."fields_title='".$this->data['fields_title']."',fields_image='".$this->data['fields_image']."',"
            ."fields_link='".$this->data['fields_link']."',fields_order='".$this->data['fields_order']."',"
            ."fields_show='".$this->data['fields_show']."',fields_addtime='".date("Y-m-d H:i:s",time())."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }


    //编辑
    public function ActionSetCarousel()
    {
        if(!regExp::checkNULL($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetOneCarousel($this->data['id']);
        if(!$data)
        {
            return array('code'=>1,'msg'=>'数据源不存在');
        }
        $res = $this->GetDBMaster()->insertquery("UPDATE ".TABLE_FIELDS." SET  fields_type=0,"
            ."fields_title='".$this->data['fields_title']."',fields_image='".$this->data['fields_image']."',"
            ."fields_link='".$this->data['fields_link']."',fields_order='".$this->data['fields_order']."',"
            ."fields_show='".$this->data['fields_show']."',fields_addtime='".date("Y-m-d H:i:s",time())."' "
            ."WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'编辑成功');
    }

    public function ActionDelCarousel()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $data = $this->GetOneCarousel($this->data['id']);
        if(!$data)
        {
           return false;
        }
        $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_FIELDS." WHERE id='".$this->data['id']."'");
        if($res)
        {
            return array('code'=>0,'msg'=>'删除成功');
        }
        return array('code'=>1,'msg'=>'删除失败');
    }
}