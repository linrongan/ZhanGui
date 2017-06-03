<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class UploadAction extends upload{
    function __construct($data)
    {
        parent::__construct($data);
    }

    //更新图片
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

    //执行上传
    public function ActionLoadUpload(){
        if(!isset($_FILES['file']) || empty($_FILES['file']['tmp_name']) || $_FILES['file']['error']!=0){
            echo json_encode(array('code'=>1,'msg'=>'请选择正确的图片'));exit;
        }
        $file = $this->upload_pic($_FILES['file'],RPC_DIR.SAVE_IMG_LARGER,WEBURL.SAVE_IMG_LARGER);
        if(!$file){
            echo json_encode(array('code'=>1,'msg'=>'图片上传失败'));exit;
        }
        echo json_encode(array('code'=>0,'msg'=>'图片上传成功','file'=>$file));exit;
    }
}
?>