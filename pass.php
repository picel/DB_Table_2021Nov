<?
$board = $_GET['board'];
$id = $_GET['id'];
$mode = $_GET['mode'];
echo ("
   <form method=post   action=pass2.php?board=$board&id=$id&mode=$mode>
   <table border=0 width=400 align=center>
   <tr><td align=center>암호를 입력하십시오</td></tr>
   <tr><td align=center>암호: <input type=password size=15 name='pass'>
   <input type=submit value=입력></td></tr>
   </form>
   </table>
");
?>
