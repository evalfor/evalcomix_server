<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/classes/cleanxml.php');
	include_once(DIRROOT . '/lib/weblib.php');

	if ( !isset( $HTTP_RAW_POST_DATA ) ) {
		$HTTP_RAW_POST_DATA = file_get_contents( 'php://input' ); 
	}
	if ( !isset( $HTTP_RAW_POST_DATA ) ) {
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}


	$xml_string = $HTTP_RAW_POST_DATA;
	$xml = simplexml_load_string($xml_string);
	$xml = cleanxml($xml);

	if(isset($xml->toolid[0])){
		foreach($xml->toolid as $toolid){ 
			if(isset($toolid['id'])){
				$id = (string)$toolid['id'];
				$value = (string)$toolid;
				if($plantilla = plantilla::fetch(array('pla_cod' => $id))){
					$pla_mod = '0';
					if($value == 'true'){
						$pla_mod = '1';
					}
					if($plantilla->pla_mod != $pla_mod){
						$plantilla->pla_mod = $pla_mod;
						$plantilla->update();
					}
				}
			}
			else{
				echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
				exit;
			}
		}
	}
	else{
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;
	}

	echo '<evalcomix><status>success</status><description>Tool modified successfully</description></evalcomix>';
?>