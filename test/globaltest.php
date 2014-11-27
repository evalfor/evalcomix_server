<?php
//TODO: Pruebas Gestión de instrumentos
	//TODO import tool
	//TODO delete tool
	//TODO get_tool
//TODO: Pruebas Gestión de evaluaciones
	//TODO saveassess
	
include_once('libtest.php');
include_once('../client/post_xml.php');
include_once('../classes/assessment.php');
include_once('../classes/plantilla.php');

$list_tools = get_tools_dir('tools');

$list_grade_tools = get_grade_tools($list_tools);

$post_datas = get_post_datas($list_grade_tools);


foreach($post_datas as $item){
	foreach($item as $id => $value){ 
		print_r($value);
		$idTool = $value['id'];
		$plantilla = plantilla::fetch(array('pla_cod' => $idTool));
		$idAssessment = md5(uniqid());
		$params['ass_id'] = $idAssessment;
		$params['ass_pla'] = $plantilla->id;
		$assessment = new assessment($params);
		$idAss = $assessment->insert();
		
		foreach($value as $key => $value2){
			$string_post = '';
			$string_post .= $key . '=' . $value2 . '&';
		}
		$url = 'http://lince.uca.es/evalfor/evalcomix41/assessment/saveassess.php?ass=' . $idAss . '&tool='.$plantilla->id;//echo $url;
		$response = xml_post($string_post, $url, 80);
		
		if($response == 'La sesión ha expirado. Por favor, vuelva a conectarse'){
			echo "Éxito <br>";
		}
		else{
			echo "Error: ";
			print_r($response);
		}
	}
}

?>