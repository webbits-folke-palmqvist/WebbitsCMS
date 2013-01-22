<?php
include('../assets/_top.php');

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

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
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
			<?php
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$finish = $time;
			$total_time = round(($finish - $start), 4);
			?>
			<center><i><?php echo "Sidan laddade på ".$total_time." sekunder"; ?></i></center>
		</div>
		<br>
		<center><a class="btn" target="_Blank" href="http://webbits.nu/">Made by Webbits</a></center>
	</body>
</html>