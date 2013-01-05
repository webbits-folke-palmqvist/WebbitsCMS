<?php
require('../assets/functions.php');
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
				  	<li><a class="btn" href="index.php">Start</a></li>
				  	<li><a class="btn" href="#">Alla sidor</a></li>
				  	<li><a class="btn" href="#">Alla användare</a></li>
				  	<li class="pull-right">
				  		<?php
				  		if(CountMessage() == 0){
				  			?><a class="btn" href="#">Meddelanden (<?php echo CountMessage(); ?>)</a><?php
				  		} else {
				  			?><a class="btn" href="#"><strong>Meddelanden (<?php echo CountMessage(); ?>)</strong></a><?php
				  		}
				  		?>
				  	</li>
				</ul>
				<h3>Välkommen</h3>
				<p>Detta är ett CMS byggt utav <a target="_Blank" href="http://webbits.nu/">Webbits</a></p>
			</div>
		</div>
	</body>
</html>