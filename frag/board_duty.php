<?php
require_once("../func/EOL.php");
$sort_rule = $_POST['sortby'];
$result=array();
$content = @file_get_contents("../config/names.dat");
$content = handleEOL($content);
$raw_names = explode(PHP_EOL, $content);
foreach($raw_names as $temp){
	$text=explode("\t", $temp);
	$result[$text[0]]["index"]=$text[0];
	$result[$text[0]]["name"]=$text[1];
}
$content = @file_get_contents("../cache/duty.dat");
$content = handleEOL($content);
$raw_duty = explode(PHP_EOL, $content);
foreach($raw_duty as $temp){
	$text=explode("\t", $temp);
	$result[$text[0]]["A"]=$text[1];
	$result[$text[0]]["B"]=$text[2];
	$result[$text[0]]["C"]=number_format($text[2]/$text[1]*100,0);
}
function sort_by_index($a, $b){
	if($a['index'] == $b['index']) return 0;
	return ($a['index'] > $b['index']) ? 1 : -1;
}
function sort_by_money($a, $b){
	if($a['C'] == $b['C']){
		if($a['index'] == $b['index']) return 0;
		return ($a['index'] > $b['index']) ? 1 : -1;
	}
	return ($a['C'] > $b['C']) ? 1 : -1;
}
function rsort_by_money($a, $b){
	if($a['C'] == $b['C']){
		if($a['index'] == $b['index']) return 0;
		return ($a['index'] > $b['index']) ? 1 : -1;
	}
	return ($a['C'] > $b['C']) ? -1 : 1;
}
if($sort_rule=="index")usort($result,'sort_by_index');
else if($sort_rule=="value")usort($result,'sort_by_money');
else if($sort_rule=="rvalue")usort($result,'rsort_by_money');
?>
<div id = "money" style = "position: relative; margin-left: 80px">
	<br>
	<h2>值日</h2>版本 : <?php echo @file_get_contents("../cache/update.dat")?>
	<br><br>
	<div class = 'table-wrapper' style="overflow-x:auto;overflow-y:auto">
	<table>
	<tr><td></td><td>姓名</td><td>訂購</td><td>值日</td><td>比例</td></tr>
	<?php
	foreach($result as $temp){
		if($temp["index"]!="")echo "<tr><td>".$temp["index"]."</td><td>".$temp["name"]."</td><td>".$temp["A"]."</td><td>".$temp["B"]."</td><td>".$temp["C"]."%</td></tr>";
	}
	?>
	</table>
	</div>
</div>
<script type='text/javascript' src='./func/edit_font_color.js'></script>
<script>dfs(document.all.frame);</script>