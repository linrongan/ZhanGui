<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$type = $obj->GetCategory();
$category = $type['category'];
$data = $obj->GetCategoryDetail();
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
    <![endif]-->
    <style type="text/css">
        .red{color: red;}
    </style>
</head>
<body>
<section id="top">
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 产品中心 <span>产品分类</span>  <span>编辑分类</span></h2>
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
                                    <div class="panel-heading">
                                        <h4 class="panel-title">编辑分类</h4>
                                        <p></p>
                                    </div>
                                    <form id="checkform" method="post"
                                          action="/?mod=admin&v_mod=category&_index=_edit&id=<?php echo $_GET['id']; ?>&_action=ActionEditCategory" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">分类图片(一级(450*230)其他(80*80))</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-6">
                                                    <div id="category_img_upload"></div>
                                                    <div id="category_img">
                                                        <?php
                                                            if(!empty($data['data']['category_img']))
                                                            {
                                                                ?>
                                                                    <input type="hidden" name="category_img[]" value="<?php echo $data['data']['category_img']; ?>">
                                                                <?php
                                                            }else{

                                                            }
                                                        ?>
                                                    </div>

                                                    <div id="category_img_show">
                                                        <?php
                                                            if(!empty($data['data']['category_img']))
                                                            {
                                                                ?>
                                                                <img width="50px" onclick="img_romove(this)" src="<?php echo $data['data']['category_img']; ?>" alt=""/>
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">商品分类</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" <?php if($data['str']){echo 'disabled';} ?> required name="category_id" id="category_id">
                                                        <option value="0">一级分类</option>
                                                        <?php
                                                        if($category[0]){
                                                            foreach($category[0] as $item){
                                                                ?>
                                                                <option <?php if($data['data']['parent_id']==$item['category_id']){echo 'selected';} ?> value="<?php echo $item['category_id']; ?>">----<?php echo $item['category_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">分类名称</label>
                                                <div class="col-sm-3">
                                                    <input name="category_name" required maxlength="30" id="category_name" value="<?php echo $data['data']['category_name']; ?>" type="text" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">分类描述</label>
                                                <div class="col-sm-3">
                                                    <textarea name="category_desc"  maxlength="255"  style="width:500px;height: 700px;"><?php echo $data['data']['category_desc']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">排序</label>
                                                <div class="col-sm-3">
                                                    <input name="ry_order" id="ry_order" digits="true" required value="<?php echo $data['data']['ry_order'] ?>" type="number" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">首页显示</label>
                                                <span class="asterisk">*</span>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" required name="show_status" id="show_status">
                                                        <option value="0" <?php echo $data['data']['show_status']==0?'selected':''; ?>>no</option>
                                                        <option value="1" <?php echo $data['data']['show_status']==1?'selected':''; ?>>yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="submit" value="确定" class="btn btn-primary">
                                                    <a href="/?mod=admin&v_mod=category&_index=_list" class="btn btn-default"  type="button">
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
<script charset="utf-8" src="/tool/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/tool/kindeditor/lang/zh_CN.js"></script>
<script src="/template/source/js/comm.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<script src="/tool/upload/upload.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
<script>
    $(function() {
        $("#checkform").validate();
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name=category_desc]', {
                allowFileManager : true
            });
        });
        $('#category_img_upload').upload({
            auto: true,
            fileTypeExts: '*.jpg;*.png',
            multi: false,
            buttonText:'选择图片',
            formData: {'format': 'small'},
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
                    layer.msg(result.msg, {icon: 6});
                    $("#category_img").append('<input type="hidden" name="category_img" value="'+result.path+'">');
                    var file_img = '<img width="100" onclick="img_romove(this)" src="'+result.path+'">';
                    $("#category_img_show").append(file_img);
                } else {
                    alert(result.msg);
                }
            }
        });

    });
    function img_romove(obj) {
        var this_index = $(obj).index();
        if(confirm('移除产品详情图第'+parseInt(this_index+1)+'张'))
        {
            $("#category_img").children('input').eq(this_index).remove();
            $(obj).remove();
        }
    }
</script>
</html>