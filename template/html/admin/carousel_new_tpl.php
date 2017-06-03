<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <link rel="stylesheet" href="/tool/upload/upload.css">
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
</head>
<body>
<section id="top">
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 图片管理 <span>轮播图</span>  <span>新增</span></h2>
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
                                          action="/?mod=admin&v_mod=carousel&_index=_new&_action=ActionNewCarousel" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">图片(640*350)</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-6">
                                                    <div id="fields_image_upload"></div>
                                                    <input type="hidden" name="fields_image" value="" id="fields_image">
                                                    <div id="fields_image_show"></div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">标题</label>
                                                <div class="col-sm-6">
                                                    <input name="fields_title" required maxlength="30" id="fields_title" type="text" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">链接</label>
                                                <div class="col-sm-6">
                                                    <input name="fields_link" id="fields_link" required type="text" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">排序</label>
                                                <div class="col-sm-3">
                                                    <input name="fields_order" id="fields_order" value="0" digits="true" value="" type="number" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">显示</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" required name="fields_show" id="fields_show">
                                                        <option value="">请选择</option>
                                                        <option value="0">是</option>
                                                        <option value="1">否</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="submit" value="确定" class="btn btn-primary">
                                                    <a href="/?mod=admin&v_mod=carousel&_index=_list" class="btn btn-default">
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
<script src="/tool/upload/upload.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
<script>
    $(function(){
        $("#checkform").validate();
        $('#fields_image_show').upload({
            auto: true,
            fileTypeExts: '*.jpg;*.png',
            multi: false,
            buttonText:'选择图片',
            fileSizeLimit: 2048,
            showUploadedPercent: true,//是否实时显示上传的百分比，如20%
            showUploadedSize: true,
            removeTimeout: 3,
            queueSizeLimit: 1,
            removeCompleted: true,
            uploader: '/tool/upload/upload.php',
            onUploadSuccess: function (file, res, response) {
                var result = $.parseJSON(res);
                if (result.code == 0) {
                    $("#fields_image").val(result.path);
                    $("#fields_image_show").empty();
                    $("#fields_image_show").append('<img src="' + result.path + '" width="100">');
                } else {
                    alert(result.msg);
                }
            }
        });
    });

</script>
</html>