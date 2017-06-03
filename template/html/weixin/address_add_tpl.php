<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>添加地址</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .weui-cells:before {
         border-top:none;
        }
    </style>
</head>
<body>
    <div id="gg-app" style="padding:1.06rem 0 0 0">
        <div class="gg-detail-header">
            <span class="gg-detail_title sz16r">添加地址</span>
            <div class="return-back" onclick="javascript :history.back(-1);"></div>
        </div>

        <div class="weui-cells" style="margin-top: 0;">

            <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                    <label for="" class="weui-label sz14r">省份</label>
                </div>
                <div class="weui-cell__bd">
                    <select class="weui-select sz12r" name="province" id="province">
                        <option value="">--请选择省份--</option>
                        <?php
                            $province = $obj->GetProvince();
                            foreach($province as $item)
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                    <label for="" class="weui-label sz14r">城市</label>
                </div>
                <div class="weui-cell__bd">
                    <select class="weui-select sz12r" name="city" id="city">
                        <option value="">--请选择城市--</option>
                    </select>
                </div>
            </div>


            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea sz12r" id="address" placeholder="填写详细地址，例如区域，街道名称，楼层和门牌号等信息" rows="3" maxlength="200"></textarea>
                    <div class="weui-textarea-counter sz12r"><span id="count">0</span>/200</div>
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label sz14r">收件人</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input sz12r" type="text" id="shop_name"  placeholder="请输入收件人名称">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label sz14r">电话号码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input sz12r" id="shop_phone" type="number" placeholder="请输入电话号码">
                </div>
            </div>
        </div>

        <div style="padding:.8rem 10%;">
            <a href="javascript:;" id="submit" class="weui-btn weui-btn_primary sz16r">保存</a>
        </div>
    </div>
    <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
    <script type="text/javascript" src="/template/source/js/textarea.js"></script>
</body>
<script>
    $("select[name=province]").change(function () {
        var province_id = $(this).val();
        var url = '/?mod=weixin&v_mod=address&_action=ReturnJson&_fun_=GetCity';
        $.getJSON(url,'city_id='+province_id,function (res) {
            var option = '<option value="">--请选择城市--</option>';
            if(res)
            {
                for(var i=0;i<res.length;i++)
                {
                    option += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
                }
            }
            $("#city").empty();
            $("#area").empty();
            $("#city").append(option);
        });
    });

    $("select[name=city]").change(function () {
        var city_id = $(this).val();
        var url = '/?mod=weixin&v_mod=address&_action=ReturnJson&_fun_=GetArea';
        $.getJSON(url,'area_id='+city_id,function (res) {
            var option = '<option value="">--请选择区域--</option>';
            if(res)
            {
                for(var i=0;i<res.length;i++)
                {
                    option += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
                }
            }
            $("#area").empty();
            $("#area").append(option);
        });
    });


    $("#submit").click(function () {
       var province = $("#province option:selected").val();
       var city = $("#city option:selected").val();
       var area = $("#area option:selected").val();
       var address = $("#address").val();
       var shop_name = $("#shop_name").val();
       var shop_phone = $("#shop_phone").val();
       if(province=='' || isNaN(province))
       {
           alert('请选择省份');
           alert(province);
           return false;
       }
       if(city=='' || isNaN(city))
        {
            alert('请选择城市');
            return false;
        }

        if(address=='')
        {
            alert('请输入详细地址');
            return false;
        }
        if(shop_name=='')
        {
            alert('请输入收货人姓名');
            return false;
        }
        if(shop_phone=='')
        {
            alert('请输入收货人手机');
            return false;
        }else if(isNaN(shop_phone) || shop_phone.length!=11)
        {
            alert('手机号码格式错误');
            return false;
        }
        var data = {
            province_id:province,
            city_id:city,
            address:address,
            shop_name:shop_name,
            shop_phone:shop_phone
        };
       var back = '<?php if(isset($_GET['redirect'])){echo urldecode($_GET['redirect']);}else{echo '/?mod=weixin&v_mod=address&_index=_list';} ?>';
        $.ajax({
            type:"post",
            url:"/?mod=weixin&v_mod=address&_action=ActionNewAddress",
            data:data,
            dataType:"json",
            success:function (res) {
                alert(res.msg);
                if(res.code==0)
                {
                    location.href=back;
                }
            },
            error:function () {
                alert('网络超时');
            }
        });
    });
</script>
</html>