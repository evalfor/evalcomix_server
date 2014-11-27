<?php
//error_reporting(E_ALL);
//ini_set('display_errors','On');
	include_once('../../../configuration/conf.php');
	include_once('../../../configuration/host.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/lib/post_xml.php');

	if ( !isset( $HTTP_RAW_POST_DATA ) ) {
		$HTTP_RAW_POST_DATA = file_get_contents( 'php://input' ); 
	}
	if ( !isset( $HTTP_RAW_POST_DATA ) ) {
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;
	}

	$xml_string = $HTTP_RAW_POST_DATA;
	$xml = simplexml_load_string($xml_string);
	
	$hashtools = array();
	foreach($xml->toolsid[0] as $item){
		$plantilla = plantilla::fetch(array('pla_cod' => (string)$item->oldid));
		$oldid = $plantilla->id;
		$plantilla = plantilla::fetch(array('pla_cod' => (string)$item->newid));
		$newid = $plantilla->id;
		$hashtools[$oldid] = $newid;
	}
	
	$asses = array();
	foreach($xml->assessmentsid[0] as $item){
		$oldid = (string)$item->oldid;
		$newid = (string)$item->newid;
		$assid = assessment::duplicate2($oldid, $newid, $hashtools);
		
	}
	
	echo '
	<evalcomix>
		<status>success</status>
		<description>Course duplicated successfully</description>
	</evalcomix>';
?>