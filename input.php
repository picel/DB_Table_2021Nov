<?
$board = $_GET['board'];
echo("
<style type=\"text/css\">
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
		<form method=post action=process.php?board=$board>
		<div style='padding:10px;'>
			<div style='width:50px; display:inline-block;'>이름</div>
			<div style='width:259px; display:inline-block;'><input type=text name=writer size=30></div>
			<div style='width: 45px; display:inline-block;'>Email </div>
			<div style='display:inline-block;'><input type=text name=email size=44></div>
		</div>
		<div style='padding:10px;'>
			<div style='width:50px; display:inline-block;'>제목 </div>
			<div style='width:120px; display:inline-block;'><input type=text name=topic size=91></div>
		</div>
		<div style='padding:10px;'><textarea name=content rows=20 cols=102></textarea></div>
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
</body>
");
?>
