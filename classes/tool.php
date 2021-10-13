<?php
require_once('toolscale.php');
require_once('toollistscale.php');
require_once('tooldifferential.php');
require_once('toollist.php');
require_once('toolrubric.php');
require_once('toolmix.php');
require_once('toolargument.php');

class tool{
	private $object;
	var $language;
	
	function __construct($params){
		switch($type){
			case 'lista':{
				$this->object = new toollist($params);
			}break;
			case 'escala':{
				$this->object = new toolscale($params);
			}break;
			case 'listaescala':{
				$this->object = new toollistscale($params);
			}break;
			case 'diferencial':{
				$this->object = new tooldifferential($params);
			}break;
			case 'rubrica':{
				$this->object = new toolrubric($params);
			}break;
			case 'mixta':{
				$this->object = new toolmix($params);
			}break;
			case 'argumentario':{
				$this->object = new toolargument($params);
			}break;
		}
		$this->language = $params['language'];
	}
	
	
	function get_numtool(){return $this->object->get_numtool();}
	function get_toolpor(){return $this->object->get_toolpor();}
	function get_tools(){return $this->object->get_tools();}
	function get_tool($id){return $this->object->get_tool($id);}
	function get_titulo($id){return $this->object->get_titulo($id);}
	function get_dimension($id){return $this->object->get_dimension($id);}
	function get_numdim($id){return $this->object->get_numdim($id);}
	function get_subdimension($id){return $this->object->get_subdimension($id);}
	function get_numsubdim($id){return $this->object->get_numsubdim($id);}
	function get_atributo($id){return $this->object->get_atributo($id);}
	function get_numatr($id){return $this->object->get_numatr($id);}
	function get_valores($id){return $this->object->get_valores($id);}
	function get_numvalores($id){return $this->object->get_numvalores($id);}
	function get_dimpor($id){return $this->object->get_dimpor($id);}
	function get_subdimpor($id){return $this->object->get_subdimpor($id);}
	function get_atribpor($id){return $this->object->get_atribpor($id);}
	function get_commentAtr($id){return $this->object->get_commentAtr($id);}
	function get_porcentage(){return $this->object->get_porcentage();}
		
	function set_titulo($titulo, $id){$this->object->set_titulo($titulo, $id);}
	function set_dimension($dimension, $id){$this->object->set_dimension($dimension, $id);}
	function set_numdim($numdim, $id){$this->object->set_numdim($numdim, $id);}
	function set_subdimension($subdimension, $id){$this->object->set_subdimension($subdimension, $id);}
	function set_numsubdim($numsubdim, $id){$this->object->set_numsubdim($numsubdim, $id);}
	function set_atributo($atributo, $id){$this->object->set_atributo($atributo, $id);}
	function set_numatr($numatr, $id){$this->object->set_numatr($numatr, $id);}
	function set_valores($valores, $id){$this->object->set_valores($valores, $id);}
	function set_numvalores($numvalores, $id){$this->object->set_numvalores($numvalores, $id);}
	function set_dimpor($dimpor, $id){$this->object->set_dimpor($dimpor, $id);}
	function set_subdimpor($subdimpor, $id){$this->object->set_subdimpor($subdimpor, $id);}
	function set_atribpor($atribpor, $id){$this->object->set_atribpor($atribpor, $id);}
	function set_toolpor($porcentage){$this->object->set_toolpor($porcentage);}
	function set_commentAtr($comment){$this->object->set_commentAtr($comment);}
	
	function import($xml){
		unset($this->object);
		$type_evx3 = dom_import_simplexml($xml)->tagName;
		$type = '';
		if($type_evx3 == 'mt:MixTool'){
			$this->object = new toolmix($this->language, (string)$xml['name'], (string)$xml->Description);
			$tools = array();
			
			$index = 1;
			if(isset($xml->Description))
				$index = 0;
				
			$i = 0;
			foreach($xml as $valor){
				if($index == 0){
					$index = 1;
					continue;
				}
				$tool = $this->importSimpleTool($valor, $i);
				$tools[$i] = $tool; 
				++$i;
			}
			$this->object->set_tools($tools);
		}
		else{
			$this->object = $this->importSimpleTool($xml);
		}
	}
	
	function importSimpleTool($xml, $id = 0){
		$language = $this->language;
		$dimension; 
		$numdim;
		$subdimension;
		$numsubdim;
		$atributo;
		$numatr;
		$valores;
		$numvalores;
		$numtotal = null;
		$valores;
		$valtotal = null;
		$valtotalpor;
		$valorestotal = null;
		$valglobal;
		$valglobalpor;
		$subdimpor;
		$atribpor;
		$numrango;
		$rango;
		$observation = null;
		$description;
		
		$tagName = dom_import_simplexml($xml)->tagName;
		$type_tool = ''; 
		if($tagName[2] == ':'){
			$type_evx3 = explode(':', $tagName);
			$type_tool = $type_evx3[1];
		}
		else{
			$type_tool = $tagName;
		}

		$type = '';
		switch($type_tool){
			case 'ControlList':
				$type = 'lista';
				break;
			case 'EvaluationSet':
				$type = 'escala';
				break;
			case 'Rubric':
				$type = 'rubrica';
				break;
			case 'ControlListEvaluationSet':
				$type = 'lista+escala';
				break;
			case 'SemanticDifferential':
				$type = 'diferencial';
				break;
			case 'ArgumentSet':
				$type = 'argumentario';
				break;
		}

		if($type == 'diferencial'){
			$titulo = (string)$xml['name'];
			$dim = 0;
			$numvalores[$id][$dim] = (string)$xml['values'];
			$numdim[$id] = 1;
			$dimension[$id][$dim]['nombre'] = "Dimension1";
			$valglobal[$id][$dim] = false;
			$valglobalpor[$id][$dim] = null;
			$dimpor[$id][$dim] = 100;
			$subdim = 0;
			$subdimension[$id][$dim][$subdim]['nombre'] = 'subdimension1';
			$numsubdim[$id][$dim] = 1;
			$subdimpor[$id][$dim][$subdim] = 100;
			$numatr[$id][$dim][$subdim] = (string)$xml['attributes'];
			$percentage = (string)$xml['percentage'];
			$valuecommentAtr = array();
			$observation[$id] = (string)$xml->Description;
			
			$j = 0;
			foreach($xml->Values[0] as $values){ 
				$valores[$id][$dim][$j]['nombre'] = (string)$values;
				++$j;
			}

			//DATOS DE LOS ATRIBUTOS
			$atrib = 0;
			foreach($xml->Attribute as $attribute){
				$atributo[$id][$dim][$subdim][$atrib]['nombre'] = (string)$attribute['nameN'];
				$atributopos[$id][$dim][$subdim][$atrib]['nombre'] = (string)$attribute['nameP'];
				$atribpor[$id][$dim][$subdim][$atrib] = (string)$attribute['percentage'];		
				$commentAtr[$id][$dim][$subdim][$atrib] = 'hidden';
				$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute;
				
				if((string)$attribute['comment'] == 1)
					$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
				
				if((string)$attribute['comment'] != 1 && (string)$attribute['comment'] != ''){
					$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
					$valuecommentAtr[$id][$dim][$subdim][$atrib] = (string)$attribute['comment'];
				}
				++$atrib;
			}//foreach($subdimension->Attribute as $attribute)
		}
		else{
			$valtotal = null;
			if(isset($xml->GlobalAssessment->Values->Value[0])){
				$valtotal[$id] = 'true';
				$valuetotalvalue[$id] = (string)$xml->GlobalAssessment->Attribute;
			}
			else{
				$valuetotalvalue[$id] = '';
			}
			$titulo = (string)$xml['name'];
			$observation[$id] = (string)$xml->Description;
			$percentage = (string)$xml['percentage'];
			$numdim[$id] = (string)$xml['dimensions']; 
			$valglobal = $valglobalpor = $commentDim = array();
			
			//Para los formularios cumplimentados
			$valueattribute = array();
			$valueglobaldim = array();
			$valuecommentAtr = array();
			$valuecommentDim = array();
			
		   //DATOS DE LA DIMENSIÓN
			$dim = 0;
			foreach ($xml->Dimension as $dimen){
				if(isset($dimen->DimensionAssessment[0]->Attribute)){
					$valglobal[$id][$dim] = 'true';
					$valglobalpor[$id][$dim] = (string)$dimen->DimensionAssessment['percentage'];
					$valueglobaldim[$id][$dim] = (string)$dimen->DimensionAssessment[0]->Attribute;
					if($type == 'rubrica'){
						$valueglobaldim[$id][$dim] = (string)$dimen->DimensionAssessment[0]->Attribute->selection->instance;
					}
					$commentDim[$id][$dim] = 'hidden';
					if((string)$dimen->DimensionAssessment[0]->Attribute['comment'] == '1'){
							$commentDim[$id][$dim] = 'visible';
					}
					if((string)$dimen->DimensionAssessment[0]->Attribute['comment'] != 1 && (string)$dimen->DimensionAssessment[0]->Attribute['comment'] != ''){
							$commentDim[$id][$dim] = 'visible';
							$valuecommentDim[$id][$dim] = (string)$dimen->DimensionAssessment[0]->Attribute['comment'];
						}
				}
				$dimension[$id][$dim]['nombre'] = (string)$dimen['name'];
				$dimpor[$id][$dim] = (string)$dimen['percentage'];
				$numsubdim[$id][$dim] = (string)$dimen['subdimensions'];
				$numvalores[$id][$dim] = (string)$dimen['values'];

				//VALORES DE LA DIMENSIÓN
				$grado = 0;
				if(isset($dimen->Values[0])){
					foreach($dimen->Values[0] as $values){
						if($type != 'rubrica'){
							$valores[$id][$dim][$grado]['nombre'] = (string)$values;							
						}
						else{
							$valores[$id][$dim][$grado]['nombre'] = (string)$values['name'];
							$numrango[$id][$dim][$grado] = (string)$values['instances'];
							$i = 0;
							foreach($values->instance as $range){
								$rango[$id][$dim][$grado][$i] = (string)$range;
								$i++;
							}
						}
						$grado++;
					}
				}
				
				//VALUES OF CHECKLIST OF CHECKLIST+RATESCALES				
				if($type == 'lista+escala'){
					$grado = 0;
					foreach($dimen->ControlListValues[0] as $values){
						$this->valoreslista[$id][$dim][$grado]['nombre'] = (string)$values;
						$grado++;
					}
				}

				//DATOS DE LA SUBDIMENSION
				$subdim = 0;
				foreach($dimen->Subdimension as $subdimen){
					$subdimension[$id][$dim][$subdim]['nombre'] = (string)$subdimen['name'];
					$subdimpor[$id][$dim][$subdim] = (string)$subdimen['percentage'];
					$numatr[$id][$dim][$subdim] = (string)$subdimen['attributes'];
					
					//DATOS DE LOS ATRIBUTOS				
					$atrib = 0;
					foreach($subdimen->Attribute as $attribute){
						$atributo[$id][$dim][$subdim][$atrib]['nombre'] = (string)$attribute['name'];
						$atribpor[$id][$dim][$subdim][$atrib] = (string)$attribute['percentage'];
						$commentAtr[$id][$dim][$subdim][$atrib] = 'hidden';
						if((string)$attribute['comment'] == 1)
							$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
						
						if((string)$attribute['comment'] != 1 && (string)$attribute['comment'] != ''){
							$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
							$valuecommentAtr[$id][$dim][$subdim][$atrib] = (string)$attribute['comment'];
						}
						
						$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute;
						if($type == 'lista+escala'){
							$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute->selection;
						}
						
						//$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute;
						if($type == 'rubrica'){
							$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute->selection->instance;
						}
						
						//DESCRIPCIONES DE LAS RÚBRICAS
						if($type == 'rubrica')
						{
							foreach($attribute->descriptions[0] as  $descrip)
							{
								$grado = (string)$descrip['value'];
								$description[$id][$dim][$subdim][$atrib][$grado] = (string)$descrip;
							}
						}//if($type == 'rubrica')
						$atrib++;
					}//foreach($subdimension->Attribute as $attribute)
					$subdim++;
				}//foreach($dimension->Subdimension as $subdimension)     
				$dim++;
			}//foreach ($xml->Dimension as $dimension)

		   //DATOS DE VALORES TOTALES
			$numtotal = $valtotalpor = $valorestotal = null;
			if(isset($xml->GlobalAssessment[0]->Values[0]->Value))
			{
				$numtotal[$id] = (string)$xml->GlobalAssessment['values'];
				$valtotalpor[$id] = (string)$xml->GlobalAssessment['percentage'];
				$grado = 0;
				foreach ($xml->GlobalAssessment[0]->Values[0] as $value){
					$valorestotal[$id][$grado]['nombre'] = (string)$value;
					$grado++;
				}
			}
		}
		$instrument;
		switch($type){
			case 'lista':{
				$instrument = new toollist($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $id, $observation, $percentage, $valueattribute, $valuecommentAtr);
			}break;
			case 'escala':{
				$instrument = new toolscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim, $id, $observation, $percentage, $valtotalpor, $valueattribute, $valueglobaldim, $valuetotalvalue, $valuecommentAtr, $valuecommentDim);
			}break;
			case 'lista+escala':{
				$instrument = new toollistscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim, $id, $observation, $percentage, $valtotalpor, $valueattribute, $valueglobaldim, $valuetotalvalue, $valuecommentAtr, $valuecommentDim);
			}break;
			case 'rubrica':{
				$instrument = new toolrubric($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim, $id, $observation, $percentage, $valtotalpor, $rango, $numrango, $description, $valueattribute, $valueglobaldim, $valuetotalvalue, $valuecommentAtr, $valuecommentDim);
			}break;
			case 'diferencial':{
				$instrument = new tooldifferential($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $id, $observation, $percentage, $atributopos, $valueattribute, $valuecommentAtr);
			}break;
			case 'argumentario':{
				$instrument = new toolargument($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $dimpor, $subdimpor, $atribpor, $commentAtr, $id, $observation, $percentage, $valuecommentAtr);
			}break;
		}
		return $instrument;
	}
	
	function display_view(){
			$id = '';
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<title>EvalCOMIX 4.0</title>
					<link href="style/copia.css" type="text/css" rel="stylesheet">
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<script type="text/javascript" src="javascript/size.js"></script>
					<script type="text/javascript" src="javascript/rollover.js"></script>					
					<script type="text/javascript" src="javascript/ajax.js"></script>
					<script type="text/javascript" src="javascript/check.js"></script>
					<script type="text/javascript" src="javascript/valida.js"></script>
					<script type="text/javascript" src="javascript/ventana-modal.js"></script>
					<script language="JavaScript" type="text/javascript">
					
						document.onkeydown = function(){
							if(window.event && window.event.keyCode == 116){
								window.event.keyCode = 505;
							}
							if(window.event && window.event.keyCode == 505){
								return false;
								// window.frame(main).location.reload(True);
							}
						}
						document.onkeydown = function(e){
							var key;
							var evento;
							if(window.event){
								if(window.event && window.event.keyCode == 116){
									window.event.keyCode = 505;
								}
								if(window.event && window.event.keyCode == 505){
									return false;
									// window.frame(main).location.reload(True);
								}								
							}
							else{
								evento = e;
								key = e.which; // Firefox
								if(evento && key == 116){
									key = 505;
								}
								if(evento && key == 505){
									return false;
									// window.frame(main).location.reload(True);
								}
							}											
						}
						function imprimir(que){
							var ventana = window.open("", "", "");
							var contenido = "<html><head><link href=\'style/copia.css\' type=\'text/css\' rel=\'stylesheet\'></head><body onload=\'window.print();window.close();\'>";
							contenido = contenido + document.getElementById(que).innerHTML + "</body></html>";
							ventana.document.open();
							ventana.document.write(contenido);
							ventana.document.close();
						}
						
						document.oncontextmenu=function(){return false;} 
					 
					</script>
					<style type="text/css">
						#mainform0{
							border: 1px solid #00f;
						}
						.dimension, .valoracionglobal, .valoraciontotal, #comentario{
							border: 2px solid #6B8F6B
;
						}
						.subdimension{
							background-color: #F1F2F1;
							margin: 0.7em 2em 0em 2em;
							overflow:visible
						}
					</style>
				</head>

				<body id="body" onload=\'javascript:window.print();location.href="generator.php"\'>
					
					<form id="mainform0" name="mainform'.$id.'" method="POST" action="generator.php">
		';	
	}
	function display_body_view($data, $mix='', $porcentage=''){
		return $this->object->display_body_view($data, $mix, $porcentage);
	}
	function display_dimension_view($dim, $data, $id=0, $mix=''){
		return $this->object->display_dimension_view($dim, $data, $id, $mix);
	}
	function display_subdimension_view($dim, $subdim, $data, $id=0, $mix=''){
		return $this->object->display_subdimension_view($dim, $data, $id, $mix);
	}
	function print_tool(){
		return $this->object->print_tool();
	}
	function view_tool($root = '', $grade = '', $print='view'){
			require('lang/'. $this->language . '/evalcomix.php');
			$wprint = '';
			if($print == 'print'){
				$wprint = 'onload="window.print()"';
			}
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>

					<head>
						<title>EVALCOMIX</title>
						<link href="'.$root.'/client/style/platform.css" type="text/css" rel="stylesheet">
						<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
					</head>

					<body '. $wprint .'>
						<div class="clear"></div>
						<div class="eval">						
							<form name="mainform" method="post" action="">
			';
			
			
			$this->object->print_tool();
			
			echo '
						</form>
							
					</div>
			';
			
			$tool = '';
			if(isset($_GET['pla'])){
				$tool = $_GET['pla'];
			}
			
			echo '
				<div class="clear"></div>
					<hr><br>
			';
			
			if($grade != ''){
				echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": " . $grade . "</span></div>";
			}
			
			echo '		
					<br><hr>
					<div class="botones">
						<div class="boton" style="margin-right: 1em;">
							<input type="button" name="imprimir" value="Imprimir" onclick="window.focus();window.print().window.close();">
						</div>
					</div>
					<div class="clear"></div>
							 
					<div class="clear"></div>
					<br>
					</body>
					
				</html>
			';
		}
		
		function assessment_tool($root = '', $assessmentid = 0, $idTool = 0, $grade = '', $saved = ''){
			require('lang/'. $this->language . '/evalcomix.php');
			$action = $root . '/assessment/webservice/services/saveassess.php?ass=' . $assessmentid . '&tool='.$idTool;
			
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>

					<head>
						<title>EVALCOMIX</title>
						<link href="'.$root.'/client/style/platform.css" type="text/css" rel="stylesheet">
						<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
						<script>
							function limpiar_mainform(){
								if(confirm(\'¿Confirma que desea borrar todas las calificaciones asignadas al instrumentos?\'))
									for (i=0;i<document.mainform.elements.length;i++){
										if(document.mainform.elements[i].type == "radio" && document.mainform.elements[i].checked == true)
										  document.mainform.elements[i].checked=false;
										else if(document.mainform.elements[i].type == "textarea") document.mainform.elements[i].value = "";
								}
							}
						</script>
					</head>

					<body>
						<div class="clear"></div>
						<div class="eval">
							<form name="mainform" method="post" action="'.$action.'">
								<input type="submit" name="submit" value="'.$string['TSave'].'" $disabledbutton>
			';
			
			$type =	get_class($this->object);	
			if($type == 'toolargument' && $grade != ''){
				$grade_exploded = explode('/',$grade);
				$score = $grade_exploded[0];
				echo "
							<div style='text-align:right; font-size:1.5em;'>
								<label for='grade'>".$string['grade'] .": </label>
								<select id='grade' name='grade'>
									<option value='-1'>".$string['nograde']."</option><br>
				";
		
				for($i = 100; $i >= 0; --$i){
					$selected = '';
					if(is_numeric($score) && $score == $i){
						$selected = 'selected';
					}
					echo "<option value='$i' $selected>$i</option><br>";
				}
				echo "
								</select>
							</div>";
			}
			
			$this->object->print_tool();
			
			echo "<input type='submit' name='".$string['TSave']."' value='".$string['TSave']."'>";

			echo "<input type='button' onclick=\"javascript:limpiar_mainform()\" value='Reset'>";
								   
			echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": " . $grade . "</span></div>";
		   
			echo '
						</form>
							
					</div><br><br>
			';
			if($saved == 'saved'){
				echo '<script type="text/javascript" language="javascript">alert("'.$string['alertsave'].'");</script>';
			}
			
			echo '
				<div class="clear"></div>
											 
					<div class="clear"></div>
					
					</body>
					
				</html>
			';
		}
		
		function assessment_tool_mixed($root = '', $assessmentid = 0, $idTool = '', $grade = '', $saved = '', $tools = array()){
			require('lang/'. $this->language . '/evalcomix.php');
			$action = $root . '/assessment/webservice/services/saveassess.php?ass=' . $assessmentid . '&tool='.$idTool;
			
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>

					<head>
						<title>EVALCOMIX</title>
						<link href="'.$root.'/client/style/platform.css" type="text/css" rel="stylesheet">
						<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
						<script>
							function limpiar_mainform(form){
								if(confirm(\'¿Confirma que desea borrar todas las calificaciones asignadas al instrumentos?\'))
									for (i=0;i<form.elements.length;i++){
										if(form.elements[i].type == "radio" && form.elements[i].checked == true)
										  form.elements[i].checked=false;
										else if(form.elements[i].type == "textarea") form.elements[i].value = "";
								}
							}
						</script>
					</head>

					<body>
						<div class="clear"></div>
						<div class="eval">
			';
			
			$listTool = $this->object->get_tools();
			$i = 0;
			foreach($listTool as $tool){
				$type =	get_class($tool);	
				$idsingle = '';
				foreach($tools as $key => $item){
					$object = $item->object;
					if(get_class($object) == $type  && $object->get_titulo() == $tool->get_titulo() 
							&& $object->get_dimension() == $tool->get_dimension() && $object->get_subdimension() == $tool->get_subdimension()
							&& $object->get_valores() == $tool->get_valores() && $object->get_atributo() == $tool->get_atributo()
							&& $object->get_commentAtr() == $tool->get_commentAtr()){
						if($type != 'toollist'){
							if($object->get_valglobal() == $tool->get_valglobal() && $object->get_valtotal() == $tool->get_valtotal()){
								if($type == 'toolrubric'){
									list(, $objectrango) = each($object->get_rango());
									list(, $toolrango) = each($tool->get_rango());
									if($objectrango == $toolrango){
										$idsingle = $key;
										break;
									}
								}
								else{
									$idsingle = $key;
									break;
								}
							}
						}
						else{
							$idsingle = $key;
							break;
						}
					}
				}
				if($idsingle == ''){
					break;
				}
				unset($tools[$idsingle]);
				echo '
							<form name="form'. $i .'" method="post" action="'.$action.'">
								<input type="hidden" name="cod" value="'.$idsingle.'">
								<input type="submit" name="submit" value="'.$string['TSave'].'">
				';
				
				$tool->print_tool();
				
				echo "
								<input type='submit' name='".$string['TSave']."' value='".$string['TSave']."'>
								<input type='button' onclick=\"javascript:limpiar_mainform(form".$i.")\" value='Reset'>
								   		 		
							</form>
							
							</div><br><br>
				";
				++$i;
			}
			
			echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": " . $grade . "</span></div>";
			
			if($saved == 'saved'){
				echo '<script type="text/javascript" language="javascript">alert("'.$string['alertsave'].'");</script>';
			}
			
			echo '
				<div class="clear"></div>
											 
					<div class="clear"></div>
					
					</body>
					
				</html>
			';
		}
		
		function view_tool_mixed($root = '', $grade = ''){
			require('lang/'. $this->language . '/evalcomix.php');
			$action = '';
			
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>

					<head>
						<title>EVALCOMIX</title>
						<link href="'.$root.'/client/style/platform.css" type="text/css" rel="stylesheet">
						<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
						<script>
							function limpiar_mainform(form){
								if(confirm(\'¿Confirma que desea borrar todas las calificaciones asignadas al instrumentos?\'))
									for (i=0;i<form.elements.length;i++){
										if(form.elements[i].type == "radio" && form.elements[i].checked == true)
										  form.elements[i].checked=false;
										else if(form.elements[i].type == "textarea") form.elements[i].value = "";
								}
							}
						</script>
					</head>

					<body>
						<div class="clear"></div>
						<div class="eval">
			';
			
			$listTool = $this->object->get_tools();
			$i = 0;
			foreach($listTool as $tool){
				echo '
							<form name="form'. $i .'" method="post" action="'.$action.'">
				';
				
				$tool->print_tool();
				
				echo "					   		 		
							</form>
							
							</div><br><br>
				";
				++$i;
			}
			
			echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": " . $grade . "</span></div>";
			
			echo '<div class="botones">
						<div class="boton" style="margin-right: 1em;">
							<input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
						</div>
					</div>';
			
			echo '
				<div class="clear"></div>
											 
					<div class="clear"></div>
					
					</body>
					
				</html>
			';
		}
}