<?php
	include_once('../../../configuration/conf.php');
	include_once(DIRROOT . '/configuration/host.php');
	include_once(DIRROOT . '/configuration/accesobd.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/client/tool.php');
	
	include_once(DIRROOT . '/session/check_session.php');
	
	if(isset($_GET['pla'])){
		$idTool = getParam($_GET['pla']);
	}	
	
	$url = HOST.'assessment/webservice/services/get_tool.php?tool='.$idTool.'&format=xml';
	//$xml = simplexml_load_file($url);
	include_once('../classes/curl.class.php');
	$curl = new Curl();
	$response = $curl->get($url);

	if ($response && $curl->getHttpCode()>=200 && $curl->getHttpCode()<400){
		$xml = simplexml_load_string($response);
		
		$tool = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
		$tool->import($xml);
		
		$plantilla = plantilla::fetch(array('pla_cod' => $idTool));
		if($plantilla->pla_tit == 'mixto'){		
			$tool->view_tool_mixed('../../..', $grade);
		}
		else{
			$tool->view_tool('../../..', $grade);
		}
	}
	else{
		die('There is a problem. Tool is not enabled in this moment');
	}
	
?>