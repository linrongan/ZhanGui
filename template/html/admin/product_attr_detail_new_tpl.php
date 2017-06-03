<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$attr_type = $obj->GetAllAttr();
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
    <![endif]-->
    <style type="text/css">
        .red{color: red;}
    </style>
</head>
<body>
<section id="top">
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 产品中心 <span>产品分类</span>  <span>新增分类</span></h2>
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
                                    <form id="checkform" method="post"
                                          action="/?mod=admin&v_mod=product&_index=_attr_detail_new&_action=ActionNewAttrDetail" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">属性</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" required name="attr_type_id" id="attr_type_id">
                                                        <option value="">请选择属性</option>
                                                        <?php
                                                        if(!empty($attr_type))
                                                        {
                                                            foreach($attr_type as $item)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $item['attr_type_id']; ?>"><?php echo $item['attr_type_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">属性内容</label>
                                                <div class="col-sm-3">
                                                    <input name="attr_name" id="attr_name" maxlength="8" required type="text" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <button  class="btn btn-primary" type="submit">
                                                        确定
                                                    </button>&nbsp;
                                                    <a href="/?mod=admin&v_mod=product&_index=_attr_detail" class="btn btn-default"  type="button">
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
<script src="/tool/CheckForm/src/localization/messages_zh.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
<script>
    $(function(){
        $("#checkform").validate();
    });
</script>
</html>