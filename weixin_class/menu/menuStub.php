<?php
class MenuStub {
    public static function reqMenu($interface,$data,$token) {
        //retry 3 times
        $retry = 3;
        while ($retry) {
            $retry --;
            if(false  === $token) {
                return false;
            }
            $url = WX_API_URL . "$interface?access_token=" . $token;
            $ret = doCurlPostRequest($url,$data);
            echo $ret;exit;
            $retData = json_decode($ret, true);
            return $retData;
        }
        return false;
    }

    public static function create($data,$token) {
        $ret = MenuStub::reqMenu("menu/create",$data,$token);
        return $ret;
    }

    public static function get($data,$token) {
        $ret = MenuStub::reqMenu("menu/get",$data,$token);
        return $ret;
    }

    public static function delete($data,$token){
        $ret = MenuStub::reqMenu("menu/delete",$data,$token);
        return $ret;
    }



    public static function create_spe($data,$token) {
        $ret = MenuStub::reqMenu("menu/addconditional",$data,$token);
        return $ret;
    }

    public static function delete_spe($data,$token){
        $ret = MenuStub::reqMenu("menu/delconditional",$data,$token);
        return $ret;
    }


}
?>