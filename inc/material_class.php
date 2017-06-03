<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class material_class{
    //图片上传
    public function UploadImageMaterial($params=array())
    {
        $url="https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$params['access_token']."";
        $ch1 = curl_init ();
        $timeout = 5;
        $real_path=$params['pic_url'];
        $data= array("media"=>"@".$real_path);
        curl_setopt ( $ch1, CURLOPT_URL,$url);
        curl_setopt ( $ch1, CURLOPT_POST, 1 );
        curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt ( $ch1, CURLOPT_POSTFIELDS, $data );
        $result = curl_exec( $ch1 );
        curl_close($ch1);
        $result=json_decode($result,true);
        if (!empty($result['url']))
        {
            return $result['url'];
        }
       return $result;
    }

    //素材库其他素材
    public function UploadOtherMaterial($params=array())
    {
        $url="https://api.weixin.qq.com/cgi-bin/material/add_material?type=".$params['type']."&access_token=".$params['access_token']."";
        $ch1 = curl_init ();
        $timeout = 5;
        $real_path=$params['material_url'];
        $data= array("media"=>"@".$real_path);
        if ($params['type']=='video' || $params['type']=='shortvideo')
        {
            $data['description']=ch_json_encode(array("title"=>$params['title'],
                "introduction"=>$params['introduction']));
        }
        curl_setopt ( $ch1, CURLOPT_URL,$url);
        curl_setopt ( $ch1, CURLOPT_POST, 1 );
        curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt ( $ch1, CURLOPT_POSTFIELDS, $data );
        $result = curl_exec( $ch1 );
        curl_close($ch1);
        $result=json_decode($result,true);
        if (!empty($result['media_id']))
        {
            return $result;
        }
        return $result;
    }


}