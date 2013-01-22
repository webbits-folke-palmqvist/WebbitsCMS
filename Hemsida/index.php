<?php
require('assets/class.php');
require('assets/functions.php');
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Beta</title>
	</head>
	<body>
		<?php $Get->menu(); ?>
		<?php $Get->content(@$_GET['page']); ?>
	</body>
</html>