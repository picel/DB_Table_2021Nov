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

if ($pass != $passwd) {
	echo   ("<script>
		window.alert('입력 암호가 일치하지 않습니다.');
		history.go(-1);
		</script>");
	exit;
} else {
    switch ($mode) {
        case 0:
            echo("<meta   http-equiv='Refresh' content='0; url=modify.php?board=$board&id=$id'>");
            break;
        case 1:
            echo("<meta   http-equiv='Refresh' content='0; url=delete.php?board=$board&id=$id'>");
            break;
    }
}

mysqli_close($con);

?>
