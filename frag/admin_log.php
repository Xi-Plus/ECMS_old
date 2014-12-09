<?php
require_once("../func/EOL.php");
$date=$_POST['date'];
?>
<?php if(@file_get_contents("../cache/".$date.".dat")){ ?>
<form method="POST">
<input type="submit" value="Submit"><br/>
Log:<br/>
<table><tr><td>
<textarea name="log" style="width:600px; height:300px">
<?php echo htmlentities(@file_get_contents("../cache/".$date.".dat"))?>
</textarea>
</td><td>
<textarea style="width:200px; height:300px">
<?php
	$content = @file_get_contents("../cache/".$date.".dat");
	$content = handleEOL($content);
	$raw_log = explode("\r\n", $content);
	$enter=0;
	foreach($raw_log as $temp){
		$text=explode("\t", $temp);
		if($text[1]!=""){
			if($enter)echo "\r\n";
			echo ($text[1]!=0?$text[1]:"")."\t".($text[2]!=0?$text[2]:"");
			$enter=1;
		}
	}
?>
</textarea>
</td></tr></table>

<input type="hidden" name="datetoadmin" value="<?php echo $date ?>">

</form>
<?php } else { ?>
<?php echo $date ?> 新建檔案<br/>
<?php }	?>

<form method="POST">
<?php if(!@file_get_contents("../cache/".$date.".dat")){ ?>Duty:<input type="text" name="dutytoadmin"><br/> <?php }	?>
<input type="submit" value="Submit"><br/>
Store:<br/>
<textarea class="config" name="store">
</textarea><br/>
Charge:<br/>
<textarea class="config" name="charge">
</textarea><br/>
<input type="hidden" name="datetoadmin" value="<?php echo $date ?>">
</form>