<?php
$machine=$db->get_one("SELECT machine_id FROM ".TABLE_USER." "
    ."WHERE openid='".$this->_fromUserName."'");
if (empty($machine))
{
    echo $this->makeHead()."<MsgType><![CDATA[text]]></MsgType><Content>"
        ."<![CDATA[请先扫描设备二维码]]></Content></xml>";exit;
}
$url=WEBURL.'/api/?api_mod=mobile/index&api_class=index&api_function=SetPassWord'
    .'&input='.$str_array[1].''
    .'&id='.$machine['machine_id'].''
    .'&name='.$this->_fromUserName;
    doCurlGetRequest($url,array(),3);
    exit;
?>