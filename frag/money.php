         MONEY
		<div id = "table-" style = "display: none; position: relative; margin-left: 80px">
       
    	<br>
    	<h2><?php echo $group['index'].' : '.$group['label']; ?></h2>
    	<br>
	
    	<div class = 'table-wrapper' style="overflow-x:auto;overflow-y:auto">
        <table>
    	
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