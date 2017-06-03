<?php
require_once  'WeChatCallBack.php';
class WeChatCallBackClass extends WeChatCallBack{
    protected function insert_input($db,$str)
    {
    }
    protected function is_run_more_service()
    {
        if (IS_RUN_MORE_SERVICE)
        {
            return $this->makeHead().'<MsgType><![CDATA[transfer_customer_service]]></MsgType></xml>';
        }
        elseif (AUTO_BACK)
        {
            return AUTO_BACK_CONTENT;
        }
        return '';
    }
    public function process($db){
        switch($this->_msgType)
        {
            case 'text';
                $str=addslashes($this->_postObject->Content);
                exit;
                break;
            case 'image';
                $str=",msgtype='image',image_picurl='".$this->_postObject->PicUrl."',image_mediaid='".$this->_postObject->MediaId."'";
                $this->insert_input($db,$str);
                return $this->is_run_more_service();
                break;
            case 'voice';
                $str=",msgtype='voice',voice_mediaid='".$this->_postObject->MediaId."',voice_format='".$this->_postObject->Format."'";
                $this->insert_input($db,$str);
                return $this->is_run_more_service();
                break;
            case 'video';
                $str=",msgtype='video',video_mediaid='".$this->_postObject->MediaId."',video_thumbmediaid='".$this->_postObject->ThumbMediaId."'";
                $this->insert_input($db,$str);
                return $this->is_run_more_service();
                break;
            case 'location';
                $str=",msgtype='location',location_x='".$this->_postObject->Location_X."',location_y='".$this->_postObject->Location_Y."',"
                    ."location_scale='".$this->_postObject->Scale."',location_label='".$this->_postObject->Label."'";
                $this->insert_input($db,$str);
                return $this->is_run_more_service();
                break;
            case 'link';
                $str=",msgtype='link',link_title='".$this->_postObject->Title."',link_description='".$this->_postObject->Description."',"
                    ."link_url='".$this->_postObject->Url."'";
                $this->insert_input($db,$str);
                return $this->is_run_more_service();
                break;
            case 'event';
                switch ($this->_event)
                {
                    case 'CLICK';
                        break;
                    case 'subscribe';
                        $is_has=$db->get_one("SELECT userid FROM ".TABLE_USER." WHERE openid='".$this->_fromUserName."'");
                        if (empty($is_has))
                        {
                            $db->query("INSERT INTO ".TABLE_USER." "
                                ."(openid,subscribe)VALUES('".$this->_fromUserName."',1)");
                            $is_has['userid']=$db->insert_id();
                        }
                        else
                        {
                            $db->query("UPDATE ".TABLE_USER." SET subscribe=1 WHERE "
                                ." openid='".$this->_fromUserName."'");
                        }
                        //带参数二维码关注开始-----------------------------------
                        if (isset($this->_postObject->EventKey) && $this->_postObject->EventKey<>"")
                        {
                            $touser=explode('qrscene_',$this->_postObject->EventKey);
                            $this->_postObject->EventKey=$touser[1];
                            $tuijian=false;
                            //当前扫描者身份
                            $is_has=$db->get_one("SELECT userid,parent_id "
                                ." FROM ".TABLE_USER." "
                                ." WHERE openid='".$this->_fromUserName."'");
                            if ($is_has['parent_id']==0)
                            {
                                //没人介绍过
                                $tuijian=true;
                            }
                            //要成为您上级的人
                            $parent=$db->get_one("SELECT userid,parent_id,parent_sub_id,parent_last_id,nickname "
                                ." FROM ".TABLE_USER_TO_INFO." "
                                ." WHERE userid='".$this->_postObject->EventKey."' AND user_level=1");
                            if (!empty($parent) && $tuijian && $this->_postObject->EventKey<>$is_has['userid']
                                && $is_has['userid']<>$parent['parent_id']
                                && $is_has['userid']<>$parent['parent_sub_id']
                                && $is_has['userid']<>$parent['parent_last_id']
                            )
                            {
                                //执行推荐关系
                                $db->query("UPDATE ".TABLE_USER_TO_INFO." SET "
                                    ." parent_id='".$this->_postObject->EventKey."',parent_sub_id='".$parent['parent_id']."',"
                                    ."parent_last_id='".$parent['parent_sub_id']."' WHERE "
                                    ." openid='".$this->_fromUserName."'");

                            //带参数二维码结束---------------------------------------------
                            $str_msg="欢迎您，您由[".addslashes($parent['nickname'])."]推荐成为成为".WEBNAME."的新会员，打造湘西土特产本土交易平台，我们竭诚为您提供满意的物美价廉的特产，给您带去无限购物享受！";
                            return $this->makeHead().'<MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$str_msg.']]></Content></xml>';
                          }
                        }

                        return $this->makeHead().'<MsgType><![CDATA[text]]></MsgType><Content><![CDATA[欢迎关注'.WEBNAME.']]></Content></xml>';
                        break;
                    case 'SCAN';
                        $tuijian=false;
                        //当前扫描者身份
                        $is_has=$db->get_one("SELECT userid,parent_id "
                            ."FROM ".TABLE_USER." WHERE openid='".$this->_fromUserName."'");
                        if ($is_has['parent_id']==0)
                        {
                            //没人介绍过
                            $tuijian=true;
                        }
                        //要成为您上级的人
                        $parent=$db->get_one("SELECT userid,parent_id,parent_sub_id,"
                            ." parent_last_id,nickname "
                            ." FROM ".TABLE_USER_TO_INFO." "
                            ." WHERE userid='".$this->_postObject->EventKey."' "
                            ." AND user_level=1");
                        if (!empty($parent) && $tuijian && $this->_postObject->EventKey<>$is_has['userid']
                            && $is_has['userid']<>$parent['parent_id']
                            && $is_has['userid']<>$parent['parent_sub_id']
                            && $is_has['userid']<>$parent['parent_last_id']
                        )
                        {
                            //执行推荐关系
                            $db->query("UPDATE ".TABLE_USER_TO_INFO." SET "
                                ." parent_id='".$this->_postObject->EventKey."',"
                                ." parent_sub_id='".$parent['parent_id']."',"
                                ." parent_last_id='".$parent['parent_sub_id']."' "
                                ." WHERE openid='".$this->_fromUserName."'");
                            //带参数二维码结束---------------------------------------------
                            $str_msg="温馨提示，您通过扫描[".addslashes($parent['nickname'])."]的专属二维码,成功绑定推荐关系。";
                            return $this->makeHead().'<MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$str_msg.']]></Content></xml>';
                        }
                        return $this->makeHead().'<MsgType><![CDATA[text]]></MsgType><Content><![CDATA[您正在进行扫码操作]]></Content></xml>';
                        break;
                    default:
                        exit;
                }
                break;
            default:
                return $this->makeHint ( "无法识别" );
        }
    }
}
?>