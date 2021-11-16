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
  height: 20px;
  display: inline-block;
}
.list {
  height: 20px;
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
	font-family: 'OTWelcomeRA';
}
@font-face {
	font-family: 'OTWelcomeRA';
	src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2110@1.0/OTWelcomeRA.woff2') format('woff2');
	font-weight: normal;
	font-style: normal;
}
</style><body bgcolor='#668C4A'>");
$field = $_POST['field'];
$key = $_POST['key'];
if (!$key) {
	echo("<script>
		window.alert('검색어를 입력하세요');
		history.go(-1);
		</script>");
	exit;
}
$board = $_GET['board'];
$con = mysqli_connect("localhost","root","kyle0908", "class");
$result=mysqli_query($con, "select * from $board where $field like '%$key%' order by id desc");
$total = mysqli_num_rows($result);
$con2 = mysqli_connect("localhost","root","kyle0908", "reply");

echo("
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
 <div class='container'>
 <div style='float:right;'>검색어:$key , 찾은 개수:$total 개</div>
	 <div style='border-bottom:3px solid #011640;'>
		 <h1>$board</h1>
	 </div>

	 <div style='margin-top:5px; padding:10px; border-bottom:1px solid #011640;'>
		 <div class='inlineDiv' style='width:80px;'>번호</div>
		 <div class='inlineDiv' style='width:300px;'>제목</div>
		 <div class='inlineDiv' style='width:100px;'>글쓴이</div>
		 <div class='inlineDiv' style='width:150px;'>날짜</div>
		 <div class='inlineDiv' style='width:50px;'>조회</div>
	 </div>
");

if (!$total){
	echo("<div style='text-align:center; padding-top:30px;'>검색된 글이 없습니다.</div>");
} else {

	$counter=0;

	while($counter<$total):

		$id=mysqli_result($result,$counter,"id");
		$writer=mysqli_result($result,$counter,"writer");
		$topic=mysqli_result($result,$counter,"topic");
		$hit=mysqli_result($result,$counter,"hit");
		$wdate=mysqli_result($result,$counter,"wdate");
		$space=mysqli_result($result,$counter,"space");

		$t="";

		if   ($space>0) {
			for ($i=0 ;   $i<=$space ; $i++)
			$t=$t .  "&nbsp;";
		}
		$result2 = mysqli_query($con2, "select * from $board where id=$id");
		$total2 = mysqli_num_rows($result2);
		echo("
		<div style='margin-top:5px; padding:10px; border-bottom:1px solid lightgray;'>
			<div class='inlineDiv' style='width:70px; padding-left:10px;'>$id</div>
			<div class='inlineDiv' style='width:300px;'>$t<a href=content.php?board=$board&id=$id>$topic");
      if ($total2 != 0) echo(" [$total2]");
      echo("
      </a></div>
			<div class='inlineDiv' style='width:100px;'>$writer</div>
			<div class='inlineDiv' style='width:150px;'>$wdate</div>
			<div class='inlineDiv' style='width:40px; padding-left:10px;'>$hit</div>
		</div>
		");

		$counter = $counter + 1;

	endwhile;

	echo("<div style='text-align:center; border-top:1px solid #011640; padding-top:30px;'>
	</div>
	<div style='margin-top:50px;'>
		<div style='width:120px; display:inline-block;'></div>
		<div style='text-align:center; width:500px; display:inline-block;'>
			<form method=post action=search.php?board=$board>
				<select name=field>
					<option value=writer>글쓴이</option>
					<option value=topic>제목</option>
					<option value=content>내용</option>
				</select>
				검색어
				<input type=text name=key size=13>
				<input type=submit value=찾기>
			</form></div><div style='text-align:right; width:120px; display:inline;'>
				[<a href=show.php?board=$board text-align=right>목록</a>]
			</div></div>
	</div></div></div></div></body>");
}

mysqli_close($con);

?>
