<?php
//LANGUAGE.............
//require_once('../configuration/conf.php');
$dirroot = '.';
if (defined('DIRROOT')) {
	$dirroot = DIRROOT;
}
require_once($dirroot . '/lib/weblib.php');

define ('LANGUAGE_ES_ES','es_es_utf8');
define ('LANGUAGE_ES',   'es_utf8');
define ('LANGUAGE_EN',   'en_utf8');
define ('LANGUAGE_CA',   'ca_utf8');
define ('LANGUAGE_EU',   'eu_utf8');

$lang = get_param('lang', PARAM_RAW, 'optional');

if(!isset($lang) && isset($_SESSION['lang'])){
	$lang = $_SESSION['lang'];
}
$language = '';
switch($lang){
	case LANGUAGE_ES_ES:{
		require_once($dirroot . '/lang/'.LANGUAGE_ES.'/dictionary.php');
		$language = LANGUAGE_ES;
	}break;
	case LANGUAGE_ES:{
		require_once($dirroot . '/lang/'.LANGUAGE_ES.'/dictionary.php');
		$language = LANGUAGE_ES;
	}break;
	case LANGUAGE_EN:{
		require_once($dirroot . '/lang/'.LANGUAGE_EN.'/dictionary.php');
		$language = LANGUAGE_EN;
	}break;
	case LANGUAGE_CA:{
		require_once($dirroot . '/lang/'.LANGUAGE_ES.'/dictionary.php');
		$language = LANGUAGE_CA;
	}break;
	case LANGUAGE_EU:{
		require_once($dirroot . '/lang/'.LANGUAGE_ES.'/dictionary.php');
		$language = LANGUAGE_EU;
	}break;
	default:{
		require_once($dirroot . '/lang/'.LANGUAGE_EN.'/dictionary.php');
		$language = LANGUAGE_EN;
	}
}
$_SESSION['lang'] = $language;