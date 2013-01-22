<?php
class Database {
	function connect() {
		mysql_connect("localhost", "root", "root") or die(mysql_error());
		mysql_select_db("webbitscms") or die(mysql_error());

		mysql_query("SET NAMES utf8");
		mysql_query("SET CHARACTER SET utf8");
	}

	function query($sql) {
		return mysql_query($sql);
	}
}

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
		$this->Database = new Database();

		$page = secure($page);

		if(empty($page)){
			$name = "hem";
		} elseif ($this->Check->page($page) == 0) {
			$name = "404";
		} else {
			$name = $page;
		}


		$row = mysql_fetch_row($this->Database->query("SELECT content,id FROM pages WHERE name = '$name' AND deleted = '0' LIMIT 1"));

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

	function menu() {
		$this->Database = new Database();

		while($row = mysql_fetch_array($this->Database->query("SELECT name FROM pages WHERE deleted = '0' AND name != '404'"))){
			$name = $row['name'];
			$name = str_replace("-"," ", $name);
			?>
			<a class="btn btn-block" href="?page=<?php echo $row['name']; ?>"><?php echo $name; ?></a>
			<?php
		}
	}

	function name($id) {
		$this->Database = new Database();

		$row = mysql_fetch_row($this->Database->query("SELECT name FROM pages WHERE id = '$id' AND deleted = '0' LIMIT 1"));

		return $row[0];
	}
}

class User {
	function rank() {
		$this->Database = new Database();

		$username = $_SESSION['user'];

		$row = mysql_fetch_row($this->Database->query("SELECT rank FROM users WHERE username = '$username'"));

		return $row[0];
	}

	function id($username) {
		$this->Database = new Database();

		$row = mysql_fetch_row($this->Database->query("SELECT id FROM users WHERE username = '$username' LIMIT 1"));

		return $row[0];
	}

	function username($id) {
		$this->Database = new Database();

		$row = mysql_fetch_row($this->Database->query("SELECT username FROM users WHERE id = '$id' LIMIT 1"));

		if($id == 0){
			return "Ingen användare";
		} else {
			return $row[0];
		}
	}
}

class Count {
	function message() {
		$this->Database = new Database();

		$num_rows = mysql_num_rows($this->Database->query("SELECT id FROM message WHERE deleted = '0' AND viewed = '0'"));

		if($num_rows < 1){
			return "0";
		} else {
			return $num_rows;
		}
	}

	function write($sql) {
		$this->Database = new Database();

		$num_rows = mysql_num_rows($this->Database->query($sql));

		if($num_rows < 1){
			return "0";
		} else {
			return $num_rows;
		}
	}
}

class Check {
	function login() {
		if(!$_SESSION['user'] OR $_SESSION['user'] == "") {
			header('location: logga-in.php');
		}
	}

	function page($page) {
		$this->Database = new Database();

		$num_rows = mysql_num_rows($this->Database->query("SELECT * FROM pages WHERE name = '$page' AND deleted = '0'"));

		if($num_rows != 1){
			return 0;
		} else {
			return $num_rows;
		}
	}

	function admin() {
		$this->Database = new Database();

		$username = $_SESSION['user'];

		$row = mysql_fetch_row($this->Database->query("SELECT rank FROM users WHERE username = '$username'"));

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