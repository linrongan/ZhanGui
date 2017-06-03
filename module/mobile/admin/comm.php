<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include_once RPC_DIR .'/module/common/common.php';
Class comm extends common{
    function __construct($data)
    {
        $this->data=daddslashes($data);
    }

    //管理员登陆
    function AdminLogin()
    {
        if (!regExp::checkNULL($this->data['admin']))
        {
            return array("code"=>1,"msg"=>"管理员账号未填");
        }
        if (!regExp::checkNULL($this->data['pwd']))
        {
            return array("code"=>1,"msg"=>"管理员密码未填");
        }
        $data=$this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ADMIN." "
            ." WHERE admin_account='".$this->data['admin']."' "
            ." AND admin_pwd='".MD5($this->data['pwd'].APISECRET)."'");
        if ($data['admin_status']>0)
        {
            return array("code"=>1,"msg"=>"该管理员已经锁定");
        }
        if (!empty($data))
        {
            //更新登陆信息
            $this->GetDBMaster()->query("UPDATE ".TABLE_ADMIN." "
                ." SET admin_last_login='".date("Y-m-d H:i:s")."',"
                ." admin_login_count=admin_login_count+1 "
                ." WHERE admin_id='".$data['admin_id']."'");
            //插入登陆记录
            $this->GetDBMaster()->query("INSERT INTO ".TABLE_ADMIN_LOGIN."(admin_id,login_time,login_ip) "
                ." VALUES('".$data['admin_id']."','".date("Y-m-d H:i:s")."','".GetIP()."')");
            $_SESSION['role_id']=$data['role_id'];
            $_SESSION['admin_id']=$data['admin_id'];
            $_SESSION['admin_name'] = $data['admin_name'];
            return array("code"=>0,"msg"=>"成功登陆,正在跳转..");
        }
        return array("code"=>1,"msg"=>"账号或密码错误");
    }


    //检验是否有权限
    public function CheckAdminAuth($admin_id,$ry_qx_url='err')
    {
        //获取当前菜单id
        $common=array('admin#admin#_default#',
            'admin#admin##','admin#admin#_left_menu#',
            'admin#admin#_top_menu#','admin#admin##AdminLogout',
            'admin#admin#_default_tip#','admin#wechat#_gzhcd_content#',
            'admin#admin#_nofound#');
        if (in_array($ry_qx_url,$common))
        {
            return;
        }
        $data=$this->GetDBSlave1()->queryrow("SELECT AU.menu_id FROM ".TABLE_ADMIN_MENU." AS M "
            ." LEFT JOIN ".TABLE_ADMIN_AUTH." AS AU ON M.id=AU.menu_id "
            ." WHERE M.ry_qx_url='".$ry_qx_url."'"
            ." AND AU.admin_id=".intval($admin_id)." ");
        if (empty($data['menu_id']))
        {
            exit('Access Denied');
        }
    }


    //获取带参数二维码开始,$scene_str为二维码字符串，$shorturl是否需要转短链接
    protected function GetQrcode($scene_str,$shorturl=false)
    {
        $data=$this->Get_access_token($_SESSION['usercode']);
        if ($data['code']==1){
            return array("code"=>1,"msg"=>$data['msg']);
        }
        if (!regExp::checkNULL($scene_str)){
            return array("code"=>1,"msg"=>'场景字符错误');
        }
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$data['access_token'];
        $para='{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$scene_str.'"}}}';
        $ret = doCurlPostRequest($url, $para);
        $result=json_decode($ret,true);
        if (!empty($result['ticket'])){
            $qrcode='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result['ticket'];
            if($shorturl)
            {
                $para=json_encode(array("action"=>"long2short","long_url"=>$qrcode));
                $ret=doCurlPostRequest('https://api.weixin.qq.com/cgi-bin/shorturl?access_token='.$data['access_token'].'',$para);
                $shorturl_ret=json_decode($ret,true);
                if (isset($shorturl_ret['errcode']) && $shorturl_ret['errcode']==0)
                {
                    return array("code"=>0,"qrcode"=>$shorturl_ret['short_url']);
                }else
                {
                    return array("code"=>1,"msg"=>isset($shorturl_ret['errmsg'])?$shorturl_ret['errmsg']:"转换短连接时发生错误");
                }
            }
            return array("code"=>0,"qrcode"=>$qrcode);
        }else{
            return array("code"=>1,"msg"=>"生成带参数二维码错误","errmsg"=>$ret);
        }
    }


    //商品列表
    function GetProductList()
    {
        $where=$canshu="";
        $orderby='ORDER BY product_id DESC';
        if(isset($this->data['product_name']) && !empty($this->data['product_name'])){
            $where .= " AND product_name LIKE '%".$this->data['product_name']."%'";
            $canshu .="&product_name=".$this->data['product_name'];
        }
        $total=$this->GetDBSlave1()->queryrow("SELECT count(*) AS total FROM ".TABLE_PRODCUTS." "
            ." WHERE usercode='".$_SESSION['usercode']."' ".$where." ");
        if ((!isset($_REQUEST['curpage'])) or (!is_numeric($_REQUEST['curpage'])) or ($_REQUEST['curpage']<1))
        {
            $curpage=1;
        }
        else
        {
            $curpage=intval($_REQUEST['curpage']);
        }
        $page_size=24;
        if (isset($_REQUEST['page_size']))
        {
            $page_size=intval($_REQUEST['page_size']);
        }
        $array=$this->GetDBSlave1()->queryrows("SELECT * "
            ." FROM ".TABLE_PRODCUTS.""
            ." WHERE usercode='".$_SESSION['usercode']."' ".$where.""
            ." ".$orderby." LIMIT ".($curpage-1)*$page_size.",".$page_size."");
        return array("data"=>$array,"total"=>$total['total'],
            "curpage"=>$curpage,"page_size"=>$page_size,"canshu"=>$canshu);
    }


    //我的设备
    public function GetAllMachine(){
        $sql = "SELECT * FROM ".TABLE_MACHINE." WHERE usercode='".$_SESSION['usercode']."' ORDER BY machine_id ASC";
        return $this->GetDBSlave1()->queryrows($sql);
    }

    public function AjaxUpload(){
        if(!isset($_FILES['file']) || empty($_FILES['file']['tmp_name']) || $_FILES['file']['error']!=0){
            echo json_encode(array('code'=>1,'msg'=>'请选择正确的图片'));exit;
        }
        $file = $this->upload_pic($_FILES['file'],RPC_DIR.SAVE_IMG_LARGER,WEBURL.SAVE_IMG_LARGER);
        if(!$file){
            echo json_encode(array('code'=>1,'msg'=>'图片上传失败'));exit;
        }
        echo json_encode(array('code'=>0,'msg'=>'图片上传成功','file'=>$file));exit;
    }

    public function upload_pic($files,$tosrc,$web)
    {
        //支持的图片类型
        $imageArray = array('image/gif','image/gif', 'image/jpeg', 'image/png', 'image/bmp');
        if (is_uploaded_file($files['tmp_name']))
        {
            if($files['error']== 0 &&
                $files['size'] > 0 &&
                $files['size'] < 100 * 1024 * 1024)
            {
                $extArray = explode('.',$files['name']);
                $fileExt = $extArray[count($extArray) -1];
                $filename = md5(time()) .rand(11,99). '.' . $fileExt;
                //$filename此处随机文件名
                if(move_uploaded_file($files['tmp_name'], $tosrc.$filename))
                {
                    //成功,返回完整的图片地址
                    return  $web.$filename;
                }
                return false;
            }
            return false;
        }
        return false;
    }
}
?>