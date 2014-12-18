<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/configuration/host.php');
	include_once(DIRROOT . '/configuration/languages.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/client/tool.php');
	
	//include_once(DIRROOT . '/session/check_session.php');
	
	if(isset($_POST['pla'])){
		$idTool = getParam($_POST['pla']);
	}
	if(isset($_POST['ass'])){
		$idAssessment = getParam($_POST['ass']);
	}
	if(isset($_POST['lang'])){
		$language = $_POST['lang'];
	}
	
	if(!isset($language) || !in_array($language, $valid_languages)){
		$language = 'es_utf8';
	}
	
	$title = '';
	if(isset($_POST['tit'])){
		$title = getParam($_POST['tit']);
	}
	
	if(empty($idTool) || empty($idAssessment)){
		echo '<evalcomix><status>error</status><id>#4</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	
	if(!$plantilla = plantilla::fetch(array('pla_cod' => $idTool))){
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters Wrong</description></evalcomix>';
		exit;
	}
	
	$getAss = '';
	$grade = '';
	if(isset($idAssessment)){
		if($assessment = assessment::fetch(array('ass_id' => $idAssessment, 'ass_pla' => $plantilla->id))){
			$getAss = '&ass='.$idAssessment;
			$grade = $assessment->ass_grd . '/' . $assessment->ass_mxg;
		}
	}
	
	
	$url = HOST.'webservice/get_tool.php?tool='.$idTool.'&format=xml'.$getAss;//echo $url;
	//$xml = simplexml_load_file($url);
	include_once('../classes/curl.class.php');
	$curl = new Curl();
	$response = $curl->get($url);
	
	if ($response && $curl->getHttpCode()>=200 && $curl->getHttpCode()<400){
		$xml = simplexml_load_string($response);
		//print_r($response);echo "holaaaaaaaaaa";
		$tool = new tool($language,'','','','','','','','','','','','','','','','','','','','');
		$tool->import($xml);
		
		$plantilla = plantilla::fetch(array('pla_cod' => $idTool));
		if($plantilla->pla_tip == 'mixto'){		
			$tool->view_tool_mixed(HOST, $grade, $title);
		}
		else{
			$tool->view_tool(HOST, $grade, 'view', $title);
		}	
	}
	else{
		die('There is a problem. Tool is not enabled in this moment');
	}
?>
