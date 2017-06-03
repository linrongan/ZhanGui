<?php
function pageNav($amount,$pageSize,$CurPage,$extUrl,$canshu) {
$amount=intval($amount);
$pageSize=intval($pageSize);
if ($pageSize==0){$pageSize=1;}
$CurPage=intval($CurPage);
if ($CurPage==0){$CurPage=1;}
$maxPage=10;
$minPage=3;
$from = 1;
$to = 1;
if( $amount){
if( $amount < $pageSize ){ $page_count = 1; }

if( $amount % $pageSize ){

$page_count = (int)($amount / $pageSize) + 1;

}else{$page_count = $amount / $pageSize;}

}else{$page_count = 0;}

if ($CurPage>$minPage){$from = $CurPage-$minPage;}

$to=$CurPage+$maxPage-$minPage-1;

if (($to-$from)<($maxPage-1)){$to=$maxPage;}

if ($page_count<=$maxPage){

$from = 1;

$to = $page_count;}
$pageNav='<strong>显示:</strong>';
if ($to>$page_count){$to = $page_count;$from=$page_count-$maxPage+1;
}
if ($CurPage>1) {$pageNav.='<a href="'.$extUrl.'?curpage='.($CurPage-1).''.$canshu.'" rel="nofollow" class="pbutton">前一页</a> &nbsp; ';}else{

$pageNav.=' &nbsp;<a href="javascript:;">前一页';

}

if ($from>1){$pageNav.=' &nbsp;<a href="'.$extUrl.'?curpage=1'.$canshu.'" rel="nofollow"> 1 </a><a href="javascript:;"> ... </a>';}



           for ($i=$from;$i<=$to;$i++){

      if ($i==$CurPage){

             $pageNav.=' &nbsp;<a href="javascript:;" style="color:red">'.$i.'</a>';

           }else{

             $pageNav.=' &nbsp;<a href="'.$extUrl.'?curpage='.$i.''.$canshu.'" rel="nofollow">'.$i.'</a>';

           }

    }

    if ($to<$page_count){$pageNav.=' &nbsp;<a href="javascript:;"> ... </a>  &nbsp;<a rel="nofollow" href="'.$extUrl.'?curpage='.$page_count.''.$canshu.'">'.$page_count.'</a>';}

    if ($CurPage<$page_count) {$pageNav.=' &nbsp;<a class="page-next" href="'.$extUrl.'?curpage='.($CurPage+1).''.$canshu.'" rel="nofollow">下一页</a>'."&nbsp&nbsp每页".$pageSize."条记录&nbsp&nbsp共".$amount."条记录";}

		   else

		   {

		   $pageNav.=' &nbsp;<a href="javascript:;">下一页</a>'
           ."&nbsp&nbsp每页".$pageSize."条记录&nbsp&nbsp共".$amount."条记录";

		   }
 return $pageNav;

}  ?>