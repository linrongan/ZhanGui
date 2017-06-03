<?php
/**
 *		这不是一个开源和免费软件,使用前请获得作者授权
 */
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(empty($_GET['code']))
{
    redirect(NOFOUND.'&msg=商户信息错误,code未获取成功');
}
include RPC_DIR.'/module/common/common_wx.php';
$wx=new wx(array());
$_merchant=$wx->GetMerchant();
if (empty($_merchant))
{
    redirect(NOFOUND);
}
$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$_GET['code'].'&grant_type=authorization_code';
$ret_json=doCurlGetRequest($url);
$ret = json_decode($ret_json);;
if (empty($ret->openid))
{
    redirect(NOFOUND.'&msg=商户信息错误,openid未获取成功');
}
$data=$wx->Get_UserInfo(trim($ret->openid));
if ($data['code']===0)
{
    redirect($_SESSION['backurl']);
}else
{
    redirect(NOFOUND.'&msg='.$data['msg'].'');
}
?>