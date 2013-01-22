<?php
include('assets/_top.php');
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Beta</title>
	</head>
	<body>
		<?php $Get->menu('<a class="btn" href="', '">', '</a>'); ?>
		<?php $Get->content(@$_GET['page']); ?>
	</body>
</html>