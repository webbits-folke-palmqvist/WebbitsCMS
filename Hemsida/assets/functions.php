<?php
function secure($unsafe){
	$unsafe = stripslashes($unsafe);
	$safe = mysql_real_escape_string($unsafe);
	return $safe;
}
?>