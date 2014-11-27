<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/lib/weblib.php');
	
	if(isset($_GET['ass'])){
		$idAssessment = getParam($_GET['ass']);
	}
	
	//Checking parameters
	if(!isset($idAssessment)){
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	
	if($assessment = assessment::fetch(array('ass_id' => $idAssessment))){
		$assessment->delete();
		echo '<evalcomix><status>success</status><description>Assessment deleted successfully</description></evalcomix>';
	}
	else{
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
	}	
?>