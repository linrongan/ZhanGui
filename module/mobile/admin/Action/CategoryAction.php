<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class CategoryAction extends category
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //新增分类
    public function ActionNewCategory()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!isset($this->data['category_id'])){
            return array('code'=>1,'msg'=>'请选择分类');
        }
        if(!regExp::checkNULL($this->data['category_name'])){
            return array('code'=>1,'msg'=>'分类名不能为空');
        }
        /*if(isset($this->data['category_img'])
            && is_array($this->data['category_img'])
            && count($this->data['category_img'])>0)
        {
            $imgs = serialize($this->data['category_img']);
        }else{
            $imgs = '';
        }*/

        $parent_id = $this->data['category_id']?$this->data['category_id']:0;
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_CATEGORY." "
            ."(category_name,ry_order,parent_id,category_desc,category_img) VALUES('".$this->data['category_name']."',"
            ."'".$this->data['ry_order']."','".$parent_id."','".$this->data['category_desc']."','".$this->data['category_img']."')");
        if($res){
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }

    //删除分类
    public function ActionDelCategory(){
        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'请选择删除的对象');
        }
        $info = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." WHERE "
            ." category_id='{$this->data['id']}'");
        if(!$info){
            return array('code'=>1,'msg'=>'分类不存在或已删除');
        }
        if($info['parent_id']==0){
            $count = $this->GetDBSlave1()->queryrow("SELECT count(*) AS total FROM ".TABLE_CATEGORY." "
                . " WHERE parent_id='{$this->data['id']}'");
            if($count['total']!=0){
                return array('code'=>1,'msg'=>'请先删除子类');
            }
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_CATEGORY." WHERE category_id='{$this->data['id']}'");
        return array('code'=>0,'msg'=>'删除成功');
    }

    //编辑分类
    public function ActionEditCategory()
    {
        if(!isset($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id'])){
            return array('code'=>1,'msg'=>'请选择编辑的对象');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CATEGORY." "
            ." WHERE category_id='{$this->data['id']}'");
        if(!$data){
            return array('code'=>1,'msg'=>'数据不存在或已删除');
        }
        if(!regExp::checkNULL($this->data['category_name']))
        {
            return array('code'=>1,'msg'=>'分类名不能为空');
        }

        /*if(isset($this->data['category_img'])
            && is_array($this->data['category_img'])
            && count($this->data['category_img'])>0)
        {
            $imgs = serialize($this->data['category_img']);
        }else{
            $imgs = '';
        }*/

        $parent_id = (!isset($this->data['category_id']) && $data['parent_id']==0)?0:$this->data['category_id'];
        $this->GetDBMaster()->query("UPDATE ".TABLE_CATEGORY." SET category_img='".$this->data['category_img']."',"
            ." category_name='".$this->data['category_name']."',ry_order='".$this->data['ry_order']."',"
            ." show_status='".$this->data['show_status']."',parent_id='".$parent_id."',"
            ." category_desc='".$this->data['category_desc']."'"
            ." WHERE category_id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'操作成功');
    }



    //新增分类BANNER
    function ActionNewCategoryBanner()
    {
        if(!regExp::checkNULL($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['category']))
        {
            return array('code'=>1,'msg'=>'分类参数错误');
        }
        if(!regExp::checkNULL($this->data['fields_image']))
        {
            return array('code'=>1,'msg'=>'请上传图片');
        }
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_FIELDS." SET  fields_type=2,"
            ."fields_title='".$this->data['fields_title']."',fields_image='".$this->data['fields_image']."',"
            ."fields_link='".$this->data['fields_link']."',fields_order='".$this->data['fields_order']."',"
            ."fields_show='".$this->data['fields_show']."',fields_addtime='".date("Y-m-d H:i:s",time())."',"
            ."fields_cid='".$this->data['category']."' ");
        if($res)
        {
            return array('code'=>0,'msg'=>'添加成功');
        }
        return array('code'=>1,'msg'=>'添加失败');
    }


    function ActionDelCategoryBanner()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT  * FROM ".TABLE_FIELDS." WHERE "
            ." id='".$this->data['id']."' AND fields_type=2");
        if(empty($res))
        {
            return array('code'=>1,'msg'=>'数据不存在');
        }
        $this->GetDBMaster()->query("DELETE FROM ".TABLE_FIELDS." WHERE id='".$this->data['id']."'");
        redirect('?mod=admin&v_mod=category&_index=_flash&id='.$res['fields_cid']);
    }


    function ActionEditCategoryBanner()
    {
        if(!regExp::checkNULL($this->data['submit']))
        {
            return false;
        }
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $res = $this->GetDBSlave1()->queryrow("SELECT  * FROM ".TABLE_FIELDS." WHERE "
            ." id='".$this->data['id']."' AND fields_type=2");
        if(empty($res))
        {
            return array('code'=>1,'msg'=>'数据不存在');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_FIELDS." SET "
            ."fields_title='".$this->data['fields_title']."',fields_image='".$this->data['fields_image']."',"
            ."fields_link='".$this->data['fields_link']."',fields_order='".$this->data['fields_order']."',"
            ."fields_show='".$this->data['fields_show']."',fields_addtime='".date("Y-m-d H:i:s",time())."' "
            ."WHERE id='".$this->data['id']."'");
        redirect('?mod=admin&v_mod=category&_index=_flash&id='.$res['fields_cid']);
    }




}