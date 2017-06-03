<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//set_time_limit(0);
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
include '../config_wx.php';
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR .'/conf/run_database.php';
$postStr = file_get_contents ("php://input");
if (isset($_GET['test']))
{
    $postStr='[{"id":"2345678","list":"","name":"","show":"101","up_type":"70","user":"01:49:46*门：开启*电池电量：100%*电池状态：优*供电：市电*外部电源：正常*机械动作结构1：正常*机械动作结构2：正常*无线模块1：正常*无线模块2：正常*"}]';
}
if (!empty($postStr))
{
    $data=json_decode($postStr,true);
    if (!empty($data[0]['up_type']))
    {
        include RPC_DIR .'/module/common/common.php';
        $obj=new common('',$db,'');
        $machine_id=$data[0]['id'];
        switch($data[0]['up_type'])
        {
            case '70';
                if($data[0]['show']==100)
                {
                    $array=array('touser'=>$data[0]['name'],'msgtype'=>'text',
                        'text'=>array('content'=>str_replace("*","\n",$data[0]['user'])));
                    $obj->SentMsgToUser($array);
                }
                elseif ($data[0]['show']==101){
                    $user=$db->get_all("SELECT openid FROM ".TABLE_USER." "
                        ." WHERE machine_id='".$machine_id."' AND machine_status=0");
                    if (!empty($user))
                    {
                        $content=str_replace("*","\n",$data[0]['user']);
                        foreach ($user as $item)
                        {
                            $array=array('touser'=>$item['openid'],'msgtype'=>'text',
                                'text'=>array('content'=>$content));
                            $obj->SentMsgToUser($array);
                        }
                    }
                    /*
                    $user=$db->get_all("SELECT openid FROM ".TABLE_USER." "
                        ." WHERE machine_id='".$machine_id."'");
                    //AND machine_status=0
                    if (!empty($user))
                    {
                        $content=str_replace("*","",$data[0]['user']);
                        foreach ($user as $item)
                        {
                                $todata=array(
                                'touser'=>$item['openid'],
                                "template_id"=>'TRyQfvHSY_b_8kZZ2r__DO1AAvbrUBdF2ooE7vJD374',
                                "topcolor"=>"#FF0000",
                                "data"=>array(
                                    "first"=>array("value"=>"群发模板消息测试\n\n","color"=>"#173177"),
                                    "keyword1"=>array("value"=>"群发模板消息测试","color"=>"#173177"),
                                    "keyword2"=>array("value"=>date("Y-m-d H:i:s"),"color"=>"#173177"),
                                    "remark"=>array("value"=>$content,"color"=>"#173177"),
                                 ));
                                echo $item['openid'].'<br/>';
                                $obj->SentNotifyFromTemplate($todata);
                        }

                    }*/
                }elseif ($data[0]['show']==102){
                    $content=str_replace("*","\n",$data[0]['user']);
                    foreach ($data[0]['list'] as $item)
                    {
                        $db->query("INSERT INTO ".TABLE_LOG." SET "
                            ."log='".$item['name']."10222222"."',"
                            ."addtime='".date("Y-m-d H:i:s")."',ip='".getIP()."'");

                        $array=array('touser'=>$item['name'],'msgtype'=>'text',
                            'text'=>array('content'=>$content));
                        $obj->SentMsgToUser($array);
                    }
                }
                break;
            case '60';
                //登入
                $array=array('touser'=>$data[0]['name'],'msgtype'=>'text',
                    'text'=>array('content'=>$data[0]['user']));
                $obj->SentMsgToUser($array);
                break;
            default:
        }
    }
}

function getIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    }
    elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    }
    elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');

    }
    elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>
