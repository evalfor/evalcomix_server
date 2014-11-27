<?php 
	ini_set('display_errors', 'Off');
	include_once('../session/check_session.php');
	include_once('controller.php');
	$type = '';
	if(isset($_GET['type'])){
		$type = getParam($_GET['type']);
	}
	$postCleaned = getParam($_POST);

	include_once('lang/' . $tool->language . '/evalcomix.php');
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
?>
