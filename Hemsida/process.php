<?php
require('assets/functions.php');

$action = secure($_GET['action']);

if(!$action){
	header('location: index.php?page=Hem');
}

if($action == "login"){
	$user = secure($_POST['username']);
	$pass = md5(secure($_POST['password']));

	$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND rank != 0";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	if($count == 1){

		$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND deleted = 0 AND rank != 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		if($count == 1){
			$_SESSION['user'] = strtolower($user);
			header('location: admin/?page=Start');
		} else {
			set_error("* Denna användare är bannad eller raderad.");
			header('location: admin/logga-in.php');
		}
	} else {
		set_error("* Fel användarnamn eller lösenord.");
		header('location: admin/logga-in.php');
	}
}

if($action == "logout"){
	session_destroy();
	header('location: admin/logga-in.php');
}

if($action == "register"){
	$user = secure($_POST['username']);
	$pass = secure($_POST['password']);
	$pass2 = secure($_POST['password2']);

	if(!$pass OR !$pass2 OR !$user){
		set_error("* Fyll i alla fälten.");
		header('location: ?page=Registrera');
	} else {
		if($pass == $pass2){
			$sql = "SELECT * FROM users WHERE username = '$user'";
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
			$pass = md5($pass);

			if($count == 1){
				set_error("* Användarnamn används redan.");
				header('location: ?page=Registrera');	
			} else {
				$sql = "INSERT INTO users(username, password, rank)VALUES('$user', '$pass', '1')";
				$add = mysql_query($sql);

				if($add){
					set_success("Grattis, du är nu registrerad!");
					header('location: ?page=Lyckat');
				}
			}
		} else {
			set_error("* Lösenorden måste matcha.");
			header('location: ?page=Registrera');
		}
	}
}

if($action == "message"){
	$do = secure($_GET['do']);

	if($do == "delete"){
		$id = secure($_GET['id']);
		if(!$id){
			header('location: admin');
		} else {
			$sql = "UPDATE message SET deleted = 1 WHERE id = '$id' LIMIT 1";
			$update = mysql_query($sql);

			if($update){
				set_success("Meddelandet är nu borttaget.");
				header('location: admin/?page=Message');
			}
		}
	}
}

if($action == "pages"){
	$do = secure($_GET['do']);

	if($do == "add"){
		$name = secure($_POST['name']);
		$content = secure($_POST['content']);

		if(empty($name) OR empty($content)){
			set_error("* Fyll i alla fält");
			header('location: admin/?page=Pages&sub=add');
		} else {
			$time = time();

			$name = preg_replace('/\s/', '-', $name);

			$sql = "INSERT INTO pages(name, content, datetime)VALUES('$name', '$content', '$time')";
			$add = mysql_query($sql);

			if($add){
				set_success("Sidan har lagts till");
				header('location: admin/?page=Pages');
			}
		}
	}

	if($do == "edit"){
		$name = secure($_POST['name']);
		$content = secure($_POST['content']);
		$id = secure($_POST['id']);

		if(empty($name) OR empty($content) OR empty($id)){
			header('location: admin/?page=Pages');
		} else {
			$time = time();

			$name = preg_replace('/\s/', '-', $name);

			$sql = "UPDATE pages SET name = '$name', content = '$content', datetime = '$time' WHERE id = '$id' LIMIT 1";
			$update = mysql_query($sql);

			if($update){
				set_success("Ändringarna är nu sparade.");
				header('location: admin/?page=Pages');
			}
		}
	}

	if($do == "delete"){
		$id = secure($_GET['id']);
		if(!$id){
			header('location: admin');
		} else {
			$sql = "UPDATE pages SET deleted = 1 WHERE id = '$id' LIMIT 1";
			$update = mysql_query($sql);

			if($update){
				set_success("Sidan är nu borttaget.");
				header('location: admin/?page=Pages');
			}
		}
	}
}
?>