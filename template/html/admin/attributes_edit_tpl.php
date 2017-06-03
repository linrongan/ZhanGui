<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetAttrTypeDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
</head>
<body>
<section id="top">
    <div class="mainpanel">
        <!--<div class="pageheader">
            <h2> 产品中心 <span>产品分类</span>  <span>编辑分类</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">产品中心</li>
                </ol>
            </div>
        </div>-->
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
                                          action="/?mod=admin&v_mod=attributes&_index=_edit&id=<?php echo $_GET['id']; ?>&_action=ActionEditAttrType" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">属性分类名</label>
                                                <div class="col-sm-3">
                                                    <input name="attr_type_name" required maxlength="30" value="<?php echo $data['attr_type_name']; ?>" type="text" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">排序</label>
                                                <div class="col-sm-3">
                                                    <input name="attr_sort" digits="true" required value="<?php echo $data['attr_sort']; ?>" type="number" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="submit" value="确定" class="btn btn-primary">
                                                    <a href="javascript:;" id="cpanel" class="btn btn-default"  type="button">
                                                        关闭
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
<?php include "footer_tpl.php"; ?>
</body>
<script>
    $(function(){
        $("#checkform").validate();

        $("#cpanel").click(function () {
            parent.location.reload();
            parent.layer.closeAll();
        });
    });
</script>
</html>