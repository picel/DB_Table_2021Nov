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
$writer = $_POST['writer'];
$email = $_POST['email'];
$topic = $_POST['topic'];
$content = $_POST['content'];
$passwd = $_POST['passwd'];
$userfile = $_FILES['userfile'];
$board = $_GET['board'];
$id = $_GET['id'];

if ($userfile) $userfile = $_FILES['userfile'];

if (!$writer){
	echo("
		<script>
		window.alert('이름을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if (!$topic){
	echo("
		<script>
		window.alert('제목을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if (!$content){
	echo("
		<script>
		window.alert('내용을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

$con = mysqli_connect("localhost","root","kyle0908", "class");
$result = mysqli_query($con, "select * from $board where id=$id");

$space = mysqli_result($result, 0, "space");
$hit = mysqli_result($result, 0, "hit");

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

mysqli_query($con, "update $board set  writer='$writer', email='$email', passwd='$passwd', topic='$topic', content='$content', hit=$hit, wdate='$wdate', space=$space, filename='$userfile_name', filesize='$userfile_size' where id=$id");

echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

mysqli_close($con);

?>
