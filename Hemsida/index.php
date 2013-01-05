<?php
require('assets/functions.php');

GetMenu();

GetContent(@$_GET['page']);
?>