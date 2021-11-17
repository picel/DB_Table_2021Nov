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

$result=mysqli_query($con, "select * from $board where id=$id");

$topic=mysqli_result($result,0,"topic");
$content=mysqli_result($result,0,"content");

$topic="[Re]" .  $topic;

$pre_content=   "\n\n\n--------------< 원본글 >-------------\n" . $content . "\n";

echo("
<style type=\"text/css\">
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
}button {
		border: 0px;
		background-color: #FFFFFF;
		font-size:15px;
	}
	input[type='file'] {
	  position: absolute;
	  width: 1px;
	  height: 1px;
	  padding: 0;
	  margin: -1px;
	  overflow: hidden;
	  clip:rect(0,0,0,0);
	  border: 0;
	}
</style>
<script src='https://kit.fontawesome.com/ce77ac93cc.js' crossorigin='anonymous'></script>
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
		<form method=post   action=rprocess.php?board=$board&id=$id  enctype='multipart/form-data'>
		<div style='padding:10px;'>
			<div style='width:50px; display:inline-block;'>이름</div>
			<div style='width:259px; display:inline-block;'><input type=text name=writer size=30></div>
			<div style='width: 45px; display:inline-block;'>Email </div>
			<div style='display:inline-block;'><input type=text name=email size=44></div>
		</div>
		<div style='padding:10px;'>
			<div style='width:50px; display:inline-block;'>제목 </div>
			<div style='width:120px; display:inline-block;'><input type=text name=topic size=91 value='$topic'></div>
		</div>
		<div style='padding:10px;'><textarea name=content rows=20 cols=102>$pre_content</textarea></div>
		<div style='padding:10px;'>
			<div style='width:50px; display:inline-block;'>암호 </div>
			<div style='display:inline-block;'><input type=password name=passwd size=15></div>
			<div style='margin-left:430px; display:inline-block;'>
				<label for='ex_file' class='fas fa-file'> 업로드</label>
				<input type=file id='ex_file' name='userfile' size=45 maxlength=80>
			</div>
		</div>
		<div>
			<div style='width:120px; display:inline-block;'></div>
			<div style='text-align:center; width:500px; display:inline-block;'><button class='fas fa-marker' type='submit'> 입력</button></div>
			<div style='text-align:right; width:120px; display:inline;'><button class='fas fa-eraser' type=reset> 지우기</button></div>
		</div>
		</form>
	</div></div>
</div></body>
");

mysqli_close($con);

?>
