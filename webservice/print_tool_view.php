<?php
	session_start();
	$_SESSION['idsession'] = session_id();

	$idTool = '';
	if(isset($_GET['pla'])){
		$idTool = $_GET['pla'];
	}
	
	$idAssessment = '';
	if(isset($_GET['ass'])){
		$idAssessment = $_GET['ass'];
	}
	
	header("Location: get_view_form.php?pla=$idTool&ass=$idAssessment");
	
?>