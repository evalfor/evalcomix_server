<?php
//Obtención de los datos a listar----------------------------------------------	
function finalgrade($assessmentid, $toolid) {
	require_once(DIRROOT . "/classes/grade.php");
	require_once("weblib.php");

	$grade = new grade($assessmentid, $toolid);
	$finalAssessment = $grade->get_grade(); 
	$maxgrade = $grade->max_grade();

	$finalgrade = $finalAssessment . ' / ' . $maxgrade;
	return $finalgrade;
}