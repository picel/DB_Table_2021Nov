<?
$writer = $_POST['writer'];
$email = $_POST['email'];
$content = $_POST['content'];
$passwd = $_POST['passwd'];
$board = $_GET['board'];
$id = $_GET['id'];
$cpage = $_GET['cpage'];

if (!$writer){
	echo("
		<script>
		window.alert('이름을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if(!$content){
	echo("
		<script>
		window.alert('내용을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

$con = mysqli_connect("localhost","root","kyle0908", "reply");
$result=mysqli_query($con, "select id from $board");
$total=mysqli_num_rows($result);

$wdate = date("Y-m-d");

mysqli_query($con, "insert into $board(id, writer, email, passwd, content, wdate, edit) values($id, '$writer', '$email', '$passwd', '$content', '$wdate', 0)");

mysqli_close($con);

echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id&cpage=$cpage'>");

?>
