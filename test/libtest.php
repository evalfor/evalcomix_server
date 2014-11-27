<?php

function get_tools_dir($dir){
	include_once('../client/post_xml.php');
	$list_tools = array();
	$list_grade_tools = array();
	$directorio=opendir('tools'); 
	$i = 0;
	while ($archivo = readdir($directorio)){
		if($archivo != '.' && $archivo != '..' && $archivo != '.svn'){
			$xml_object = simplexml_load_file('tools/' . $archivo);
			$id = md5(uniqid());
			$xml = $xml_object->asXML();
			$type_tool = dom_import_simplexml($xml_object)->tagName;
			$type = '';
			switch($type_tool){
				case 'mt:MixTool':
					$type = 'mixto';
					break;
				case 'cl:ControlList':
					$type = 'lista';
					break;
				case 'es:EvaluationSet':
					$type = 'escala';
					break;
				case 'ru:Rubric':
					$type = 'rubrica';
					break;
				case 'ce:ControlListEvaluationSet':
					$type = 'lista+escala';
					break;
				case 'sd:SemanticDifferential':
					$type = 'diferencial';
					break;
				case 'ar:ArgumentSet':
					$type = 'argumentario';
					break;
			}
			
			$url = 'http://lince.uca.es/evalfor/evalcomix41/webservice/import_tool.php?id='.$id;
			$response = xml_post($xml, $url, 80);
			$xml2 = simplexml_load_string($response);
			if($xml2->id && (string)$xml2->id != '#error'){
				echo "El fichero '$archivo' ha sido importado con éxito <br>";
			}
			else{
				echo "Error al procesar el fichero '$archivo'<br>";
			}
			
			$tool = new stdClass();
			$tool->id = $id;
			$tool->code = $i;
			$tool->type = $type;
			$tool->plantilla = $xml_object;
			$list_tools[$i] = $tool;
			++$i;
		}
	}
	closedir($directorio); 
	return $list_tools;
}

function get_grade_tools($list_tools){
	$list_grade_tools = array();
	foreach($list_tools as $tool){
		$grade_tool = new stdClass();
		$id = $tool->id;
		$grade_tool->id = $id;
		if(isset($tool->plantilla->GlobalAssessment->Values->Value[0])){
			$grade_tool->num_scale_vg = (string)$tool->plantilla->GlobalAssessment['values'];
			$grado = 0;
			foreach ($tool->plantilla->GlobalAssessment[0]->Values[0] as $value){
				$grade_tool->scale_vg[$grado] = (string)$value;
				$grado++;
			}
		}
		if($tool->type != 'rubrica' && $tool->type != 'diferencial' && $tool->type != 'lista+escala'){
			$dim = 0;
			foreach($tool->plantilla->Dimension as $dimen){
				if(isset($dimen->DimensionAssessment[0]->Attribute)){
					$grade_tool->vgd[$dim] = 'true';
					if((string)$dimen->DimensionAssessment[0]->Attribute['comment'] == '1'){
						$grade_tool->commentDim[$dim] = 'true';
					}
				}
				
				$grade_tool->num_scale_dim[$dim] = (int)$dimen['values'];
				if(isset($dimen->Values[0])){
					$grado = 0;
					foreach($dimen->Values[0] as $values){
						$grade_tool->scale_dim[$dim][$grado] = (string)$values;							
						$grado++;
					}
				}
					
				$subdim = 0;
				foreach($dimen->Subdimension as $subdimen){				
					//DATOS DE LOS ATRIBUTOS				
					$atrib = 0;
					$grade_tool->num_atr[$dim][$subdim] = (string)$subdimen['attributes'];
					foreach($subdimen->Attribute as $attribute){
						if((string)$attribute['comment'] == '1'){
							$grade_tool->comment_atr[$dim][$subdim][$atrib] = 'true';
						}
						
						$atrib++;
					}
					$subdim++;
				}		
				$dim++;
				
			}
		}
		$grade_tool->comment = "comentario tool: $id";
		$list_grade_tools[$id] = $grade_tool;
	}
	return $list_grade_tools;
}

function get_post_datas($list_grade_tools){
	//echo "Nueva colección de datos POST: <BR>";
	$result = array();
	foreach($list_grade_tools as $item){
		$name = array();
		$observation_atr = array();
		$observation_dim = array();
		$maxvaluedim = array();
		$observation = '';
		$name_dim = array();
		foreach($item->num_atr as $dim => $value1){
			foreach($value1 as $subdim => $value2){
				for($i = 0; $i < $value2; $i++){
					$name[$dim][$subdim][$i] = 'radio'.$dim.$subdim.$i;
					if(isset($item->comment_atr[$dim][$subdim][$i])){
						$observation_atr[$i] = 'observaciones'.$dim.'_'.$subdim.'_'.$i;
						//$observation_atr[$i] = "Comentarios del atributo $i - subdim: $subdim - dim: $dim";
					}
				}
			}
			if(isset($item->vgd[$dim])){ 
				$name_dim[$dim] = 'radio'.$dim;
				if(isset($item->commentDim[$dim])){
					$observation_dim[$dim] = "observaciones$dim";
				}
			}
			$maxvaluedim[$dim] = $item->num_scale_dim[$dim];
			$minvaluedim[$dim] = 1;
		}
		$observation = "Comentario generales del instrumento";

		$id = $item->id;		
		//CASOS DE PRUEBA
		//-------------------------------------------
		//1 . Todo marcado al máximo con comentarios
		//-------------------------------------------
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['valueAttribute'] = $maxvaluedim;
		$params['comAttribute'] = "comentarios del atributo";;
		$params['valueDim'] = $maxvaluedim;
		$params['name_dim'] = $name_dim;
		$params['comDim'] = 'Comentarios de la vg de la dimension';
		if(isset($item->num_scale_vg)){
			$grado = $item->num_scale_vg - 1;
			$params['total'] = $item->scale_vg[$grado];
		}
		$params['comTotal'] = 'Todo marcado al máximo con comentarios';

		$i = 0;
		$result[$id][$i] = get_variables($params);
		
		//-------------------------------------------
		//2 . Todo marcado al mínimo con comentarios
		//-------------------------------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['valueAttribute'] = $minvaluedim;
		$params['comAttribute'] = "comentarios del atributo";
		$params['valueDim'] = $minvaluedim;
		$params['comDim'] = 'Comentarios de la vg de la dimension';
		$params['name_dim'] = $name_dim;
		if(isset($item->num_scale_vg)){
			$grado = 0;
			$params['total'] = $item->scale_vg[$grado];
		}
		$params['comTotal'] = 'Todo marcado al mínimo con comentarios';
		$i = 1;
		$result[$id][$i] = get_variables($params);
		
		
		//-------------------------------------------
		//3 . Uno marcado al mínimo y todo vacío
		//-------------------------------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['valueAttribute'] = $minvaluedim;
		$params['flag'] = 1;
		$params['name_dim'] = $name_dim;
		$i = 2;
		$result[$id][$i] = get_variables($params);
		
		
		//-------------------------------------------
		//4 . Todo marcado al máximo sin comentarios
		//-------------------------------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['valueAttribute'] = $maxvaluedim;
		$params['valueDim'] = $maxvaluedim;
		$params['name_dim'] = $name_dim;
		if(isset($item->num_scale_vg)){
			$grado = $item->num_scale_vg - 1;
			$params['total'] = $item->scale_vg[$grado];
		}
		$i = 3;
		$result[$id][$i] = get_variables($params);

		
		//-------------------------------------------
		//5 . Todo marcado al mínimo sin comentarios
		//-------------------------------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['valueAttribute'] = $minvaluedim;
		$params['valueDim'] = $minvaluedim;
		$params['name_dim'] = $name_dim;
		if(isset($item->num_scale_vg)){
			$grado = 0;
			$params['total'] = $item->scale_vg[$grado];
		}
		$i = 4;
		$result[$id][$i] = get_variables($params);
		
		
		//--------------------------------------------------------------
		//6 . Solo valoraciones globales de dimensiones con comentarios
		//--------------------------------------------------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['valueDim'] = $maxvaluedim;
		$params['comDim'] = 'Comentarios de la vg de la dimension';
		$params['random'] = 1;
		$params['comTotal'] = 'Solo valoraciones globales de dimensiones con comentarios';
		$params['name_dim'] = $name_dim;
		$i = 5;
		$result[$id][$i] = get_variables($params);
		
		//-----------------------------------------
		//7 . Solo valoración total con comentario
		//-----------------------------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['name_dim'] = $name_dim;
		if(isset($item->num_scale_vg)){
			$grado = mt_rand(0,($item->num_scale_vg - 1));
			$params['total'] = $item->scale_vg[$grado];
		}
		$params['comTotal'] = 'Solo valoración total con comentario';
		$i = 6;
		$result[$id][$i] = get_variables($params);
		
		
		//---------------------------------------------------------
		//8 . Solo valoraciones globales y totales con comentarios
		//---------------------------------------------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['valueDim'] = $maxvaluedim;
		$params['comDim'] = 'Comentarios de la vg de la dimension';
		$params['random'] = 1;
		$params['name_dim'] = $name_dim;
		if(isset($item->num_scale_vg)){
			$grado = mt_rand(0,($item->num_scale_vg - 1));
			$params['total'] = $item->scale_vg[$grado];
		}
		$params['comTotal'] = 'Solo valoraciones globales y totales con comentarios';
		$i = 7;
		$result[$id][$i] = get_variables($params);
		
		//---------------------
		//9 . Solo comentarios
		//---------------------
		$params = array();
		$params['name'] = $name;
		$params['observation_atr'] = $observation_atr;
		$params['observation_dim'] = $observation_dim;
		$params['id'] = $id;
		$params['comAttribute'] = "comentarios del atributo";;
		$params['comDim'] = 'Comentarios de la vg de la dimension';
		$params['comTotal'] = 'Solo comentarios';
		$params['name_dim'] = $name_dim;
		$i = 8;
		$result[$id][$i] = get_variables($params);

	}
//	echo "Fin POST <br><br><br>";
	return $result;
}

function get_variables($params){
	$result = array();
	$result['id'] = $params['id'];
	$name = $params['name'];
	$observation_atr = $params['observation_atr'];
	$observation_dim = $params['observation_dim'];
	$flag = 0;
	if(isset($params['flag'])){
		$flag = 1;
	}
	
	foreach($name as $dim => $value){
		foreach($value as $subdim => $value2){
			foreach($value2 as $key => $namevar){
				if($flag == 1){
					$result[$namevar] = $params['valueAttribute'][$dim];
					$flag = 2;
				}
				elseif($flag == 2){
					$result[$namevar] = null;
				}
				elseif($flag == 0){
					if(isset($params['valueAttribute'][$dim])){
						$result[$namevar] = $params['valueAttribute'][$dim];
					}
				}
				if(isset($observation_atr[$key])){
					$obs_atr = $observation_atr[$key];
					if(isset($params['comAttribute'])){
						$result[$obs_atr] = $params['comAttribute'];
					}
					else{
						$result[$obs_atr] = null;
					}
				}
			}
		}
		
		if(isset($params['valueDim'][$dim])){
			if(isset($params['valueDim'][$dim])){
				if(isset($params['name_dim'][$dim])){
					$name_dim = $params['name_dim'][$dim];
	
					if(isset($params['random'])){
						$valuedim = mt_rand(1, $params['valueDim'][$dim]);
						$result[$name_dim] = $valuedim;
					}
					else{
						$result[$name_dim] = $params['valueDim'][$dim];
					}
				}
			}
			else{
				$result[$name_dim] = null;
			}
			if(isset($observation_dim[$dim])){
				$var = $observation_dim[$dim];
				if(isset($params['comDim'])){
					$result[$var] = $params['comDim'];
				}
				else{
					$result[$var] = null;
				}
			}
		}
	}
	if(isset($params['total'])){
		$result['total'] = $params['total'];	
	}
	if(isset($params['comTotal'])){
		$result['observaciones'] = $params['comTotal'];
	}
	else{
		$result['observaciones'] = null;
	}
	
	return $result;
}
?>