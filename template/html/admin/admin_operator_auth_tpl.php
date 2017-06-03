<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$auth=$obj->GetChildAuthMenu();
$data=$obj->GetAdminAuthPage();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <script src="/template/source/js/jquery.js"></script>
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
</head>
<body>
<form method="post" action="/?mod=admin&_index=_operator_auth&admin_id=<?php echo $_GET['admin_id']; ?>&_action=EditAuthAction">
    <section>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data)){
                            foreach($data as $item){
                                ?>
                                <tr class="odd gradeX">
                                    <td class="center">
                                        <span class="fa fa-folder-o"></span>
                                        <?php echo $item['ry_menu'];?>
                                    </td>
                                    <td class="center">
                                        <input name="auth[]" value="<?php echo $item['id']; ?>" type="checkbox" <?php if (in_array($item['id'],$auth['data'])){echo 'checked';} ?>>
                                    </td>
                                </tr>
                                <?php
                                if (!empty($item))
                                {
                                    $array_key=array_keys($item);
                                    //找出需要循环数组的二级分类
                                    foreach ($array_key as $key=>$value)
                                    {
                                        if (is_array($item[$value]))
                                        {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="center">
                                                    &nbsp;&nbsp;&nbsp;|_____ <span class="fa fa-folder-open-o"></span>
                                                    <?php echo $item[$value]['ry_menu'];?>
                                                </td>
                                                <td class="center">
                                                    <input value="<?php echo $item[$value]['id'];  ?>" name="auth[]" <?php if (in_array($item[$value]['id'],$auth['data'])){echo 'checked';} ?> type="checkbox">
                                                </td>
                                            </tr>
                                            <?php
                                            $array_key_sub=array_keys($item[$value]);
                                            foreach ($array_key_sub as $k=>$v)
                                            {
                                                if (is_array($item[$value][$v]))
                                                {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|_____<span class="fa fa-key"></span>
                                                            <?php echo $item[$value][$v]['ry_menu'];?>
                                                        </td>
                                                        <td class="center">
                                                            <input name="auth[]" value="<?php echo $item[$value][$v]['id'];  ?>" <?php if (in_array($item[$value]['id'],$auth['data'])){echo 'checked';} ?> type="checkbox">
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button class="btn btn-primary" type="submit">提交</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<?php include "footer_tpl.php"; ?>
</body>
</html>