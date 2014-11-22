<?php
require_once("../func/EOL.php");
$date=$_POST['date'];
?>
<?php if(@file_get_contents("../cache/".$date.".dat")){ ?>
<form method="POST">
<input type="submit" value="Submit"><br/>
Log:<br/>
<textarea class="config" name="log">
<?php echo htmlentities(@file_get_contents("../cache/".$date.".dat"))?>
</textarea><br/>
<input type="hidden" name="datetoadmin" value="<?php echo $date ?>">
</form>
<?php } else { ?>
<?php echo $date ?> 新建檔案<br/>
<?php }	?>

<form method="POST">
<input type="submit" value="Submit"><br/>
Store:<br/>
<textarea class="config" name="store">
</textarea><br/>
Charge:<br/>
<textarea class="config" name="charge">
</textarea><br/>
<input type="hidden" name="datetoadmin" value="<?php echo $date ?>">
</form>