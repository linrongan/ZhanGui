<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class err extends common
{
    function __construct($data) {
        $this->data=daddslashes($data);
    }
}
?>