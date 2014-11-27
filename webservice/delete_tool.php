<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/lib/weblib.php');

	$id = getParam($_GET['id']);

	//Checking parameters
	if(!isset($id)) {
		echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	
	try{
		if($plantilla = plantilla::fetch(array('pla_cod' => $id))){
			$plantilla->delete();
		}
		else{
			echo '<evalcomix><status>error</status><id>#4</id><description>Parameters wrong</description></evalcomix>';
			exit;
		}
	}catch(Exception $e){
		echo '<evalcomix><status>error</status><id>#5</id><description>No enough privileges in database</description></evalcomix>';
		exit;
	}
	
	echo '<evalcomix><status>success</status><description>Tool deleted successfully</description></evalcomix>';
?> 
