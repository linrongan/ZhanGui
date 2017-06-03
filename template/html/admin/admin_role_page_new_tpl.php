<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
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
<section>
    <div class="mainpanel">
        <div class="contentpanel">
            <form enctype="multipart/form-data" id="checkform"  method="post" class="form-horizontal form-bordered" action="?mod=admin&_index=_role_page_new&_action=NewRoleAuth">
                <div class="panel panel-default">
                    <div class="panel-body panel-body-nopadding">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">新增菜单</h4>
                                <p></p>
                            </div>
                            <div class="panel-body panel-body-nopadding">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" >上级菜单：</label>
                                        <div class="col-sm-3">
                                            <select class="form-control mb15" id="ry_parent_id" name="ry_parent_id" required="" aria-required="true">
                                                <option value="0">顶级菜单...</option>
                                                <?php $page_array=$obj->GetAdminAuthPage(0);
                                                if (!empty($page_array))
                                                {
                                                $i=0;
                                                foreach ($page_array as $page)
                                                {
                                                $i++;
                                                ?>
                                                    <option value="<?php echo $page['id']; ?>"><?php echo $page['ry_menu']; ?></option>
                                                <?php
                                                if (!empty($page))
                                                {
                                                $array_key=array_keys($page);
                                                ?>
                                                    <?php //找出需要循环数组的二级分类
                                                    foreach ($array_key as $key=>$value)
                                                    {
                                                        if (is_array($page[$value]))
                                                        {
                                                        ?>
                                                            <option value=" <?php echo $page[$value]['id'];?>">
                                                                |_____
                                                                <?php echo $page[$value]['ry_menu'];?></option>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                        } ?>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" >菜单名称：</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="ry_menu" id="ry_menu" maxlength="20" class="form-control" placeholder="请输入分类名称" value="" required><span></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" >菜单类型：</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="menu_type" id="menu_type">
                                                <option value="0">菜单</option>
                                                <option value="1">功能</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" >链接：</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="ry_link" id="ry_link" maxlength="255" class="form-control" placeholder="" value="" >
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" >排序：</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="ry_order" id="ry_order" maxlength="20" class="form-control" placeholder="" value="0" required>
                                            <span></span>
                                        </div>
                                    </div>
                            </div><!-- panel-body -->
                            <!-- panel-footer -->
                        </div><!-- panel -->
                    </div><!-- panel-body -->

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary">提交</button>&nbsp;
                                <a href="?mod=admin&_index=_role_page" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </div><!-- panel-footer -->
                </div><!-- panel -->
            </form>
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/template/html/admin/js/custom.js"></script>
<script>
    $(function()
    {
        $( "#checkform" ).validate( {
            rules: {
                ry_parent_id:"required",
                ry_menu: "required"
            },
            messages: {
                ry_parent_id:"上级菜单微填写",
                ry_menu: "请输入菜单名称",

            }
        } );
    })
</script>
</body>
</html>