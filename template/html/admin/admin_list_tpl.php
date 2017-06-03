<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/inc/category_three.php';
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
    <script type="text/javascript">
        $(function()
        {
            $("#menu em").click(function()
            {
                if ($(this).hasClass("on")==true)
                {
                    $(this).removeClass('on').addClass('off');
                    $(this).parent().children().show();
                }else
                {
                    $(this).removeClass('off').addClass('on');
                    $(this).parent().find('ul').hide();
                    $(this).parent().find('em').removeClass('off').addClass('on');
                }
            })
        })

        function close_all(id)
        {
            if (id==1)
            {
                $("#menu ul").find('em').removeClass("off").addClass("on");
                $("#menu ul").find('ul').hide();
            }else if(id==2)
            {
                $("#menu ul").find('em').removeClass("on").addClass("off");
                $("#menu ul").find('ul').show();
            }
        }
    </script>
    <style type="text/css">
        body,ul,h3 {margin:0px; padding:0px;}
        li {list-style-type:none;}
        body{
            font-size:12px;
            color:#333;
            font-family: Simsun;
            line-height:15px;
        }
        a{text-decoration:none;color:#004285;border:none;}
        a:hover{text-decoration:none;color:#C33;}
        #menu {
            padding:10px;
        }
        #menu h3 {
            font-size:12px;
        }
        #menu ul {
            background:url("/upload/admin/ul-bg.gif") repeat-y 5px 0px; overflow:hidden;
        }
        #menu ul li {
            padding:5px 0 2px 30px;
            background:url("/upload/admin/tree-ul-li.gif") no-repeat 5px -32px;
        }
        #menu ul li ul{display: none;}
        #menu ul li em {
            cursor:pointer;
            display:inline-block;
            width:15px;
            float:left;
            height:15px;
            margin-left:-14px;
            background:url("/upload/admin/tree-ul-li.gif") no-repeat -32px 2px;
        }
        #menu ul li em.off1 {
            background-position: -17px -15px;
        }
        .f_strong{font-weight: bold;color: red;}

        #menu ul.off1 {
            display:block;
        }
        #menu ul li em.off {
            background-position: -17px -15px;
        }

        #menu ul.off {
            display:block;
        }
        </style>
</head>
<body>
<section>
    <div class="mainpanel">
        <div class="pageheader">
            <h2><i class="fa fa-home"></i> 管理员列表 <span>所有管理员</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">管理列表</li>
                </ol>
            </div>
        </div>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">条件查询</h4>
                    <p></p>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post" action="/manager/admin/?_index=_list">

                        <div class="form-group">
                            <button class="btn btn-default" type="button" onclick="close_all(1)"> + 全部收起</button>
                            <button class="btn btn-default" type="button" onclick="close_all(2)"> - 全部展开</button>


                        </div>

                    </form>
                </div><!-- panel-body -->
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <h5 class="subtitle mb5">管理列表</h5>
                    <br />
                    <div class="table-responsive">
                        <div id="menu">
                            <ul><?php echo get_tree_ul($obj->AdminList(),$_SESSION['fid']); ?></ul>
                        </div>
                    </div>
                    <div class="clearfix mb30"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script type="text/javascript">
    $(function(){
        close_all(1);
        $("#menu em").click(function(){
            if ($(this).hasClass("on")==true)
            {
                $(this).removeClass('on').addClass('off');
                $(this).parent().children().show();
            }else
            {
                $(this).removeClass('off').addClass('on');
                $(this).parent().find('ul').hide();
                $(this).parent().find('em').removeClass('off').addClass('on');
            }
        })
    })
</script>
</body>
</html>