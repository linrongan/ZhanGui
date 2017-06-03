<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
class ProductAction extends product
{
    function __construct($data)
    {
        $this->data = $data;
    }

    //产品收藏
    public function CancelProductColle()
    {
        if(!regExp::checkNULL($this->data['product']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        $arr = array(1,2);
        if(!regExp::checkNULL($this->data['type']) ||
            !in_array($this->data['type'],$arr))
        {
            return array('code'=>1,'msg'=>'未知产品类型');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT_COLLE." "
            ." WHERE product_id='".$this->data['product']."' AND userid='".$_SESSION['userid']."' "
            ." AND product_type='".$this->data['type']."'");
        if(!$data)
        {
            $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_PRODUCT." "
                ." WHERE product_id='".$this->data['product']."'");
            if(!$product)
            {
                return array('code'=>1,'msg'=>'产品不存在');
            }
            $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_PRODUCT_COLLE." "
                ." SET userid='".$_SESSION['userid']."',product_id='".$this->data['product']."',"
                ." addtime='".date("Y-m-d H:i:s",time())."',product_type='".$this->data['type']."',"
                ." product_img='".$product['product_img']."',product_name='".$product['product_name']."',"
                ." product_price='".$product['product_price']."'");
            if($id)
            {
                return array('code'=>0,'msg'=>'已收藏','type'=>1);
            }else{
                return array('code'=>0,'msg'=>'收藏失败');
            }
        }else{
            $res = $this->GetDBMaster()->query("DELETE FROM ".TABLE_PRODUCT_COLLE." "
                ." WHERE product_id='".$this->data['product']."' AND userid='".$_SESSION['userid']."' "
                ." AND product_type='".$this->data['type']."'");
            if($res)
            {
                return array('code'=>0,'msg'=>'已取消','type'=>2);
            }
            return array('code'=>0,'msg'=>'取消失败');
        }
    }
    public function ActionCancelProductColle()
    {
        echo json_encode($this->CancelProductColle());exit;
    }



    //产品评论
    public function ProductComment()
    {
        if(!regExp::checkNULL($this->data['comm_id']))
        {
            return array('code'=>1,'msg'=>'参数错误');
        }
        if(!regExp::checkNULL($this->data['content']))
        {
            return array('code'=>1,'msg'=>'请输入评论内容');
        }
        if(!regExp::checkNULL($this->data['count']))
        {
            return array('code'=>1,'msg'=>'请选择星级');
        }
        $data = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_DETAIL." "
            ." WHERE id='".$this->data['comm_id']."' AND userid='".$_SESSION['userid']."'");
        if(!$data)
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }elseif($data['is_comment']==1)
        {
            return array('code'=>1,'msg'=>'产品已经评论过了');
        }
        $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." "
            ." WHERE orderid='".$data['orderid']."'");
        $order_count = $this->GetDBSlave1()->queryrow("SELECT COUNT(*) AS count FROM ".TABLE_ORDER_DETAIL." "
            ." WHERE orderid='".$data['orderid']."' AND is_comment=0");
        if(!$order)
        {
            return array('code'=>1,'msg'=>'订单不存在');
        }elseif($order['order_status']!=6)
        {
            return array('code'=>1,'msg'=>'订单状态错误');
        }
        $this->GetDBMaster()->StartTransaction();
        $res = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_COMMENT." "
            ." SET orderid='".$data['orderid']."',product_id='".$data['product_id']."',"
            ." product_type='".$order['order_type']."',userid='".$_SESSION['userid']."',comment='".$this->data['content']."',"
            ." addtime='".date("Y-m-d H:i:s",time(0))."',comment_level='".$this->data['count']."',"
            ." is_show=1");
        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_DETAIL." SET "
            ." is_comment=1 WHERE id='".$this->data['comm_id']."'");
        if($order_count['count']==1)
        {
            $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET order_status=8 "
                ." WHERE orderid='".$data['orderid']."'");
        }else{
            $res2 = true;
        }
        if($res && $res1 && $res2)
        {

            $this->GetDBMaster()->SubmitTransaction();
            return array('code'=>0,'msg'=>'评论成功,审核后将显示！','orderid'=>$data['orderid']);
        }
        $this->GetDBMaster()->RollbackTransaction();
        return array('code'=>1,'msg'=>'评论失败');
    }


    public function ActionProductComment()
    {
        echo json_encode($this->ProductComment());exit;
    }

}