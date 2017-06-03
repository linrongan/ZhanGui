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
                    <option value="">广东省</option>
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
                    <option value="">广州市</option>
                </select>
            </div>
        </div>
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label sz14r">地区</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select sz12r" name="area" id="area">
                    <option value="">--请选择区域--</option>
                    <option value="">白云区</option>
                </select>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__bd">
                    <textarea class="weui-textarea sz12r" id="address" placeholder="填写详细地址，例如街道名称，楼层和门牌号等信息" rows="3"
                              maxlength="200"></textarea>
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
        <a href="javascript:;" onclick="location.href=history.back(-1)" class="weui-btn weui-btn_plain-primary">返回</a>
    </div>

</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/template/source/js/textarea.js"></script>
</body>
</html>