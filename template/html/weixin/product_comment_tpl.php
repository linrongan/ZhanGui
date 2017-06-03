<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetOrderDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>填写评论</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .user-img>img {
            width: 1rem;
            height: 1rem;
            display: block;
            margin-right: .2rem;
            border-radius: 0;
        }
		.weui-btn_gray{background:#CCC;}
		.fanGui{position:fixed; left:50%; top:50%; width:80%; margin-left:-43%; height:auto; margin-top:-150px; background:rgba(0,0,0,0.7); border-radius:10px; display:none;}
		.weui-cells__title{color:white; position:relative; }
		#star>p{color:white;}
		.remove-comment{font-size:24px; color:white; position:absolute; right:0; top:-8px;}
    </style>
</head>

<body>

    <div id="gg-app" style="padding:.8rem 0 0 0">
        <div class="gg-detail-header">
            <span class="gg-detail_title sz16r">填写评论</span>
            <div class="return-back" onclick="javascript :history.back(-1);"></div>
        </div>
        <div class="weui-cells__title" style="padding-left:3%; color:#333;">点击评论</div>
        <div class=" weui-cells" style="margin-top:0;">
            <?php
                for($i=0;$i<count($data['details']);$i++){
                    ?>
                    <div class="weui-cell" onclick="pinglun(<?php echo $data['details'][$i]['id']; ?>,<?php echo $data['details'][$i]['is_comment']; ?>)">
                        <div class="weui-cell__hd user-img">
                            <img src="<?php echo $data['details'][$i]['product_img']; ?>" alt="">
                        </div>
                        <div class="weui-cell__bd ">
                        	<div class="sz12r cl999"><?php if($data['details'][$i]['is_comment']){echo '已评论';} ?></div>
                            <div class="sz14r mtr01"><?php echo $data['details'][$i]['product_name']; ?></div>
                        </div>
                        <div class="fr cl999 sz12r"><?php echo '<span style="color:red;">'.$data['details'][$i]['product_price'].'</span>'.'x'.$data['details'][$i]['product_count']; ?></div>
                    </div>
                    <?php
                }
            ?>
        </div>
        <div class="fanGui">
            <div class="weui-cells__title sz14r">评价<span class="remove-comment" onClick="hideComment()">×</span></div>
            <div class="weui-cells-star" id="star">
                <ul class="fl">
                    <li class="on"><a href="javascript:;">1</a></li>
                    <li class="on"><a href="javascript:;">2</a></li>
                    <li class="on"><a href="javascript:;">3</a></li>
                    <li class="on"><a href="javascript:;">4</a></li>
                    <li class="on"><a href="javascript:;">5</a></li>
                </ul>
                <p class="fl sz12r">谢谢亲，打了个：很好</p>
                <div class="clearfix"></div>
            </div>
            <div class="weui-cells__title sz14r">评论内容</div>
            <div class="weui-cells weui-cells_form" style="border-radius:5px;">
                <div class="weui-cell">
                    <div class="weui-cell__bd sz12r">
                        <input type="hidden" id="comm_id" value="">
                        <textarea class="weui-textarea" id="message" maxlength="200" placeholder="请输入文本" rows="5"></textarea>
                        <div class="weui-textarea-counter"><span id="count">0</span>/200</div>
                    </div>
                </div>
            </div>
            <div class="page__bd page__bd_spacing" style="padding:.4rem 10%; .2rem;">
                <a href="javascript:;" id="submit_comment" class="weui-btn weui-btn_primary sz16r">提交</a>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
    <script type="text/javascript" src="/template/source/js/textarea.js"></script>

    <script>
        $(function(){
            var arr = ['很差','差','一般',"好","很好"];
            var pinnum = 4;
            var i = 0;
            for(i = 0; i<= pinnum; i++){
                $("#star>ul>li").eq(i).addClass("on");
                $("#star>p").html('谢谢亲，打了个：'+arr[pinnum]);
            }

            $("#star>ul>li").click(function(){
                $("#star>ul>li").removeClass("on");
                var Index = $(this).index();
                if(Index){}
                var i = 0;
                for(i = 0; i <= Index; i++){
                    $("#star>ul>li").eq(i).addClass("on");
                    $("#star>p").html('谢谢亲，打了个：'+arr[Index]);
                }
            });

        });


        function pinglun(id,is_comment) {
            if(!id || isNaN(id))
            {
                return false;
            }
            if(is_comment)
            {
                alert('已评论！');
                return false;
            }
            $("#comm_id").val(id);
            $(".fanGui").show();
        }
		
		
		function hideComment(){
			$(".fanGui").hide();
            $("#comm_id").val('');
		}
        var request = 1;
		$("#submit_comment").click(function () {
		    if(!request)
		    {
		        return false;
            }
            var comm_id = $("#comm_id").val();
            if(!comm_id || isNaN(comm_id))
            {
                alert('参数错误');
                return false;
            }
            var message = $("#message").val();
            if(message=='')
            {
                alert('请输入评论内容');
                return false;
            }else if(message.length<5)
            {
                alert('至少输入5个字的评论的内容');
                return false;
            }
            var count = Getselectstar();
            var data = {
                count:count,
                comm_id:comm_id,
                content:message
            };
            request = 0;
            $.ajax({
                type:"post",
                url:"/?mod=weixin&v_mod=product&_action=ActionProductComment",
                data:data,
                success:function (res) {
                    request = 1;
                    alert(res.msg);
                    if(res.code==0)
                    {
                        location.href='?mod=weixin&v_mod=product&_index=_comment&orderid='+res.orderid;
                    }
                },
                error:function () {
                    request = 1;
                    alert('网络超时');
                },
                dataType:"json"
            });
        });


		function Getselectstar() {
		    var count = 0;
            $("#star ul >li").each(function () {
               if($(this).hasClass('on'))
               {
                   count++;
               }
            });
            return count;
        }
    </script>
</body>
</html>