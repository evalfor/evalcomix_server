<?php
	require_once('../session/check_session.php');
	require_once('controller.php');
	$type = '';
	if(isset($_GET['type'])){
		$type = getParam($_GET['type']);
	}
	$postCleaned = getParam($_POST);

	require_once('lang/' . $tool->language . '/evalcomix.php');
	if($type == 'importar'){
		$tool->display_dialog();
	}
	else{
		$tool->display_header($postCleaned);
		$tool->display_body($postCleaned);
		$save = '';
		if(isset($_GET['save'])){
			$save = getParam($_GET['save']);
		}
		if($save == '1'){
			echo "<script>alert('" . $string['save'] . "');</script>";
		}
		$tool->display_footer();
	}
	$toolObj = serialize($tool);
	$_SESSION['tool'] = $toolObj;
	$_SESSION['secuencia'] = $secuencia;