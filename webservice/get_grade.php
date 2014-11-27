<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/configuration/host.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/client/tool.php');
	
	if(isset($_GET['pla'])){
		$idTool = getParam($_GET['pla']);
	}
	if(isset($_GET['ass'])){
		$idAssessment = getParam($_GET['ass']);
	}
	
	if(!$plantilla = plantilla::fetch(array('pla_cod' => $idTool))){
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		exit;
	}
	
	$getAss = '';
	if(isset($idAssessment) && $idAssessment != ''){
		$params['ass_id'] = $idAssessment;
		$params['ass_pla'] = $plantilla->id;
		$assessment = new assessment($params);
		if($assessment = assessment::fetch($params)){
			$getAss = '&ass='.$idAssessment;
			$grade = $assessment->ass_grd; 
			$maxgrade = $assessment->ass_mxg;
			
			// Header para escribir XML----------------------------------------------------
			header('Content-type: text/xml; charset="utf-8"', true);

			//Declaración XML--------------------------------------------------------------
			echo '<?xml version="1.0" encoding="utf-8"?>
			<!DOCTYPE instrumentos SYSTEM "getgrades.dtd">';
			//Elemento raíz----------------------------------------------------------------
			echo "\n\n   <grade>\n";   
			echo "\t".'<finalAssessment>' . $grade . '</finalAssessment>';
			echo "\t".'<maxgrade>' . $maxgrade . '</maxgrade>';
			echo "\n\t".'</grade>'."\n";
		}
		else{
			echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
		}
	}
	else{
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
	}
?>