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
$num = $_GET['num'];
$id = $_GET['id'];
$cpage = $_GET['cpage'];
$pass = $_POST['pass'];
$con = mysqli_connect("localhost","root","kyle0908", "reply");
$result=mysqli_query($con, "select passwd from $board where num=$num");
$passwd=mysqli_result($result,0,"passwd");

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
		mysqli_query($con, "delete from $board where num=$num");
    echo("
    	<script>
    	window.alert('댓글이 삭제 되었습니다.');
    	</script>
    ");
    echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id&cpage=$cpage'>");
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
