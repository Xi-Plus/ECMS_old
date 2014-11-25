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
	$date=$_POST['datetoadmin'];
	$content = $_POST['log'];
	$content = str_replace(" ", "\t", $content);
	if($content==""){unlink("../cache/".$_POST['datetoadmin'].".dat");echo "del.";}
	else if(@file_put_contents("../cache/".$_POST['datetoadmin'].".dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
}
if(isset($_POST['store'])){
	$result=array();
	$date=$_POST['datetoadmin'];
	//讀取姓名列表
	$content = @file_get_contents("../config/names.dat");
	$content = handleEOL($content);
	$raw_names = explode(PHP_EOL, $content);
	foreach($raw_names as $temp){
		$text=explode("\t", $temp);
		$result[$text[0]]["index"]=$text[0];
		$result[$text[0]]["store"]=0;
		$result[$text[0]]["charge"]=0;
	}
	//讀取原始餘額
	$content = @file_get_contents("../cache/money.dat");
	$content = handleEOL($content);
	$raw_money = explode(PHP_EOL, $content);
	foreach($raw_money as $temp){
		$text=explode("\t", $temp);
		$result[$text[0]]["money"]=$text[1];
		$result[$text[0]]["logmoney"]=$text[1];
	}
	//讀取原始值日
	$content = @file_get_contents("../cache/duty.dat");
	$content = handleEOL($content);
	$raw_duty= explode(PHP_EOL, $content);
	foreach($raw_duty as $temp){
		$text=explode("\t", $temp);
		$result[$text[0]]["duty1"]=$text[1];
		$result[$text[0]]["duty2"]=$text[2];
	}
	$filename="../cache/".$_POST['datetoadmin'].".dat";
	$content = @file_get_contents($filename);
	$newfile=false;
	//如果有記錄 讀取
	if($content){
		$content = handleEOL($content);
		$raw_log = explode(PHP_EOL, $content);
		foreach($raw_log as $temp){
			$text=explode("\t", $temp);
			$result[$text[0]]["store"]=$text[1];
			$result[$text[0]]["charge"]=$text[2];
			$result[$text[0]]["logmoney"]=($text[3]+$text[1]+$text[2]);
		}
	}
	else {
		$newfile=true;
		fopen($filename, 'w');
		fclose($filename);
		if(@file_put_contents("../cache/update.dat",$_POST['datetoadmin'])===false)echo "Failed to write file. Please check file permission.<br/>";
	}
	//處理值日
	$duty = $_POST['dutytoadmin'];
	$duty = handleEOL($duty);
	$raw_duty=explode(" ", $duty);
	foreach($raw_duty as $temp){
		$result[$temp]["duty2"]++;
	}
	//處理儲值
	$store = $_POST['store'];
	$store = handleEOL($store);
	$raw_store=explode(PHP_EOL, $store);
	foreach($raw_store as $temp){
		$text=explode(" ", $temp);
		$result[$text[0]]["store"]+=$text[1];
		$result[$text[0]]["money"]+=$text[1];
	}
	//處理扣款
	$charge = $_POST['charge'];
	$charge = handleEOL($charge);
	$raw_charge=explode(PHP_EOL, $charge);
	foreach($raw_charge as $temp){
		$text=explode(" ", $temp);
		for($i=1;$i<count($text);$i++){
			$result[$text[$i]]["charge"]-=$text[0];
			$result[$text[$i]]["money"]-=$text[0];
			$result[$text[$i]]["duty1"]++;
		}
	}
	//寫入餘額
	$content="";
	foreach($result as $temp){
		if($temp["index"]!="")$content.=$temp["index"]."\t".$temp["money"]."\r\n";
	}
	if(@file_put_contents("../cache/money.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	//寫入值日
	$content="";
	foreach($result as $temp){
		if($temp["index"]!="")$content.=$temp["index"]."\t".$temp["duty1"]."\t".$temp["duty2"]."\r\n";
	}
	if(@file_put_contents("../cache/duty.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
	//寫入紀錄
	$content="";
	foreach($result as $temp){
		if($temp["index"]!="")$content.=$temp["index"]."\t".$temp["store"]."\t".$temp["charge"]."\t".($temp["logmoney"]+$temp["store"]+$temp["charge"])."\r\n";
	}
	if(@file_put_contents($filename,$content)===false)echo "Failed to write file. Please check file permission.<br/>";
}
if(isset($_POST['update'])){
	$content = $_POST['update'];
	if(@file_put_contents("../cache/update.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
}
if(isset($_POST['money'])){
	$content = $_POST['money'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../cache/money.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
}
if(isset($_POST['duty'])){
	$content = $_POST['duty'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../cache/duty.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
}
if(isset($_POST['names'])){
	$content = $_POST['names'];
	$content = str_replace(" ", "\t", $content);
	if(@file_put_contents("../config/names.dat",$content)===false)echo "Failed to write file. Please check file permission.<br/>";
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
<hr>
<form method="POST">
<input type="submit" value="Submit"><br/>
update:<input type="text" name="update" value="<?php echo @file_get_contents("../cache/update.dat")?>">
<br/>
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