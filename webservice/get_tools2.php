<?php
include_once('../configuration/conf.php');
include_once(DIRROOT . '/lib/weblib.php');
include_once(DIRROOT . '/classes/assessment.php');
include_once(DIRROOT . '/classes/plantilla.php');
include_once(DIRROOT . '/classes/cleanxml.php');
include_once(DIRROOT . '/classes/exporter.php');

if ( !isset( $HTTP_RAW_POST_DATA ) ) {
	$HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );
}
if ( !isset( $HTTP_RAW_POST_DATA ) ) {
	echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
	exit;
}


if(isset($_GET['format'])){
	$format = getParam($_GET['format']);
}

$xml_string = $HTTP_RAW_POST_DATA;
$xml = simplexml_load_string($xml_string);
$xml = cleanxml($xml);

//Definition of formats required
$required_formats = array('xml');


//Checking parameters

if(!isset($format)){
	echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
	exit;
}

if (!in_array($format, $required_formats)){
	echo '<evalcomix><status>error</status><id>#3</id><description>Format required is wrong</description></evalcomix>';
	exit;
}

$params = array();
$params['format'] = $format;

header('Content-type: text/xml; charset="utf-8"', true);
echo '<?xml version="1.0" encoding="utf-8"?>
<assessmentTools>';
foreach($xml as $tool){
	$pla_cod = (string)$tool;
	if(!$toolFetch = plantilla::fetch(array('pla_cod' => $pla_cod))){
		continue;
	}
	echo '<tool id="'.$toolFetch->pla_cod.'">';
	$params['tool_id'] = $toolFetch->id;
	$result = new exporter($params, $format);
	$result->export('none');
	echo '</tool>';
}
echo '</assessmentTools>';



?>