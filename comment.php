<?
$secret = '6LekaVcdAAAAAETHFgJqvk_GZTUSYjOEofrBGFb3';
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

if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
	{
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
	if ($verifyResponse.success == true) {
				$con = mysqli_connect("localhost","root","kyle0908", "reply");
				$result=mysqli_query($con, "select id from $board");
				$total=mysqli_num_rows($result);

				$wdate = date("Y-m-d");

				mysqli_query($con, "insert into $board(id, writer, email, passwd, content, wdate, edit) values($id, '$writer', '$email', '$passwd', '$content', '$wdate', 0)");

				mysqli_close($con);

				echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id&cpage=$cpage'>");
			}
	else {
		echo("
			<script>
			window.alert('자동입력 방지를 통과하지 못했습니다.')
			history.go(-1)
			</script>
		");
	}
}
?>
