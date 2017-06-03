<?php
$return=explode("_",$this->_postObject->EventKey);
$url=WEBURL.'/api/?api_mod=mobile/index&api_class=index&api_function=MenuKeyEvent'
    .'&key='.$return[1].''
    .'&machine_id='.$machine['machine_id'].''
    .'&name='.$this->_fromUserName;
$json=doCurlGetRequest($url,array(),3);
//interface_log (ERROR, EC_OK, '点击菜单返回'.$json.'mamamam'.$machine['machine_id']);
exit;
?>