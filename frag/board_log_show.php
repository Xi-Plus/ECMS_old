<?php
require_once("../func/EOL.php");
$sort_rule = $_POST['sortby'];
$date=date("Ymd");
if($_POST["date"]!="")$date=$_POST["date"];
$result=array();
$content = @file_get_contents("../config/names.dat");
$content = handleEOL($content);
$raw_names = explode(PHP_EOL, $content);
foreach($raw_names as $temp){
	$text=explode("\t", $temp);
	$result[$text[0]]["index"]=$text[0];
	$result[$text[0]]["name"]=$text[1];
}
$content = @file_get_contents("../cache/".$date.".dat");
if($content){
$content = handleEOL($content);
$raw_log = explode(PHP_EOL, $content);
foreach($raw_log as $temp){
	$text=explode("\t", $temp);
	$result[$text[0]]["store"]=$text[1];
	$result[$text[0]]["charge"]=$text[2];
	$result[$text[0]]["sum"]=$text[1]+$text[2];
}
function sort_by_index($a, $b){
	if($a['index'] == $b['index']) return 0;
	return ($a['index'] > $b['index']) ? 1 : -1;
}
function sort_by_sum($a, $b){
	if($a['sum'] == $b['sum']){
		if($a['index'] == $b['index']) return 0;
		return ($a['index'] > $b['index']) ? 1 : -1;
	}
	return ($a['sum'] > $b['sum']) ? 1 : -1;
}
function sort_by_rsum($a, $b){
	if($a['sum'] == $b['sum']){
		if($a['index'] == $b['index']) return 0;
		return ($a['index'] > $b['index']) ? 1 : -1;
	}
	return ($a['sum'] > $b['sum']) ? -1 : 1;
}
if($sort_rule=="index")usort($result,'sort_by_index');
else if($sort_rule=="value")usort($result,'sort_by_sum');
else if($sort_rule=="rvalue")usort($result,'rsort_by_sum');
}
?>
<div class = 'table-wrapper' style="overflow-x:auto;overflow-y:auto">
<?php if($content){ ?>
<table>
<tr><td></td><td>姓名</td><td>儲值</td><td>扣款</td><td>小計</td></tr>
<?php
foreach($result as $temp){
	echo "<tr><td>".$temp["index"]."</td><td>".$temp["name"]."</td><td>".$temp["store"]."</td><td>".$temp["charge"]."</td><td>".$temp["sum"]."</td></tr>";
}
?>
</table>
<?php } else { ?>
<?php echo $date ?> 沒有任何資料
<?php }	?>
</div>