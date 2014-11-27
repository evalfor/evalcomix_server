<?php
	

//Obtención de los datos a listar----------------------------------------------
	
   function finalgrade($assessmentid, $toolid)
   {
	include_once("../classes/grade.php");
	include_once("../lib/weblib.php");
	include_once("../configuration/host.php");

	$grade = new grade($assessmentid, $toolid);
	$finalAssessment = $grade->get_grade(); 
	$maxgrade = $grade->max_grade();

	$finalgrade = $finalAssessment . ' / ' . $maxgrade;
	return $finalgrade;
   }
?>
