<html>
<head>
    <meta charset = 'utf-8'>
	<title>EchoStats Admin</title>
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
	<link href = '../res/theme.css' rel = 'stylesheet' type = 'text/css'>
</head>
<body>

<?php
require_once("../func/EOL.php");
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
$date=date("Ymd");

if(isset($_POST['log'])){
	echo "edit ";
	$date=$_POST['datetoadmin'];
	$content = $_POST['log'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../cache/".$_POST['datetoadmin'].".dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	else echo "done.";
}
if(isset($_POST['store'])){
    echo "edit ";
	$result=array();
	$date=$_POST['datetoadmin'];
	$content = @file_get_contents("../config/names.dat");
	$content = handleEOL($content);
	$raw_names = explode(PHP_EOL, $content);
	foreach($raw_names as $temp){
		$text=explode("\t", $temp);
		$result[$text[0]]["index"]=$text[0];
		$result[$text[0]]["store"]=0;
		$result[$text[0]]["charge"]=0;
	}
	$filename="../cache/".$_POST['datetoadmin'].".dat";
	$content = @file_get_contents($filename);
	if($content){
		$content = handleEOL($content);
		$raw_log = explode(PHP_EOL, $content);
		foreach($raw_log as $temp){
			$text=explode("\t", $temp);
			$result[$text[0]]["store"]+=$text[1];
			$result[$text[0]]["charge"]+=$text[2];
			$result[$text[0]]["money"]+=($text[3]-$text[1]-$text[2]);
		}
	}
	else {
		fopen($filename, 'w');
		fclose($filename);
	}
	$store = $_POST['store'];
	$store = handleEOL($store);
	$raw_store=explode(PHP_EOL, $store);
	foreach($raw_store as $temp){
		$text=explode(" ", $temp);
		$result[$text[0]]["store"]+=$text[1];
	}
	$charge = $_POST['charge'];
	$charge = handleEOL($charge);
	$raw_charge=explode(PHP_EOL, $charge);
	foreach($raw_charge as $temp){
		$text=explode(" ", $temp);
		for($i=1;$i<count($text);$i++){
			$result[$text[$i]]["charge"]-=$text[0];echo($text[$i]);
		}
	}
	$content="";
	foreach($result as $temp){
		$content.=$temp["index"]."\t".$temp["store"]."\t".$temp["charge"]."\t".($temp["money"]+$temp["store"]+$temp["charge"])."\r\n";
	}
	if(@file_put_contents($filename,$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	else echo "done.";
}

if(isset($_POST['money'])){
    echo "edit ";
	$content = $_POST['money'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../cache/money.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	else echo "done.";
}
if(isset($_POST['duty'])){
    echo "edit ";
	$content = $_POST['duty'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../cache/duty.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	else echo "done.";
}
if(isset($_POST['names'])){
    echo "edit ";
	$content = $_POST['names'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../config/names.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	else echo "done.";
}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){ loadadminlogPage(); });
	function loadadminlogPage(){
        $('#adminlogframe').load('admin_log.php',
            {
				date: document.all.dateinput.value
            }
		);
    }
</script>

<style>
.config{
	width:600px;
	height:300px;
}
</style>

Date: <input id="dateinput" name="dateinput" value="<?php echo $date; ?>">
<input type="button" value="Submit" onclick="loadadminlogPage();">
<div id = "adminlogframe">
</div>
<!--
<form method="POST">
<input type="submit" value="Submit"><br/>
Date: <input id="dateinput" name="dateinput" value="<?php echo date("Ymd"); ?>">
<br/>
Store:<br/>
<textarea class="config" name="store"></textarea><br/>
Charge:<br/>
<textarea class="config" name="charge"></textarea><br/>
</form>-->
<hr>
<form method="POST">
<input type="submit" value="Submit"><br/>
money:<br/>
<textarea class="config" name="money">
<?php echo htmlentities(@file_get_contents("../cache/money.dat"))?>
</textarea><br/>
duty:<br/>
<textarea class="config" name="duty">
<?php echo htmlentities(@file_get_contents("../cache/duty.dat"))?>
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