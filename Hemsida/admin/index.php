<?php
require('../assets/class.php');
require('../assets/functions.php');
include('../assets/database.php');

$Check->login();

$page = secure(@$_GET['page']);

switch ($page) {
	case '':
		$show_page = "start";
		break;
	case 'Start':
		$show_page = "start";
		break;
	case 'Pages':
		$show_page = "pages";
		break;
	case 'Message':
		$show_page = "message";
		break;
	default:
		$show_page = "404";
		break;
}
?>
<html>
	<head>
		<title>Adminpanelen</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='../assets/css/bootstrap.css' rel='stylesheet' type='text/css'>
		<link href='../assets/css/stylesheet.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="container">
			<div class="hero-unit">
				<ul class="breadcrumb">
				  	<li><a class="btn" href="?page=Start">Start</a></li>
				  	<li><a class="btn" href="?page=Pages">Alla sidor</a></li>
				  	<!--<li><a class="btn" href="#">Alla användare</a></li>-->
				  	<li class="pull-right">
				  		<?php
				  		if($Count->message() == 0){
				  			?><a class="btn" href="?page=Message">Meddelanden (<?php echo $Count->message(); ?>)</a><?php
				  		} else {
				  			?><a class="btn" href="?page=Message"><strong>Meddelanden (<?php echo CountMessage(); ?>)</strong></a><?php
				  		}
				  		?>
				  		<a class="btn" href="../process.php?action=logout">Logga ut</a>
				  	</li>
				</ul>
				<?php
				include($show_page.'.php');
				?>
			</div>
		</div>
		<br>
		<center><a class="btn" target="_Blank" href="http://webbits.nu/">Made by Webbits</a></center>
	</body>
</html>