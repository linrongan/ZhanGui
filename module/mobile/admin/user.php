<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class user extends comm{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    /*
    * 微信粉丝
    */
    function UserListWx()
    {
        $where=$canshu="";
        $orderby='ORDER BY userid DESC';
        $total=$this->GetDBSlave1()->queryrow("SELECT count(*) AS total FROM ".TABLE_USER." "
            ." WHERE 1 ".$where." ");
        if ((!isset($_REQUEST['curpage'])) or (!is_numeric($_REQUEST['curpage'])) or ($_REQUEST['curpage']<1))
        {
            $curpage=1;
        }
        else
        {
            $curpage=intval($_REQUEST['curpage']);
        }
        $page_size=24;
        if (isset($_REQUEST['page_size']))
        {
            $page_size=intval($_REQUEST['page_size']);
        }
        $array=$this->GetDBSlave1()->queryrows("SELECT * "
            ." FROM ".TABLE_USER.""
            ." WHERE 1 ".$where.""
            ." ".$orderby." LIMIT ".($curpage-1)*$page_size.",".$page_size."");
        return array("data"=>$array,"total"=>$total['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }

    /*
    * 获取粉丝单条信息
    */
    function GetOneUser($id)
    {
        $data=$this->GetDBSlave1()->queryrow("SELECT * "
            ." FROM ".TABLE_USER.""
            ." WHERE userid='".$id."'");
        return $data;
    }


    //编辑微信
    public function GetSetUser()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            redirect(ADMIN_ERROR);
        }
        return $this->GetOneUser($this->data['id']);
    }

    //用户等级
    public function GetUserLevel()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_LEVEL." "
            ." ORDER BY level_sort ASC");
    }




}
?>