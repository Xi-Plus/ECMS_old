<html>
<head>
    <meta charset = 'utf-8'>
	<title>EchoStats Admin</title>
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
	<link href = '../res/theme.css' rel = 'stylesheet' type = 'text/css'>
</head>
<body>

<?php
if(md5($_COOKIE["ECMSadmin"]."ECMS")=="a34a9753321d94b6e09af0f0bfef71e1")echoAdminPage();
else if(!isset($_POST["pwd"])){
	echoLoginPage();
}else{
	if( md5(md5($_POST["pwd"])."ECMS") == "a34a9753321d94b6e09af0f0bfef71e1" ){
		echo "login succeeded<br/><br/>";
		setcookie("ECMSadmin",md5($_POST["pwd"]),time()+86400*7);
		echoAdminPage();
	}else{
		echo "wrong password<br/><br/>";
		echoLoginPage();
	}
}

?>


<?php
function echoAdminPage(){

if(isset($_POST['money'])){
    echo "edit ";
	$content = $_POST['money'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../cache/money.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	else echo "done.<br/>";
}
else if(isset($_POST['names'])){
    echo "edit ";
	$content = $_POST['names'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../config/names.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	else echo "done.<br/>";
}
?>

<style>
.config{
	width:600px;
	height:300px;
}
</style>


<form method="POST">
<input type="submit" value="Submit"><br/>
money:<br/>
<textarea class="config" name="money">
<?php echo htmlentities(@file_get_contents("../cache/money.dat"))?>
</textarea><br/>
names:<br/>
<textarea class="config" name="names">
<?php echo htmlentities(@file_get_contents("../config/names.dat"))?>
</textarea><br/>
<input type="hidden" name="pwd" value="<?=$_POST["pwd"]?>">
</form>

<?php } ?>

<?php
function echoLoginPage(){  ?>
<form method="POST">
Password: <input type="password" name="pwd">
</form>
<?php } ?>

</body>
</html>