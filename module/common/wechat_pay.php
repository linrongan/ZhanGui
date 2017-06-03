<?php
error_reporting(0);
require_once RPC_DIR.'/module/mobile/WxPayPubHelper/WxPayPubHelper.php';
class wechat_pay extends common
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    public function WeChatPay($array=array())
    {
        $jsApi = new JsApi_pub();
        $openid=$_SESSION['openid'];
        $timeStamp = time().rand(1,1000);
        //生成唯一交易订单号
        $out_trade_no=$timeStamp;
        $unifiedOrder = new UnifiedOrder_pub();
        $unifiedOrder->setParameter("openid","$openid");
        $unifiedOrder->setParameter("body","支付订单");
        $unifiedOrder->setParameter("out_trade_no",$array['out_trade_no']);//商户订单号
        $unifiedOrder->setParameter("total_fee",$array['total_fee']*100);//总金额
        $unifiedOrder->setParameter("notify_url",$array['notify_url']);//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        $prepay_id = $unifiedOrder->getPrepayId();
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }

/*
 * 2017030998888
 * */

    function ListenUserPayProduct()
    {
        $log='';
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $out_trade_no=$return['out_trade_no'];
                $money=$return['total_fee']/100;//支付金额
                $order = $this->GetDBMaster()->queryrow("SELECT * FROM ".TABLE_ORDER." WHERE "
                    ." orderid='".$out_trade_no."'");
                if($order['recommend_id'])
                {
                    $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET parent_id='".$order['recommend_id']."' "
                        ." WHERE userid='".$order['userid']."'");
                }
                $this->GetDBMaster()->StartTransaction();
                //更改订单状态
                $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET order_status=3,"
                    ." pay_money='".$money."',pay_datetime='".date("Y-m-d H:i:s",time())."' WHERE "
                    ." orderid='".$out_trade_no."' ");
                //查询订单详情
                $details = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_DETAIL." WHERE "
                    ." orderid='".$out_trade_no."' ");
                if($details)
                {
                    if($order['order_type']==0)
                    {
                        $tabName = TABLE_PRODUCT;
                    }else{
                        $tabName = TABLE_GROUP_PRODUCT;
                    }
                    foreach($details as $item)
                    {
                        $this->GetDBMaster()->query("UPDATE ".$tabName." SET "
                            ." product_sold=product_sold+'".$item['product_count']."' "
                            ." WHERE product_id='".$item['product_id']."'");
                    }
                }
                //存储记录
                $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_PAY." SET pay_return='".json_encode($return)."' "
                    ." WHERE orderid='".$out_trade_no."'");
                if($res1 && $res2)
                {
                    $this->GetDBMaster()->SubmitTransaction();
                }
                $this->GetDBMaster()->RollbackTransaction();
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }


    function ListenCreateGroupResult()
    {
        $log='';
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $out_trade_no = $return['out_trade_no'];
                $money = $return['total_fee']/100;//支付金额
                $this->GetDBMaster()->StartTransaction();
                $group_over = date("Y-m-d H:i:s",time()+3600*24);   //一天作废
                //激活团购状态
                $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." SET group_over='".$group_over."',"
                    ." group_join=1,group_status=3,group_pay='".date("Y-m-d H:i:s",time())."' WHERE "
                    ." group_id='".$out_trade_no."'");
                $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GROUP." SET group_status=3,"
                    ." pay_date='".date("Y-m-d H:i:s".time())."' WHERE group_id='".$out_trade_no."'");
                $res3 = $this->GetDBMaster()->query("UPDATE ".TABLE_PAY." SET pay_return='".json_encode($return)."' "
                    ." WHERE orderid='".$out_trade_no."'");
                if($res1 && $res2 && $res3)
                {
                    $this->GetDBMaster()->SubmitTransaction();
                }
                $this->GetDBMaster()->RollbackTransaction();
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }



    //加入团购订单
    function listenGroupJoinResult()
    {
        $log='';
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $out_trade_no = $return['out_trade_no'];
                $money = $return['total_fee']/100;//支付金额
                $this->GetDBMaster()->StartTransaction();
                $group_order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER_GROUP." "
                    ." WHERE orderid='".$out_trade_no."'");
                $group = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP." WHERE "
                    ."group_id ='".$group_order['group_id']."'");
                $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." SET group_join=group_join+1 "
                    ." WHERE group_id='".$group_order['group_id']."'");
                $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER_GROUP." SET group_status=3, "
                    ."pay_date='".date("Y-m-d H:i:s",time())."' WHERE orderid='".$out_trade_no."'");
                $res3 = $this->GetDBMaster()->query("UPDATE ".TABLE_PAY." SET pay_return='".json_encode($return)."' "
                    ." WHERE orderid='".$out_trade_no."'");
                if($res1 && $res2)
                {
                    $this->GetDBMaster()->SubmitTransaction();

                    if($group['group_count']-$group['group_join']==1){
                        $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP." SET group_status=5 "
                            ." WHERE group_id='".$group_order['group_id']."'");
                        //取出所有团购订单
                        $list = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_GROUP." "
                            ." WHERE group_id='".$group_order['group_id']."' AND group_status=3");
                        //产品信息
                        $product = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_GROUP_PRODUCT." "
                            ." WHERE product_id='".$group['product_id']."'");
                        $product_count = 0;
                        if($list)
                        {
                            foreach($list as $item)
                            {
                                $product_count += $item['product_count'];
                                $this->GetDBMaster()->query("INSERT INTO ".TABLE_ORDER." "
                                    ." (orderid,userid,order_total,order_pro_money,order_pro_count,"
                                    ."order_ship_name,order_ship_phone,order_ship_sheng,order_ship_shi,"
                                    ."order_ship_qu,order_ship_address,order_img,order_addtime,order_status,"
                                    ."out_trade_no,pay_money,pay_datetime,order_type) VALUES('".$item['orderid']."',"
                                    ."'".$item['userid']."','".$item['group_total']."','".$item['group_total']."',"
                                    ."'".$item['product_count']."','".$item['shop_name']."','".$item['shop_phone']."',"
                                    ."'".$item['shop_province']."','".$item['shop_city']."','".$item['shop_area']."',"
                                    ."'".$item['shop_address']."','".$item['product_img']."','".$item['group_addtime']."',"
                                    ."'".$item['group_status']."','".$item['orderid']."','".$item['group_total']."',"
                                    ."'".$item['pay_date']."',2)");

                                $this->GetDBMaster()->query("INSERT INTO ".TABLE_ORDER_DETAIL." "
                                    ."(orderid,product_id,product_count,product_name,product_price,product_sum_price,"
                                    ."userid,product_img,addtime) VALUES('".$item['orderid']."','".$group['product_id']."',"
                                    ."'".$item['product_count']."','".$product['product_name']."','".$product['product_price']."',"
                                    ."'".$item['group_total']."','".$item['userid']."','".$item['product_img']."',"
                                    ."'".date("Y-m-d H:i:s",time())."')");
                            }
                        }
                        $this->GetDBMaster()->query("UPDATE ".TABLE_GROUP_PRODUCT." SET "
                            ." product_sold=product_sold+'".$product_count."' WHERE product_id='".$group['product_id']."'");
                    }
                }else{
                    $this->GetDBMaster()->RollbackTransaction();
                }
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }


    //用户购买代理或代理购买代理
    function ListenUserPayDailiProduct()
    {
        $log='';
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $out_trade_no = $return['out_trade_no'];
                $money = $return['total_fee']/100;//支付金额
                $this->GetDBMaster()->StartTransaction();
                //查出订单是铺货还是用户下单
                $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." WHERE "
                    ." orderid='".$out_trade_no."'");

                if($order)
                {
                    if($order['order_status']<3)
                    {
                        $daili = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_AUTHORIZE_USER_DETAIL." "
                            ." WHERE userid='".$order['userid']."'");
                        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET order_status=3,pay_money='".$money."',"
                            ." pay_datetime='".date("Y-m-d H:i:s".time())."' WHERE orderid='".$out_trade_no."'");
                        //查询订单详情
                        $order_details = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_ORDER_DETAIL." WHERE "
                            ." orderid='".$out_trade_no."'");
                        if($order_details)
                        {
                            foreach($order_details as $item)
                            {
                                $this->GetDBMaster()->query("UPDATE ".TABLE_STORE_PRODUCT." SET product_sold=product_sold+".$item['product_count'].","
                                    ." product_count=IF(product_count-".$item['product_count']."<=0,0,product_count-".$item['product_count'].") "
                                    ." WHERE product_id='".$item['product_id']."' AND userid='".$order['store_id']."'");
                                $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET product_sold=product_sold+".$item['product_count']." "
                                    ." WHERE product_id='".$item['product_id']."'");
                                $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_DAILI_YEJI." SET "
                                    ." userid='".$order['store_id']."',product_id='".$item['product_id']."',"
                                    ." product_name='".$item['product_name']."',product_price='".$item['product_price']."',"
                                    ." product_count='".$item['product_count']."',product_sum_price='".$item['product_sum_price']."',"
                                    ." user_parent_id='".$daili['userid']."',yeji_type=2,addtime='".date("Y-m-d H:i:s",time())."',"
                                    ." orderid='".$out_trade_no."'");
                            }
                        }
                        $title = '订单收益';
                        $res2 = $this->GetDBMaster()->query("INSERT INTO ".TABLE_LOG_GAINS." SET userid='".$order['store_id']."',"
                            ." title='".$title."',addtime='".date("Y-m-d H:i:s",time())."',fee='".$money."',status=1");
                        $res3 = $this->GetDBMaster()->query("UPDATE ".TABLE_PAY." SET pay_return='".json_encode($return)."' "
                            ." WHERE orderid='".$out_trade_no."'");
                        if($res1 && $res2 && $res3)
                        {
                            $this->GetDBMaster()->SubmitTransaction();
                        }else{
                            $this->GetDBMaster()->RollbackTransaction();
                        }
                    }
                }
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }


    function ListenDailiPayResult()
    {
        $log='';
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $out_trade_no = $return['out_trade_no'];
                $money = $return['total_fee']/100;//支付金额
                $orderid = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_D_ORDER."  "
                ." WHERE orderid='".$out_trade_no."'");
                $this->GetDBMaster()->StartTransaction();
                if(!empty($orderid))
                {
                    $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_D_ORDER." "
                        ." SET order_status=3,pay_money='".$money."',pay_datetime='".date("Y-m-d H:i:s",time())."'  "
                        ." WHERE orderid='".$out_trade_no."'");
                    $details = $this->GetDBSlave1()->queryrows("SELECT * FROM ".TABLE_D_ORDER_DETAIL."  "
                        ." WHERE orderid='".$out_trade_no."'");
                    //获取下单用户资料
                    $daili = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_AUTHORIZE_USER_DETAIL." "
                        ." WHERE userid='".$orderid['userid']."'");
                    if($details)
                    {
                        foreach($details as $item)
                        {
                            $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." "
                                ."SET product_sold=product_sold+'".$item['product_count']."' WHERE product_id='".$item['product_id']."'");
                            //业绩
                            $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_DAILI_YEJI." SET "
                                ." userid='".$orderid['userid']."',product_id='".$item['product_id']."',"
                                ." product_name='".$item['product_name']."',product_price='".$item['product_price']."',"
                                ." product_count='".$item['product_count']."',product_sum_price='".$item['product_sum_price']."',"
                                ." user_parent_id='".$daili['parent_id']."',yeji_type=1,addtime='".date("Y-m-d H:i:s",time())."',"
                                ." orderid='".$out_trade_no."'");
                        }

                    }
                    $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_PAY." SET pay_return='".json_encode($return)."' "
                        ." WHERE orderid='".$out_trade_no."'");
                    if($res1 && $res2)
                    {
                        $this->GetDBMaster()->SubmitTransaction();
                    }else{
                        $this->GetDBMaster()->RollbackTransaction();
                    }
                }
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }



    function charge_result()
    {
        $log='';
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $out_trade_no = $return['out_trade_no'];
                $money = $return['total_fee']/100;//支付金额
                $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_CHARGE_READY." WHERE "
                    ." orderid='".$out_trade_no."'");
                if(!empty($order))
                {
                    if($order['status']==1)
                    {
                        $this->GetDBMaster()->StartTransaction();
                        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_CHARGE_READY." SET status=3 WHERE "
                            ." orderid='".$out_trade_no."'");
                        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_USER." SET user_money=user_money+'".$order['money']."' "
                            ." WHERE userid='".$order['userid']."'");
                        $id = $this->GetDBMaster()->insertquery("INSERT INTO ".TABLE_CHARGE_ORDER." "
                            ."(orderid,userid,money,transaction_id,pay_money,time_end,status,addtime,"
                            ."err_status) VALUES('".$out_trade_no."','".$order['userid']."',"
                            ."'".$money."','".$return['transaction_id']."','".$money."','".$return['time_end']."',"
                            ."3,'".date("Y-m-d H:i:s",time())."',0)");
                        if($res && $res1 && $id)
                        {
                            $this->GetDBMaster()->SubmitTransaction();
                        }else{
                            $this->GetDBMaster()->RollbackTransaction();
                        }
                    }else{
                        $log .= '订单号'.$out_trade_no.'重复交易';
                    }
                }else{
                    $log .= '订单号'.$out_trade_no.'没有找到';
                }
                $this->GetDBMaster()->StartTransaction();
            }
            $this->AddLogAlert("充值",$log);
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }



    //秒杀回调
    function SeckillBack()
    {
        $log='';
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($notify->checkSign() == TRUE)
        {
            $return=$notify->xmlToArray($xml);
            if ($notify->data["return_code"] == "FAIL") {
                //通信出错
                $log='交易号'.$return['out_trade_no'].'出现异常';
            }elseif($notify->data["result_code"] == "FAIL"){
                $log='交易号'.$return['out_trade_no'].'业务错误';
            }else{
                $out_trade_no = $return['out_trade_no'];
                $money = $return['total_fee']/100;//支付金额
                $order = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_ORDER." WHERE "
                    ." orderid='".$out_trade_no."'");
                if(!empty($order))
                {
                    if($order['status']==1)
                    {
                        $this->GetDBMaster()->StartTransaction();
                        $seckill_temp = $this->GetDBSlave1()->queryrow("SELECT * FROM ".TABLE_SEKILL_TEMP." WHERE "
                            ." orderid='".$out_trade_no."'");
                        $res = $this->GetDBMaster()->query("UPDATE ".TABLE_SEKILL_TEMP." SET status=2 WHERE "
                            ." orderid='".$out_trade_no."'");
                        $res1 = $this->GetDBMaster()->query("UPDATE ".TABLE_SEKILL_PRODUCT." SET "
                            ."seckill_surplus_stock=seckill_surplus_stock-'".$seckill_temp['sekill_nums']."' "
                            ."WHERE id='".$seckill_temp['sekill_id']."'");
                        $res2 = $this->GetDBMaster()->query("UPDATE ".TABLE_ORDER." SET order_status=3,"
                            ."pay_money='".$money."',pay_datetime='".date("Y-m-d H:i:s",time())."' "
                            ."WHERE orderid='".$out_trade_no."'");
                        $res3 = $this->GetDBMaster()->query("UPDATE ".TABLE_PRODUCT." SET "
                            ."product_sold=product_sold+'".$seckill_temp['sekill_nums']."' "
                            ."WHERE product_id='".$seckill_temp['product_id']."'");
                        if($res && $res1 && $res2)
                        {
                            $log .= '订单号'.$out_trade_no.'秒杀';
                            $this->GetDBMaster()->SubmitTransaction();
                        }else{
                            $log .= '订单号'.$out_trade_no.'秒杀失败';
                            $this->GetDBMaster()->RollbackTransaction();
                        }
                    }else{
                        $log .= '订单号'.$out_trade_no.'重复交易';
                    }
                }else{
                    $log .= '订单号'.$out_trade_no.'没有找到';
                }
                $this->GetDBMaster()->StartTransaction();
            }
            $this->AddLogAlert("秒杀",$log);
            $returnXml = $notify->returnXml();
            echo $returnXml;
            exit;
        }
    }


}