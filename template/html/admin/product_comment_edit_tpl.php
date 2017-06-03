<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetProductCommentDetails();
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
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- BASIC WIZARD -->
                    <div class="basic-wizard" id="basicWizard">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">编辑评论</h4>
                                        <p></p>
                                    </div>
                                    <form id="checkform" method="post"
                                          action="/?mod=admin&v_mod=product&_index=_comment_edit&id=<?php echo $_GET['id']; ?>&_action=ActionEditProductComment" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">评论人</label>
                                                <div class="col-sm-3">
                                                    <div style="padding: 10px;">
                                                        <?php echo $data['nickname']; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">评论内容</label>
                                                <div class="col-sm-3">
                                                    <div style="padding: 10px;">
                                                        <?php echo $data['comment']; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">审核</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" required name="is_show" id="is_show">
                                                        <option value="">请选择是否通过</option>
                                                        <option <?php echo $data['is_show']==0?'selected':'';?> value="0">是</option>
                                                        <option <?php echo $data['is_show']==1?'selected':'';?> value="1">否</option>
                                                    </select>
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