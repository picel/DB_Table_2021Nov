<?
function mysqli_result($res,$row=0,$col=0)
{
	$nums=mysqli_num_rows($res);
	if($nums && $row<=($nums-1) && $row>=0)
	{
		mysqli_data_seek($res,$row);
		$resrow=(is_numeric($col))?mysqli_fetch_row($res):mysqli_fetch_assoc($res);
		if(isset($resrow[$col]))
		{
			return $resrow[$col];
		}
	}
	return false;
}
$secret = '6LekaVcdAAAAAETHFgJqvk_GZTUSYjOEofrBGFb3';
$board = $_GET['board'];
$id = $_GET['id'];
$writer = $_POST['writer'];
$email = $_POST['email'];
$topic = $_POST['topic'];
$content = $_POST['content'];
$passwd = $_POST['passwd'];
$userfile = $_FILES['userfile'];

if(!$writer){
	echo("
		<script>
		window.alert('이름을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
	{
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
	if ($verifyResponse.success == true) {
		$con = mysqli_connect("localhost","root","kyle0908", "class");
		$con2 = mysqli_connect("localhost","root","kyle0908", "reply");
		$result=mysqli_query($con, "select space from $board where id=$id");
		$space=mysqli_result($result, 0, "space");
		$space=$space+1;

		$wdate=date("Y-m-d");

		$tmp = mysqli_query($con, "select id from $board");
		$total = mysqli_num_rows($tmp);

		while($total >= $id):
			mysqli_query($con, "update $board set id=id+1 where id=$total");
			mysqli_query($con2, "update $board set id=id+1 where id=$total");
			$total--;
		endwhile;

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

		mysqli_query($con, "insert into $board(id, writer, email, passwd, topic, content, hit, wdate, space, filename, filesize) values ($id, '$writer', '$email', '$passwd', '$topic','$content', 0, '$wdate', $space, '$userfile_name', '$userfile_size')");

		mysqli_close($con);

		echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");
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
