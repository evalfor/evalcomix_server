<?php
	if(isset($_SESSION['tool']))
		unset($_SESSION['tool']);
//LANGUAGE.............
	require_once('weblib.php');
	if(isset($_GET['lang'])){
		$lang = getParam($_GET['lang']);
	}
	elseif(isset($_SESSION['lang'])){
		$lang = $_SESSION['lang'];
	}
	$language;
	switch($lang){
		case 'es_es_utf8':{
			require_once('lang/es_utf8/evalcomix.php');
			$language = 'es_utf8';
		}break;
		case 'es_utf8':{
			require_once('lang/es_utf8/evalcomix.php');
			$language = 'es_utf8';
		}break;
		case 'en_utf8':{
			require_once('lang/en_utf8/evalcomix.php');
			$language = 'en_utf8';
		}break;
		case 'ca_utf8':{
			require_once('lang/ca_utf8/evalcomix.php');
			$language = 'ca_utf8';
		}break;
		case 'eu_utf8':{
			require_once('lang/eu_utf8/evalcomix.php');
			$language = 'eu_utf8';
		}break;
		default:{
			require_once('lang/es_utf8/evalcomix.php');
			$language = 'es_utf8';
		}
	}
	$_SESSION['lang'] = $language;