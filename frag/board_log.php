<?php
$logdate = $_COOKIE["ECMSlogshowdate"];
if($logdate=="")$logdate=date("Ymd");
$time = mktime(0,0,0,1*substr($logdate,4,2),1*substr($logdate,6,2),1*substr($logdate,0,4));
?>
<script>
	var sortby = "<?php echo $_POST["sortby"]; ?>";
	var time = <?php echo $time; ?>;
	var today = <?php echo time(); ?>;
	var d = new Date();
	d.setFullYear(<?php echo substr($logdate,0,4); ?>,<?php echo substr($logdate,4,2); ?>,<?php echo substr($logdate,6,2); ?>);
	function addzero(n){
		if(n<10)return "0"+n;
		return n;
	}
	function settime(n){
		time+=86400*n;
		d.setTime(time*1000);
		document.all.dateinput.value=d.getFullYear().toString()+addzero(d.getMonth()+1)+addzero(d.getDate()).toString();
	}
	
    $(document).ready(function(){ loadlogPage();settime(0); });
	
    function loadlogPage(){
        $('#logframe').load('frag/board_log_show.php',
            {
				date: document.all.dateinput.value,
				sortby_log: sortby
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
	Date: <input id="dateinput" name="dateinput" value="<?php echo $_COOKIE["ECMSlogshowdate"]; ?>">
	<input type="button" value="Submit" onclick="loadlogPage();">
	<input type="button" value="前一天" onclick="settime(-1);loadlogPage();">
	<input type="button" value="後一天" onclick="settime(1);loadlogPage();">
	<input type="button" value="今天" onclick="time=today;settime(0);loadlogPage();">
	</form>
	</div>
	<br>
	
	<div id = "logframe" style = "float: left">
    
    </div>
	
</div>
<script>dfs(document.all.frame);</script>