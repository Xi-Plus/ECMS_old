<script>
    var current_page = 'money';

    $(document).ready(function(){ loadPage('money'); });

    function loadPage(page){
		current_page=page;
        $('#frame').load('frag/'+current_page+'.php');
    }
</script>

<div style = "width: 100%">
    <!-- LEFT NAVIGATION BAR -->
    <div id = "tools" style = "float: left;">
        <br>

        <div>BOARDS:</div>
        <div style =  "text-align: right">
			<hr>
			<a id = "money" onclick = "loadPage('money')">餘額</a>
            <hr>
            <a id = "money" onclick = "loadPage('duty')">值日</a>
        </div>
        
        <br>

        <div id="TOOLS">TOOLS:</div>
        <div style =  "text-align: right">
            <hr>
            <div><a onclick = "loadPage(current_page)">refresh</a></div>
			<div id="settingdiv"><a onclick = 'if(document.all.setting.style.display=="none"){$("#setting").show("slow");}else{$("#setting").hide("slow");}'>setting</a></div>
			<div id="setting" style="display:none; position: absolute; top: 25px; left: 20px; z-index: 1; text-align: left; border: 2px solid #CCC; background: #000;">Setting font color:<br><input type="color" id="color" value="#ffffff"><br><a onclick="setcookie();">submit</a><br><a onclick="unsetcookie();">unset</a></div>
        </div>
		<script>
			$(window).resize(settingPositionChange);
			settingPositionChange();
			function settingPositionChange(){
				setting.style.top=($("#TOOLS").position().top+100)+"px";
				setting.style.left=($("#settingdiv").position().left+70)+"px";
			}
			function setcookie(){
				document.cookie="color="+document.all.color.value;
				location.reload();
			}
			function unsetcookie(){
				document.cookie="color=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
				location.reload();
			}
		</script>
        
    </div>
    
    <!-- BOARDS -->
    <div id = "frame" style = "float: left">
    
    </div>
    
</div>
<script type='text/javascript' src='./func/edit_font_color.js'></script>
<script>
document.all.color.value=(getCookie("color")==""?"#ffffff":getCookie("color"));
dfs(document.all.content);
</script>