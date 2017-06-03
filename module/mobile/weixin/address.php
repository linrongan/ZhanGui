<?php
class address extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }
    //获取所有省份
    public function GetProvince()
    {
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_PROVINCE." ");
        return $data;
    }

    //取一条省
    public function GetOneProvince($province_id=0)
    {
        if(!$province_id)
        {
            if(isset($this->data['province_id']) &&
                !empty($this->data['province_id']))
            {
                $province_id = $this->data['province_id'];
            }
        }
        if(!$province_id){return false;}
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PROVINCE." "
            ." WHERE id='".$province_id."'");
        return $data;
    }

    //根据条件获取城市
    public function GetCity($city_id=0)
    {
        if(!$city_id)
        {
            if(isset($this->data['city_id']) &&
                !empty($this->data['city_id']))
            {
                $city_id = $this->data['city_id'];
            }
        }
        if(!$city_id){return false;}
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_CITY." "
            ." WHERE father='".$city_id."'");
        return $data;
    }


    //获取一条城市
    public function GetOneCity($city_id)
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CITY." "
            ." WHERE id='".$city_id."'");
        return $data;
    }

    //根据条件获取区域
    public function GetArea($area_id=0)
    {
        if(!$area_id)
        {
            if(isset($this->data['area_id']) &&
                !empty($this->data['area_id']))
            {
                $area_id = $this->data['area_id'];
            }
        }
        if(!$area_id){return false;}
        $data = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_AREA." "
            ." WHERE father='".$area_id."'");
        return $data;
    }

    //获取一条区域
    public function GetOneArea($area_id)
    {
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_AREA." "
            ." WHERE id='".$area_id."'");
        return $data;
    }


    //json格式返回
    public function ReturnJson()
    {
        $fun = $this->data['_fun_'];
        if(method_exists($this,$fun))
        {
            echo json_encode($this->$fun());exit;
        }
    }

    //用户所有收货地址
    public function GetUserAddress()
    {
        return $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ADDRESS." "
            ." WHERE userid='".$_SESSION['userid']."'");
    }


    //取一条地址
    public function GetOneAddress($id)
    {
        return $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADDRESS." "
            ." WHERE id='".$id."' AND userid='".$_SESSION['userid']."'");
    }


    //获取编辑的地址信息
    public function GetAddressDetails()
    {
        if(!regExp::checkNULL($this->data['id']))
        {
            exit(404);
        }
        $address = $this->GetOneAddress($this->data['id']);
        if(!$address)
        {
            exit(404);
        }
        return $address;
    }
}