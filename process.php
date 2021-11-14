<?
$writer = $_POST['writer'];
$email = $_POST['email'];
$topic = $_POST['topic'];
$content = $_POST['content'];
$passwd = $_POST['passwd'];
$board = $_GET['board'];

if (!$writer){
	echo("
		<script>
		window.alert('이름을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if(!$topic){
	echo("
		<script>
		window.alert('제목을 입력 해주세요.')
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

$con = mysqli_connect("localhost","root","kyle0908", "class");

$result=mysqli_query($con, "select id from $board");
$total=mysqli_num_rows($result);

if (!$total){
	$id = 1;
} else {
	$id = $total + 1;
}

$wdate = date("Y-m-d");

mysqli_query($con, "insert into $board(id, writer, email, passwd, topic, content, hit, wdate, space) values($id, '$writer', '$email', '$passwd', '$topic', '$content', 0, '$wdate', 0)");

mysqli_close($con);

echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

?>
