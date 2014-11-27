<?php
	include_once('../configuration/conf.php');
	include_once('../configuration/host.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/lib/post_xml.php');
	

	if(isset($_GET['oldid'])){
		$oldid = getParam($_GET['oldid']);
	}
	if(isset($_GET['newid'])){
		$newid = getParam($_GET['newid']);
	}
	
	
//Checking parameters
	if(!isset($oldid)){
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;
	}
	if(!isset($newid) || $newid == ''){
		/*list($usec, $sec) = explode(" ", microtime());
		$res = 240912* ($sec + $sec );
		$newid = $res + (int)($usec * 10000000);*/
		$newid = md5(uniqid());
	}

	$url = HOST.'webservice/get_tool.php?tool='.$oldid.'&format=xml';
	$xml = simplexml_load_file($url);
	$xmlstring = $xml->asXML();
	
	$url = HOST . 'webservice/import_tool.php?id='. $newid;
	$port = '';
	$response = xml_post($xmlstring, $url, $port);
	$xml2 = simplexml_load_string($response);

	if(isset($xml2->status) && (string)$xml2->status == 'success' && isset($xml2->description)){
		$xml_result = current($xml2->description);
		echo '<evalcomix><status>success</status><description>'.(string)$xml_result['id'].'</description></evalcomix>';
	}
	else{
		echo '<evalcomix><status>error</status><id>#</id><description></description></evalcomix>';
		exit;
	}


?>