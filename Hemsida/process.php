<?php
include('assets/_top.php');

$action = secure($_GET['action']);

if(!$action){
	header('location: index.php?page=Hem');
} elseif ($action == "login"){
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
			$Error->set("* Denna användare är bannad eller raderad.");
			header('location: admin/logga-in.php');
		}
	} else {
		$Error->set("* Fel användarnamn eller lösenord.");
		header('location: admin/logga-in.php');
	}
} elseif ($action == "logout"){
	session_destroy();
	header('location: admin/logga-in.php');
} elseif ($action == "register"){
	$user = secure($_POST['username']);
	$pass = secure($_POST['password']);
	$pass2 = secure($_POST['password2']);

	if(!$pass OR !$pass2 OR !$user){
		$Error->set("* Fyll i alla fälten.");
		header('location: ?page=Registrera');
	} else {
		if($pass == $pass2){
			$sql = "SELECT * FROM users WHERE username = '$user'";
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
			$pass = md5($pass);

			if($count == 1){
				$Error->set("* Användarnamn används redan.");
				header('location: ?page=Registrera');	
			} else {
				$sql = "INSERT INTO users(username, password, rank)VALUES('$user', '$pass', '1')";
				$add = mysql_query($sql);

				if($add){
					$Success->set("Grattis, du är nu registrerad!");
					header('location: ?page=Lyckat');
				}
			}
		} else {
			$Error->set("* Lösenorden måste matcha.");
			header('location: ?page=Registrera');
		}
	}
} elseif ($action == "message"){
	$do = secure($_GET['do']);

	if($do == "delete"){
		$id = secure($_GET['id']);
		if(!$id){
			header('location: admin');
		} else {
			$sql = "UPDATE message SET deleted = 1 WHERE id = '$id' LIMIT 1";
			$update = mysql_query($sql);

			if($update){
				$Success->set("Meddelandet är nu borttaget.");
				header('location: admin/?page=Message');
			}
		}
	}
} elseif ($action == "pages"){
	$do = secure($_GET['do']);

	if($do == "add"){
		$name = secure($_POST['name']);
		$content = secure($_POST['content']);

		if(empty($name) OR empty($content)){
			$Error->set("* Fyll i alla fält");
			header('location: admin/?page=Pages&sub=add');
		} else {
			$time = time();

			$name = preg_replace('/\s/', '-', $name);
			$byt = array ( "Ã…", "Ã„", "Ã–", "Ã¥", "Ã¤", "Ã¶" );
			$med = array ( "Å", "Ä", "Ö", "å", "ä", "ö" );
			$name = str_replace($byt,$med,$name);

			$sql = "INSERT INTO pages(name, content, datetime)VALUES('$name', '$content', '$time')";
			$add = mysql_query($sql);

			if($add){
				$Success->set("Sidan har lagts till");
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
				$Success->set("Ändringarna är nu sparade.");
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
				$Success->set("Sidan är nu borttaget.");
				header('location: admin/?page=Pages');
			} else {
				$Error->set("Något gick fel.");
				header('location: admin/?page=Pages');
			}
		}
	}
} elseif ($action == "kontakt"){
	$from_name = secure($_POST['from_name']);
	$from_email = secure($_POST['from_email']);
	$content = secure($_POST['content']);
	$datetime = time();

	if(empty($from_email) OR empty($from_name) OR empty($content)){
		$Error->set("* Fyll i alla fält.");
		header('location: index.php?page='.$Get->page(3));
	} else {
		$sql = "INSERT INTO message(from_name, from_email, content, datetime)VALUES('$from_name', '$from_email', '$content', '$datetime')";
		$add = mysql_query($sql);

		if($add){
			$Success->set("Ditt meddelande skickades");
			header('location: index.php?page='.$Get->page(3));
		}
	}
} elseif ($action == "users") {
	$do = $_GET['do'];

	if($do == "edit") {
		$id = secure($_GET['id']);
		$username = secure($_POST['username']);
		$password = secure($_POST['password']);
		$rank = secure($_POST['rank']);

		if(empty($username) OR empty($rank)){
			$Error->set("Något gick fel.");
			header('location: admin/?page=Members&sub=edit&id='.$id);
		} else {
			if(empty($password)) {
				$sql = "UPDATE users SET username = '$username', rank = '$rank' WHERE id = '$id' LIMIT 1";
				$update = mysql_query($sql);

				if($update){
					$Success->set("Ändringarna är nu sparade.");
					header('location: admin/?page=Members&sub=edit&id='.$id);;
				}
			} else {
				$sql = "UPDATE users SET username = '$username', password = '$password', rank = '$rank' WHERE id = '$id' LIMIT 1";
				$update = mysql_query($sql);

				if($update){
					$Success->set("Ändringarna är nu sparade.");
					header('location: admin/?page=Members&sub=edit&id='.$id);;
				}
			}
		}
	} elseif ($do == "add") {
		$username = secure($_POST['username']);
		$password = secure($_POST['password']);
		$rank = secure($_POST['rank']);

		if(empty($username) OR empty($password) OR empty($rank)){
			$Error->set("Fyll i alla fält.");
			header('location: admin/?page=Members&sub=add');
		} else {
			$password = md5($password);
			$sql = "INSERT INTO users(username, password, rank, deleted)VALUES('$username', '$password', '$rank', '0')";
			$add = mysql_query($sql);

			if($add){
				$Success->set("Användaren har nu skapats.");
				header('location: admin/?page=Members');
			}
		}
	}
} else {
	header('location: ?page='.$Get->page(3));
}
?>