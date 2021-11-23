<?
$board = $_GET['board'];
$num = $_GET['num'];
$id = $_GET['id'];
$cpage = $_GET['cpage'];
if ($_GET['mode'] == 0){
  echo ("
     <form method=post action=cmtdelete.php?board=$board&num=$num&id=$id&cpage=$cpage>
     <table border=0 width=400 align=center>
     <tr><td align=center>암호를 입력하십시오</td></tr>
     <tr><td align=center>암호: <input type=password size=15 name='pass'>
     <input type=submit value=입력></td></tr>
     </form>
     </table>
  ");
}
else {
  echo ("
     <form method=post action=cmtmodify.php?board=$board&num=$num&id=$id&cpage=$cpage>
     <table border=0 width=400 align=center>
     <tr><td align=center>암호를 입력하십시오</td></tr>
     <tr><td align=center>암호: <input type=password size=15 name='pass'>
     <input type=submit value=입력></td></tr>
     </form>
     </table>
  ");
}
?>
