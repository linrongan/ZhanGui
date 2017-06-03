<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/inc/curl_class.php';
Class api {
    function __construct($data,$cu)
    {
        $this->url=$data['url'];
        unset($data['url']);
        $this->data=$data;
        $this->curl=$cu;
    }
    public function api()
    {
        $data=$this->curl->post($this->url,
            array("data"=>json_encode($this->data)));
        return $data;
    }

}
?>