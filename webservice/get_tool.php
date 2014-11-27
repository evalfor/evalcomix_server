<?php	
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/classes/plantilla.php');

	if(isset($_GET['format'])){
		$format = getParam($_GET['format']);
	}
	if(isset($_GET['tool'])){
		$tool = getParam($_GET['tool']);
	}
	if(isset($_GET['ass'])){
		$idAssessment = getParam($_GET['ass']);
	}
	
//Definition of formats required	
	$required_formats = array('xml');
	
	
//Checking parameters
	$case = 0;
	if(!isset($tool) || !isset($format)){
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;
	}
	
	if (!in_array($format, $required_formats)){
		echo '<evalcomix><status>error</status><id>#3</id><description>Format required is wrong</description></evalcomix>';
		exit;
	}
	
	$params = array();
	$params['format'] = $format;
	
	if($plantilla = plantilla::fetch(array('pla_cod' => $tool))){
		$params['tool_id'] = $plantilla->id;
	}
	else{
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;
	}
	
	//Get id assessment
	if(isset($idAssessment)){
		$params['ass_id'] = $idAssessment;
		$params['ass_pla'] = $plantilla->id;
		if(!$assessment = assessment::fetch($params)){
			echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
			exit;
		}
		
		$params['assessment'] = $assessment;
	}

	include_once(DIRROOT . '/classes/exporter.php');
	$result = new exporter($params, $format);
	$result->export();
?>