<?
$writer = $_POST['writer'];
$email = $_POST['email'];
$topic = $_POST['topic'];
$content = $_POST['content'];
$passwd = $_POST['passwd'];
$userfile = $_FILES['userfile'];
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

if ($userfile['name'] != null) {
   $savedir = './pds';
	 $userfile_name = $userfile['name'];
	 $userfile_size = $userfile['size'];
   copy($userfile['tmp_name'], "$savedir/$userfile_name");
   unlink($userfile['tmp_name']);
}
else{
	$userfile_name = null;
	$userfile_size = null;
}

$wdate = date("Y-m-d");

mysqli_query($con, "insert into $board(id, writer, email, passwd, topic, content, hit, wdate, space, filename, filesize) values($id, '$writer', '$email', '$passwd', '$topic', '$content', 0, '$wdate', 0, '$userfile_name', '$userfile_size')");

mysqli_close($con);

echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

?>
