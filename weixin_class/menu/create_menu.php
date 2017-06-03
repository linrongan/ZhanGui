<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
include '../../config_wx.php';
include RPC_DIR .'/conf/conf.php';
include RPC_DIR .'/conf/config.php';
include RPC_DIR .'/module/common/common.php';
include RPC_DIR .'/weixin_class/menu/menuStub.php';
$common = new common(array());
$action=isset($_REQUEST['action']) && (!empty($_REQUEST['action']))?$_REQUEST['action']:"";
$merchant=$common->GetMerchantInfo();
if (empty($merchant))
{
    $_tip['msg']="商户信息不正确";
    include RPC_DIR .TEMPLATEPATH."/weixin/err_tip_tpl.php";
}
switch ($action)
{
    case "create_menu";
        //创建普通按钮
        $access_token=$common->Get_access_token();
        $data=MenuStub::create($merchant['json_menu'],$access_token['access_token']);
        if (!empty($data) && $data['errcode']==0)
        {
            $_tip['msg']="菜单创建成功";
            include RPC_DIR .TEMPLATEPATH."/weixin/success_tip_tpl.php";
            exit;
        }
        elseif (!empty($data) && $data['errcode']==40001)
        {
            $common->Reload_Access_Token();
            $access_token=$common->Get_access_token();
            $data=MenuStub::create($merchant['json_menu'],$access_token['access_token']);
            if (!empty($data) && $data['errcode']==0)
            {
                $_tip['msg']="菜单创建成功";
                include RPC_DIR .TEMPLATEPATH."/weixin/success_tip_tpl.php";
                exit;
            }else
            {
                $_tip['msg']=$data['errmsg'];
                include RPC_DIR .TEMPLATEPATH."/weixin/err_tip_tpl.php";
            }
        }else
        {
            $_tip['msg']='请求超时或者错误';
            include RPC_DIR .TEMPLATEPATH."/weixin/err_tip_tpl.php";
        }
        exit;
        break;
    case "create_menu_spe";
        //创建普通按钮
        $access_token=$common->Get_access_token(1);
        $data=MenuStub::create_spe($merchant['spec_menu'],$access_token['access_token']);
        if (!empty($data['menuid']))
        {
            $_tip['msg']="创建个性菜单成功";
            include RPC_DIR .TEMPLATEPATH."/weixin/success_tip_tpl.php";
            exit;
        }
        elseif (!empty($data) && $data['errcode']==40001)
        {
            $common->Get_access_token(0);
            $_tip['msg']=$data['errmsg'];
            include RPC_DIR .TEMPLATEPATH."/weixin/err_tip_tpl.php";
        }else
        {
            $_tip['msg']='请求超时或者错误';
            include RPC_DIR .TEMPLATEPATH."/weixin/err_tip_tpl.php";
        }
        exit;
        break;
}

