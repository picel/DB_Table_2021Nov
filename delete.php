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
$con = mysqli_connect("localhost","root","kyle0908", "class");

mysqli_query($con, "delete from $board where id=$id");
echo("
	<script>
	window.alert('글이 삭제 되었습니다.');
	</script>
");

// 삭제된 글보다 글 번호가 큰 게시물은 글 번호를 1씩 감소
$tmp = mysqli_query($con, "select id from $board order by id desc");
$last = mysqli_result($tmp, 0, "id");     // 가장 마지막 글 번호 추출

$i = $id + 1;       // 삭제된 글의 번호보다 1이 큰 글 번호부터 변경
while($i <= $last):
	mysqli_query($con, "update $board set id=id-1 where id=$i");
	$i++;
endwhile;

// 글 삭제 결과를 보여주기 위한 글 목록 보기 프로그램 호출
echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

mysqli_close($con);

?>
