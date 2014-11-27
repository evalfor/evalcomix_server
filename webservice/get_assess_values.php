<?php

include_once('../configuration/conf.php');
include_once(DIRROOT . '/lib/weblib.php');
include_once(DIRROOT . '/classes/plantilla.php');
include_once(DIRROOT . '/classes/assessment.php');

// Get params
if(isset($_GET['format'])){
	$format = getParam($_GET['format']);
}
if(isset($_GET['tool'])){
	$tool = getParam($_GET['tool']);
}
if(isset($_GET['ass'])){
	$ass = getParam($_GET['ass']);
}

//Definition of formats required
$required_formats = array('xml');

//Checking parameters
if(!isset($tool) || !isset($format) || !isset($ass)){
	echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
	exit;
}

if (!in_array($format, $required_formats)){
	echo '<evalcomix><status>error</status><id>#3</id><description>Format required is wrong</description></evalcomix>';
	exit;
}

$params = array();
//$params['format'] = $format;

// Get id tool
if($plantilla = plantilla::fetch(array('pla_cod' => $tool))){
	$params['toolid'] = $plantilla->id;
}
else{
	echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
	exit;
}

// Get id assessment
if(!$assessment = assessment::fetch(array('ass_id' => $ass))){

	// Check if the max grade is received
	if(isset($_GET['maxgrade']) && $_GET['maxgrade'] != ''){
		$ass_mxg = $_GET['maxgrade'];
	}
	else{
		$ass_mxg = 100;
	}

	// Create the row
	$ass_params = array('id'=>'',
			'ass_id'=>$ass,
			'ass_pla'=>$plantilla->id,
			'ass_com'=>'',
			//'ass_grd'=>null,
			'ass_mxg'=>$ass_mxg);

	$assessment = new assessment($ass_params);
	$assessment->insert();
}

$params['assid'] = $assessment->id;

// Create XML to return it
header('Content-type: text/xml; charset="utf-8"', true);
echo '<?xml version="1.0" encoding="utf-8"?>
	  <assess_values>
		<assid>'.$params['assid'].'</assid>
		<toolid>'.$params['toolid'].'</toolid>
	  </assess_values>';

?>