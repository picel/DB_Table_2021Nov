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
$con2 = mysqli_connect("localhost","root","kyle0908", "reply");
$result=mysqli_query($con, "select * from $board where id=$id");
$result2 = mysqli_query($con2, "select * from $board where id=$id");
$total = mysqli_num_rows($result2);

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
		margin: 0 auto;
	}
	.leftDiv {
		width: 250px;
		display: inline-block;
		float: left;
	}
	.rightDiv {
    margin: 15px;
		display: inline-block;
	}
	.container {
		width: 740px;
    background-color: #FFFFFF;
    padding: 40px;
		margin-bottom:15px;
		display: block;
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
		background-color: #FFFFFF;
		padding: 10px;
		margin-top: 15px;
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
		font-family: 'BMJUA';
  }
	@font-face {
    font-family: 'BMJUA';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_one@1.0/BMJUA.woff') format('woff');
    font-weight: normal;
    font-style: normal;
	}
</style><body bgcolor='#668C4A'>
<div class='outerDiv'>
	<div class='leftDiv' style='margin-top: 15px;'>
	<div class='list' style='text-align:center;font-size:30px;height:130px; display:table-cell;'>어서오슈</div>
	");
  $showtables= mysqli_query($con, "SHOW TABLES FROM class");
   while($table = mysqli_fetch_array($showtables)) {
    echo ("<div class='list'><a href=show.php?board=$table[0]>$table[0]</a></div>");
   }

echo ("
	</div>
	<div class='rightDiv'>
	<div class='container' style='height:600px;'>
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
		");

if ($total!=0){
	echo("<div class='container' style='padding-top:0px;'>");
	$counter = 0;
	while($counter<$total):
		$writer=mysqli_result($result2,$counter,"writer");
		$email=mysqli_result($result2,$counter,"email");
		$content=mysqli_result($result2,$counter,"content");
		$wdate=mysqli_result($result2,$counter,"wdate");
		$cid=mysqli_result($result2,$counter,"id");
		echo("
		<div style='padding-top:40px;'>
			<div style='margin-bottom:10px;'>
				<div style='display:inline-block;'><span style='font:bold; font-size:20px;'>$writer</span></div>
				<div style='display:inline-block; float:right;'>$wdate</div>
			</div>
			<div>
				<div style='width:650px; display:inline-block;'>$content</div>
				<div style='float:right; display:inline-block;'><a href=commentrm.php?board=$board&id=$cid text-align=right>[삭제]</a></div>
			</div>
		</div>
		");
		$counter++;
	endwhile;
	echo("</div>");
}

echo("
		<div class='container'>
		<form method=post action=comment.php?board=$board&id=$id>
		<div style='padding:10px;'>
			<div style='width:50px; display:inline-block;'>이름</div>
			<div style='width:259px; display:inline-block;'><input type=text name=writer size=30></div>
			<div style='width: 45px; display:inline-block;'>Email </div>
			<div style='display:inline-block;'><input type=text name=email size=44></div>
		</div>
		<div style='padding:10px;'><textarea name=content rows=8 cols=100></textarea></div>
		<div style='padding:10px;'>
			<div style='width:50px; display:inline-block;'>암호 </div>
			<div style='display:inline-block;'><input type=password name=passwd size=15></div>
		</div>
		<div>
			<div style='width:120px; display:inline-block;'></div>
			<div style='text-align:center; width:500px; display:inline-block;'><input type=submit value=등록하기></div>
			<div style='text-align:right; width:120px; display:inline;'><input type=reset value=지우기></div>
		</div>
		</form>
		</div>
	</div>
</div></body>");
?>
