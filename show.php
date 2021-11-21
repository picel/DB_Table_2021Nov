<? function mysqli_result($res, $row = 0, $col = 0)
{
    $nums = mysqli_num_rows($res);
    if ($nums && $row <= ($nums - 1) && $row >= 0)
    {
        mysqli_data_seek($res, $row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col]))
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
<body bgcolor='#668C4A'>");
$board = $_GET['board'];
$con = mysqli_connect("localhost", "root", "kyle0908", "class");
$result = mysqli_query($con, "select * from $board order by id desc");
$total = mysqli_num_rows($result);
$con2 = mysqli_connect("localhost","root","kyle0908", "reply");


echo ("
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
		<div style='margin-top:5px; padding:10px; border-bottom:2px solid #011640;'>
			<div class='inlineDiv' style='width:80px;'>번호</div>
			<div class='inlineDiv' style='width:300px;'>제목</div>
			<div class='inlineDiv' style='width:100px;'>글쓴이</div>
			<div class='inlineDiv' style='width:150px;'>날짜</div>
			<div class='inlineDiv' style='width:50px;'>조회</div>
		</div>
");
if (!$total)
{
    echo ("<div style='text-align:center; padding:20px; height:343px;'>아직 등록된 글이 없습니다.</div>
    <div style='text-align:right; width:120px; display:inline; width:500px; float:right; margin-right:69px;'>
      <a href=input.php?board=$board text-align=right>[쓰기]</a>
    </div>");
}
else
{
    if (empty($_GET['cpage'])) $cpage = 1;
    else $cpage = $_GET['cpage'];
    $pagesize = 5;
    $totalpage = (int)($total / $pagesize);
    if (($total % $pagesize) != 0) $totalpage = $totalpage + 1;
    $counter = 0;
    while ($counter < $pagesize):
        $newcounter = ($cpage - 1) * $pagesize + $counter;
        if ($newcounter == $total) break;
        $id = mysqli_result($result, $newcounter, "id");
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
        $result2 = mysqli_query($con2, "select * from $board where id=$id");
        $total2 = mysqli_num_rows($result2);
        echo ("
		<div class='inline' style='padding:15px; border-bottom:1px solid lightgray;'>
			<div class='inlineDiv' style='width:70px; padding-left:10px;'>$id</div>
			<div class='inlineDiv' style='width:300px;'>$t<a href=content.php?board=$board&id=$id&cpage=$cpage>$topic");
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
    echo ("<div style='text-align:center; border-top:3px solid #011640; padding-top:30px;'>");
    if (empty($_GET['cblock'])) $cblock = 1;
    else $cblock = $_GET['cblock'];
    $blocksize = 5;
    $pblock = $cblock - 1;
    $nblock = $cblock + 1;
    $startpage = ($cblock - 1) * $blocksize + 1;
    $pstartpage = $startpage - 1;
    $nstartpage = $startpage + $blocksize;
    if ($pblock > 0) echo ("[<a href=show.php?board=$board&cblock=$pblock&cpage=$pstartpage>이전블록</a>] ");
    $i = $startpage;
    while ($i < $nstartpage):
        if ($i > $totalpage) break;
        echo ("[<a href=show.php?board=$board&cblock=$cblock&cpage=$i>$i</a>]");
        $i = $i + 1;
    endwhile;
    if ($nstartpage <= $totalpage) echo ("[<a href=show.php?board=$board&cblock=$nblock&cpage=$nstartpage>다음블록</a>] ");
    echo ("</div>
    <div style='margin-top:50px;'>
      <div style='width:120px; display:inline-block;'></div>
      <div style='text-align:center; width:500px; display:inline-block;'>
  			<form method=post action=search.php?board=$board>
  				<select name=field style='height:22px;'>
  					<option value=writer>글쓴이</option>
  					<option value=topic>제목</option>
  					<option value=content>내용</option>
  				</select>
  				<input type=text name=key size=13>
  				<button type=submit class='fas fa-search'> 검색</button>
  			</form></div><div style='text-align:right; width:120px; display:inline;'>
    			<a href=input.php?board=$board text-align=right class='fas fa-pen'> 글쓰기</a>
    		</div></div>
		</div></div></div></div></body>");
}
mysqli_close($con);
?>
