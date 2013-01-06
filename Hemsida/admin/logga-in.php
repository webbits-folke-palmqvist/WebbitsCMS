<?php
require('../assets/functions.php');

if($_SESSION['user'] != ""){
	header('location: ?page=Start');
}
?>
<html>
	<head>
		<title>Logga in</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='../assets/css/bootstrap.css' rel='stylesheet' type='text/css'>
		<link href='../assets/css/stylesheet.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<form class="form-signin" action="../process.php?action=login" method="POST">
			<h2 class="form-signin-heading">Var vänlig att logga in</h2>
			<h5><?php error(); ?></h5>
			<input name="username" type="text" class="input-block-level" placeholder="Användarnamn">
			<input name="password" type="password" class="input-block-level" placeholder="Lösenord">
			<button class="btn btn-large btn-success btn-block" type="submit">Logga in</button>
			<hr>
			<center><a class="btn" href="../">Tillbaka till sidan</a></center>
		</form>
		<center><a class="btn" target="_Blank" href="http://webbits.nu/">Made by Webbits</a></center>
	</body>
</html>