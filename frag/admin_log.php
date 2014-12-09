<?php
require_once("../func/EOL.php");
$date=$_POST['date'];
$content=@file_get_contents("../cache/".$date.".dat");
if($content){ ?>
<hr>
<form method="POST">
<input type="submit" value="Submit"><br/>
<table><tr><td style="text-align:left;">
Log:<br/>
<textarea name="log" style="width:600px; height:300px">
<?php echo htmlentities($content)?>
</textarea>
</td><td>
<br/>
<textarea style="width:300px; height:300px">
<?php
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
<?php } ?>

<hr>

<form method="POST">
<input type="submit" value="Submit"> <?php if($content==false)echo $date."新建檔案<br/>" ?>
<?php if(!@file_get_contents("../cache/".$date.".dat")){ ?>Duty: <input type="text" name="dutytoadmin"><br/> <?php }	?>
<table><tr>
<td style="text-align:left;">
Store:<br/>
<textarea name="store" style="width:450px; height:300px">
</textarea>
</td><td style="text-align:left;">
Charge:<br/>
<textarea name="charge" style="width:450px; height:300px">
</textarea>
</td></tr></table>
<input type="hidden" name="datetoadmin" value="<?php echo $date ?>">
</form>