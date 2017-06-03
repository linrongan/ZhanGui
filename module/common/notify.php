<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/conf/define_template.php';
Class notify extends common{
    function __construct($data,$db) {
        $this->data=daddslashes($data);
        $this->db=$db;
    }
    //订单自动分销
    function ActionFenXiao()
    {
        $data=$this->db->get_one("SELECT * FROM ".TABLE_ORDER." "
            ." WHERE fenxiao_status=0 "
            ." AND parent_id>0 AND order_status>=3 AND fenxiao_status=0");
        $user =$this->db->get_one("SELECT * FROM ".TABLE_USER." WHERE userid=".$data['userid']);
        if (empty($data))
        {
            return array("code"=>1,"msg"=>"无分销订单可执行记录");
        }else
        {
                if ($data['parent_id']>0)
                {
                    //一级分销
                    $submit1=$this->db->query("UPDATE ".TABLE_ORDER." "
                        ." SET parent_money='".$data['parent_money']."',"
                        ." fenxiao_status=1"
                        ." WHERE id='".$data['id']."'");
                    $submit2=$this->db->query("UPDATE ".TABLE_USER." "
                        ." SET user_has_money=user_has_money+".$data['parent_money'].",  "
                        ." user_sale_money=user_sale_money+".$data['order_total'].","
                        ." user_sale_order=user_sale_order+1,"
                        ." user_all_yongjin=user_all_yongjin+".$data['parent_money'].""
                        ." WHERE userid='".$data['parent_id']."'");

                       $this->db->query("INSERT INTO ".TABLE_YONGJIN_LOG." "
                        ." SET yongjin='".$data['parent_money']."',"
                        ." userid='".$data['userid']."',"
                        ." user_level='1',"
                        ." orderid='".$data['orderid']."',"
                        ." log_time='".date("Y-m-d H:i:s")."',"
                        ." who_get='".$data['parent_id']."'");
                }

                if ($data['parent_sub_id']>0)
                {
                    //二级分销
                    $submit1=$this->db->query("UPDATE ".TABLE_ORDER." "
                        ." SET parent_sub_money='".$data['parent_sub_money']."',"
                        ." fenxiao_status=1"
                        ." WHERE id='".$data['id']."'");
                    $submit2=$this->db->query("UPDATE ".TABLE_USER." "
                        ." SET user_has_money=user_has_money+".$data['parent_sub_money'].", "
                        ." user_sale_money=user_sale_money+".$data['order_total'].","
                        ." user_sale_order=user_sale_order+1,"
                        ." user_all_yongjin=user_all_yongjin+".$data['parent_sub_money'].""
                        ." WHERE userid='".$data['parent_sub_id']."'");

                    $this->db->query("INSERT INTO ".TABLE_YONGJIN_LOG." "
                        ." SET yongjin='".$data['parent_sub_money']."',"
                        ." userid='".$data['userid']."',"
                        ." user_level='2',"
                        ." orderid='".$data['orderid']."',"
                        ." log_time='".date("Y-m-d H:i:s")."',"
                        ." who_get='".$data['parent_sub_id']."'");
                }

                if($user['user_level']==1){
                    //三级分销
                    $submit1=$this->db->query("UPDATE ".TABLE_ORDER." "
                        ." SET parent_last_money='".$data['parent_last_money']."',"
                        ." fenxiao_status=1,"
                        ." user_sale_money=user_sale_money+".$data['order_total'].","
                        ." user_sale_order=user_sale_order+1"
                        ." WHERE id='".$data['id']."'");
                    $submit2=$this->db->query("UPDATE ".TABLE_USER." "
                        ." SET user_has_money=user_has_money+".$data['parent_last_money'].", "
                        ." user_sale_money=user_sale_money+".$data['order_total'].","
                        ." user_sale_order=user_sale_order+1,"
                        ." user_all_yongjin=user_all_yongjin+".$data['parent_last_money'].""
                        ." WHERE userid='".$user['userid']."'");

                    $this->db->query("INSERT INTO ".TABLE_YONGJIN_LOG." "
                        ." SET yongjin='".$data['parent_last_money']."',"
                        ." userid='".$data['userid']."',"
                        ." user_level='3',"
                        ." orderid='".$data['orderid']."',"
                        ." log_time='".date("Y-m-d H:i:s")."',"
                        ." who_get='".$user['userid']."'");
                    if($submit1 && $submit2){
                        $this->db->query("COMMIT");
                        echo 'ok';
                    }
                    else{
                        $this->db->query("ROLLBACK");
                        echo 'fail';
                    }
                }
                elseif ($data['parent_last_id']>0)
                {
                    //三级分销
                    $submit1=$this->db->query("UPDATE ".TABLE_ORDER." "
                        ." SET parent_last_money='".$data['parent_last_money']."',"
                        ." fenxiao_status=1,"
                        ." user_sale_money=user_sale_money+".$data['order_total'].","
                        ." user_sale_order=user_sale_order+1"
                        ." WHERE id='".$data['id']."'");
                    $submit2=$this->db->query("UPDATE ".TABLE_USER." "
                        ." SET user_has_money=user_has_money+".$data['parent_last_money'].", "
                        ." user_sale_money=user_sale_money+".$data['order_total'].","
                        ." user_sale_order=user_sale_order+1,"
                        ." user_all_yongjin=user_all_yongjin+".$data['parent_last_money'].""
                        ." WHERE userid='".$data['parent_last_id']."'");

                    $this->db->query("INSERT INTO ".TABLE_YONGJIN_LOG." "
                        ." SET yongjin='".$data['parent_last_money']."',"
                        ." userid='".$data['userid']."',"
                        ." user_level='3',"
                        ." orderid='".$data['orderid']."',"
                        ." log_time='".date("Y-m-d H:i:s")."',"
                        ." who_get='".$data['parent_last_id']."'");
                }
                if($submit1 && $submit2){
                    $this->db->query("COMMIT");
                    echo 'ok';
                }
                else{
                    $this->db->query("ROLLBACK");
                    echo 'fail';
                }
            }
    }
}
?>