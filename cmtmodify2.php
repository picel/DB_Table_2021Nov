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
$num = $_GET['num'];
$id = $_GET['id'];
$cpage = $_GET['cpage'];
$writer = $_POST['writer'];
$email = $_POST['email'];
$content = $_POST['content'];
$passwd = $_POST['passwd'];
$con = mysqli_connect("localhost","root","kyle0908", "reply");
$result=mysqli_query($con, "select passwd from $board where num=$num");
$passwd=mysqli_result($result,0,"passwd");

$wdate = date("Y-m-d");

mysqli_query($con, "update $board set writer='$writer', email='$email', passwd='$passwd', content='$content', wdate='$wdate', edit=1 where num=$num");

mysqli_close($con);

echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id&cpage=$cpage'>");

?>
