<?
$board = $_GET['board'];
$id = $_GET['id'];
$mode = $_GET['mode'];
echo ("
   <style>
   button {
     border: 0px;
     background-color: #FFFFFF;
     font-size:15px;
   }
   </style>
   <script src='https://www.google.com/recaptcha/api.js' async defer></script>
   <script src='https://kit.fontawesome.com/ce77ac93cc.js' crossorigin='anonymous'></script>
   <script>
     function onSubmit(token){document.getElementById('pass').submit();}
   </script>
   <form id='pass' method=post action=pass2.php?board=$board&id=$id&mode=$mode>
   <table border=0 width=400 align=center>
   <tr><td align=center>암호를 입력하십시오</td></tr>
   <tr><td align=center>암호: <input type=password size=15 name='pass'>
   <button class='g-recaptcha form-field' data-sitekey='6LekaVcdAAAAABPYwLTb_tfkxFdjSs-j2YCi-M7s' data-callback='onSubmit'><i class='fas fa-check'></i> 입력</button>
   </td></tr>
   </form>
   </table>
");
?>
