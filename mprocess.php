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
$board = $_GET['board'];
$id = $_GET['id'];
if (!$writer){
	echo("
		<script>
		window.alert('이름이 없습니다. 다시 입력하세요')
		history.go(-1)
		</script>
	");
	exit;
}

if (!$topic){
	echo("
		<script>
		window.alert('제목이 없습니다. 다시 입력하세요')
		history.go(-1)
		</script>
	");
	exit;
}

if (!$content){
	echo("
		<script>
		window.alert('내용이 없습니다. 다시 입력하세요')
		history.go(-1)
		</script>
	");
	exit;
}

$con = mysqli_connect("localhost","root","kyle0908", "class");
$result = mysqli_query($con, "select * from $board where id=$id");

// 기존 필드값을 유지할 항목을 추출함
$space = mysqli_result($result, 0, "space");
$hit = mysqli_result($result, 0, "hit");

$wdate = date("Y-m-d");	//글 수정한 날짜 저장

// 변경 내용을 테이블에 저장함
mysqli_query($con, "update $board set  writer='$writer', email='$email', passwd='$passwd', topic='$topic', content='$content', hit=$hit, wdate='$wdate', space=$space where   id=$id");

echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

//mysqli_fetch_row_close($con);
mysqli_close($con);

?>
