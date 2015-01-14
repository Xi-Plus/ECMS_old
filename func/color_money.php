<?php
function color_money($money){
	if($money>=250)return "<font color='#66FFE6'>".$money."</font>";
	else if($money>=100)return "<font color='#66FF00'>".$money."</font>";
	else if($money>=0)return "<font color='#FFFF00'>".$money."</font>";
	else if($money>-100)return "<font color='#FFA500'>".$money."</font>";
	else return "<font class='blink' color='#FF0000'>".$money."</font>";
}
?>
