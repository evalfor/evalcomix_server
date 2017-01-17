<?php
include_once('../configuration/conf.php');
include_once(DIRROOT . '/lib/weblib.php');
include_once(DIRROOT . '/classes/assessment.php');
include_once(DIRROOT . '/classes/plantilla.php');
include_once(DIRROOT . '/classes/cleanxml.php');
include_once(DIRROOT . '/classes/exporter.php');

$post_data = file_get_contents( 'php://input' );
if ( !isset( $post_data ) ) {
	echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
	exit;
}


if(isset($_GET['format'])){
	$format = getParam($_GET['format']);
}

$xml_string = $post_data;
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
foreach($xml as $assessment){
	$params['ass_id'] = (string)$assessment;
	if(!$assessmentFetch = assessment::fetch($params)){
		continue;
	}
	$params['tool_id'] = $assessmentFetch->ass_pla;
	$params['assessment'] = $assessmentFetch;
	echo '<assessment id="'.$assessmentFetch->ass_id.'">';
	$result = new exporter($params, $format);
	$result->export('none');
	echo '</assessment>';
}
echo '</assessmentTools>';



?>