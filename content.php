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
$cpage = $_GET['cpage'];
$con = mysqli_connect("localhost","root","kyle0908", "class");
$con2 = mysqli_connect("localhost","root","kyle0908", "reply");
$result=mysqli_query($con, "select * from $board where id=$id");
$result2 = mysqli_query($con2, "select * from $board where id=$id");
$total = mysqli_num_rows($result2);

$id=mysqli_result($result,0,"id");
$writer=mysqli_result($result,0,"writer");
$topic=mysqli_result($result,0,"topic");
$hit=mysqli_result($result,0,"hit");
$filename=mysqli_result($result,0,"filename");
$filesize=mysqli_result($result,0,"filesize");

if ($filesize > 1000) {
	$kb_filesize =   (int)($filesize / 1000);
	$disp_size = $kb_filesize . ' KBytes';
} else {
	$disp_size = $filesize . ' Bytes';
}

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
	button {
		border: 0px;
		background-color: #FFFFFF;
		font-size:15px;
	}
</style>
<script src='https://kit.fontawesome.com/ce77ac93cc.js' crossorigin='anonymous'></script>
<script  src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type='text/javascript'>
$(document).ready(function() {
		$('.inline').hover(function() {
			$(this).css('background-color','#E4F7BA');
		}, function() {
			$(this).css('background-color','#ffffff');
		});
	});
</script>
<body bgcolor='#668C4A'>
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
		<div style='border-bottom:3px solid #011640;'>
			<h1>$board</h1>
		</div>
		<div style='margin:5px;'>
		  <div style='display:inline-block; padding-left:20px;'>
		    <h3>$topic</h3>
		  </div>
		  <div style='display:inline-block; float:right;'>
		    <div style='margin:10px; float:right;'><a href=pass.php?board=$board&id=$id&mode=0 class='fas fa-edit'> 수정</a></div>
		    <div style='margin:10px; float:right;'><a href=pass.php?board=$board&id=$id&mode=1 class='fas fa-trash'> 삭제</a></div>
		  </div>
		</div>
		<div style='margin-top:5px; margin-bottom:20px; padding:25px;'><pre>$content</pre></div>
		");

if ($filename != null){
	echo("<div style='padding:25px;'>첨부파일 : <a href=./pds/$filename class='fas fa-file'> $filename</a> [$disp_size]</div>");
}

echo ("
		<div style='padding:10px; border-bottom:1px solid #011640; border-top:1px solid #011640;'>
			<div class='inlineDiv' style='width:80px;'>번호 : $id</div>
		  <div class='inlineDiv' style='width:200px;'>글쓴이 : <a href=mailto:$email>$writer</a></div>
		  <div class='inlineDiv' style='width:150px;'>날짜 : $wdate</div>
		  <div class='inlineDiv' style='width:100px;'>조회 : $hit</div>
		</div>
		<div style='margin:10px; float:right;'><a href=reply.php?board=$board&id=$id class='fas fa-reply'> 답변</a></div>
		<div style='margin:10px; float:right;'><a href=show.php?board=$board class='fas fa-list'> 목록</a></div>
		</div>
		");

if ($total!=0){
	echo("<div class='container'>");
	$counter = 0;
	while($counter<$total):
		$writer=mysqli_result($result2,$counter,"writer");
		$email=mysqli_result($result2,$counter,"email");
		$content=mysqli_result($result2,$counter,"content");
		$wdate=mysqli_result($result2,$counter,"wdate");
		$num=mysqli_result($result2,$counter,"num");
		$edit=mysqli_result($result2,$counter,"edit");
		echo("
		<div style='padding:15px;'>
			<div style='margin-bottom:10px;'>
				<div style='display:inline-block;'><span style='font:bold; font-size:20px;'>$writer</span></div>
				<div style='display:inline-block; float:right;'>$wdate
		");

		if ($edit == 1) {
			echo ("(수정됨)");
		}
		echo("
				</div>
			</div>
			<div>
				<div style='width:650px; display:inline-block;'>$content</div>
				<div style='float:right; display:inline-block;'>
					<a href=cmtpass.php?board=$board&num=$num&id=$id&cpage=$cpage&mode=0 text-align=right class='fas fa-trash'> 삭제</a>
					&nbsp;<a href=cmtpass.php?board=$board&num=$num&id=$id&cpage=$cpage&mode=1 text-align=right class='fas fa-edit'> 수정</a>
				</div>
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
					<div style='text-align:center; width:500px; display:inline-block;'><button class='fas fa-pen' type='submit'> 입력</button></div>
					<div style='text-align:right; width:120px; display:inline;'><button class='fas fa-eraser' type=reset> 지우기</button></div>
				</div>
			</form>
		</div>
		<div class='container'>
		<div style='border-top:3px solid black; border-bottom:3px solid black;'>
");
$result = mysqli_query($con, "select * from $board order by id desc");
$total = mysqli_num_rows($result);
$pagesize = 5;
$totalpage = (int)($total / $pagesize);
if (($total % $pagesize) != 0) $totalpage = $totalpage + 1;
$counter = 0;
while ($counter < $pagesize):
    $newcounter = ($cpage - 1) * $pagesize + $counter;
    if ($newcounter == $total) break;
    $id2 = mysqli_result($result, $newcounter, "id");
    $writer = mysqli_result($result, $newcounter, "writer");
    $topic = mysqli_result($result, $newcounter, "topic");
    $hit = mysqli_result($result, $newcounter, "hit");
    $wdate = mysqli_result($result, $newcounter, "wdate");
    $space = mysqli_result($result, $newcounter, "space");
    $filename = mysqli_result($result, $newcounter, "filename");
    $t = "";
    if ($space > 0)
    {
        for ($i = 0;$i <= $space;$i++) $t = $t . "&nbsp;";
    }
    $result2 = mysqli_query($con2, "select * from $board where id=$id2");
    $total2 = mysqli_num_rows($result2);
		if ($id2 == $id) echo ("<div style='padding:15px; border-bottom:1px solid lightgray; background-color:#E4F7BA;'>");
		else echo ("<div class='inline' style='padding:15px; border-bottom:1px solid lightgray;'>");
    echo ("
	  <div class='inlineDiv' style='width:70px; padding-left:10px;'>$id2</div>
	  <div class='inlineDiv' style='width:300px;'>$t<a href=content.php?board=$board&id=$id2&cpage=$cpage>$topic");
	  if ($total2 != 0) echo(" [$total2]");
	  if ($filename != null) echo(" <i class='fas fa-file'></i>");
	  echo("
	  </a></div>
	  <div class='inlineDiv' style='width:100px;'>$writer</div>
	  <div class='inlineDiv' style='width:150px;'>$wdate</div>
	  <div class='inlineDiv' style='width:40px; padding-left:10px;'>$hit</div>
	</div>
	");
	    $counter = $counter + 1;
endwhile;
echo ("
</div>
<div style='text-align:center;padding-top:30px;'>");
if (empty($_GET['cblock'])) $cblock = 1;
else $cblock = $_GET['cblock'];
$blocksize = 5;
$pblock = $cblock - 1;
$nblock = $cblock + 1;
$startpage = ($cblock - 1) * $blocksize + 1;
$pstartpage = $startpage - 1;
$nstartpage = $startpage + $blocksize;
if ($pblock > 0) echo ("[<a href=content.php?board=$board&id=$id&cblock=$pblock&cpage=$pstartpage>이전블록</a>] ");
$i = $startpage;
while ($i < $nstartpage):
		if ($i > $totalpage) break;
		echo ("[<a href=content.php?board=$board&id=$id&cblock=$cblock&cpage=$i>$i</a>]");
		$i = $i + 1;
endwhile;
if ($nstartpage <= $totalpage) echo ("[<a href=content.php?board=$board&id=$id&cblock=$nblock&cpage=$nstartpage>다음블록</a>] ");

echo("
		</div>
	</div>
</div></body>");
?>
