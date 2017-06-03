<?php
/**
 *      (C)2014-2099 Guangzhou RuoYuWangLuo KeJi Inc.
 * 		若宇网 ruoyw.com
 *		这不是一个开源和免费软件,使用前请获得作者授权
 *      /inc/upload.class.php
 */
if(!defined('RUOYWCOM')) 
{
exit('Access Denied');
}

class Upload
{
	//$files文件,$tosrc存储物理目录,$web存储网址目录
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
    function more_upload_pic($files,$tosrc,$web)
    {
        $path = array();
        //支持的图片类型
        $imageArray = array('image/gif', 'image/gif', 'image/jpeg', 'image/png', 'image/bmp');
        if(count($files)<=0){
            return array('msg'=>'缺少文件');
        }
        for ($i = 0; $i <count($files['name']); $i++) {
            if(is_uploaded_file($files['tmp_name'][$i])){
                if ($files['error'][$i] == 0 && $files['size'][$i] && $files['size'][$i] < 1024 * 1024 * 2) {
                    $extArray = explode('.', $files['name'][$i]);
                    $fileExt = $extArray[count($extArray) - 1];
                    $filename = md5(time()) . rand(11, 99) . '.' . $fileExt;
                    if (move_uploaded_file($files['tmp_name'][$i],$tosrc.$filename)) {
                        $path[] = $web.$filename;
                    }else{
                        return array('msg'=>'移动失败');
                    }
                }else{
                    return array('msg'=>'第'.$i.'张图片文件过大');
                }
            }else{
                return array('msg'=>'上传途径不对');
            }
        }
        return $path;
    }
    //$files文件,$tosrc存储物理目录,$web存储网址目录
    public function upload_pic_reupload($files,$tosrc,$web,$picurl)
    {
        //支持的图片类型
        $imageArray = array('image/gif', 'image/jpeg', 'image/png', 'image/bmp');
        if (is_uploaded_file($files['tmp_name']))
        {
            if($files['error']== 0 &&
                $files['size'] > 0 &&
                $files['size'] < 2 * 1024 * 1024)
            {
                $extArray = explode('/',$picurl);
                $filename = $extArray[count($extArray) -1];
                //echo $filename;exit;
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
//$files文件,$tosrc存储物理目录,$web存储网址目录
public function upload_file($files,$tosrc,$web)
{
    //支持的图片类型
    $imageArray = array('application/pdf','application/zip','application/mp3',
        'application/mp4','application/mov');
    if (is_uploaded_file($files['tmp_name']))
    {
        if($files['error']== 0 &&
            $files['size'] > 0 &&
            $files['size'] < 5 * 1024 * 1024)
        {
            $extArray = explode('.',$files['name']);
            $fileExt = $extArray[count($extArray) -1];
            $filename = md5(time()) .rand(11,99). '.' . $fileExt;
            //$filename此处随机文件名
            if(move_uploaded_file($files['tmp_name'], $tosrc.$filename))
            {
                //成功,只返回文件地址
                return  $web.$filename;
            }
            return false;
        }
        return false;
    }
    return false;
}



    //198*262 388*513 755*999
    function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
    {
        if(!is_file($src_img))
        {
            return false;
        }
        $ot = $this->fileext($dst_img);
        $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
        $srcinfo = getimagesize($src_img);
        $src_w = $srcinfo[0];
        $src_h = $srcinfo[1];
        $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
        $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

        $dst_h = $height;
        $dst_w = $width;
        $x = $y = 0;

        /**
         * 缩略图不超过源图尺寸（前提是宽或高只有一个）
         */
        if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
        {
            $proportion = 1;
        }
        if($width> $src_w)
        {
            $dst_w = $width = $src_w;
        }
        if($height> $src_h)
        {
            $dst_h = $height = $src_h;
        }

        if(!$width && !$height && !$proportion)
        {
            return false;
        }
        if(!$proportion)
        {
            if($cut == 0)
            {
                if($dst_w && $dst_h)
                {
                    if($dst_w/$src_w> $dst_h/$src_h)
                    {
                        $dst_w = $src_w * ($dst_h / $src_h);
                        $x = 0 - ($dst_w - $width) / 2;
                    }
                    else
                    {
                        $dst_h = $src_h * ($dst_w / $src_w);
                        $y = 0 - ($dst_h - $height) / 2;
                    }
                }
                else if($dst_w xor $dst_h)
                {
                    if($dst_w && !$dst_h)  //有宽无高
                    {
                        $propor = $dst_w / $src_w;
                        $height = $dst_h  = $src_h * $propor;
                    }
                    else if(!$dst_w && $dst_h)  //有高无宽
                    {
                        $propor = $dst_h / $src_h;
                        $width  = $dst_w = $src_w * $propor;
                    }
                }
            }
            else
            {
                if(!$dst_h)  //裁剪时无高
                {
                    $height = $dst_h = $dst_w;
                }
                if(!$dst_w)  //裁剪时无宽
                {
                    $width = $dst_w = $dst_h;
                }
                $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
                $dst_w = (int)round($src_w * $propor);
                $dst_h = (int)round($src_h * $propor);
                $x = ($width - $dst_w) / 2;
                $y = ($height - $dst_h) / 2;
            }
        }
        else
        {
            $proportion = min($proportion, 1);
            $height = $dst_h = $src_h * $proportion;
            $width  = $dst_w = $src_w * $proportion;
        }

        $src = $createfun($src_img);
        $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        if(function_exists('imagecopyresampled'))
        {
            imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        }
        else
        {
            imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        }
        $otfunc($dst, $dst_img);
        imagedestroy($dst);
        imagedestroy($src);
        return true;
    }

    public function fileext($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }



}
?>