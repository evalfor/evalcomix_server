<?php
	ini_set('display_errors', 'On');
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/configuration/host.php');
	include_once(DIRROOT . '/lib/weblib.php');	
	include_once(DIRROOT . '/classes/plantilla.php');

	if(isset($_GET['tool'])){
		$toolid = getParam($_GET['tool']);
	}
	
	if(!isset($toolid)) {
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}

	
//Obtención de los datos a listar----------------------------------------------	
	if($plantilla = plantilla::fetch(array('pla_cod' => $toolid))){
		// Header para escribir XML----------------------------------------------------
		header('Content-type: text/xml; charset="utf-8"', true);

		//Declaración XML--------------------------------------------------------------
		echo '<?xml version="1.0" encoding="utf-8"?>
		<!DOCTYPE instrumentos SYSTEM "list_tools_course.dtd">';
		//Elemento raíz----------------------------------------------------------------
		echo "\n\n   <tools>\n";

		$com = '0';
		echo '<tool>
			<id>' . $plantilla->pla_cod . '</id>
			<name>' . htmlspecialchars($plantilla->pla_tit, ENT_QUOTES, 'UTF-8') . '</name>
			<type>' . $plantilla->pla_tip . '</type>
			<shared>'. $com . '</shared>';
			echo '</tool>';
		
		echo '</tools>';
	}
	else{
		echo '<evalcomix><status>error</status><id>#10</id><description>Tool has not found</description></evalcomix>';
		exit;
	}
	
?>
