<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$type = $obj->GetCategory();
$category = $type['category'];

$data = $obj->GetProductDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <link rel="stylesheet" href="/tool/upload/uploadify/Huploadify.css">
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
    <style>
        #input_items input{
            display: inline-block;
            width: 90%;
        }
        #input_items a{
            display: inline-block;
            width: 10%;
            text-align: center;
        }
        #attach_show a,#attach_del a{
            display: block;
            line-height: 30px;
        }
        .fa-remove:before{
            content: "\f00d";
        }
    </style>
</head>
<body>
<section id="top">
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 产品中心 <span>产品列表</span>  <span>编辑</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">产品中心</li>
                </ol>
            </div>
        </div>
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- BASIC WIZARD -->
                    <div class="basic-wizard" id="basicWizard">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="panel panel-default">
                                    <form enctype="multipart/form-data" id="checkform" method="post"
                                          action="/?mod=admin&v_mod=product&_index=_edit&id=<?php echo $_GET['id']; ?>&_action=ActionEditProduct" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">名称</label>
                                                <div class="col-sm-6">
                                                    <input  name="product_name" required maxlength="20" id="product_name" type="text" class="form-control" value="<?php echo $data['product_name']; ?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">描述</label>
                                                <div class="col-sm-6">
                                                    <textarea name="product_desc" maxlength="50" id="product_desc" style="width:500px;height: 100px;"><?php echo $data['product_desc']; ?></textarea>
                                                </div>
                                            </div>

                                            <!--是否首页显示-->
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">是否首页显示</label>
                                                <div class="col-sm-6">
                                                    <label class="radio-inline"><input <?php echo $data['is_tuijian']==0?'checked':''; ?> name="is_tuijian" type="radio" value="0" />否 </label>
                                                    <label class="radio-inline"><input <?php echo $data['is_tuijian']==1?'checked':''; ?> name="is_tuijian" type="radio" value="1" />是 </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">商品分类</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-6">
                                                    <select class="form-control mb13" required name="category_id" id="category_id">
                                                        <option value="">请选择分类</option>
                                                        <?php
                                                        if($category[0]){
                                                            foreach($category[0] as $item){
                                                                ?>
                                                                <option <?php if($data['category_id']==$item['category_id']){echo 'selected';} ?> value="<?php echo $item['category_id']; ?>"><?php echo $item['category_name']; ?></option>
                                                                <?php
                                                                if(!empty($category[$item['category_id']])){
                                                                    foreach($category[$item['category_id']] as $value){
                                                                        ?>
                                                                        <option <?php if($data['category_id']==$value['category_id']){echo 'selected';} ?> value="<?php echo $value['category_id']; ?>">
                                                                            |__<?php echo $value['category_name']; ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">图片(封面)(宽*高100*150)</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-6">
                                                    <div id="product_img_upload"></div>
                                                    <input type="hidden" name="product_img" value="<?php echo $data['product_img']; ?>"  id="product_img">
                                                    <div id="product_img_show">
                                                        <?php
                                                            if(!empty($data['product_img']))
                                                            {
                                                                ?>
                                                                <img onclick="product_img_romove(this)" src="<?php echo $data['product_img']; ?>" width="100" alt="">
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">图片(轮播图)(宽*高100*150)</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-6">
                                                    <div id="product_details_img_upload"></div>
                                                    <div id="img_items">
                                                        <?php
                                                            if(!empty($data['product_details_img']))
                                                            {
                                                                $imgs = unserialize($data['product_details_img']);
                                                                for($i=0;$i<count($imgs);$i++)
                                                                {
                                                                    ?>
                                                                    <input type="hidden" name="product_details_img[]" value="<?php echo $imgs[$i]; ?>">
                                                                    <?php
                                                                }
                                                            }else{
                                                                $imgs = null;
                                                            }
                                                        ?>
                                                    </div>
                                                    <div id="product_details_img_show">
                                                        <?php
                                                            if($imgs)
                                                            {
                                                                for($i=0;$i<count($imgs);$i++)
                                                                {
                                                                    ?>
                                                                    <img onclick="product_details_img_romove(this)" src="<?php echo $imgs[$i]; ?>" width="100" alt="">
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    标价
                                                </label>
                                                <div class="col-sm-3">
                                                    <input maxlength="11" required name="product_fake_price" number="true"  type="text" class="form-control" value="<?php echo $data['product_fake_price']; ?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    售价
                                                </label>
                                                <div class="col-sm-3">
                                                    <input maxlength="11" required name="product_price" number="true"  type="text" class="form-control" value="<?php echo $data['product_price']; ?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    运费
                                                </label>
                                                <div class="col-sm-3">
                                                    <input maxlength="10" name="freight" number="true"  type="text" class="form-control" value="<?php echo $data['freight']; ?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="color: #0000ff" class="col-sm-3 control-label">温馨提示：</label>
                                                <div class="col-sm-6">
                                                    <textarea style="color: red" name="reminder"  maxlength="50" class="form-control"><?php echo $data['reminder']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">图文</label>
                                                <div class="col-sm-6">
                                                    <textarea name="product_text"  maxlength="50"  style="width:500px;height: 700px;"><?php echo $data['product_text']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">参数</label>
                                                <div class="col-sm-6">
                                                    <textarea name="product_param" style="width:500px;height: 700px;"><?php echo $data['product_param']; ?></textarea>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">排序</label>
                                                <div class="col-sm-3">
                                                    <input  name="product_sort" type="number" class="form-control" value="<?php echo $data['product_sort']; ?>" />
                                                </div>
                                                <div class="col-sm-3">
                                                     <span class="help-block fa fa-info-circle red" >
                                                         数字越小越前
                                                     </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">状态</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-6">
                                                    <select class="form-control mb13" required name="product_status">
                                                        <option value="">请选择状态</option>
                                                        <option value="0" <?php echo $data['product_status']==0?'selected':''; ?>>上架</option>
                                                        <option value="1" <?php echo $data['product_status']==1?'selected':''; ?>>下架</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="submit" value="确定" class="btn btn-primary">
                                                    <a href="?mod=admin&v_mod=product&_index=_list" class="btn btn-default"  type="button">
                                                        返回上一页
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- panel-footer -->
                                </div>
                            </div>
                        </div><!-- tab-content -->
                    </div><!-- #basicWizard -->
                </div><!-- panel-body -->
            </div><!-- panel -->
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/CheckForm/dist/jquery.validate.js"></script>
<script src="/tool/CheckForm/dist/localization/messages_zh.js"></script>
<script src="/template/source/js/comm.js"></script>
<script charset="utf-8" src="/tool/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/tool/kindeditor/lang/zh_CN.js"></script>
<script src="/tool/upload/uploadify/jquery.Huploadify.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<script>
    $(function(){
        $("#checkform").validate();
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name=product_text]', {
                allowFileManager : true
            });
        });
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name=product_param]', {
                allowFileManager : true
            });
        });


        $('#product_img_upload').Huploadify({
            auto:true,
            fileTypeExts:'*.jpg;*.png',
            multi:false,
            fileSizeLimit:2048,
            showUploadedPercent:true,//是否实时显示上传的百分比，如20%
            showUploadedSize:true,
            removeTimeout:3,
            queueSizeLimit: 1,
            removeCompleted:true,
            uploader:'/?mod=admin&_action=AjaxUpload',
            onUploadStart:function(){
                //alert('开始上传');
            },
            onInit:function(){
                //alert('初始化');
            },
            onUploadComplete:function(){
                //alert('上传完成');
            },
            onDelete:function(file){
                console.log('删除的文件：'+file);
                console.log(file);
            },
            'onUploadSuccess':function(file,res,response){
                var data = $.parseJSON(res);
                if(data.code==1){
                    layer.msg(data.msg, {icon: 5});
                }else{
                    layer.msg(data.msg, {icon: 6});
                    $("#product_img").val(data.file);
                    var file_img = '<img width="100" onclick="product_img_romove(this)" src="'+data.file+'">';
                    $("#product_img_show").empty();
                    $("#product_img_show").append(file_img);
                }
            }
        });

        $('#product_details_img_upload').Huploadify({
            auto:true,
            fileTypeExts:'*.jpg;*.png',
            multi:false,
            fileSizeLimit:2048,
            showUploadedPercent:true,//是否实时显示上传的百分比，如20%
            showUploadedSize:true,
            removeTimeout:3,
            queueSizeLimit: 1,
            removeCompleted:true,
            uploader:'/?mod=admin&_action=AjaxUpload',
            onUploadStart:function(){
                //alert('开始上传');
            },
            onInit:function(){
                //alert('初始化');
            },
            onUploadComplete:function(){
                //alert('上传完成');
            },
            onDelete:function(file){
                console.log('删除的文件：'+file);
                console.log(file);
            },
            'onUploadSuccess':function(file,res,response){
                var data = $.parseJSON(res);
                if(data.code==1){
                    layer.msg(data.msg, {icon: 5});
                }else{
                    layer.msg(data.msg, {icon: 6});
                    $("#img_items").append('<input type="hidden" name="product_details_img[]" value="'+data.file+'">');
                    var file_img = '<img width="100" onclick="product_details_img_romove(this)" src="'+data.file+'">';
                    $("#product_details_img_show").append(file_img);
                }
            }
        });
    });

    function product_img_romove(obj) {
        if(confirm('移除当前图片？'))
        {
            $("#product_img").val('');
            $(obj).remove();
        }
    }

    function product_details_img_romove(obj) {
        var this_index = $(obj).index();
        if(confirm('移除产品详情图第'+parseInt(this_index+1)+'张'))
        {
            $("#img_items").children('input').eq(this_index).remove();
            $(obj).remove();
        }
    }
    function attach_romove(obj) {
        var this_index = $(obj).index();
        if(confirm('移除附件'+parseInt(this_index+1)+'？'))
        {
            $("#attach_items").children('input').eq(this_index).remove();
            $("#attach_show").children('a').eq(this_index).remove();
            $(obj).remove();
        }
    }
</script>
<?php include "footer_tpl.php"; ?>
</body>
</html>