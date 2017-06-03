<?php
    $machine=$db->get_one("SELECT machine_id FROM ".TABLE_USER." "
        ." WHERE openid='".$this->_fromUserName."'");
    if ($machine)
    {

        $url=WEBURL.'/api/?api_mod=mobile/index&api_class=index&api_function=InputEvent'
            .'&key='.$str.''
            .'&machine_id='.$machine['machine_id'].''
            .'&name='.$this->_fromUserName;

        $db->query("INSERT INTO ".TABLE_LOG." SET "
            ."log='".$url."',"
            ."addtime='".date("Y-m-d H:i:s")."'");

        //interface_log (ERROR, EC_OK, '输入菜单指令'.$str);
        doCurlGetRequest($url,array(),3);
    }
exit;

interface_log (ERROR, EC_OK, '输入菜单返回'.$json);
$data=json_decode($json,true);
$str_msg='';
if (!empty($data[0]['list']))
{
    //进入主菜单的链接
    $str_msg="".$data[1]['title'];
    foreach($data[0]['list'] as $item)
    {
        $str_msg.="\r\n".$item['name'];
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