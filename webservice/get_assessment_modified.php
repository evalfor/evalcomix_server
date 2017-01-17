<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/classes/cleanxml.php');
	include_once(DIRROOT . '/lib/weblib.php');
	
	$post_data = file_get_contents( 'php://input' );
	if ( !isset( $post_data ) ) {
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	

	$xml_string = $post_data;
	$xml = simplexml_load_string($xml_string);
	$xml = cleanxml($xml);

	$e = getParam($_GET['e']);	//$e contendrá un valor que indicará el tipo de operación: lectura o escritura (1 | 2). 
	if(isset($_GET['v'])){
		$v = getParam($_GET['v']); 	//En el caso de ser una operación de escritura $v valdrá '1' para indicar 'true' o '2' para indicar 'false'
	}
	
	//Checking parameters
	if(!isset($e)) {
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	
	if($e != '1' && $e != '2'){
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;
	}
	
	if($e == '2' && !isset($v)){
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	
	if($e == '2' && isset($v) && ($v != '1' && $v != '2')){
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;	
	}
	
	
	//Si se trata de una petición de lectura
	if($e == '1'){
		$result = '<assessments>';
		foreach($xml->toolid as $toolid){
			if($plantilla = plantilla::fetch(array('pla_cod' => (string)$toolid, 'pla_mod' => '1'))){
				if($assessments = assessment::fetch_all(array('ass_pla' => $plantilla->id))){
					foreach($assessments as $assessment){
						$result.= '<assessment id="'.$assessment->ass_id.'">
							<grade>'.$assessment->ass_grd.'</grade>
							<maxgrade>'.$assessment->ass_mxg.'</maxgrade>
							<toolid>'.$plantilla->pla_cod.'</toolid>
						</assessment>';
					}
				}
			}
		}
		$result .= '</assessments>';
		echo '<evalcomix><status>success</status><description>'.$result.'</description></evalcomix>';
	}
	elseif($e == '2' && $v == '1'){
		if($plantilla->pla_mod != '1'){
			$plantilla->pla_mod = '1';
			$plantilla->update();
		}
		echo '<evalcomix><status>success</status><description>Tool modified successfully</description></evalcomix>';
	}
	elseif($e == '2' && $v == '2'){
		if($plantilla->pla_mod != '2'){
			$plantilla->pla_mod = '0';
			$plantilla->update();
		}
		echo '<evalcomix><status>success</status><description>Tool modified successfully</description></evalcomix>';
	}
	
?> 
