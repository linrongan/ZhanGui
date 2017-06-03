<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR . '/inc/upload.class.php';
Class admin extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //退出登陆
    function AdminLogout()
    {
        $_SESSION['admin_name']=$_SESSION['admin_id']=$_SESSION['fid']=$_SESSION['role_id']=NULL;
        unset($_SESSION['admin_name'],$_SESSION['admin_id'],$_SESSION['fid'],$_SESSION['role_id']);
        redirect("/?mod=admin");
    }

    //获取我的管理员信息
    function GetAdminInfo()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * "
            ." FROM ".TABLE_ADMIN." AS A "
            ." WHERE A.admin_id='".$this->data['admin_id']."'");
        return $data;
    }

    //编辑管理员信息
    function ActionEditAdminInfo()
    {
        if (regExp::checkNULL($this->data['admin_name']))
        {
            //是否有权限编辑
            $myauth=$this->GetChildAuthMenu();
            if ($myauth['code']==1)
            {
                return $myauth;
            }

            $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN." "
                ." SET admin_name='".$this->data['admin_name']."'"
                ." WHERE admin_id='".$this->data['id']."'");
            return array("code"=>0,"msg"=>"操作成功");
        }
        return array("code"=>1,"msg"=>"信息不完整");
    }

    //管理员列表数据源
    function AdminList()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * "
            ." FROM ".TABLE_ADMIN."");
        return $data;
    }

    function AdminList2()
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * "
            ." FROM ".TABLE_ADMIN." WHERE admin_type=1");
        return $data;
    }

    //获取我的权限菜单
    function GetMyAuthMenu()
    {
        return $this->GetAuthMenu($_SESSION['admin_id']);
    }

    //获取下级的权限菜单
    function GetChildAuthMenu()
    {
        return array("code"=>0,"data"=>$this->GetAuthMenu($this->data['admin_id']));
    }

    //获取权限菜单
    private function GetAuthMenu($admin_id)
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT menu_id FROM ".TABLE_ADMIN_AUTH." "
            ." WHERE admin_id='".$admin_id."'");
        $return=array();
        foreach($data as $item)
        {
            $return[$item['menu_id']]=$item['menu_id'];
        }
        return $return;
    }

    //管理员权限页面
    function GetAdminAuthPage($ry_role_id=2)
    {
        //普通操作员
        if ($_SESSION['role_id']>1)
        {
            $ry_role_id=2;
        }
        elseif (isset($this->data['admin_id']) &&
            $this->data['admin_id']==$_SESSION['admin_id'] &&
            $_SESSION['role_id']==1
        )
        {
            //管理员更改自己的权限
            $ry_role_id=1;
        }
        $page_array=$t = array();
        $list=$this->GetAllRoleMenuList($ry_role_id);
        if ($list)
        {
            foreach ($list as $row)
            {
                $page_array[$row['id']] = $row;
            }
            foreach ($page_array as $id => $item)
            {
                if ($item['ry_parent_id'])
                {
                    $page_array[$item['ry_parent_id']][$item['id']] = &$page_array[$item['id']];
                    $t[] = $id;
                }
            }
            foreach($t as $u) {
                unset($page_array[$u]);
            }
        }
        return $page_array;
    }
    //管理员菜单映射关系
    function GetRoleMenuDetail()
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADMIN_MENU." "
            ." WHERE id='".$this->data['id']."' "
            ." AND ry_role_id>='".$_SESSION['role_id']."'");
        return $data;
    }

    //管理员菜单映射关系
    private function  GetAllRoleMenuList($ry_role_id=2)
    {
        $data=$this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ADMIN_MENU." "
            ." WHERE ry_role_id>='".$ry_role_id."' ORDER BY ry_order ASC");
        return $data;
    }

    //删除管理员菜单
    function DelAuthPage()
    {
        $data=$this->GetRoleMenuDetail();
        if (!empty($data))
        {
            $this->GetDBMaster()->query("DELETE FROM ".TABLE_ADMIN_MENU." "
            ." WHERE id='".$this->data['id']."' ");
            $this->GetDBMaster()->query("DELETE FROM ".TABLE_ADMIN_MENU." "
                ." WHERE ry_parent_id='".$this->data['id']."' ");
            $this->GetDBMaster()->query("DELETE FROM ".TABLE_ADMIN_AUTH." "
                ." WHERE menu_id='".$this->data['id']."' ");
            redirect("/?mod=admin&_index=_role_page");
        }
    }


    //判断是否有权限操作下一级
    private function CommAllowChildAuth($admin_id)
    {
        $my_child=$this->get_tree_child($this->AdminList(),$_SESSION['fid']);
        if (!in_array($admin_id,$my_child))
        {
            return false;
        }
        return true;
    }

    //编辑权限菜单
    function EditAuthAction()
    {
        $myauth=$this->GetChildAuthMenu();
        if ($myauth['code']==1)
        {
            return $myauth;
        }
        //查询所有菜单
        $page=$this->GetAllRoleMenuList(1);
        if (is_array($_POST['auth']) && !empty($_POST['auth']))
        {
            //查询我的所有权限，合并发过来的
            foreach($page as $item)
            {
                if (array_key_exists($item['id'],$myauth['data']))
                {
                    if (!in_array($item['id'],$_POST['auth']))
                    {
                        //删除
                        $this->GetDBMaster()->query("DELETE FROM ".TABLE_ADMIN_AUTH." "
                            ." WHERE admin_id='".$this->data['admin_id']."' "
                            ." AND menu_id='".$item['id']."'");
                    }
                }else
                {
                    if (in_array($item['id'],$_POST['auth']))
                    {
                        //新增
                        $this->GetDBMaster()->query("INSERT INTO ".TABLE_ADMIN_AUTH." "
                            ."(admin_id,menu_id)"
                            ."VALUES('".$this->data['admin_id']."','".$item['id']."')");
                    }
                }
            }
            return array("code"=>0,"msg"=>"操作完成");
        }
    }


    //保存新增操作员
    function ActionSaveNewOperator()
    {
        if (regExp::checkNULL($this->data['usercode']) &&
            regExp::checkNULL($this->data['admin_name']) &&
            regExp::checkNULL($this->data['allow_reg_count']) &&
            regExp::checkNULL($this->data['allow_charge_money']) &&
            regExp::checkNULL($this->data['admin_account']) &&
            regExp::checkNULL($this->data['admin_pwd']))
        {

            return array("code"=>0,"msg"=>"操作完成");
        }
        return array("code"=>1,"msg"=>"信息不完整");
    }

    //获取管理员下级
    private function get_tree_child($data, $fid) {
        $result = array();
        $fids = array($fid);
        do {
            $cadmin_ids = array();
            $flag = false;
            foreach($fids as $fid) {
                for($i = count($data) - 1; $i >=0 ; $i--) {
                    $node = $data[$i];
                    if($node['fid'] == $fid) {
                        array_splice($data, $i , 1);
                        $result[] = $node['admin_id'];
                        $cadmin_ids[] = $node['admin_id'];
                        $flag = true;
                    }
                }
            }
            $fids = $cadmin_ids;
        } while($flag === true);
        return $result;
    }

    function CheckPwd(){
        $opwd = $this->data['opwd'];
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADMIN." WHERE "
            ." admin_id='".$_SESSION['admin_id']."'");
        if($data['admin_pwd']!=MD5($opwd.APISECRET)){
            if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
                echo json_encode(false);exit;
            }else{
                return false;
            }
        }else{
            if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
                echo json_encode(true);exit;
            }else{
                return true;
            }
        }
    }


    function EditPwd(){
        if(!isset($this->data['opwd']) || empty($this->data['opwd']) || !$this->CheckPwd()){
            return array('code'=>1,'msg'=>'当前密码输入错误');
        }
        $pwd = md5($this->data['npwd'].APISECRET);
        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN." SET admin_pwd='".$pwd."' WHERE admin_id='".$_SESSION['admin_id']."'");
        if($res){
            return array('code'=>0,'msg'=>'修改成功，下次登录生效');
        }
        return array('code'=>1,'msg'=>'修改失败');
    }


    function GetRole(){
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADMIN_ROLE." ");
    }

}
?>