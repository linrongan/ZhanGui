<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/conf/database_table.php';
include RPC_DIR .'/conf/dbclass.php';
Class common {
    protected  $conn='';
    protected  $db='';
    function __construct($data)
    {
        $this->data = daddslashes($data);
    }

    //获取数据库主库可写
    public function GetDBMaster()
    {
        $db = dbtemplate::getInstance('mysql:host=rm-wz9decsr1538g09boo.mysql.rds.aliyuncs.com;port=3306;dbname=zhangui;charset=utf8mb4',
            'array_user',
            'u33Tds763KOIH');
        return $db;
    }

    //获取数据库从库可读1
    public function GetDBSlave1()
    {
        $db = dbtemplate::getInstance('mysql:host=rm-wz9decsr1538g09boo.mysql.rds.aliyuncs.com;port=3306;dbname=zhangui;charset=utf8mb4',
            'array_user',
            'u33Tds763KOIH');
        return $db;
    }

    public function GetUserInfo($userid)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_USER." WHERE "
            ." userid='".$userid."'");
    }

    //取出附件
    public function GetAttachList($type_id=0,$id=0)
    {
        $res = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ATTACH."  "
            ." WHERE type_id='".$type_id."' "
            ." AND id='".$id."'");
        return $res;
    }

    //获取用户级别
    public function GetUserLevel()
    {
        if($_SESSION['level'])
        {
            $res = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_LEVEL." WHERE "
                ." level_id='".$_SESSION['level']."'");
            if($res)
            {
                return true;
            }
            return false;
        }
        return false;
    }

    //公众日记表操作记录
    protected function AddLogAlert($KEY,$VALUE)
    {
        $this->GetDBMaster()->query("INSERT INTO ".TABLE_LOG_ALERTED." (key_title,content,addtime,status)"
            ."VALUES('".$KEY."','".$VALUE."','".date("Y-m-d H:i:s")."',0)");
    }

    //运费计算
    function GetShipFee($total=0)
    {

            return 0;


    }


    function GetConf($key)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CONFIG." WHERE `key`='".$key."'");
    }

}
?>