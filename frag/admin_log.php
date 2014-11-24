<?php
require_once("../func/EOL.php");
$date=$_POST['date'];
?>
<?php if(@file_get_contents("../cache/".$date.".dat")){ ?>
<form method="POST">
<input type="submit" value="Submit"><br/>
Log:<br/>
<div style="float:left">
<textarea class="config" name="log">
<?php echo htmlentities(@file_get_contents("../cache/".$date.".dat"))?>
</textarea>
<textarea class="config">
<?php
	$content = @file_get_contents("../cache/".$date.".dat");
	$content = handleEOL($content);
	$raw_log = explode("\r\n", $content);
	$enter=0;
	foreach($raw_log as $temp){
		$text=explode("\t", $temp);
		if($text[1]!=""){
			if($enter)echo "\r\n";
			echo $text[1]."\t".$text[2];
			$enter=1;
		}
	}
?>
</textarea>
</div>
<br/>
<input type="hidden" name="datetoadmin" value="<?php echo $date ?>">
</form>
<?php } else { ?>
<?php echo $date ?> 新建檔案<br/>
<?php }	?>

<form method="POST">
<?php if(!@file_get_contents("../cache/".$date.".dat")){ ?>Duty:<input type="text" name="dutytoadmin"> <?php }	?>
<input type="submit" value="Submit"><br/>
Store:<br/>
<textarea class="config" name="store">
</textarea><br/>
Charge:<br/>
<textarea class="config" name="charge">
</textarea><br/>
<input type="hidden" name="datetoadmin" value="<?php echo $date ?>">
</form>