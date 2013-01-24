<?php
class Error {
	function show() {
		if(@$_SESSION['error']){
			echo '<div class="alert alert-error">'.@$_SESSION['error'].'</div>';
			unset($_SESSION['error']);
		}
	}

	function set($error) {
		$_SESSION['error'] = $error;
	}
}

class Success {
	function show() {
		if(@$_SESSION['success']){
			echo '<div class="alert alert-success">'.@$_SESSION['success'].'</div>';
			unset($_SESSION['success']);
		}
	}

	function set($success) {
		$_SESSION['success'] = $success;
	}
}

class Get {
	function content($page) {

		$this->Error = new Error();
		$this->Success = new Success();
		$this->Check = new Check();

		$page = secure($page);

		if(empty($page)){
			$name = "hem";
		} elseif ($this->Check->page($page) == 0) {
			$name = "404";
		} else {
			$name = $page;
		}

		$result = mysql_query("SELECT content,id FROM pages WHERE name = '$name' AND deleted = '0' LIMIT 1");
		$row = mysql_fetch_row($result);

		echo $row[0];

		if($row[1] == 3){
			$this->Success->show();
			$this->Error->show();
			?>
			<form action="process.php?action=kontakt" method="POST">
				<input class="input-fill" type="text" name="from_name" placeholder="Namn"><br />
				<input class="input-fill" type="text" name="from_email" placeholder="Email"><br />
				<textarea name="content"></textarea>
				<script language="javascript" type="text/javascript" src="assets/tiny_mce/tiny_mce.js"></script>
			    <script language="javascript" type="text/javascript">
			    tinyMCE.init({
			            theme : "simple",
			            mode : "textareas",
			            theme_advanced_toolbar_location : "top"
			    });
			    </script>
			    <br>
			    <input class="btn btn-success" type="submit" value="Skicka meddelande">
			</form>
			<?php
		}
	}

	function menu($a, $b, $c) {
		$result = mysql_query("SELECT name FROM pages WHERE deleted = '0' AND name != '404'");
		while($row = mysql_fetch_array($result)){
			$name = $row['name'];
			$name2 = str_replace("-"," ", $name);
			echo $a."?page=".$name."".$b."".$name2."".$c." ";
		}
	}

	function name($id) {
		$result = mysql_query("SELECT name FROM pages WHERE id = '$id' AND deleted = '0' LIMIT 1");

		$row = mysql_fetch_row($result);

		return $row[0];
	}
}

class User {
	function rank() {
		$username = $_SESSION['user'];

		$result = mysql_query("SELECT rank FROM users WHERE username = '$username'");
		$row = mysql_fetch_row();

		return $row[0];
	}

	function id($username) {
		$result = mysql_query("SELECT id FROM users WHERE username = '$username' LIMIT 1");

		$row = mysql_fetch_row();

		return $row[0];
	}

	function username($id) {
		$result = mysql_query("SELECT username FROM users WHERE id = '$id' LIMIT 1");

		$row = mysql_fetch_row();

		if($id == 0){
			return "Ingen användare";
		} else {
			return $row[0];
		}
	}
}

class Count {
	function message() {
		$result = mysql_query("SELECT id FROM message WHERE deleted = '0' AND viewed = '0'");

		$num_rows = @mysql_num_rows();

		if($num_rows < 1){
			return "0";
		} else {
			return $num_rows;
		}
	}

	function write($sql) {
		$result = mysql_query($sql);

		$num_rows = mysql_num_rows($result);

		if($num_rows < 1){
			return "0";
		} else {
			return $num_rows;
		}
	}
}

class Check {
	function login() {
		if(!@$_SESSION['user'] OR @$_SESSION['user'] == "") {
			header('location: logga-in.php');
		}
	}

	function page($page) {
		$result = mysql_query("SELECT * FROM pages WHERE name = '$page' AND deleted = '0'");

		$num_rows = mysql_num_rows($result);

		if($num_rows != 1){
			return 0;
		} else {
			return $num_rows;
		}
	}

	function admin() {
		$username = $_SESSION['user'];

		$result = mysql_query("SELECT rank FROM users WHERE username = '$username'");
		$row = mysql_fetch_row($result);

		if($row[0]){
			return true;
		} else {
			return false;
		}
	}
}

class Datentime {
	function now() {
		$now = date("d/m/y - H:i:s", time());
	}

	function then($timestamp) {
		$get = date("d/m/y", $timestamp);
		$now = date("d/m/y", time());
		$yesterday = date("d/m/y", (time() - (60 * 60 * 24)));

		if($get == $now){
			$date = "Idag - ".date("H:i:s", $timestamp);
		} elseif ($get == $yesterday) {
			$date = "Ig&aring;r".date("H:i:s", $timestamp);
		} else {
			$date = $get." - ".date("H:i:s", $timestamp);
		}

		return $date;
	}
}

$Error = new Error;
$Success = new Success;
$Get = new Get;
$User = new User;
$Count = new Count;
$Check = new Check;
$Datentime = new Datentime;
?>