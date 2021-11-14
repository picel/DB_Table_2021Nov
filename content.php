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
$id = $_GET['id'];
$board = $_GET['board'];
$con = mysqli_connect("localhost","root","kyle0908", "class");
$result=mysqli_query($con, "select * from $board where id=$id");

$id=mysqli_result($result,0,"id");
$writer=mysqli_result($result,0,"writer");
$topic=mysqli_result($result,0,"topic");
$hit=mysqli_result($result,0,"hit");

$hit = $hit +1;
mysqli_query($con, "update $board set hit=$hit where id=$id");

$wdate=mysqli_result($result,0,"wdate");
$email=mysqli_result($result,0,"email");
$content=mysqli_result($result,0,"content");

echo ("<style type=\"text/css\">
	.outerDiv {
		width: 1100px;
		height: 600px;
	}
	.leftDiv {
		width: 250px;
		height: 600px;
		float: left;
	}
	.rightDiv {
		width: 740px;
		height: 600px;
		float: right;
    background-color: #F2F2F2;
    border-radius: 20px / 20px;
    padding: 40px;
    margin: 15px;
    color: #011640;
	}
	.inlineDiv {
		height: 30px;
		display: inline-block;
	}
	.list {
		height: 30px;
		width: 230px;
		text-align: center;
		font-size: 20px;
		border-radius: 0px 20px 20px 0px / 0px 20px 20px 0px;
		background-color: #F2F2F2;
		padding: 10px;
		margin-top: 10px;
		display: block;
		vertical-align: middle;
	}
	a {
		text-decoration-line: none;
		color: inherit;
	}
  html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
  }
</style><body bgcolor='#B0B7BF'>
<div class='outerDiv'>
	<div class='leftDiv' style='margin-top: 15px;'>
	<div class='list' style='text-align:center;font-size:30px;height:130px; display:table-cell;'>어서오슈</div>
	<div class='list'><a href=show.php?board=testboard>test</a></div>
	<div class='list'><a href=show.php?board=qna>qna</a></div>
	<div class='list'><a href=show.php?board=alpha>alpha</a></div>
	</div>
	<div class='rightDiv'>
		<div style='border-bottom:3px solid #011640;'>
			<h1>$board</h1>
		</div>
		<div style='margin:5px;'>
		  <div style='display:inline-block; padding-left:20px;'>
		    <h3>$topic</h3>
		  </div>
		  <div style='display:inline-block; float:right;'>
		    <a href=pass.php?board=$board&id=$id&mode=0>[수정]</a>
		    <a href=pass.php?board=$board&id=$id&mode=1>[삭제]</a>
		  </div>
		</div>
		<div style='margin-top:5px; padding:25px; height:300px;  border-bottom:1px solid #011640;'>$content</div>
		<div style='margin-top:10px; padding:10px; border-bottom:1px solid #011640;'>
			<div class='inlineDiv' style='width:80px;'>번호 : $id</div>
		  <div class='inlineDiv' style='width:200px;'>글쓴이 : <a href=mailto:$email>$writer</a></div>
		  <div class='inlineDiv' style='width:150px;'>날짜 : $wdate</div>
		  <div class='inlineDiv' style='width:100px;'>조회 : $hit</div>
		</div>
		<div style='margin:20px; float:right;'><a href=reply.php?board=$board&id=$id>[답변]</a>
		<a href=show.php?board=$board>[목록]</a></div>
	</div>
</div></body>");
?>
