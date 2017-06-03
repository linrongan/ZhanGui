<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class AdminAction extends admin
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
    //编辑权限菜单
    function EditRoleAuth()
    {
        if (regExp::checkNULL($this->data['ry_parent_id']) &&
            regExp::checkNULL($this->data['ry_menu']) &&
            regExp::checkNULL($this->data['menu_type']))
        {
            $mod=$index=$action=$ry_qx_url='';
            if (!empty($this->data['ry_link']))
            {
                $url_array=parse_url($this->data['ry_link']);
                parse_str($url_array['query'],$query);
                $mod=isset($query['mod'])?$query['mod']:"";
                $v_mod=isset($query['v_mod'])?$query['v_mod']:$mod;
                $index=isset($query['_index'])?$query['_index']:"";
                $action=isset($query['_action'])?$query['_action']:"";
                $ry_qx_url=$mod.'#'.$v_mod.'#'.$index.'#'.$action;
            }
            $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN_MENU." "
                ." SET menu_type='".$this->data['menu_type']."',"
                ." ry_menu='".$this->data['ry_menu']."',"
                ." ry_parent_id='".$this->data['ry_parent_id']."',"
                ." ry_link='".$this->data['ry_link']."',"
                ." ry_order='".$this->data['ry_order']."',"
                ." ry_qx_url='".$ry_qx_url."' "
                ." WHERE id='".$this->data['id']."'");
            redirect("?mod=admin&_index=_role_page_edit&id=".$this->data['id']."");
        }
    }

    //管理员菜单
    function NewRoleAuth()
    {
        if (regExp::checkNULL($this->data['ry_parent_id']) &&
            regExp::checkNULL($this->data['ry_menu']))
        {
            $mod=$index=$action=$ry_qx_url='';
            if (!empty($this->data['ry_link']))
            {
                $url_array=parse_url($this->data['ry_link']);
                parse_str($url_array['query'],$query);
                $mod=isset($query['mod'])?$query['mod']:"";
                $v_mod=isset($query['v_mod'])?$query['v_mod']:$mod;
                $index=isset($query['_index'])?$query['_index']:"";
                $action=isset($query['_action'])?$query['_action']:"";
                $ry_qx_url=$mod.'#'.$v_mod.'#'.$index.'#'.$action;
            }

            //获取类别ry_parent_id
            $id=$this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADMIN_MENU." "
                ."(menu_type,ry_menu,ry_parent_id,ry_link,ry_order,ry_qx_url)"
                ."VALUES('".$this->data['menu_type']."',"
                ."'".$this->data['ry_menu']."',"
                ."'".$this->data['ry_parent_id']."',"
                ."'".$this->data['ry_link']."',"
                ."'".$this->data['ry_order']."',"
                ."'".$ry_qx_url."')");
            if ($id)
            {
                $this->GetDBMaster()->query("INSERT INTO ".TABLE_ADMIN_AUTH." "
                    ."(admin_id,menu_id)VALUES('".$_SESSION['admin_id']."','".$id."')");
            }
            redirect("?mod=admin&_index=_role_page");
        }
    }


    function ActionOperatorAdd(){
        if(regExp::checkNULL($this->data['fid']) &&
        regExp::checkNULL($this->data['admin_name'])){
            $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADMIN."(admin_name,usercode,admin_type,fid)"
                ." VALUES('".$this->data['admin_name']."','".$_SESSION['usercode']."',1,'".$this->data['fid']."')");
        }
        redirect('/?mod=admin&_index=_operator_er_list');
    }

}