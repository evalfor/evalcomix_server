<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/client/tool.php');
	include_once(DIRROOT . '/classes/cleanxml.php');
	
	if ( !isset( $HTTP_RAW_POST_DATA ) ) {
		$HTTP_RAW_POST_DATA = file_get_contents( 'php://input' ); 
	}
	if ( !isset( $HTTP_RAW_POST_DATA ) ) {
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	
	if(isset($_GET['id'])){
		$id = getParam($_GET['id']);
	}

	$xml_string = $HTTP_RAW_POST_DATA;
	$xml = simplexml_load_string($xml_string);
	$xml = cleanxml($xml);

	$tool = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
	$tool->import($xml);
	
	try{
		$result_params = $tool->save($id);
		$result = $result_params['xml'];
		
		header('Content-type: text/xml; charset="utf-8"', true);
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<tool>
			<status>success</status>
			<description>'.$result.'</description>
			</tool>
		';
	}
	catch(Exception $e){
		header('Content-type: text/xml; charset="utf-8"', true);
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<tool>
				<status>#error</status>
				<description>#error '.print_r($e).'</description>
				</tool>';
	}	
?>