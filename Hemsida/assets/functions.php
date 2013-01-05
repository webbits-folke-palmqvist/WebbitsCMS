<?php
@session_start();
include('assets/database.php');

function error() {
	if($_SESSION['error']){
		echo '<div class="alert alert-error">'.@$_SESSION['error'].'</div>';
		unset_error();
	}
}

function set_error($error) {
	$_SESSION['error'] = $error;
}

function unset_error() {
	unset($_SESSION['error']);
}

function success() {
	if($_SESSION['success']){
		echo '<div class="alert alert-success">'.@$_SESSION['success'].'</div>';
		unset_success();
	}
}

function set_success($success) {
	$_SESSION['success'] = $success;
}

function unset_success() {
	unset($_SESSION['success']);
}

function login(){
	if(!$_SESSION['user'] OR $_SESSION['user'] == "") {
		header('location: ?page=Logga-in');
	}
}

function rank(){
	$session = $_SESSION['user'];

	$sql = "SELECT rank FROM users WHERE username = '$session'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);

	return $row[0];
}

function count_rows($table) {
	$result = mysql_query("SELECT * FROM ".$table." WHERE deleted = '0'");
	$num_rows = mysql_num_rows($result);

	if($num_rows < 1){
		echo "0";
	} else {
		echo $num_rows;
	}
}

function count_rows_users_return($table) {
	$result = mysql_query("SELECT * FROM ".$table." WHERE deleted = '0' AND rank = '1'");
	$num_rows = mysql_num_rows($result);

	if($num_rows < 1){
		return 0;
	} else {
		return $num_rows;
	}
}

function count_rows_log_return($table) {
	$result = mysql_query("SELECT * FROM ".$table);
	$num_rows = mysql_num_rows($result);

	if($num_rows < 1){
		return 0;
	} else {
		return $num_rows;
	}
}

function count_rows_user($table, $user_id) {
	$result = mysql_query("SELECT * FROM ".$table." WHERE user_id = '$user_id' AND deleted = '0'");
	$num_rows = mysql_num_rows($result);

	if($num_rows < 1){
		echo "0";
	} else {
		echo $num_rows;
	}
}

function user_id($username){
	$result = mysql_query("SELECT id FROM users WHERE username = '$username' LIMIT 1");
	$row = mysql_fetch_row($result);

	return $row[0];
}

function username($id){
	$result = mysql_query("SELECT username FROM users WHERE id = '$id' LIMIT 1");
	$row = mysql_fetch_row($result);

	if($id == 0){
		return "Ingen användare";
	} else {
		return $row[0];
	}
}

function secure($unsafe){
	$unsafe = stripslashes($unsafe);
	$safe = mysql_real_escape_string($unsafe);
	return $safe;
}

function cat_name($id) {
	$result = mysql_query("SELECT name FROM category WHERE id = '$id' LIMIT 1");
	$row = mysql_fetch_row($result);

	return $row[0];
}

function my_cat($cat_id){
	$user_id = user_id($_SESSION['user']);

	$result = mysql_query("SELECT * FROM category WHERE deleted = '0' AND user_id = '$user_id' AND id = '$cat_id' LIMIT 1");
	$num_rows = mysql_num_rows($result);

	if($num_rows == 0){
		header('location: ?page=Start');
	}
}

function my_doc($doc_id){
	$user_id = user_id($_SESSION['user']);

	$result = mysql_query("SELECT * FROM document WHERE deleted = '0' AND user_id = '$user_id' AND id = '$doc_id' LIMIT 1");
	$num_rows = mysql_num_rows($result);

	if($num_rows == 0){
		header('location: ?page=Start');
	}
}

function random_code(){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
	$length = 32;

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}

function update_log($content){
	$user_id = user_id($_SESSION['user']);
	$contant = secure($content);
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = time();

	if($ip == "::1"){
		$ip = "localhost";
	}

	if(!$_SESSION['user']){
		$user_id = 0;
	}

	$sql = "INSERT INTO log(user_id, content, ip, time)VALUES('$user_id', '$content', '$ip', '$time')";
	$add = mysql_query($sql);
}

function daten($timestamp){
	$get = date("d-m-y", $timestamp);
	$now = date("d-m-y", time());
	$yesterday = date("d-m-y", (time() - (60 * 60 * 24)));

	if($get == $now){
		$date = "Idag";
	} elseif ($get == $yesterday) {
		$date = "Ig&aring;r";
	} else {
		$date = $get;
	}

	return $date;
}

function timen($timestamp){
	$get = date("d-m-y", $timestamp);
	$now = date("d-m-y", time());
	$yesterday = date("d-m-y", (time() - (60 * 60 * 24)));

	if($get == $now){
		$date = "Idag";
	} elseif ($date == $yesterday) {
		$date = "Ig&aring;r";
	} else {
		$date = $date_get;
	}
}

function GetSetting($id){
	$result = mysql_query("SELECT onoroff FROM settings WHERE id = '$id' LIMIT 1");
	$row = mysql_fetch_row($result);

	return $row[0];
}

function SiteDown(){
	if(GetSetting(1) == 1){
		if(rank() != 9){
			header('location: ?page=Sidan-nere');	
		}
	}
}
?>