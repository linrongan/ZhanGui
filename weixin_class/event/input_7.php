<?php

$url=WEBURL.'/api/?api_mod=mobile/index&api_class=index&api_function=InputEvent'
    .'&key='.$this->_postObject->Content.''
    .'&action=10'
    .'&machine_id='.$machine['machine_id'].'&name='.$this->_fromUserName;
$json=doCurlGetRequest($url);
interface_log (ERROR, EC_OK, '输入菜单返回'.$json);
$data=json_decode($json,true);
$str_msg='';
if (!empty($data[0]['list']))
{
    //进入主菜单的链接
    $str_msg="".$data[0]['title'];
    foreach($data[0]['list'] as $item)
    {
        $str_msg.="\r\n".$item['name'].'======'.$item['result'].'';
    }
}
elseif(!empty($data[0]['title']))
{
    $str_msg=$data[0]['title'];
}
elseif(!empty($data[0]['result']))
{
    $str_msg=$data[0]['result'];
}
else
{
    $str_msg='菜单响应超时!';
}
echo $this->makeHead()."<MsgType><![CDATA[text]]></MsgType><Content>"
    ."<![CDATA[".$str_msg."]]></Content></xml>";
exit;
?>