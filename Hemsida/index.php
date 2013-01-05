<?php
$page = @$_GET['page'];
switch ($page) {
	case '':
		$show_page = "home";
		$title = "Hem";
		break;
	case 'Hem':
		$show_page = "home";
		$title = "Hem";
		break;
	case 'Start':
		$show_page = "start";
		$title = "Start";
		break;
	case 'Om-oss':
		$show_page = "about";
		$title = "Om oss";
		break;
	case 'Logga-in':
		$show_page = "login";
		$title = "Logga in";
		break;
	case 'Registrera':
		$show_page = "register";
		$title = "Registrera dig";
		break;
	case 'Dokument':
		$show_page = "document";
		$title = "Lägg till ett dokument";
		break;
	case 'Process':
		$show_page = "process";
		$title = "Process";
		break;
	case 'Lyckat':
		$show_page = "success";
		$title = "Lyckat";
		break;
	case 'Kategori':
		$show_page = "category";
		$title = "Kategori";
		break;
	case 'Admin':
		$show_page = "admin";
		$title = "Admin";
		break;
	case 'Mitt-konto':
		$show_page = "account";
		$title = "Mitt konto";
		break;
	case 'Visa':
		$show_page = "view";
		$title = "Visa";
		break;
	case 'Sidan-nere':
		$show_page = "sitedown";
		$title = "Sidan nere";
		break;
	default:
		$show_page = "404";
		$title = "404";
		break;
}

include('assets/pages/'.$show_page.'.php');
?>