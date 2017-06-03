<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class AddressAction extends address
{
    function __construct($data)
    {
        parent::__construct($data);
    }


    //新增地址
    private function NewAddress()
    {
        if(!regExp::checkNULL($this->data['province_id']))
        {
            return array('code'=>1,'msg'=>'请选择省份');
        }
        if(!regExp::checkNULL($this->data['city_id']))
        {
            return array('code'=>1,'msg'=>'请选择城市');
        }

        /*if(!regExp::checkNULL($this->data['area_id']))
        {
            return array('code'=>1,'msg'=>'请选择区域');
        }*/
        if(!regExp::checkNULL($this->data['address']))
        {
            return array('code'=>1,'msg'=>'请输入详细收货地址');
        }
        if(!regExp::checkNULL($this->data['shop_name']))
        {
            return array('code'=>1,'msg'=>'请输入收货人姓名');
        }
        if(!regExp::checkNULL($this->data['shop_phone']))
        {
            return array('code'=>1,'msg'=>'请输入收货人手机');
        }
        $address = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADDRESS." "
            ." WHERE userid='".$_SESSION['userid']."' LIMIT 1");
        if(!$address)
        {
            $default = 0;
        }else{
            $default = 1;
        }
        $province = $this->GetOneProvince($this->data['province_id']);
        if(!$province)
        {
            return array('code'=>1,'msg'=>'省参数错误');
        }
        $city = $this->GetOneCity($this->data['city_id']);
        if(!$city)
        {
            return array('code'=>1,'msg'=>'市参数错误');
        }

        $date = date("Y-m-d H:i:s",time());
        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_ADDRESS." "
            ." (userid,shop_name,shop_phone,province_id,provice_name,"
            ."city_id,city_name,address,addtime,"
            ."default_select) VALUES('".$_SESSION['userid']."',"
            ."'".$this->data['shop_name']."','".$this->data['shop_phone']."',"
            ."'".$this->data['province_id']."','".$province['name']."',"
            ."'".$this->data['city_id']."','".$city['name']."',"
            ."'".$this->data['address']."','".$date."',"
            ."'".$default."')");
        if($id)
        {
            return array('code'=>0,'msg'=>'新增成功');
        }
        return array('code'=>1,'msg'=>'新增失败');
    }



    public function ActionNewAddress()
    {
        echo json_encode($this->NewAddress());exit;
    }

    public function ActionEditAddress()
    {
        echo json_encode($this->EditAddress());exit;
    }

    public function ActionDelAddress()
    {
        echo json_encode($this->DelAddress());exit;
    }

    public function EditAddress()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $address = $this->GetOneAddress($this->data['id']);
        if(!$address)
        {
            return array('code'=>1,'msg'=>'无此地址');
        }
        if(!regExp::checkNULL($this->data['province_id']))
        {
            return array('code'=>1,'msg'=>'请选择省份');
        }
        if(!regExp::checkNULL($this->data['city_id']))
        {
            return array('code'=>1,'msg'=>'请选择城市');
        }
        /*if(!regExp::checkNULL($this->data['area_id']))
        {
            return array('code'=>1,'msg'=>'请选择区域');
        }*/
        if(!regExp::checkNULL($this->data['address']))
        {
            return array('code'=>1,'msg'=>'请输入详细收货地址');
        }
        if(!regExp::checkNULL($this->data['shop_name']))
        {
            return array('code'=>1,'msg'=>'请输入收货人姓名');
        }
        if(!regExp::checkNULL($this->data['shop_phone']))
        {
            return array('code'=>1,'msg'=>'请输入收货人手机');
        }
        $province = $this->GetOneProvince($this->data['province_id']);
        if(!$province)
        {
            return array('code'=>1,'msg'=>'省参数错误');
        }
        $city = $this->GetOneCity($this->data['city_id']);
        if(!$city)
        {
            return array('code'=>1,'msg'=>'市参数错误');
        }

        if($this->data['default_select']=='on')
        {
            $default = 0;
        }else{
            $default = 1;
        }
        $set = '';
        if($address['default_select']!=$default)
        {
            if($default==0)
            {
                $set .= " ,default_select=0";
                $this->GetDBMaster()->query("UPDATE ".TABLE_ADDRESS." SET default_select=1 "
                    ." WHERE userid='".$_SESSION['userid']."'");
            }else{
                $set .= " ,default_select=1";
            }
        }
        $this->GetDBMaster()->query("UPDATE ".TABLE_ADDRESS." "
            ." SET shop_name='".$this->data['shop_name']."',"
            ." shop_phone='".$this->data['shop_phone']."',"
            ." province_id='".$this->data['province_id']."',"
            ." provice_name='".$province['name']."',"
            ." city_id='".$this->data['city_id']."',"
            ." city_name='".$city['name']."',"
            ." address='".$this->data['address']."' ".$set." "
            ." WHERE id='".$this->data['id']."'");
        return array('code'=>0,'msg'=>'修改成功');
    }


    //删除地址
    public function DelAddress()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $id = $this->GetOneAddress($this->data['id']);
        if($id)
        {
            $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_ADDRESS." "
                ." WHERE id='".$this->data['id']."'");
            if($res)
            {
                return array('code'=>0,'msg'=>'删除成功');
            }else{
                return array('code'=>1,'msg'=>'删除失败');
            }
        }else{
            return array('code'=>1,'msg'=>'地址不存在');
        }
    }
}