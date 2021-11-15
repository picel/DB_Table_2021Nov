<?
$board = $_GET['board'];
$id = $_GET['id'];
$con = mysqli_connect("localhost","root","kyle0908", "reply");

mysqli_query($con, "delete from $board where id=$id");
echo("
	<script>
	window.alert('댓글이 삭제 되었습니다.');
	</script>
");

echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>");

mysqli_close($con);

?>
