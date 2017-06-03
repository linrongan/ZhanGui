<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetSetNavigation();
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
</head>
<body>
<section id="top">
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 图片管理 <span>首页导航</span>  <span>编辑</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">图片管理</li>
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
                                    <form id="checkform" method="post"
                                          action="/?mod=admin&v_mod=navigation&_index=_edit&id=<?php echo $_GET['id']; ?>&_action=ActionSetNavigation" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">图片(640*350)</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-6">
                                                    <div id="fields_image_upload"></div>
                                                    <input type="hidden" name="fields_image" value="<?php echo $data['fields_image']; ?>" id="fields_image">
                                                    <div id="fields_image_show">
                                                        <?php
                                                        if($data['fields_image'])
                                                        {
                                                            ?>
                                                            <img width="50" src="<?php echo $data['fields_image']; ?>" alt="">
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">标题</label>
                                                <div class="col-sm-6">
                                                    <input name="fields_title" value="<?php echo $data['fields_title']; ?>" required maxlength="30" id="fields_title" type="text" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">链接</label>
                                                <div class="col-sm-6">
                                                    <input name="fields_link" id="fields_link"  required value="<?php echo $data['fields_link']; ?>" type="url" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">排序</label>
                                                <div class="col-sm-3">
                                                    <input name="fields_order" id="fields_order" required digits="true" value="<?php echo $data['fields_order']; ?>" type="number" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">显示</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" required name="fields_show" id="fields_show">
                                                        <option value="">请选择</option>
                                                        <option value="0" <?php echo $data['fields_show']==0?'selected':''; ?>>是</option>
                                                        <option value="1" <?php echo $data['fields_show']==1?'selected':''; ?>>否</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="submit" value="确定" class="btn btn-primary">
                                                    <a href="/?mod=admin&v_mod=navigation&_index=_list" class="btn btn-default">
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
<script src="/tool/layer/layer/layer.js"></script>
<script src="/tool/upload/uploadify/jquery.Huploadify.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
<script>
    $(function(){
        $("#checkform").validate();
        $('#fields_image_show').Huploadify({
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
                    $("#fields_image").val(data.file);
                    var file_img = '<img width="100" onclick="product_img_romve(this)" src="'+data.file+'">';
                    $("#category_img_show").empty();
                    $("#fields_image_show").append(file_img);
                }
            }
        });
    });

    function product_img_romve(obj) {
        if(confirm('是否要移除图片'))
        {
            $(obj).remove();
            $("#product_img").val('');
        }
    }
</script>
</html>