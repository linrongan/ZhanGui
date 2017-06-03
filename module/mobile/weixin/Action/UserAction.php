<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class UserAction extends user
{
    function __construct($data)
    {
        $this->data = $data;
    }

    //更改用户资料
    private function EditUserInfo()
    {
        if(!regExp::checkNULL($this->data['username']))
        {
            return array('code'=>1,'msg'=>'请输入真实姓名');
        }
        if(!regExp::checkNULL($this->data['phone']))
        {
            return array('code'=>1,'msg'=>'请输入手机号码');
        }elseif(!regExp::Phone($this->data['phone']))
        {
            return array('code'=>1,'msg'=>'请输入正确的手机号码');
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET "
            ."username='".$this->data['username']."',"
            ."phone='".$this->data['phone']."' "
            ."WHERE userid='".$_SESSION['userid']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }


    public function ActionEditUserInfo()
    {
        echo json_encode($this->EditUserInfo());exit;
    }



    //反馈
    public function NewMessage()
    {
        if(!regExp::checkNULL($this->data['message']))
        {
            die(json_encode(array('code'=>1,'msg'=>'请输入内容')));
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_MESSAGE."(userid,"
            ."contact,message,ip,addtime,location) VALUES('".$_SESSION['userid']."',"
            ."'".$this->data['contact']."','".$this->data['message']."',"
            ."'".$ip."','".date("Y-m-d H:i:s",time())."','".$this->data['v_mod']."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'反馈成功');
        }else{
            return array('code'=>1,'msg'=>'反馈失败');
        }
    }
    public function ActionNewMessage()
    {
        echo json_encode($this->NewMessage());exit;
    }

    //取消产品收藏
    public function CancelProductColle()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $arr = array(1,2);
        if(!regExp::checkNULL($this->data['type']) ||
            !in_array($this->data['type'],$arr))
        {
            return array('code'=>1,'msg'=>'未知产品类型');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_COLLE." "
            ." WHERE product_id='".$this->data['id']."' AND userid='".$_SESSION['userid']."' "
            ." AND product_type='".$this->data['type']."'");
        if(!$data)
        {
            $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
                ." WHERE product_id='".$this->data['id']."'");
            if(!$product)
            {
                return array('code'=>1,'msg'=>'产品不存在');
            }
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT_COLLE." "
                ." SET userid='".$_SESSION['userid']."',product_id='".$this->data['id']."',"
                ." addtime='".date("Y-m-d H:i:s",time())."',product_type='".$this->data['type']."',"
                ." product_img='".$product['product_img']."',product_name='".$product['product_name']."',"
                ." product_price='".$product['product_price']."'");
            if($id)
            {
                return array('code'=>0,'msg'=>'已收藏','type'=>1);
            }else{
                return array('code'=>0,'msg'=>'收藏失败');
            }
        }else{
            $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_PRODUCT_COLLE." "
                ." WHERE product_id='".$this->data['id']."' AND userid='".$_SESSION['userid']."' "
                ." AND product_type='".$this->data['type']."'");
            if($res)
            {
                return array('code'=>0,'msg'=>'已取消','type'=>2);
            }
            return array('code'=>0,'msg'=>'取消失败');
        }
    }
    public function ActionCancelProductColle()
    {
        echo json_encode($this->CancelProductColle());exit;
    }








}