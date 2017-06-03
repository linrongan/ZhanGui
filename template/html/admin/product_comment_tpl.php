<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetProductComment();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section>
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 产品管理 <span>产品评论</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">产品评论</li>
                </ol>
            </div>
        </div>
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" method="post" action="">
                        <div class="form-group">
                            <input value="<?php echo isset($_REQUEST['search'])?trim($_REQUEST['search']):""; ?>" type="text"
                                   placeholder="请输入评论内容、用户昵称、产品Id" id="search" name="search" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">查询</button>
                        <a href="/?mod=admin&v_mod=product&_index=_comment" class="btn btn-default">返回</a>
                    </form>
                </div><!-- panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive dataTable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>产品图片</th>
                                <th>产品名</th>
                                <th>用户头像</th>
                                <th>用户昵称</th>
                                <th>评论内容</th>
                                <th>评论等级</th>
                                <th>订单号</th>
                                <th>时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['data'])){
                                foreach($data['data'] as $item){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center">
                                            <img width="50" src="<?php echo $item['product_img']; ?>" alt="">
                                        </td>
                                        <td class="center" id="product_<?php echo $item['id']; ?>" onmouseover="layer.tips('<?php echo $item['product_name']; ?>', '#product_<?php echo $item['id']; ?>', {tips: [1, '#3595CC'],time: 4000});">
                                            <?php echo mb_substr($item['product_name'],0,10,'utf-8'); ?>
                                        </td>
                                        <td class="center">
                                            <img src="<?php echo $item['headimgurl']; ?>" width="50" alt="">
                                        </td>
                                        <td class="center">
                                            <?php echo $item['nickname']; ?>
                                        </td>
                                        <td class="center" id="comment_<?php echo $item['id']; ?>" onmouseover="layer.tips('<?php echo $item['comment_text']; ?>', '#comment_<?php echo $item['id']; ?>', {tips: [1, '#3595CC'],time: 4000});">
                                            <?php echo mb_substr($item['comment'],0,12,'utf-8'); ?>
                                        </td>
                                        <td class="center">
                                            <?php if($item['comment_level']==1){
                                                echo '好评';
                                            }else if($item['comment_level']==2){
                                                echo '中评';
                                            }else{
                                                echo '差评';
                                            } ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['orderid']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['addtime'] ?>
                                        </td>
                                        <td>
                                            <a title="编辑" onclick="comment_edit(<?php echo $item['id']; ?>)" href="javascript:;">
                                                <span class="fa fa-edit"></span>
                                            </a>
                                            <a onclick="return confirm('确定要删除吗？')" href="/?mod=admin&v_mod=product&_index=_comment&id=<?php echo $item['id'] ?>&_action=ActionDelComment"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                        <?php
                        include RPC_DIR ."/inc/page_nav.php";
                        $page=new page_nav(array("total"=>$data['total'],
                            "page_size"=>$data['page_size'],
                            "curpage"=>$data['curpage'],
                            "extUrl"=>"",
                            "canshu"=>'&mod=admin&v_mod=product&_index=_comment'.$data['canshu']));
                        echo $page->page_nav();
                        ?>
                    </div>
                    <div class="clearfix mb30"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<?php include "footer_tpl.php"; ?>
<script>
    function comment_edit(id) {
        if(!id)
        {
            alert('参数错误');
            return false;
        }
        layer.open({
            type: 2,
            title: '编辑产品属性类型',
            shadeClose: true,
            shade: 0.8,
            area: ['80%', '90%'],
            content: '/?mod=admin&v_mod=product&_index=_comment_edit&id='+id //iframe的url
        });
    }
</script>
</body>
</html>