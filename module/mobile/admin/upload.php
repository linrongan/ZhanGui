<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class upload extends comm
{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }
}