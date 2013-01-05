<?php
require('assets/functions.php');
require('assets/database.php');

session_start();

$action = secure($_GET['action']);

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
			header('location: ?page=Start');
		} else {
			set_error("* Denna användare är bannad eller raderad.");
			header('location: ?page=Logga-in');
		}
	} else {
		set_error("* Fel användarnamn eller lösenord.");
		header('location: ?page=Logga-in');
	}
}

if($action == "logout"){
	session_destroy();
	header('location: ?page=Logga-in');
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
?>