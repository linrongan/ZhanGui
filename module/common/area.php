<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class area {
    function __construct($data,$db,$cu) {
        $this->data=daddslashes($data);
        $this->db=$db;
    }
    //省会
    public function allprovince() {
        $data=$this->db->get_all("SELECT * FROM ".TABLE_PROVINCE."");
        return array("code"=>0,"data"=>$data);
    }
    //市区
    public function get_city() {
        if ((isset($_GET['id']) && $_GET['id']<>""))
        {
            $id=intval($_GET['id']);
        }
        else{
            //默认为浙江省
            $id=440000;
        }
        $data=$this->db->get_all("SELECT *  FROM ".TABLE_CITY." WHERE father='".$id."'");
        return array("code"=>0,"data"=>$data);
    }
    //市区
    public function get_area() {
        if ((isset($_GET['id']) && $_GET['id']<>"")){
            $id=intval($_GET['id']);
        }else{
            //默认为广州市
            $id=440100;
        }
        $data=$this->db->get_all("SELECT *  FROM ".TABLE_AREA." WHERE father='".$id."'");
        return array("code"=>0,"data"=>$data);
    }

    /**
     * 两级区域联动表
     */
    public function Area()
    {
        if (isset($this->data['upid'])){
            $data=$this->db->get_all("SELECT * FROM ".TABLE_TWO_AREA." "
                ."WHERE upid='".$this->data['upid']."' ");
        }else{
            $data=$this->db->get_all("SELECT * FROM ".TABLE_TWO_AREA." "
                ."WHERE upid=0");
        }
        return array("code"=>0,"data"=>$data);

    }


}
?>
