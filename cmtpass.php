<?
$board = $_GET['board'];
$num = $_GET['num'];
$id = $_GET['id'];
echo ("
   <form method=post action=cmtpass2.php?board=$board&num=$num&id=$id>
   <table border=0 width=400 align=center>
   <tr><td align=center>암호를 입력하십시오</td></tr>
   <tr><td align=center>암호: <input type=password size=15 name='pass'>
   <input type=submit value=입력></td></tr>
   </form>
   </table>
");
?>
