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

function CountMessage() {
	$result = mysql_query("SELECT id FROM message WHERE deleted = '0' AND viewed = '0'");
	$num_rows = mysql_num_rows($result);

	if($num_rows < 1){
		return "0";
	} else {
		return $num_rows;
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

function GetContent($page){
	$page = secure($page);

	if(empty($page)){
		$name = "hem";
	} elseif (CheckPage($page) == 0) {
		$name = "404";
	} else {
		$name = $page;
	}

	$result = mysql_query("SELECT content FROM pages WHERE name = '$name' AND deleted = '0' LIMIT 1");
	$row = mysql_fetch_row($result);

	echo $row[0];
}

function GetMenu(){
	$result = mysql_query("SELECT name FROM pages WHERE deleted = '0' AND name != '404'");

	while($row = mysql_fetch_array($result)){
		?>
		<a href="?page=<?php echo $row['name']; ?>"><?php echo $row['name']; ?></a>
		<?php
	}
}

function GetPages(){
	$result = mysql_query("SELECT * FROM pages WHERE deleted = '0' AND name != '404'");

	while($row = mysql_fetch_array($result)){
		?>
		<td><?php echo $row['id']; ?></td>
		<td><?php echo $row['name']; ?></td>
		<td style="width:1px;"><a class="btn" href="#">Ändra</a></td>
		<td style="width:90px;"><a class="btn" href="#">Ta bort</a></td>
		<?php
	}
}

function CheckPage($page) {
	$result = mysql_query("SELECT * FROM pages WHERE name = '$page' AND deleted = '0'");
	$num_rows = mysql_num_rows($result);

	if($num_rows != 1){
		return 0;
	} else {
		return $num_rows;
	}
}

function CheckLogin() {
	if(!$_SESSION['user'] OR $_SESSION['user'] == "") {
		header('location: logga-in.php');
	}
}
?>