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
$writer = $_POST['writer'];
$email = $_POST['email'];
$topic = $_POST['topic'];
$content = $_POST['content'];
$passwd = $_POST['passwd'];

if(!$writer){
	echo("
		<script>
		window.alert('이름을 입력 해주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

$con = mysqli_connect("localhost","root","kyle0908", "class");

$result=mysqli_query($con, "select space from $board where id=$id");
$space=mysqli_result($result, 0, "space");
$space=$space+1;

$wdate=date("Y-m-d");

$tmp = mysqli_query($con, "select id from $board");
$total = mysqli_num_rows($tmp);

while($total >= $id):
	mysqli_query($con, "update $board set id=id+1 where id=$total");
	$total--;
endwhile;

mysqli_query($con, "insert into   $board(id, writer, email, passwd, topic, content, hit, wdate, space) values ($id, '$writer', '$email', '$passwd', '$topic','$content', 0, '$wdate',   $space)");

mysqli_close($con);

echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

?>
