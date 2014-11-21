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
$content = @file_get_contents("../cache/money.dat");
$content = handleEOL($content);
$raw_money = explode(PHP_EOL, $content);
$array_money=array();
foreach($raw_money as $temp){
	$text=explode("\t", $temp);
	$result[$text[0]]["money"]=$text[1];
}
function sort_by_index($a, $b){
	if($a['index'] == $b['index']) return 0;
	return ($a['index'] > $b['index']) ? 1 : -1;
}
function sort_by_money($a, $b){
	if($a['money'] == $b['money']){
		if($a['index'] == $b['index']) return 0;
		return ($a['index'] > $b['index']) ? 1 : -1;
	}
	return ($a['money'] > $b['money']) ? 1 : -1;
}
function rsort_by_money($a, $b){
	if($a['money'] == $b['money']){
		if($a['index'] == $b['index']) return 0;
		return ($a['index'] > $b['index']) ? 1 : -1;
	}
	return ($a['money'] > $b['money']) ? -1 : 1;
}
if($sort_rule=="index")usort($result,'sort_by_index');
else if($sort_rule=="value")usort($result,'sort_by_money');
else if($sort_rule=="rvalue")usort($result,'rsort_by_money');
?>
<div id = "money" style = "position: relative; margin-left: 80px">
	<br>
	<h2>餘額</h2>
	<br>

	<div class = 'table-wrapper' style="overflow-x:auto;overflow-y:auto">
	<table>
	<tr><td></td><td>姓名</td><td>餘額</td></tr>
	<?php
	foreach($result as $temp){
		echo "<tr><td>".$temp["index"]."</td><td>".$temp["name"]."</td><td>".$temp["money"]."</td></tr>";
	}
	?>
	</table>
	</div>
	<script>
		$(window).resize(windowSizeChange);
		$("#table-<?=(int)$group['index']?>").width(800);
		windowSizeChange();
		function windowSizeChange(){
			$("#table-<?=(int)$group['index']?>").width( $(window).width()-$("#frame").position().left - 150 );
		}
	</script>
</div>
<div style = "color: #666666; padding-left: 80px">
    <?php echo $status_string; ?>
    <br>
</div>
<script type='text/javascript' src='./func/edit_font_color.js'></script>
<script>dfs(document.all.frame);</script>