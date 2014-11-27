<?php
	session_start();
	$_SESSION['idsession'] = session_id();
	include_once('selectlanguage.php');	
	$id = $_GET['identifier'];
	$lang = $_GET['lang'];
	$new = $_GET['type'];

	header("Location: selection.php?identifier=$id&lang=$lang&type=$new");
?>