<?php
   function upload()
   {
       $array = array('image/png','image/jpeg','image/jpg','image/gif');
       if(!isset($_FILES['file']) || empty($_FILES))
       {
           return array('code'=>1,'msg'=>'没有图片被上传');
       }
       if($_FILES['file']['size']>1024*1024*2)
       {
           return array('code'=>1,'msg'=>'图片尺寸不能超过2M');
       }
       if(!in_array($_FILES['file']['type'],$array))
       {
           return array('code'=>1,'msg'=>'文件格式不支持');
       }
       switch ($_FILES['file']['error'])
       {
           case 1:
               return array('code'=>1,'msg'=>'图片尺寸溢出');
               break;
           case 2:
               return array('code'=>1,'msg'=>'文件大小超过传输最大值');
               break;
           case 3:
               return array('code'=>1,'msg'=>'部分文件上传');
               break;
           case 4:
               return array('code'=>1,'msg'=>'没有文件被上传');
               break;
           case 6:
               return array('code'=>1,'msg'=>'找不到临时文件夹');
               break;
           case 7:
               return array('code'=>1,'msg'=>'文件写入失败');
               break;
       }
       $file_array = explode('.',$_FILES['file']['name']);
       $ext = $file_array[count($file_array) -1];
       $file_name = $filename = md5(time()) .rand(11111,99999). '.' . $ext;
       $dir_path = '../../upload/larger/';
       if(is_writable($dir_path))
       {
           if(move_uploaded_file($_FILES['file']['tmp_name'],$dir_path.$file_name))
           {
               $file_path = '/upload/larger/'.$file_name;
               return array('code'=>0,'msg'=>'success','path'=>$file_path);
           }else{
               return array('code'=>1,'msg'=>'文件上传失败');
           }
       }else{
           return array('code'=>1,'msg'=>'文件没有写入权限');
       }
   }
$return = upload();
echo json_encode($return);
?>