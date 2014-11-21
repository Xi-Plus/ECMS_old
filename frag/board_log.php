<script>
    var datevalue = '<?php echo date("Ymd"); ?>';
	
    $(document).ready(function(){ loadlogPage(datevalue); });
	
    function loadlogPage(){
        $('#logframe').load('frag/board_log_show.php',
            {
                date: datevalue
            }
		);
    }
</script>
<div id = "log" style = "position: relative; margin-left: 80px">
	<br>
	<h2>紀錄</h2>
	<br>
	<div class = 'table-wrapper'>
	<form method="POST">
	Date: <input id="dateinput" name="dateinput" value="<?php echo date("Ymd"); ?>"> <input type="button" value="Submit" onclick="datevalue=document.all.dateinput.value;loadlogPage();">
	</form>
	</div>
	<br>
	
	<div id = "logframe" style = "float: left">
    
    </div>
	
</div>
<script type='text/javascript' src='./func/edit_font_color.js'></script>
<script>dfs(document.all.frame);</script>