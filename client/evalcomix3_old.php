<?php
	session_start();
	$_SESSION['idsession'] = session_id();
	include_once('selectlanguage.php');	
	$curso = getParam($_GET['cur']);
	$plataforma = getParam($_GET['plt']);
	$id = $_GET['identifier'];
	$lang = $_GET['lang'];

	header("Location: selection.php?cur=$curso&plt=$plataforma&identifier=$id&lang=$lang");
?>