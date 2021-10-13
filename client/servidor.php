<?php
	require_once('../configuration/conf.php');
	require_once('controller.php');
	require_once('lang/' . $tool->language . '/evalcomix.php');
	
	$postCleaned = getParam($_POST);
	
	//opción imprimir
	$print = null;
	if(isset($_GET['op'])){
		$print = getParam($_GET['op']);
	}
	if(isset($print)){
		$id = null;
		if(isset($postCleaned['id'])) {
			$id = $postCleaned['id'];
		}
	
		$tool->display_header();
		$tool->view_tool('..');
		$tool->display_footer();
		
	}
//Tras seleccionar el fichero de importación...........
	elseif(isset($_FILES['Filetype']['name'])){
		$tool->display_header();
		$namefile = 'Filetype';
		$extension = explode(".",$_FILES[$namefile]['name']);
		$num = count($extension)-1;
		if(!$_FILES[$namefile]['name'] || ($extension[$num] != "evx")){
			print '<br style="color:#f00">' . $string['ErrorFormato'] . '<br>
			<input type="button" style="width:5em" value="Volver" name="vover" onclick=\'javascript:history.back(-1)\'>';
			exit;
		}

		$xml_string = file_get_contents($_FILES[$namefile]['tmp_name']);
		if(!($xml = simplexml_load_string($xml_string))){
			echo $string['ErrorAcceso'];
			exit;
		}		
		$tool->import($xml);
		$tool->display_body('');
		$tool->display_footer();
	}
//Si estamos trabajando con instrumentos miembro de una mixta
	elseif(isset($_POST['mix']) && $_POST['mix'] != ''){
		$id = $postCleaned['mix'];
		$instrument = $tool->get_tool($id);

		if(isset($postCleaned['addDim']) || isset($postCleaned['addtool'.$id])){
			$instrument->display_body($postCleaned, $id);
		}
		elseif(isset($postCleaned['addSubDim'])){
			$dim = $postCleaned['addSubDim'];
			$id = $postCleaned['id'];
			$instrument->display_dimension($dim, $postCleaned, null, $id);
		}
		elseif(isset($postCleaned['addAtr'])){
			$valor = explode('_', $postCleaned['addAtr']);
			$dim = $valor[0];
			$subdim = $valor[1];
			$id = $postCleaned['id'];
			$instrument->display_subdimension($dim, $subdim, $postCleaned, null, $id);
		}
		if(isset($postCleaned['moveDim']) || isset($postCleaned['moveTool'])){
			$instrument->display_body($postCleaned, $id);
		}
		elseif(isset($postCleaned['moveSub'])){
			$dim = $postCleaned['moveSub'];
			$id = $postCleaned['id'];
			$instrument->display_dimension($dim, $postCleaned, null, $id);
		}
		elseif(isset($postCleaned['moveAtr'])){
			$valor = explode('_', $postCleaned['moveAtr']);
			$dim = $valor[0];
			$subdim = $valor[1];
			$id = $postCleaned['id'];
			$instrument->display_subdimension($dim, $subdim, $postCleaned, null, $id);
		}
	}
//Si estamos trabajando con instrumentos completos (mixtos o simples)
	else{
		if(isset($postCleaned['id'])){
			$id = $postCleaned['id'];
		}
		if(isset($postCleaned['save']) && (isset($postCleaned['addtool'.$id]) || isset($postCleaned['addDim']) || isset($postCleaned['addtool']))){
			$tool->display_header($postCleaned);
			$tool->display_body($postCleaned);
			$id = $_SESSION['id'];
			if(isset($id))
				$get = '&id='.$id;

			$componentid = '';
			if(isset($postCleaned['id'])){
				$componentid = $postCleaned['id'];
			}
			
			$error = false;
			if(!isset($postCleaned['titulo'.$componentid]) or trim($postCleaned['titulo'.$componentid]) == ''){
				echo "<script type='text/javascript'>alert('". $string['ErrorSaveTitle'] ."');</script>";
				echo "<script type='text/javascript'>location.href = 'generator.php';</script>";$tool->display_footer();				
				$error = true;
			}
			if(isset($postCleaned['seltool'])){
				$numtool = $tool->get_numtool();
				if($numtool == 0){
					echo "<script type='text/javascript'>alert('". $string['ErrorSaveTools'] ."');</script>";
					echo "<script type='text/javascript'>location.href = 'generator.php';</script>";$tool->display_footer();				
					$error = true;
				}
			}
			
			if($error == false){
				$xmlstring = $tool->export();
				$xml = simplexml_load_string($xmlstring);
				$tool_aux = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
				$tool_aux->import($xml);
				try{
					$resultparams = $tool_aux->save($id);

					if($tool->type == 'mixta'){
						$tool_aux_plantillasId = $tool_aux->get_plantillasId();
						$tool_plantillas = $tool->get_tools();
						$tool_aux_plantillas = $tool_aux->get_tools();
						$plantillasId = array();
						
						if(isset($tool_aux_plantillasId)){
							foreach($tool_plantillas as $id => $plantilla){
								if(list($key1, $data1) = each($tool_aux_plantillasId)){
									$plantillasId[$id] = $data1;
								}
								
								if(list($key2, $plantilla_aux2) = each($tool_aux_plantillas)){
									response_tool($plantilla, $plantilla_aux2);
								}
							}
						}
						$tool->set_plantillasId($plantillasId, '');
					}
					else{
						response_tool($tool, $tool_aux);
					}
					echo "<script type='text/javascript'>location.href = 'generator.php?save=1';</script>";$tool->display_footer();		
				}
				catch(Exception $e){
					print_r($e);
					echo "<script type='text/javascript'>alert('There is a problem. Tool is not saved');</script>";
				}
			}
			
			$tool->display_footer();
			
		}
		elseif(isset($postCleaned['addtool'.$id]) || isset($postCleaned['addtool']) || isset($postCleaned['moveTool'])){
			$tool->display_header($postCleaned);
			$tool->display_body($postCleaned);
			$tool->display_footer();
		}
		elseif(isset($postCleaned['addDim'])){
			$tool->display_body($postCleaned);
		}
		elseif(isset($postCleaned['addSubDim'])){
			$dim = $postCleaned['addSubDim'];
			$id = $postCleaned['id'];
			$tool->display_dimension($dim, $postCleaned, $id);
		}
		elseif(isset($postCleaned['addAtr'])){
			$valor = explode('_', $postCleaned['addAtr']);
			$dim = $valor[0];
			$subdim = $valor[1];
			$id = $postCleaned['id'];
			$tool->display_subdimension($dim, $subdim, $postCleaned, $id);
		}
		elseif(isset($postCleaned['moveAtr'])){
			$valor = explode('_', $postCleaned['moveAtr']);
			$dim = $valor[0];
			$subdim = $valor[1];
			$id = $postCleaned['id'];
			$tool->display_subdimension($dim, $subdim, $postCleaned, $id);
		}
		elseif(isset($postCleaned['moveSub'])){
			$dim = $postCleaned['moveSub'];
			$id = $postCleaned['id'];
			$tool->display_dimension($dim, $postCleaned, $id);
		}
		elseif(isset($postCleaned['moveDim'])){
			$tool->display_body($postCleaned);
		}
		
	}
	//Si se ha hecho clic en el botón "Guardar"------
	$toolObj = serialize($tool);
	$_SESSION['tool'] = $toolObj;
	$_SESSION['secuencia'] = $secuencia;
	
	
	
	function response_tool($tool, $tool_aux){
		$type = '';
		if(!isset($tool->type)){
			$classtype = get_class($tool);
			switch($classtype){
				case 'toollist': $type = 'lista';break;
				case 'toolscale': $type = 'escala';break;
				case 'toollistscale': $type = 'listaescala';break;
				case 'toolrubric': $type = 'rubrica';break;
				case 'tooldifferential': $type = 'diferencial';break;
				case 'toolargument': $type = 'argumentario';break;
			}
		}
		else{
			$type = $tool->type;
		}
		
		$tool_aux_dimensionsId = $tool_aux->get_dimensionsId();
		$tool_aux_subdimensionsId = $tool_aux->get_subdimensionsId();
		$tool_aux_atributosId = $tool_aux->get_atributosId();
		$tool_aux_valoresId = $tool_aux->get_valoresId();
		$tool_aux_valorestotalesId = $tool_aux->get_valorestotalesId();
		$tool_aux_valoreslistaId = array();
		$tool_aux_rangoId = array();
		$tool_aux_descriptionsId = array();
		$tool_aux_atributosposId = array();
							
		switch($type){
			case 'rubrica':{
				$tool_aux_rangoId = $tool_aux->get_rangoId();
				$tool_aux_descriptionsId = $tool_aux->get_descriptionsId();
				}break;
			case 'listaescala':{
				$tool_aux_valoreslistaId = $tool_aux->get_valoreslistaId();
			}break;
			case 'diferencial':{
				$tool_aux_atributosposId = $tool_aux->get_atributosposId();
			}
		}
		
		$tool_dimensions = $tool->get_dimension('');
		$tool_subdimensions = $tool->get_subdimension('');
		$tool_atributos = $tool->get_atributo('');
		$tool_valores = $tool->get_valores('');
		$tool_valorestotales = $tool->get_valorestotal('');
		$tool_rango = array();
		$tool_description = array();
		$tool_valoreslista_id = array();
		$tool_valoreslista = array();
		$tool_atributospos = array();
		switch($type){
			case 'rubrica':{
				$tool_rango = $tool->get_rango('');
				$tool_description = $tool->get_description('');
			}break;
			case 'listaescala':{
				$tool_valoreslista = $tool->get_valoreslista();
			}break;
			case 'diferencial':{
				$tool_atributospos = $tool->get_atributopos('');
			}
		}
		
		$dimensionsId = array();
		$subdimensionsId = array();
		$atributosId = array();
		$valoreslistaId = array();
		$valoresId = array();
		$rangoId = array();
		$descriptionsId = array();
		$atributosposId = array();
		if(isset($tool_aux_dimensionsId) && isset($tool_aux_subdimensionsId) && isset($tool_aux_atributosId)){
			foreach($tool_dimensions as $dim => $value_dimensions){
				if(list($key2, $data2) = each($tool_aux_dimensionsId)){
					$dimensionsId[$dim] = $data2;
				}
				
				if(isset($tool_valores[$dim])){
					foreach($tool_valores[$dim] as $grado => $values){
						if(isset($tool_aux_valoresId[$key2]) && list($keyv, $datav) = each($tool_aux_valoresId[$key2])){
							$valoresId[$dim][$grado] = $datav;
						}
						if($type == 'rubrica'){
							foreach($tool_rango[$dim][$grado] as $rgrado => $rango){
								if(list($keyr, $datar) = each($tool_aux_rangoId[$key2][$keyv])){
									$rangoId[$dim][$grado][$rgrado] = $datar;
								}
							}
						}
					}
				}
						
				if($type == 'listaescala'){
					foreach($tool_valoreslista[$dim] as $grado => $values){
						if(list($keyvl, $datavl) = each($tool_aux_valoreslistaId[$key2])){
							$valoreslistaId[$dim][$grado] = $datavl;
						}
					}
				}
								
				foreach($tool_subdimensions[$dim] as $subdim => $value_subdimensions){
					if(list($key3, $data3) = each($tool_aux_subdimensionsId[$key2])){
						$subdimensionsId[$dim][$subdim] = $data3;
					}
					foreach($tool_atributos[$dim][$subdim] as $atrib => $value_attributes){
						if(list($key4, $data4) = each($tool_aux_atributosId[$key2][$key3])){
							$atributosId[$dim][$subdim][$atrib] = $data4;											
						}
											
						if($type == 'rubrica'){
							foreach($tool_description[$dim][$subdim][$atrib] as $gradod => $value_description){
								if(list($key5, $data5) = each($tool_aux_descriptionsId[$key2][$key3][$key4])){
									$descriptionsId[$dim][$subdim][$atrib][$gradod] = $data5;
								}
							}
						}
					}
					if($type == 'diferencial'){
						foreach($tool_atributospos[$dim][$subdim] as $atrib => $value_attributes){
							if(list($key6, $data6) = each($tool_aux_atributosposId[$key2][$key3])){
								$atributosposId[$dim][$subdim][$atrib] = $data6;											
							}
						}
					}
				}
			}
			
			$tool->set_dimensionsId($dimensionsId, '');
			$tool->set_valoresId($valoresId, '');
			$tool->set_subdimensionsId($subdimensionsId, '');
			$tool->set_atributosId($atributosId, '');
			if($type == 'listaescala'){
				$tool->set_valoreslistaId($valoreslistaId, '');
			}
			if($type == 'rubrica'){
				$tool->set_rangoId($rangoId, '');
				$tool->set_descriptionsId($descriptionsId, '');
			}
			if($type == 'diferencial'){
				$tool->set_atributosposId($atributosposId, '');
			}
		}
		if(!empty($tool_aux_valorestotalesId)){
			foreach($tool_valorestotales as $grade => $value){
				if(list($key1, $data1) = each($tool_aux_valorestotalesId)){
					$valorestotalesId[$grade] = $data1;
				}
			}
			$tool->set_valorestotalesId($valorestotalesId, '');
		}
	}