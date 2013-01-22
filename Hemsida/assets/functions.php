<?php
@session_start();
include('database.php');

function secure($unsafe){
	$unsafe = stripslashes($unsafe);
	$safe = mysql_real_escape_string($unsafe);
	return $safe;
}

function checkpage($page) {
	$result = mysql_query("SELECT * FROM pages WHERE name = '$page' AND deleted = '0'");
	$num_rows = mysql_num_rows($result);

	if($num_rows != 1){
		return 0;
	} else {
		return $num_rows;
	}
}
?>