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
$board = $_GET['board'];
$id = $_GET['id'];
$mode = $_GET['mode'];
$pass = $_POST['pass'];
$con = mysqli_connect("localhost","root","kyle0908", "class");
$result=mysqli_query($con, "select passwd from $board where id=$id");
$passwd=mysqli_result($result,0,"passwd");
$secret = '6LekaVcdAAAAAETHFgJqvk_GZTUSYjOEofrBGFb3';

if ($pass != $passwd) {
	echo   ("<script>
		window.alert('입력 암호가 일치하지 않습니다.');
		history.go(-1);
		</script>");
	exit;
}

if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
	{
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
	if ($verifyResponse.success == true) {
				switch ($mode) {
						case 0:
								echo("<meta   http-equiv='Refresh' content='0; url=modify.php?board=$board&id=$id'>");
								break;
						case 1:
								echo("<meta   http-equiv='Refresh' content='0; url=delete.php?board=$board&id=$id'>");
								break;
				}

				mysqli_close($con);
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
