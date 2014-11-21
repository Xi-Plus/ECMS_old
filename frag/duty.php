<?php
require_once("../func/EOL.php");
$content = @file_get_contents("../config/names.dat");
$content = handleEOL($content);
$raw_names = explode(PHP_EOL, $content);
$array_names=array();
foreach($raw_names as $temp){
	$text=explode("\t", $temp);
	$array_names[$text[0]]["index"]=$text[0];
	$array_names[$text[0]]["name"]=$text[1];
}
$content = @file_get_contents("../cache/money.dat");
$content = handleEOL($content);
$raw_money = explode(PHP_EOL, $content);
$array_money=array();
foreach($raw_money as $temp){
	$text=explode("\t", $temp);
	$array_money[$text[0]]=$text[1];
}
?>
<div id = "money" style = "position: relative; margin-left: 80px">
	<br>
	<h2>值日</h2>
	<br>

	<div class = 'table-wrapper' style="overflow-x:auto;overflow-y:auto">
	<table>
	<tr><td></td><td>姓名</td><td>餘額</td></tr>
	<?php
	foreach($array_names as $names){
		echo "<tr><td>".$names["index"]."</td><td>".$names["name"]."</td><td>".$array_money[$names["index"]]."</td></tr>";
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