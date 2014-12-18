<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/configuration/host.php');
	include_once(DIRROOT . '/configuration/languages.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/classes/assessment.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/classes/mixtopla.php');
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
	
	if(empty($idTool)|| empty($idAssessment)){
		echo '<evalcomix><status>error</status><id>#4</id><description>Missing Parameters</description></evalcomix>';
		exit;
	}
	
	if(!$plantilla = plantilla::fetch(array('pla_cod' => $idTool))){
		echo '<evalcomix><status>error</status><id>#4</id><description>Parameters Wrong</description></evalcomix>';
		exit;
	}
	$getAss = '';
	if(isset($idAssessment)){
		/*if($assessments = assessment::fetch_all(array('ass_id' => $idAssessment))){
			$countassessment = count($assessments);
			if($countassessment > 1){
				foreach($assessments as $item){
					if($item->ass_pla != $plantilla->id){
						$item->delete();
					}
				}
			}
			elseif($countassessment == 1 && $assessments[0]->ass_pla == $plantilla->id){
				$getAss = '&ass='.$idAssessment;
			}
		}*/
		
		/*if($assessment = assessment::fetch(array('ass_id' => $idAssessment, 'ass_pla' => $plantilla->id))){
			$getAss = '&ass='.$idAssessment;
		}*/
		if($assessment = assessment::fetch(array('ass_id' => $idAssessment))){
			if($assessment->ass_pla != $plantilla->id){
				assessment::set_properties($assessment, array('ass_pla' => $plantilla->id));
				$assessment->update();
			}
			$getAss = '&ass='.$idAssessment;
		}
	}
	
	
	$url = HOST.'webservice/get_tool.php?tool='.$idTool.'&format=xml'.$getAss;//echo $url;
	
	include_once('../classes/curl.class.php');
	$curl = new Curl();
	$response = $curl->get($url);

	if ($response && $curl->getHttpCode()>=200 && $curl->getHttpCode()<400){
		$xml = simplexml_load_string($response);
		
	//$xml = simplexml_load_file($url);

		$tool = new tool($language,'','','','','','','','','','','','','','','','','','','','');
		$tool->import($xml);
	
		if($getAss == ''){
			$params['ass_id'] = $idAssessment;
			$params['ass_pla'] = $plantilla->id;
			$assessment = new assessment($params);
			$assessment->insert();
		}
		$grade = '';
		if(isset($_GET['grade'])){
			$grade = getParam($_GET['grade']);
		}
		else{
			$grade = $assessment->ass_grd . '/' . $assessment->ass_mxg;
		}
		$saved = '';
		if(isset($_GET['saved'])){
			$saved = getParam($_GET['saved']);
		}
		
		if($plantillas = mixtopla::fetch_all(array('mip_mix' => $plantilla->id))){
			$idAss = $assessment->id;
			foreach($plantillas as $item){	
				$object_plantilla = plantilla::fetch(array('id' => $item->mip_pla));
				$pla_cod = $object_plantilla->pla_cod;
				$url = HOST.'webservice/get_tool.php?tool='. $pla_cod .'&format=xml';
				//$xml = simplexml_load_file($url);
				
				$response = $curl->get($url);
				if ($response && $curl->getHttpCode()>=200 && $curl->getHttpCode()<400){
					$xml = simplexml_load_string($response);
				
					$toolaux = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
					$toolaux->import($xml);
					$id = $object_plantilla->id;
					$tools[$id] = $toolaux;
				}
			}
			include_once('../lib/finalgrade.php');
			$finalgrade = finalgrade($idAss, $plantilla->id);
			$gradexp = explode('/', $finalgrade);
			$params['ass_grd'] = $gradexp[0];
			$params['ass_mxg'] = $gradexp[1];
			//$params['ass_com'] = '';
			assessment::set_properties($assessment, $params);
			$assessment->update();
			
			$tool->assessment_tool_mixed(HOST, $idAss, $plantilla->id, $finalgrade, $saved, $tools, $title);
		}
		else{
			$tool->assessment_tool(HOST, $assessment->id, $plantilla->id, $grade, $saved, $title);
		}
	}
	else{
		die('There is a problem. Tool is not enabled in this moment');
	}
?>