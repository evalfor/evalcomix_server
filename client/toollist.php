<?php
	/**
		Representa un instrumento de evaluaciÃ³n genÃ©rico
	*/
	class toollist{
		//string
		private $titulo;
		
		//array -- titulo de cada dimensiones
		private $dimension;
		
		//array -- nÃºmero de dimensiones de cada dimensiÃ³n
		private $numdim;
		
		//array -- titulo de cada subdimensiÃ³n de cada dimensiÃ³n
		private $subdimension;
		
		//array -- nÃºmero de subdimensiones de cada subdimensiÃ³n
		private $numsubdim;
		
		//array -- titulo de cada atributo de cada subdimensiÃ³n de cada dimensiÃ³n
		private $atributo;
		
		//array -- nÃºmero de atributos de cada subdimensiÃ³n
		private $numatr;
		
		//array -- valores de cada dimensiÃ³n
		private $valores;
		
		//array -- nÃºmero de valores de cada dimensiÃ³n
		private $numvalores;
		
		//boolean -- indica si el instrumento tiene activada la valoraciÃ³n total
		private $valtotal;
		
		//integer -- nÃºmero de grados de la valoraciÃ³n total
		private $numtotal;
		
		//array -- grados de la valoraciÃ³n total
		private $valorestotal;
		
		//integer -- porcentaje de la valoraciÃ³n total
		private $valtotalpor;
		
		//array -- indica si estÃ¡ activada la valoraciÃ³n global por cada dimensiÃ³n
		private $valglobal;
		
		//array -- porcentaje de la valoraciÃ³n global de cada dimensiÃ³n
		private $valglobalpor;
		
		//string -- url del diccionario por defecto
		private $filediccionario;
		
		//array -- porcentaje de las dimensiones
		private $dimpor;
		
		//array -- porcentaje de las subdimensiones
		private $subdimpor;
	
		//array -- porcentaje de los atributos
		private $atribpor;
		
		//id
		private $id;
		
		//integer -- En caso de formar parte de un instrumento mixto, almacenarÃ¡ el valor porcentaje
		private $porcentage;
		
		//string -- comentarios
		private $observation;

		//'view' | 'design' -- indica si el instrumento estÃ¡ en modo diseÃ±o o vista previa
		private $view;
		
		//Array -- Almacena si los atributos tienen activados los comentarios o no
		private $commentAtr;
		
		//Array -- Almacena los valores asignados por el evaluador durante el proceso de evaluación
		private $valueattribute;
		
		//Array -- Almacena los comentarios de los atributos otorgados durante el proceso de evaluación
		private $valuecommentAtr;
		
		//Array -- Almacena los IDs de la BD relativos a las dimensiones
		private $dimensionsId;
		
		//Array -- Almacena los IDs de la BD relativos a las subdimensiones
		private $subdimensionsId;
		
		//Array -- Almacena los IDs de la BD relativos a los atributos
		private $atributosId;
		
		//Array -- Almacena los IDs de la BD relativos a los valores de las dimensiones
		private $valoresId;
		
		//Array -- Almacena los IDs de la BD relativos a los valores totales del instrumento
		private $valorestotalesId;
		
		function get_tool($id){}
		function get_titulo(){return $this->titulo;}
		function get_dimension(){return $this->dimension[$this->id];}
		function get_numdim(){return $this->numdim[$this->id];}
		function get_subdimension(){return $this->subdimension[$this->id];}
		function get_numsubdim(){return $this->numsubdim[$this->id];}
		function get_atributo(){return $this->atributo[$this->id];}
		function get_numatr(){return $this->numatr[$this->id];}
		function get_valores(){return $this->valores[$this->id];}
		function get_numvalores(){return $this->numvalores[$this->id];}
		function get_valtotal(){return $this->valtotal[$this->id];}
		function get_numtotal($id=0){return $this->numtotal[$this->id];}
		function get_valtotalpor(){return $this->valtotalpor[$this->id];}
		function get_valorestotal($id=0){if(isset($this->valorestotal[$this->id]))return $this->valorestotal[$this->id];}
		function get_valglobal(){return $this->valglobal[$this->id];}
		function get_valglobalpor(){}
		function get_dimpor(){return $this->dimpor[$this->id];}
		function get_subdimpor(){return $this->subdimpor[$this->id];}
		function get_atribpor(){return $this->atribpor[$this->id];}
		function get_commentAtr($id = 0){return $this->commentAtr[$this->id];}
		function get_porcentage(){return $this->porcentage;}
		function get_dimensionsId(){return $this->dimensionsId[$this->id];}
		function get_subdimensionsId(){return $this->subdimensionsId[$this->id];}
		function get_atributosId(){return $this->atributosId[$this->id];}
		function get_valoresId(){return $this->valoresId[$this->id];}
		function get_valorestotalesId(){return array();}
		
		function set_titulo($titulo){$this->titulo = $titulo;}
		function set_dimension($dimension){$this->dimension[$this->id] = $dimension;}
		function set_numdim($numdim){$this->numdim[$this->id] = $numdim;}
		function set_subdimension($subdimension){$this->subdimension[$this->id] = $subdimension;}
		function set_numsubdim($numsubdim){$this->numsubdim[$this->id] = $numsubdim;}
		function set_atributo($atributo){$this->atributo[$this->id] = $atributo;}
		function set_numatr($numatr){$this->numatr[$this->id] = $numatr;}
		function set_valores($valores){$this->valores[$this->id] = $valores;}
		function set_numvalores($numvalores){$this->numvalores[$this->id] = $numvalores;}
		function set_valtotal($valtotal){$this->valtotal[$this->id] = $valtotal;}
		function set_numtotal($numtotal){$this->numtotal[$this->id] = $numtotal;}
		function set_valtotalpor($valtotalpor){$this->valtotalpor[$this->id] = $valtotalpor;}
		function set_valorestotal($valorestotal){$this->valorestotal[$this->id] = $valorestotal;}
		function set_valglobal($valglobal){$this->valglobal[$this->id] = $valglobal;}
		function set_valglobalpor($valglobalpor, $id=0){$this->valglobalpor[$this->id] = $valglobalpor;}
		function set_dimpor($dimpor, $id=0){$this->dimpor[$this->id] = $dimpor;}
		function set_subdimpor($subdimpor){$this->subdimpor[$this->id] = $subdimpor;}
		function set_atribpor($atribpor){$this->atribpor[$this->id] = $atribpor;}
		function set_view($view, $id=''){$this->view = $view;}
		function set_commentAtr($comment){$this->commentAtr[$this->id] = $comment;}
		function set_dimensionsId($dimensionsId, $id = ''){$this->dimensionsId[$this->id] = $dimensionsId;}
		function set_subdimensionsId($subdimensionsId, $id = ''){$this->subdimensionsId[$this->id] = $subdimensionsId;}
		function set_atributosId($atributosId, $id = ''){$this->atributosId[$this->id] = $atributosId;}
		function set_valoresId($valoresId, $id = ''){$this->valoresId[$this->id] = $valoresId;}
		function set_valorestotalesId($valoresId, $id = ''){$this->valorestotalesId[$this->id] = $valoresId;}
		
		function __construct($lang='es_utf8', $titulo, $dimension, $numdim = 1, $subdimension, $numsubdim = 1, $atributo, $numatr = 1, $valores = array(), $numvalores = 2, $valtotal, $numtotal = 0, $valorestotal, $valglobal = false, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $id = 0, $observation = '', $porcentage=0, $valueattribute = '', $valuecommentAtr = '', $params = array()){
			$this->filediccionario = 'lang/'.$lang.'/evalcomix.php';
			$this->titulo = $titulo;
			$this->dimension = $dimension;
			$this->numdim = $numdim;
			$this->subdimension = $subdimension;
			$this->numsubdim = $numsubdim;
			$this->atributo = $atributo;
			$this->numatr = $numatr;
			$this->valores = $valores;
			$this->numvalores = $numvalores;
			$this->valtotal = $valtotal;
			$this->numtotal = $numtotal;
			$this->valorestotal = $valorestotal;
			$this->valglobal = $valglobal;
			$this->valglobalpor = $valglobalpor;
			$this->dimpor = $dimpor;
			$this->subdimpor = $subdimpor;
			$this->atribpor = $atribpor;
			$this->id = $id;
			$this->observation = $observation;
			$this->porcentage = $porcentage;
			$this->view = 'design';
			$this->commentAtr = $commentAtr;
			$this->valueattribute = $valueattribute;
			$this->valuecommentAtr = $valuecommentAtr;
			if(!empty($params['dimensionsId'])){
				$this->dimensionsId = $params['dimensionsId'];
			}
			if(!empty($params['subdimensionsId'])){
				$this->subdimensionsId = $params['subdimensionsId'];
			}
			if(!empty($params['atributosId'])){
				$this->atributosId = $params['atributosId'];
			}
			if(!empty($params['valoresId'])){
				$this->valoresId = $params['valoresId'];
			}
			if(!empty($params['valorestotalesId'])){
				$this->valorestotalesId = $params['valorestotalesId'];
			}
		}
		
		function addDimension($dim, $key){
			include($this->filediccionario);
			$dimen;
			$this->numdim[$this->id] += 1;
			if(!isset($dim)){
				$dim = $key;
				$dimen = $dim;
				$key++;
				$this->dimension[$this->id][$dim]['nombre'] = $string['titledim'].$this->numdim[$this->id];
			}
			else{
				$newindex = $key;
				$dimen = $newindex;
				$elem['nombre'] = $string['titledim'].$this->numdim[$this->id];
				$this->dimension[$this->id] = $this->arrayAdd($this->dimension[$this->id], $dim, $elem, $newindex);
			}
		
			$subdim = $key;
			$key++;
			$this->numatr[$this->id][$dimen][$subdim] = 1;
			$this->numsubdim[$this->id][$dimen] = 1;
			$this->atributo[$this->id][$dimen][$subdim][0]['nombre'] = $string['titleatrib'].$this->numatr[$this->id][$dimen][$subdim];
			$this->atribpor[$this->id][$dimen][$subdim][0] = 100;
			$this->subdimension[$this->id][$dimen][$subdim]['nombre'] = $string['titlesubdim'].$this->numsubdim[$this->id][$dimen];
			$this->subdimpor[$this->id][$dimen][$subdim] = 100;
			$this->valores[$this->id][$dimen][0]['nombre'] = 'No';
			$this->valores[$this->id][$dimen][1]['nombre'] = 'Yes';
			$this->numvalores[$this->id][$dimen] = 2;
		}
		
		
		function addSubdimension($dim, $subdim, $key){
			include($this->filediccionario);
			$subdimen;
			$this->numsubdim[$this->id][$dim] += 1;
			if(!isset($subdim)){
				$subdim = $key;
				$subdimen = $subdim;
				$this->subdimension[$this->id][$dim][$subdim]['nombre'] = $string['titlesubdim'].$this->numsubdim[$this->id][$dim];	
			}
			else{
				$newindex = $key;
				$subdimen = $newindex;
				$elem['nombre'] = $string['titlesubdim'].$this->numsubdim[$this->id][$dim];
				$this->subdimension[$this->id][$dim] = $this->arrayAdd($this->subdimension[$this->id][$dim], $subdim, $elem, $newindex);
			}
			$this->numatr[$this->id][$dim][$subdimen] = 1;
			$atrib = $key++;
			$this->atributo[$this->id][$dim][$subdimen][$atrib]['nombre'] = $string['titleatrib'].$this->numatr[$this->id][$dim][$subdim];
			$this->atribpor[$this->id][$dim][$subdimen][$atrib] = 100;
		}
		
		
		function addAtributo($dim, $subdim, $atrib, $key){
			include($this->filediccionario);
			$this->numatr[$this->id][$dim][$subdim]++;
	
			if(!isset($atrib)){
				$atrib = $key;
				$this->atributo[$this->id][$dim][$subdim][$atrib]['nombre'] = $string['titleatrib'].$this->numatr[$this->id][$dim][$subdim];
			}
			else{
				$newindex = $key;
				$elem['nombre'] = $string['titleatrib'].$this->numatr[$this->id][$dim][$subdim];
				$this->atributo[$this->id][$dim][$subdim] = $this->arrayAdd($this->atributo[$this->id][$dim][$subdim], $atrib, $elem, $newindex);
				$this->commentAtr[$this->id][$dim][$subdim][$newindex]= 'hidden';
			}
		}
		
		
		function addValores($dim, $key, $id = 0){
			include($this->filediccionario);
			$this->numvalores[$this->id][$dim]++;
			$this->valores[$this->id][$dim][$key]['nombre'] = $string['titlevalue'].$this->numvalores[$this->id][$dim];
		}
		
		function addValoresTotal($key){
			$this->numtotal++;
			$this->valorestotal[$key]['nombre'] = $string['titlevalue'].$this->numtotal;
		}
		
		function eliminaValoresTotal($grado){
			if($this->numtotal > 2){
				$this->numtotal--;
				$this->valorestotal = $this->arrayElimina($this->valorestotal, $grado);	
			}
		}
		
		function eliminaDimension($dim, $id = 0){	
			include($this->filediccionario);
			if($this->numdim[$this->id] > 1){
				if($this->numsubdim[$this->id][$dim] > 0)
					$this->numsubdim[$this->id][$dim]--;
				if($this->numvalores[$this->id][$dim] > 2)
					$this->numvalores[$this->id][$dim]--;
				$this->dimension[$this->id] = $this->arrayElimina($this->dimension[$this->id], $dim);
				$this->subdimension[$this->id] = $this->arrayElimina($this->subdimension[$this->id], $dim);
				$this->atributo[$this->id] = $this->arrayElimina($this->atributo[$this->id], $dim);
				$this->valores[$this->id] = $this->arrayElimina($this->valores[$this->id], $dim);
				$this->numsubdim[$this->id] = $this->arrayElimina($this->numsubdim[$this->id], $dim);
				$this->numatr[$this->id] = $this->arrayElimina($this->numatr[$this->id], $dim);
				$this->numdim[$this->id]--;
			}
			else{
				echo '<span class="mensaje">'.$string['alertdimension'].'</span>';
			}
			return 1;
		}
		
		function eliminaSubdimension($dim, $subdim){ 
			include($this->filediccionario);
			if($this->numsubdim[$this->id][$dim] > 1){
				$this->numsubdim[$this->id][$dim]--;
				$this->subdimension[$this->id][$dim] = $this->arrayElimina($this->subdimension[$this->id][$dim], $subdim);
				$this->subdimpor[$this->id][$dim] = $this->arrayElimina($this->subdimpor[$this->id][$dim], $subdim);
				if(empty($this->subdimension[$this->id][$dim]))
					unset($this->subdimension[$this->id][$dim]);
				$this->atributo[$this->id][$dim] = $this->arrayElimina($this->atributo[$this->id][$dim], $subdim);
				$this->numatr[$this->id][$dim] = $this->arrayElimina($this->numatr[$this->id][$dim], $subdim);
			}
			else{
				echo '<span class="mensaje">'.$string['alertsubdimension'].'</span>';
			}
			return 1;
		}
		
		function eliminaAtributo($dim, $subdim, $atrib, $id){
			include($this->filediccionario);
			if(isset($this->atributo[$this->id][$dim][$subdim][$atrib])){
				if($this->numatr[$this->id][$dim][$subdim] > 1){
					$this->numatr[$this->id][$dim][$subdim]--;
					
					$this->atributo[$this->id][$dim][$subdim] = $this->arrayElimina($this->atributo[$this->id][$dim][$subdim], $atrib);
					$this->atribpor[$this->id][$dim][$subdim] = $this->arrayElimina($this->atribpor[$this->id][$dim][$subdim], $atrib);
				}
				else{
					echo '<span class="mensaje">'.$string['alertatrib'].'</span>';
				}
			}
			return 1;
		}
		
		
		function eliminaValores($dim, $grado){
			if($this->numvalores[$this->id][$dim] > 2){
				$this->numvalores[$this->id][$dim]--;
				$this->valores[$this->id][$dim] = $this->arrayElimina($this->valores[$this->id][$dim], $grado);	
			}
		}
		
	function upBlock($params){
			include($this->filediccionario);
			include_once('array.class.php');
			$id = $this->id;
			
			$instanceName = $params['instanceName'];
			$blockData = $params['blockData'];
			$blockIndex = $params['blockIndex'];
			$blockName = $params['blockName'];
			if(isset($params['dim'])){
				$dim = $params['dim'];
			}
			if(isset($params['subdim'])){
				$subdim = $params['subdim'];
			}
			
			
			if(isset($blockData)){
				$previousIndex = array_util::getPrevElement($blockData, $blockIndex);
				if($previousIndex !== false){
					$elem['nombre'] = $instanceName;
					$blockData = $this->arrayElimina($blockData, $blockIndex);
					$blockData = array_util::arrayAddLeft($blockData, $previousIndex, $elem, $blockIndex);
				}
			}
			switch($blockName){
				case 'dimension':{
					$this->dimension[$id] = $blockData;
				}break;
				case 'subdimension':{
					$this->subdimension[$id][$dim] = $blockData;
				}break;
				case 'atributo':{
					$this->atributo[$id][$dim][$subdim] = $blockData;
				}
			}	
		}
		
		function downBlock($params){
			include($this->filediccionario);
			include_once('array.class.php');
			$id = $this->id;
				
			$instanceName = $params['instanceName'];
			$blockData = $params['blockData'];
			$blockIndex = $params['blockIndex'];
			$blockName = $params['blockName'];
			if(isset($params['dim'])){
				$dim = $params['dim'];
			}
			if(isset($params['subdim'])){
				$subdim = $params['subdim'];
			}
				
				
			if(isset($blockData)){
				$previousIndex = array_util::getNextElement($blockData, $blockIndex);
				if($previousIndex !== false){
					$elem['nombre'] = $instanceName;
					$blockData = $this->arrayElimina($blockData, $blockIndex);
					$blockData = array_util::arrayAddRight($blockData, $previousIndex, $elem, $blockIndex);
				}
			}
			switch($blockName){
				case 'dimension':{
					$this->dimension[$id] = $blockData;
				}break;
				case 'subdimension':{
					$this->subdimension[$id][$dim] = $blockData;
				}break;
				case 'atributo':{
					$this->atributo[$id][$dim][$subdim] = $blockData;
				}
			}
		}
		
		function display_header(){
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<link href="style/copia.css" type="text/css" rel="stylesheet">
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<script type="text/javascript" src="javascript/tamaÃ±o.js"></script>
					<script type="text/javascript" src="javascript/rollover.js"></script>					
					<script type="text/javascript" src="javascript/ajax.js"></script>
					<script type="text/javascript" src="javascript/check.js"></script>
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
						document.onkeyup = function(e){
							if(e.which == 116){
								e.which = 505;
							}
							if(e.which == 505){
								return false;
								// window.frame(main).location.reload(True);
							}
							 

						}

						document.oncontextmenu=function(){return false;} 
						
						function validar(e) {
							tecla = (document.all) ? e.keyCode : e.which;
							if (tecla==8 || tecla==37 || tecla==39) return true;
								//patron =/[A-Za-zÃ±Ã‘\s/./-/_/:/;]/;
								patron = /\d/;
							te = String.fromCharCode(tecla);
							return patron.test(te);
						} 
					</script>
				</head>
	
				<body id="body" >
					<div id="cabecera">
						<div id="menu">				
							<img id="guardar" src="images/guardar.png" onmouseover="javascript:cAmbiaOver(this.id, \'images/guardarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/guardar.png\');" alt="Guardar" title="Guardar"/>
							<img id="importar" src="images/importar.png" alt="Importar" title="Importar" onmouseover="javascript:cAmbiaOver(this.id, \'images/importarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/importar.png\');"/>
							<img id="exportar" src="images/exportar.png" alt="Exportar" title="Exportar" onmouseover="javascript:cAmbiaOver(this.id, \'images/exportarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/exportar.png\');"/>
							<a onClick="MasTxt(\'cuerpo\');" href=#><img id="aumentar" src="images/aumentar.png" alt="Aumentar" title="Aumentar tamaÃ±o de fuente" onmouseover="javascript:cAmbiaOver(this.id, \'images/aumentarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/aumentar.png\');"/></a>
							<a onClick="MenosTxt(\'cuerpo\');" href=#><img id="disminuir" src="images/disminuir.png" alt="Disminuir" title="Disminuir tamaÃ±o de fuente" onmouseover="javascript:cAmbiaOver(this.id, \'images/disminuirhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/disminuir.png\');"/></a>
							<img id="imprimir" src="images/imprimir.png" alt="Imprimir" title="Imprimir" onmouseover="javascript:cAmbiaOver(this.id, \'images/imprimirhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/imprimir.png\');"/>
							<img id="ayudar" src="images/ayuda.png" alt="Ayuda" title="Ayuda" onmouseover="javascript:cAmbiaOver(this.id, \'images/ayudahover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/ayuda.png\');"/>
							<img id="acerca" src="images/acerca.png" alt="Acerca de" title="Acerca de" onmouseover="javascript:cAmbiaOver(this.id, \'images/acercahover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/acerca.png\');"/>
						</div>
					</div>';						
			flush();
		}
		
		function display_body($data, $mix = '', $porcentage=''){		
			if($porcentage != '')
				$this->porcentage = $porcentage;
			if(isset($data['titulo'.$this->id]))
				$this->titulo = stripslashes($data['titulo'.$this->id]);
			
			if(isset($data['valtotal'.$this->id]))
				$this->valtotal[$this->id] = stripslashes($data['valtotal'.$this->id]);
			
			if(isset($data['numvalores'.$this->id]) && $data['numvalores'.$this->id] >= 2)
				$this->numtotal[$this->id] = stripslashes($data['numvalores'.$this->id]);
			
	
			include($this->filediccionario);
			$numdimen = count($this->dimension[$this->id]);
			
			if($this->view == 'view' && !is_numeric($mix)){
				echo '<input type="button" style="width:10em" value="'.$string['view'].'" onclick=\'javascript:location.href="generator.php?op=design"\'><br>';
			}
			$id = $this->id;
			//----------------------------------------------TODO
			echo '
			<div id="cuerpo'.$id.'"  class="cuerpo">
				<br>
				<label for="titulo'.$id.'" style="margin-left:1em">'.$string['checklist'].':</label><span class="labelcampo">
					<textarea class="width" id="titulo'.$id.'" name="titulo'.$id.'">'.$this->titulo.'</textarea></span>
				';
			if($this->view == 'design')
				echo '
				<label for="numdimensiones'.$id.'">'.$string['numdimensions'].'</label>
				<span class="labelcampo">
					<input type="text" id="numdimensiones'.$id.'" name="numdimensiones'.$id.'" value="'.$this->numdim[$this->id].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/>
				</span>
				
				<input class="flecha" type="button" id="addDim" onclick=\'javascript:if(!validarEntero(document.getElementById("numdimensiones'.$id.'").value)){alert("' . $string['ADimension'] . '"); return false;} sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&addDim=1&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&numdimensiones="+ document.getElementById("numdimensiones'.$id.'").value +"", "mainform0");\' name="addDim" value=""/>				
			';
			if(isset($mix) && is_numeric($mix)){
				echo '
				<span class="labelcampo">
					<label for="toolpor_'.$id.'">'.$string['porvalue'].'</label>
					<input class="porcentaje" type="text" name="toolpor_'.$id.'" id="toolpor_'.$id.'" value="'.$this->porcentage.'" onchange=\'document.getElementById("sumpor").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("toolpor_'.$id.'").value > 100)document.getElementById("toolpor_'.$id.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
					<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("body", "id='.$id.'&toolpor_'.$id.'="+document.getElementById("toolpor_'.$id.'").value+"&addtool'.$id.'=1", "mainform0");\'>
				</span>';
			}
			
			echo '<br/>';
			flush();
			foreach($this->dimension[$id] as $dim => $value){
				echo '<div class="dimension" id="dimensiontag'.$id.'_'.$dim.'">';
				$this->display_dimension($dim, $data, $id, $mix);
				echo '</div>';
			}
			
			if(!is_numeric($mix)){
				if(isset($data['observation'.$id]))
					$this->observation[$id] = stripslashes($data['observation'.$id]);

				$observationid = '';
				if(isset($this->observation[$id])){
					$observationid = $this->observation[$id];
				}
				
				echo '
				<div id="comentario">
					<div id="marco">
						<label for="observation'.$id.'">' . $string['observation']. ':</label>
						<textarea id="observation'.$id.'" style="width:100%" rows="4" cols="200">' . $observationid . '</textarea>
					</div>
				</div>
				';
			}
			echo '
				<input type="hidden" id="sumpor3'.$id.'" value=""/>
			</div>
			
			';
			flush();
		}
		
		function display_footer(){
			echo '
				</body>
			</html>';
		}

		function display_dimension($dim, $data, $id=0, $mix=''){ 
			$id = $this->id;
			if(isset($data['dimension'.$id.'_'.$dim])) 
				$this->dimension[$this->id][$dim]['nombre'] = stripslashes($data['dimension'.$id.'_'.$dim]);
			
			if(isset($data['numvalores'.$id.'_'.$dim]) && $data['numvalores'.$id.'_'.$dim] > 1) 
				$this->numvalores[$this->id][$dim] = stripslashes($data['numvalores'.$id.'_'.$dim]);

			if(isset($data['valglobal'.$id.'_'.$dim]))
			
				$this->valglobal[$this->id][$dim] = stripslashes($data['valglobal'.$dim]);
			
			$checked = '';
			if(isset($this->valglobal[$this->id][$dim]) && $this->valglobal[$this->id][$dim] == "true"){
				$globalchecked = 'checked';
			}
			include($this->filediccionario);
			
			if($this->view == 'design')
				echo '
			<div>
				<input type="button" class="delete" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addDim=1&numvalores='.$this->numtotal.'&dd='.$dim.'", "mainform0");\'>
				<input type="button" class="up" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&moveDim=1&dUp='.$dim.'", "mainform0");\'>
				<br>
			</div>
				';
			echo '
			<input type="hidden" id="sumpor2'.$id.'_'.$dim.'" value=""/>
			<div class="margin">
				<label for="dimension'.$id.'_'.$dim.'">'.$string['dimension'].'</label>
				<span class="labelcampo">
					<textarea class="width" id="dimension'.$id.'_'.$dim.'" name="dimension'.$id.'_'.$dim.'">'. $this->dimension[$this->id][$dim]['nombre'] .'</textarea>
				</span>
			';
			if($this->view == 'design')
				echo '
				<label for="numsubdimensiones'.$id.'_'.$dim.'">'.$string['numsubdimension'].'</label>
				<span class="labelcampo"><input type="text" id="numsubdimensiones'.$id.'_'.$dim.'" name="numsubdimensiones'.$id.'_'.$dim.'" value="'.$this->numsubdim[$this->id][$dim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
		
				<label for="numvalores'.$id.'_'.$dim.'">'.$string['numvalues'].'</label>
				<span class="labelcampo"><input type="text" disabled id="numvalores'.$id.'_'.$dim.'" name="numvalores'.$id.'_'.$dim.'" value="'.$this->numvalores[$this->id][$dim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
				
				<input class="flecha" type="button" id="addSubDim'.$id.'" name="addSubDim'.$id.'" onclick=\'javascript:if(!validarEntero(document.getElementById("numvalores'.$id.'_'.$dim.'").value) || !validarEntero(document.getElementById("numsubdimensiones'.$id.'_'.$dim.'").value)){alert("' . $string['ASubdimension'] . '"); return false;}sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim="+this.value+"&numvalores'.$id.'_'.$dim.'="+ document.getElementById("numvalores'.$id.'_'.$dim.'").value +"&numsubdimensiones'.$dim.'="+ document.getElementById("numsubdimensiones'.$id.'_'.$dim.'").value +"", "mainform0");\' style="font-size:1px" value="'.$dim.'"/>		
				';
			echo '
				<span class="labelcampo"><label for="dimpor'.$id.'_'.$dim.'">'.$string['porvalue'].'</label><span class="labelcampo">
				<input class="porcentaje" type="text" maxlength="3" name="dimpor'.$id.'_'.$dim.'" id="dimpor'.$id.'_'.$dim.'" value="'.$this->dimpor[$this->id][$dim].'" onchange=\'javascript:document.getElementById("sumpor3'.$id.'").value += this.id +"-";;\' onkeyup=\'javascript:if(document.getElementById("dimpor'.$id.'_'.$dim.'").value > 100)document.getElementById("dimpor'.$id.'_'.$dim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
				<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&dimpor'.$id.'="+document.getElementById("dimpor'.$id.'_'.$dim.'").value+"&dpi='.$dim.'&addDim=1", "mainform0");\'></span>';
		
			if(isset($this->subdimension[$this->id][$dim])){
				foreach($this->subdimension[$this->id][$dim] as $subdim => $elemsubdim){
					echo '								
						<div class="subdimension" id="subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'">
					';
					$this->display_subdimension($dim, $subdim, $data, $id, $mix);
					echo '</div>					
					';
				}				
			}
			
			echo '</div>';
		
			if($this->view == 'design')
				echo '<div>
						<input type="button" class="add" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addDim=1&ad='.$dim.'", "mainform0");\'>
						<input type="button" class="down" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&mix='.$mix.'&id='.$id.'&moveDim=1&dDown='.$dim.'", "mainform0");\'>
					<br></div>
					';
			flush();
		}		
		function display_subdimension($dim, $subdim, $data, $id='0', $mix=''){
			$id = $this->id;
			include($this->filediccionario);
			if(isset($data['subdimension'.$id.'_'.$dim.'_'.$subdim])) 
				$this->subdimension[$id][$dim][$subdim]['nombre'] = stripslashes($data['subdimension'.$id.'_'.$dim.'_'.$subdim]);
				
			
			if($this->view == 'design')
				echo '
				<input type="hidden" id="sumpor'.$id.'_'.$dim.'_'.$subdim.'" value=""/>
				<div>
					<input type="button" class="delete" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim='.$dim.'&dS=1&sd='.$subdim.'", "mainform0");\'>
					<input type="button" class="up" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&moveSub='.$dim.'&sUp='.$subdim.'", "mainform0");\'>		
					<br><br>
				</div>
				';

				echo '
					<div class="margin">
						<label for="subdimension'.$id.'_'.$dim.'_'.$subdim.'">'.$string['subdimension'].'</label>
						<span class="labelcampo">
						<textarea  class="width" id="subdimension'.$id.'_'.$dim.'_'.$subdim.'" name="subdimension'.$id.'_'.$dim.'_'.$subdim.'">'.$this->subdimension[$this->id][$dim][$subdim]['nombre'].'</textarea>
					</span>
			';
			if($this->view == 'design')
				echo '
						<label for="numatributos'.$id.'_'.$dim.'_'.$subdim.'">'.$string['numattributes'].'</label>
						<span class="labelcampo"><input type="text" id="numatributos'.$id.'_'.$dim.'_'.$subdim.'" name="numatributos'.$id.'_'.$dim.'_'.$subdim.'" value="'.$this->numatr[$this->id][$dim][$subdim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
						<input class="flecha" type="button" id="addAtr'.$id.'" name="addAtr'.$id.'" style="font-size:1px" onclick=\'javascript:if(!validarEntero(document.getElementById("numatributos'.$id.'_'.$dim.'_'.$subdim.'").value)){alert("' . $string['AAttribute'] . '"); return false;}sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&addAtr="+this.value+"&numatributos'.$id.'_'.$dim.'_'.$subdim.'="+ document.getElementById("numatributos'.$id.'_'.$dim.'_'.$subdim.'").value +"", "mainform0");\' value="'.$dim.'_'.$subdim.'"/>
				';

			echo '
						<span class="labelcampo"><label for="subdimpor'.$id.'_'.$dim.'_'.$subdim.'">'.$string['porvalue'].'</label><span class="labelcampo">
						<input class="porcentaje" type="text" maxlength="3" id="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" name="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" value="'.$this->subdimpor[$this->id][$dim][$subdim].'" onchange=\'document.getElementById("sumpor2'.$id.'_'.$dim.'").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value > 100)document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
						<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&subdimpor="+document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value+"&spi='.$subdim.'&addSubDim='.$dim.'", "mainform0");\'>
						</span><br>
				<br>
						<table class="maintable">
							<tr><th/><th/><th/>
							<th style="text-align:right;"><span class="font">'.$string['attribute'].'</span>  <span class="atributovalores" style="font-size:1em">/</span> <span class="atributovalores">'.$string['values'].'</span></th>
						';
			foreach($this->valores[$this->id][$dim] as $grado => $elemvalue){
				if(isset($data['valor'.$id.'_'.$dim.'_'.$grado])) 
					$this->valores[$this->id][$dim][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$dim.'_'.$grado]);
					
				echo '<th class="grado"><input class="valores" onkeyup=\'javascript:var valores=document.getElementsByName("valor'.$id.'_'.$dim.'_'.$grado.'");for(var i=0; i<valores.length; i++){valores[i].value=this.value;}\' type="text" id="valor'.$id.'_'.$dim.'_'.$grado.'" name="valor'.$id.'_'.$dim.'_'.$grado.'" value="'.htmlspecialchars($this->valores[$this->id][$dim][$grado]['nombre']).'"/></th>
				';
			}
			echo '</tr>';
			$numAtributo = count($this->atributo[$this->id][$dim][$subdim]);
			if(isset($this->atributo[$this->id][$dim][$subdim])){
				foreach($this->atributo[$this->id][$dim][$subdim] as $atrib => $elematrib){
					if(isset($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributo[$this->id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					
					echo '			<tr>
								<td style="">';
					if($this->view == 'design')
						echo '
									<div style="margin-bottom:2em;">					
										<input type="button" class="delete" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&addAtr='.$dim.'_'.$subdim.'&dt='.$atrib.'", "mainform0");\'>
									</div>
									<div style="margin-top:2em;">
										<input type="button" class="add" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&addAtr='.$dim.'_'.$subdim.'&at='.$atrib.'", "mainform0");\'>
									</div>
						';
					echo '</td>';
					
					if($this->view == 'design'){
						echo '
								<td style="">
									<div style="margin-bottom:2em;">
										<input type="button" class="up" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&moveAtr='.$dim.'_'.$subdim.'&aUp='.$atrib.'", "mainform0");\'>
									</div>
									<div style="margin-top:2em;">
										<input type="button" class="down" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&moveAtr='.$dim.'_'.$subdim.'&aDown='.$atrib.'", "mainform0");\'>
									</div>
								</td>
						';
					}
					echo '
										
							<td><input class="porcentaje" type="text" onchange=\'document.getElementById("sumpor'.$id.'_'.$dim.'_'.$subdim.'").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value > 100)document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'  maxlength="3" name="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" id="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" value="'.$this->atribpor[$this->id][$dim][$subdim][$atrib].'"/>
							<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&atribpor="+document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value+"&api='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'></td>
							<td><span class="font"><textarea class="width" id="atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" name="atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'">'.$this->atributo[$this->id][$dim][$subdim][$atrib]['nombre'].'</textarea></span></td>
						';
					foreach($this->valores[$this->id][$dim] as $grado => $elemvalue){
						echo '<td><input type="radio" name="radio'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
						';
					}	
								
					echo '</tr>';
					
					//COMENTARIOS-ATRIBUTOS-------------------------
					$visible = null;
					if(isset($data['commentAtr'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])){
						$visible = stripslashes($data['commentAtr'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
						$this->commentAtr[$id][$dim][$subdim][$atrib]= $visible;
					}
					
					if(isset($this->commentAtr[$id][$dim][$subdim][$atrib]) && $this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
						$visible = 'visible';
						$novisible = 'hidden';
					}
					else{
						$novisible = 'visible';
						$visible = 'hidden';
					}
					
					echo '<tr>
					<td></td>
					<td>';
					
					if($this->view == 'design'){
						echo '
						<div style="text-align:right">
							<input type="button" class="showcomment" title="'. $string['add_comments'] .'" 
								onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&commentAtr'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'='.$novisible.'&comAtr='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'>
						</div>';
					}
					echo '
					</td><td/><td></td>
					<td colspan="'.$this->numvalores[$id][$dim].'">';
					
					if($visible == 'visible'){
						$divheight = 'height:2.5em';
						$textheight = 'height:2em';
					}
					else{
						$divheight  = 'height:0.5em';
						$textheight = 'height:0.5em';
					}
					echo '<div class="atrcomment" id="atribcomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" style="'.$divheight.'">
					<textarea disabled style="width:97%; visibility:'.$visible.'; '.$textheight.'"  id="atributocomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'"></textarea>
						</div>
					</td>
					';
				
					echo '</tr>';
					//--------------------------------------------------------
				}
			}
			echo '</table>
					</div>
			';
			if($this->view == 'design')
				echo '
					<div><input type="button" class="add" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim='.$dim.'&sd='.$subdim.'&aS=1'.'", "mainform0");\'>
					<input type="button" class="down" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&moveSub='.$dim.'&sDown='.$subdim.'", "mainform0");\'>		
					<br></div>
			';
			flush();
		}
		
		/*
		@param $array 
		@param $i Ã­ndice del elemento a eliminar en $array
		@return $array sin el elemento
		Elimina de @array el elemento $i
		*/
		function arrayElimina($array, $i){
			$arrayAux = array();
			if(is_array($array)){
				foreach($array as $key => $value){
					if($key != $i)
						$arrayAux[$key] = $value;
				}
			}
			return $arrayAux;
		}
		
		/*
		@param $array - array o tabla hash
		@param $i Ã­ndice del elemento a partir del que introducirÃ¡ el elemento $elem en $array
		@param $elem nuevo elemento a aÃ±adir
		@param $index indice del nuevo elemento. Si no se especifica, el nuevo Ã­ndice serÃ¡ $i+1
		@return $array con el nuevo elemento
		AÃ±ade $elem a @array a continuaciÃ³n de $i.
		*/
		function arrayAdd($array, $i, $elem, $index){
			$arrayAux = array();
			$flag = false;
			if(is_array($array)){
				foreach($array as $key => $value){
					$arrayAux[$key] = $value;
					if($key == $i)
						$flag = true;
					if($flag == true){
						$newkey = $key + 1;
						if(isset($index))
							$newkey = $index;
						$arrayAux[$newkey] = $elem;
						$flag = false;
					}
				}
			}
			return $arrayAux;
		}
		
		function save($cod = ''){
			$id = $this->id;
			if($cod == ''){
				throw new InvalidArgumentException('Missing scale cod');
			}
			
			include_once('../classes/plantilla.php');
			include_once('../classes/dimension.php');
			include_once('../classes/valoracion.php');
			include_once('../classes/dimval.php');
			include_once('../classes/atreva.php');
			include_once('../classes/atrcomment.php');
			include_once('../classes/subdimension.php');
			include_once('../classes/atributo.php');
			include_once('../classes/db.php');
			include_once('../lib/weblib.php');
			
			$type = 'lista';
			$tableid = 0;
			
			$modify = 0;
			if($plantilla = plantilla::fetch(array('pla_cod' => $cod))){
				$modify = 1;
				$tableid = $plantilla->id;
			}
			$valtotal = '0';
			if(isset($this->valtotal[$id]) && ($this->valtotal[$id] == 'true' || $this->valtotal[$id] == 't')){
				$valtotal = '1';
			}
			$observation = '';
			if(isset($this->observation[$id])){
				$observation = $this->observation[$id];
			}
			$porcentage = '100';
			if(isset($this->porcentage) && $this->porcentage != ''){
				$porcentage = $this->porcentage;
			}
				
			$destroy = false;
			$recalculate = true;
			if($modify == 0){
				$params['pla_cod'] = $cod;
				$params['pla_tit'] = $this->titulo;
				$params['pla_tip'] = $type;
				$params['pla_gpr'] = 0;
				$params['pla_glo'] = $valtotal;
				$params['pla_des'] = $observation;			
				$params['pla_por'] = $porcentage;
				
				$plantilla = new plantilla($params);
				
				$tableid = $plantilla->insert();
				$destroy = true;
			}
			else{
				//Comprobamos los elementos estructurales. Si no se han modificado
				$updateplantilla = false;
				if($plantilla->pla_tit != $this->titulo || $plantilla->pla_glo != $valtotal || $plantilla->pla_des != $this->observation[$id] || $plantilla->pla_por != $porcentage){
					$updateplantilla = true;
				}
				$plantilla->pla_tit = $this->titulo;
				$plantilla->pla_des = $observation;			
				$plantilla->pla_por = $porcentage;
				
				if($updateplantilla == true){
					$pla_glo = '0';
					plantilla::set_properties($plantilla, array('id' => $tableid, 'pla_glo' => $pla_glo));
					$plantilla->update();
				}
				
				$numdim = 0;
				$numsubdim = 0;
				$numatributos = 0;
				$numvalores = 0;
				
				$dimensions = dimension::fetch_all(array('dim_pla' => $tableid));//print_r($dimensions);
				$numdim = count($dimensions);
				$dimensionsCod = array();
				$dimvalsCod = array();
				$dimvals = array();
				$subdimensionsCod = array();
				$subdimensions = array();
				$atributosCod = array();
				$atributos = array();
				foreach($dimensions as $keydim => $object){
					$codDim = encrypt_tool_element($keydim);
					$dimensionsCod[$codDim] = $keydim;
					
					if($dimvals_aux = dimval::fetch_all(array('div_dim' => $keydim))){
						foreach($dimvals_aux as $keydimval => $dimval_aux){
							$codDimval = encrypt_tool_element($keydimval);
							$dimvalsCod[$codDimval] = $keydimval;
							$dimvals[$keydimval] = $dimval_aux;
						}
					}
					
					if($subdimensions_aux = subdimension::fetch_all(array('sub_dim' => $keydim))){//print_r($dimensions);
						$numsubdim = count($subdimensions_aux);
						foreach($subdimensions_aux as $keysubdim => $subdimension_aux){
							$codSubdim = encrypt_tool_element($keysubdim);
							$subdimensionsCod[$codSubdim] = $keysubdim;
							$subdimensions[$keysubdim] = $subdimension_aux;
							
							if($atributos_aux = atributo::fetch_all(array('atr_sub' => $keysubdim))){
								foreach($atributos_aux as $keyatributo => $atributo_aux){
									$codAtributo = encrypt_tool_element($keyatributo);
									$atributosCod[$codAtributo] = $keyatributo;
									$atributos[$keyatributo] = $atributo_aux;
								}
							}
						}
					}	
				}
			}
				
			if($destroy == false){
				//El orden de las dimensiones no debería importar
				$dim_pos = 0;
				foreach($this->dimension[$id] as $dim => $value){
					if($numdim != 0 && $numdim != $this->numdim[$id]){
						//$destroy = true;
					}
					
					$idDim = $this->dimensionsId[$id][$dim];
					if(isset($dimensionsCod[$idDim])){
						//$dimensions[$id_plane]->dim_glo = $dim_glo;
						//$dimensions[$id_plane]->dim_com = $dim_com;
						$update = false;
						$id_plane = $dimensionsCod[$idDim];
						if($dimensions[$id_plane]->dim_por != $this->dimpor[$id][$dim] || $dimensions[$id_plane]->dim_sub != $this->numsubdim[$id][$dim]){
							$update = true;
							$recalculate = true;
						//	$destroy = true;
						//	break;
						}
						if($dimensions[$id_plane]->dim_nom != $this->dimension[$id][$dim]['nombre'] || $dimensions[$id_plane]->dim_pos != $dim_pos){
							$update = true;
						}
						if($update == true){
							$dimensions[$id_plane]->dim_glo = '0';
							$dimensions[$id_plane]->dim_com = '0';
							$dimensions[$id_plane]->dim_nom = $this->dimension[$id][$dim]['nombre'];
							$dimensions[$id_plane]->dim_pos = $dim_pos;
							$dimensions[$id_plane]->dim_por = $this->dimpor[$id][$dim];
							$dimensions[$id_plane]->dim_sub = $dimensions[$id_plane]->dim_sub;
							$dimensions[$id_plane]->update();
						}
						
						unset($dimensions[$id_plane]);
					}
					else{
						//Insertamos la nueva dimensión
						
						$dim_glo = '0';
						$dim_com = '0';
						
						$params_dimension['dim_pla'] = $tableid;
						$params_dimension['dim_nom'] = $this->dimension[$id][$dim]['nombre'];
						$params_dimension['dim_por'] = $this->dimpor[$id][$dim];
						$params_dimension['dim_glo'] = $dim_glo;
						$params_dimension['dim_sub'] = $this->numsubdim[$id][$dim];
						$params_dimension['dim_com'] = $dim_com;
						$params_dimension['dim_pos'] = $dim_pos;
						$dimension = new dimension($params_dimension);
						$dimensionid = $dimension->insert();
						$did = $dimensionid; 
						$codDim = encrypt_tool_element($dimensionid);
						$dimensionsCod[$codDim] = $did;						
						$this->dimensionsId[$id][$dim] = $codDim;						
						
						$recalculate = true;
						//$destroy = true;
						//break;
					}
					
					$div_pos = 0;
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						$idDimval = $this->valoresId[$id][$dim][$grado];
						if(isset($dimvalsCod[$idDimval])){
							$update = false;
							$id_plane = $dimvalsCod[$idDimval];
							if($dimvals[$id_plane]->div_val != $elemvalue['nombre']){
								$update = true;
								$recalculate = true;
							}
							if($update == true){
								if(!$valoracion = valoracion::fetch(array('val_cod' => $elemvalue['nombre']))){									
									$valoracion = new valoracion(array('val_cod' => $elemvalue['nombre']));
									$valoracion->insert();
								}
								$dimvals[$id_plane]->div_val = $elemvalue['nombre'];
								$dimvals[$id_plane]->div_pos = $div_pos;
								$dimvals[$id_plane]->update();
							}	
							unset($dimvals[$id_plane]);
						}
						else{
							$params_value['val_cod'] = $elemvalue['nombre'];
							if(!$valoracion = valoracion::fetch($params_value)){
								$valoracion = new valoracion($params_value);
								$valoracionid = $valoracion->insert();
							}
							
							$dimensionId = $this->dimensionsId[$id][$dim]; 
							$dim_plane = $dimensionsCod[$dimensionId]; 
							$params_dimval['div_dim'] = $dim_plane;
							//$params_dimval['div_val'] = $valoracionid;
							$params_dimval['div_val'] = $elemvalue['nombre'];
							$params_dimval['div_pos'] = $div_pos;
							$dimval = new dimval($params_dimval);
							$dimvalid = $dimval->insert();
							$dvid = $dimvalid;
							$codDimval = encrypt_tool_element($dimvalid);
							$dimvalsCod[$codDimval] = $dvid;						
							$this->valoresId[$id][$dim][$grado] = $codDimval;
							
							$recalculate = true;
						}
						$div_pos++;
					}
					
					$sub_pos = 0;
					foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
						$idSubdim = $this->subdimensionsId[$id][$dim][$subdim];
						if(isset($subdimensionsCod[$idSubdim])){ 
							$update = false;
							$id_plane_sub = $subdimensionsCod[$idSubdim];
							if($subdimensions[$id_plane_sub]->sub_por != $this->subdimpor[$id][$dim][$subdim]){
								$update = true;
								$recalculate = true;
								//$destroy = true;
							}
							if($subdimensions[$id_plane_sub]->sub_nom != $this->subdimension[$id][$dim][$subdim]['nombre'] || $subdimensions[$id_plane_sub]->sub_pos != $sub_pos){
								$update = true;
							}
							if($update == true){
								$subdimensions[$id_plane_sub]->sub_por = $this->subdimpor[$id][$dim][$subdim];
								$subdimensions[$id_plane_sub]->sub_atr = $this->numatr[$id][$dim][$subdim];
								$subdimensions[$id_plane_sub]->sub_nom = $this->subdimension[$id][$dim][$subdim]['nombre'];
								$subdimensions[$id_plane_sub]->sub_pos = $sub_pos;
								$subdimensions[$id_plane_sub]->update();
							}
							unset($subdimensions[$id_plane_sub]);
						}
						else{
							$dimensionId = $this->dimensionsId[$id][$dim]; 
							$dim_plane = $dimensionsCod[$dimensionId]; 
							$params_subdimension['sub_dim'] = $dim_plane;
							$params_subdimension['sub_nom'] = $this->subdimension[$id][$dim][$subdim]['nombre'];
							$params_subdimension['sub_por'] = $this->subdimpor[$id][$dim][$subdim];
							$params_subdimension['sub_pos'] = $sub_pos;
							$subdimension = new subdimension($params_subdimension);
							$subdimensionid = $subdimension->insert();
							$sid = $subdimensionid; 
							$codSubdim = encrypt_tool_element($subdimensionid);
							$subdimensionsCod[$codSubdim] = $sid;						
							$this->subdimensionsId[$id][$dim][$subdim] = $codSubdim;						
							$recalculate = true;
							//$destroy = true;
						}
						
						$atr_pos = 0;
						foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
							
							$atr_com = '0';
							if($this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
								$atr_com = '1';
							}
							$idAtributo = $this->atributosId[$id][$dim][$subdim][$atrib];
							if(isset($atributosCod[$idAtributo])){
								$id_plane_atr = $atributosCod[$idAtributo];
								$update = false;
								if($atributos[$id_plane_atr]->atr_por != $this->atribpor[$id][$dim][$subdim][$atrib]){
									$update = true;
									$recalculate = true;
									//$destroy = true;
								}
								if($atributos[$id_plane_atr]->atr_des != $this->atributo[$id][$dim][$subdim][$atrib]['nombre'] || 
									$atributos[$id_plane_atr]->atr_com != $atr_com || $atributos[$id_plane_atr]->atr_pos != $atr_pos){
									$update = true;
								}
								if($update == true){
									$atributos[$id_plane_atr]->atr_por = $this->atribpor[$id][$dim][$subdim][$atrib];
									$atributos[$id_plane_atr]->atr_des = $this->atributo[$id][$dim][$subdim][$atrib]['nombre'];
									$atributos[$id_plane_atr]->atr_com = $atr_com;
									$atributos[$id_plane_atr]->atr_pos = $atr_pos;
									$atributos[$id_plane_atr]->update();
								}
								unset($atributos[$id_plane_atr]);
							}
							else{
								$subdimensionId = $this->subdimensionsId[$id][$dim][$subdim]; 
								$subdim_plane = $subdimensionsCod[$subdimensionId]; 
								$params_attribute['atr_sub'] = $subdim_plane;
								$params_attribute['atr_des'] = $this->atributo[$id][$dim][$subdim][$atrib]['nombre'];
								$params_attribute['atr_por'] = $this->atribpor[$id][$dim][$subdim][$atrib];
								$params_attribute['atr_com'] = $atr_com;
								$params_attribute['atr_pos'] = $atr_pos;
								$atributo = new atributo($params_attribute);
								$attributeid = $atributo->insert();
								$aid = $attributeid; 
								$codatributo = encrypt_tool_element($attributeid);
								$atributosCod[$codatributo] = $aid;						
								$this->atributosId[$id][$dim][$subdim][$atrib] = $codatributo;						
								$recalculate = true;
							}
							$atr_pos++;
						}
						$sub_pos++;
					}
					$dim_pos++;
				}
				
				if(!empty($dimensions)){
					foreach($dimensions as $dimension){
						$dimension->delete();
					}
					$recalculate = true;
				}
				
				if(!empty($subdimensions)){
					foreach($subdimensions as $subdimension){
						$subdimension->delete();
					}
					$recalculate = true;
				}
				
				if(!empty($atributos)){
					foreach($atributos as $atributo){
						$atributo->delete();
					}
					$recalculate = true;
				}
				
				if(!empty($dimvals)){
					foreach($dimvals as $dimval){
						$dimval->delete();
					}
					$recalculate = true;
				}
				
			}
			
			/*TODO: Donde digo $destroy digo $recalculate y si $recalculate == true establezco la nueva variable plantilla->pla_mod = '1' y,
			a continuación, busco todos los assessments asociados y les recalculo el ass_grd*/
			
			if($destroy == true){
				$dimensions = dimension::fetch_all(array('dim_pla' => $tableid));
				foreach($dimensions as $keydim => $object){
					$subdimens = subdimension::fetch_all(array('sub_dim' => $object->id));
					foreach($subdimens as $sub){
						$atribs = atributo::fetch_all(array('atr_sub' => $sub->id));
						foreach($atribs as $atr){
							$atrevas = atreva::fetch_all(array('ate_atr' => $atr->id));
							foreach($atrevas as $atreva){
								$atreva->delete();
							}
							$atrcomments = atrcomment::fetch_all(array('atc_atr' => $atr->id));
							foreach($atrcomments as $atrcom){
								$atrcom->delete();
							}
						}
					}
					$object->delete();
				}
				$this->dimensionsId = array();
				//DIMENSIONS------------------
				$dim_position = 0;
				foreach($this->dimension[$id] as $dim => $itemdim){
					$dim_glo = '0';
					$dim_com = '0';
					
					$params_dimension['dim_pla'] = $tableid;
					$params_dimension['dim_nom'] = $this->dimension[$id][$dim]['nombre'];
					$params_dimension['dim_por'] = $this->dimpor[$id][$dim];
					$params_dimension['dim_glo'] = $dim_glo;
					$params_dimension['dim_sub'] = $this->numsubdim[$id][$dim];
					$params_dimension['dim_com'] = $dim_com;
					$params_dimension['dim_pos'] = $dim_position;
					$dimension = new dimension($params_dimension);
					$dimensionid = $dimension->insert();
					$codDim = encrypt_tool_element($dimensionid);
					$this->dimensionsId[$id][$dim] = $codDim;
					
					$dim_pos = 0;
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						$params_value['val_cod'] = $elemvalue['nombre'];
						if(!$valoracion = valoracion::fetch($params_value)){
							$valoracion = new valoracion($params_value);
							$valoracionid = $valoracion->insert();
						}
						
						$params_dimval['div_dim'] = $dimensionid;
						//$params_dimval['div_val'] = $valoracionid;
						$params_dimval['div_val'] = $elemvalue['nombre'];
						$params_dimval['div_pos'] = $dim_pos;
						$dimval = new dimval($params_dimval);
						$dimval->insert();
						$dim_pos++;
					}
					
					$sub_pos = 0;
					foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
						$params_subdimension['sub_dim'] = $dimensionid;
						$params_subdimension['sub_nom'] = $this->subdimension[$id][$dim][$subdim]['nombre'];
						$params_subdimension['sub_por'] = $this->subdimpor[$id][$dim][$subdim];
						$params_subdimension['sub_pos'] = $sub_pos;
						$subdimension = new subdimension($params_subdimension);
						$subdimensionid = $subdimension->insert();
						$codSubdim = encrypt_tool_element($subdimensionid);
						$this->subdimensionsId[$id][$dim][$subdim] = $codSubdim;
						
						$atr_pos = 0;
						foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
							$atr_com = '0';
							if($this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
								$atr_com = '1';
							}
							$params_attribute['atr_sub'] = $subdimensionid;
							$params_attribute['atr_des'] = $this->atributo[$id][$dim][$subdim][$atrib]['nombre'];
							$params_attribute['atr_por'] = $this->atribpor[$id][$dim][$subdim][$atrib];
							$params_attribute['atr_com'] = $atr_com;
							$params_attribute['atr_pos'] = $atr_pos;
							$atributo = new atributo($params_attribute);
							$attributeid = $atributo->insert();
							$codAtributo = encrypt_tool_element($attributeid);
							$this->atributosId[$id][$dim][$subdim][$atrib] = $codAtributo;
							$atr_pos++;
						}
						$sub_pos++;
					}
					$dim_position++;
				}
			}
			
			$params_result = array();
			if($recalculate == true){				
				include_once('../classes/assessment.php');
				if($assessments = assessment::fetch_all(array('ass_pla' => $tableid))){
					$plantilla->pla_mod = '1';
					$plantilla->pla_glo = '0';
					$plantilla->update();
					include_once('../lib/finalgrade.php');
					foreach($assessments as $assessment){
						$finalgrade = finalgrade($assessment->id, $tableid);
						$gradexp = explode('/', $finalgrade);
						$params['ass_grd'] = $gradexp[0];
						$params['ass_mxg'] = $gradexp[1];
						//$params['ass_com'] = $assessment->ass_com;
						assessment::set_properties($assessment, $params);
						$assessment->update();
					}
				}
				$params_result['recalculate'] = true;
			}
			
			$params_result['xml'] = $this->export(array('mixed' => '1', 'id' => $cod));
			return $params_result;
		}
		
		
		/**Exporta el instrumento en formato XML
			@param $mixed
				0 --> No forma parte de un instrumento mixto o no se desea cabecera xsd
				1 --> Sí forma parte de un instrumento mixto o sí se desea cabecera xsd
			@param $id 
		*/
		function export($params = array()){
			$id = $this->id;
			
			$mixed = 0;
			if(isset($params['mixed'])){
				$mixed = $params['mixed'];
			}
			$idtool = '';
			if(isset($params['id'])){
				$idtool = $params['id'];
			}
			
			$root = '';
			$rootend = '';
			$percentage1 = '';
			if($mixed == '0'){
				$root = '<cl:ControlList xmlns:cl="http://avanza.uca.es/assessmentservice/controllist"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/controllist http://avanza.uca.es/assessmentservice/ControlList.xsd"
	';
				$rootend = '</cl:ControlList>
	';
			}
			elseif($mixed == '1'){
				$root = '<ControlList ';
				$rootend = '</ControlList>';
				$percentage1 = ' percentage="' . $this->porcentage . '"';
			}
		
			//ROOT-----------------------
			$xml = $root . ' id="'. $idtool .'" name="' . htmlspecialchars($this->titulo) . '" dimensions="' . $this->numdim[$id] .'" ' . $percentage1 . '>
			';
			
			if(isset($this->observation[$id])){
				$xml .= '<Description>' . htmlspecialchars($this->observation[$id]) . '</Description>
				';
			}

			//DIMENSIONS------------------
			foreach($this->dimension[$id] as $dim => $itemdim){
				$xml .=  '<Dimension id="'.$this->dimensionsId[$id][$dim].'" name="' . htmlspecialchars($this->dimension[$id][$dim]['nombre']) . '" subdimensions="' . $this->numsubdim[$id][$dim] . '" values="2" percentage="' . $this->dimpor[$id][$dim] . '">
	';
			//VALUES-----------------------
				$xml .=  "<Values>\n";
				foreach($this->valores[$id][$dim] as $grado => $elemvalue){
					$xml .= '<Value id="'.$this->valoresId[$id][$dim][$grado].'">'. htmlspecialchars($this->valores[$id][$dim][$grado]['nombre']) . "</Value>\n";
				}

				$xml .=  "</Values>\n";
			
				//SUBDIMENSIONS-----------------
				foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
					$xml .=  '<Subdimension id="'.$this->subdimensionsId[$id][$dim][$subdim].'" name="' . htmlspecialchars($this->subdimension[$id][$dim][$subdim]['nombre']) . '" attributes="' . $this->numatr[$id][$dim][$subdim] . '" percentage="' . $this->subdimpor[$id][$dim][$subdim] . '">
	';
					//ATTRIBUTES--------------------
					foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
						$comment = '';
						if(isset($this->commentAtr[$id][$dim][$subdim][$atrib]) && $this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible')
							$comment = '1';
						$xml .=  '<Attribute id="'.$this->atributosId[$id][$dim][$subdim][$atrib].'" name="' . htmlspecialchars($this->atributo[$id][$dim][$subdim][$atrib]['nombre']) . '" comment="'. $comment .'" percentage="' . $this->atribpor[$id][$dim][$subdim][$atrib] . '">0</Attribute>
	';
					}

					$xml .=  "</Subdimension>\n";
				}
				$xml .=  "</Dimension>\n";
			}

			$xml .= $rootend;
			
			return $xml;
		}
		
		function display_body_view($data, $mix = '', $porcentage=''){		
			if($porcentage != '')
				$this->porcentage = $porcentage;
			if(isset($data['titulo'.$this->id]))
				$this->titulo = stripslashes($data['titulo'.$this->id]);
			
			if(isset($data['valtotal'.$this->id]))
				$this->valtotal[$this->id] = stripslashes($data['valtotal'.$this->id]);
			
			if(isset($data['numvalores'.$this->id]) && $data['numvalores'.$this->id] >= 2)
				$this->numtotal[$this->id] = stripslashes($data['numvalores'.$this->id]);
			
	
			include($this->filediccionario);
			$numdimen = count($this->dimension[$this->id]);
			
			$id = $this->id;
			//----------------------------------------------TODO
			echo '
			<div id="cuerpo'.$id.'"  class="cuerpo">
				<br>
				<label for="titulo'.$id.'" style="margin-left:1em">'.$string['checklist'].':</label><span class="labelcampo">
					<span class="titulovista">'.$this->titulo.'</span>
				</span>
				';
			if(isset($mix) && is_numeric($mix)){
				echo '
				<span class="labelcampo">
					<label for="toolpor_'.$id.'">'.$string['porvalue'].'</label>
					<input class="porcentaje" type="text" name="toolpor_'.$id.'" id="toolpor_'.$id.'" value="'.$this->porcentage.'" onkeyup=\'javascript:if(document.getElementById("toolpor_'.$id.'").value > 100)document.getElementById("toolpor_'.$id.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
					<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("body", "id='.$id.'&toolpor_'.$id.'="+document.getElementById("toolpor_'.$id.'").value+"&addtool'.$id.'=1", "mainform0");\'>
				</span>';
			}
			
			echo '<br/>';
			flush();
			foreach($this->dimension[$id] as $dim => $value){
				echo '<div class="dimension" id="dimensiontag'.$id.'_'.$dim.'">';
				$this->display_dimension_view($dim, $data, $id, $mix);
				echo '</div>';
			}
			
			if(!is_numeric($mix)){
				if(isset($data['observation'.$id]))
					$this->observation[$id] = stripslashes($data['observation'.$id]);
				
				echo '
				<div id="comentario">
					<div id="marco">
						<label for="observation'.$id.'">' . $string['observation']. ':</label>
						<textarea id="observation'.$id.'" style="width:100%" rows="4" cols="200">' . $this->observation[$id] . '</textarea>
					</div>
				</div>
				';
			}
			echo '</div>
			
			';
			flush();
		}
		
		
		function display_dimension_view($dim, $data, $id=0, $mix=''){
			$id = $this->id;
			if(isset($data['dimension'.$id.'_'.$dim])) 
				$this->dimension[$this->id][$dim]['nombre'] = stripslashes($data['dimension'.$id.'_'.$dim]);
			
			if(isset($data['numvalores'.$id.'_'.$dim]) && $data['numvalores'.$id.'_'.$dim] > 1) 
				$this->numvalores[$this->id][$dim] = stripslashes($data['numvalores'.$id.'_'.$dim]);

			if(isset($data['valglobal'.$id.'_'.$dim]))
			
				$this->valglobal[$this->id][$dim] = stripslashes($data['valglobal'.$dim]);
			
			$checked = '';
			if($this->valglobal[$this->id][$dim] == "true"){
				$globalchecked = 'checked';
			}
			include($this->filediccionario);
			

			echo '
			<div class="margin">
				<label for="dimension'.$id.'_'.$dim.'">'.$string['dimension'].'</label>
				<span class="labelcampo">
					<span class="dimensionvista">'. $this->dimension[$id][$dim]['nombre'] .'</span>
				</span>
			';
			echo '
				<span class="labelcampo"><label for="dimpor'.$id.'_'.$dim.'">'.$string['porvalue'].'</label><span class="labelcampo">
				<input class="porcentaje" type="text" maxlength="3" name="dimpor'.$id.'_'.$dim.'" id="dimpor'.$id.'_'.$dim.'" value="'.$this->dimpor[$this->id][$dim].'" onkeyup=\'javascript:if(document.getElementById("dimpor'.$id.'_'.$dim.'").value > 100)document.getElementById("dimpor'.$id.'_'.$dim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
				<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&dimpor'.$id.'="+document.getElementById("dimpor'.$id.'_'.$dim.'").value+"&dpi='.$dim.'&addDim=1", "mainform0");\'></span>';
		
			if(isset($this->subdimension[$this->id][$dim])){
				foreach($this->subdimension[$this->id][$dim] as $subdim => $elemsubdim){
					echo '								
						<div class="subdimension" id="subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'">
					';
					$this->display_subdimension_view($dim, $subdim, $data, $id, $mix);
					echo '</div>					
					';
				}				
			}
			
			echo '</div>';
		
			
			flush();
		}		
		function display_subdimension_view($dim, $subdim, $data, $id='0', $mix=''){
			$id = $this->id;
			include($this->filediccionario);
			if(isset($data['subdimension'.$id.'_'.$dim.'_'.$subdim])) 
				$this->subdimension[$id][$dim][$subdim]['nombre'] = stripslashes($data['subdimension'.$id.'_'.$dim.'_'.$subdim]);
				
			echo '
					<div class="margin">
						<label for="subdimension'.$id.'_'.$dim.'_'.$subdim.'">'.$string['subdimension'].'</label>
						<span class="labelcampo" >
						<span class="subdimensionvista">'.$this->subdimension[$this->id][$dim][$subdim]['nombre'].'</span>
					</span>
			';
		
			echo '
						<span class="labelcampo"><label for="subdimpor'.$id.'_'.$dim.'_'.$subdim.'">'.$string['porvalue'].'</label><span class="labelcampo">
						<input class="porcentaje" type="text" maxlength="3" id="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" name="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" value="'.$this->subdimpor[$this->id][$dim][$subdim].'" onkeyup=\'javascript:if(document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value > 100)document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
						<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&subdimpor="+document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value+"&spi='.$subdim.'&addSubDim='.$dim.'", "mainform0");\'>
						</span><br>
				<br>
						<table class="maintable">
							<tr><th/><th/>
							<th style="text-align:right;"><span class="font">'.$string['attribute'].'</span>  <span class="atributovalores" style="font-size:1em">/</span> <span class="atributovalores">'.$string['values'].'</span></th>
						';
			foreach($this->valores[$this->id][$dim] as $grado => $elemvalue){
				if(isset($data['valor'.$id.'_'.$dim.'_'.$grado])) 
					$this->valores[$this->id][$dim][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$dim.'_'.$grado]);
					
				echo '<th class="grado"><input class="valores" onkeyup=\'javascript:var valores=document.getElementsByName("valor'.$id.'_'.$dim.'_'.$grado.'");for(var i=0; i<valores.length; i++){valores[i].value=this.value;}\' type="text" id="valor'.$id.'_'.$dim.'_'.$grado.'" name="valor'.$id.'_'.$dim.'_'.$grado.'" value="'.$this->valores[$this->id][$dim][$grado]['nombre'].'"/></th>
				';
			}
			echo '</tr>';
			$numAtributo = count($this->atributo[$this->id][$dim][$subdim]);
			if(isset($this->atributo[$this->id][$dim][$subdim])){
				foreach($this->atributo[$this->id][$dim][$subdim] as $atrib => $elematrib){
					if(isset($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributo[$this->id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					
					echo '			<tr>
								<td style="">';
					echo '
								</td>
											
								<td><input class="porcentaje" type="text" onkeyup=\'javascript:if(document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value > 100)document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'  maxlength="3" name="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" id="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" value="'.$this->atribpor[$this->id][$dim][$subdim][$atrib].'"/>
								<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&atribpor="+document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value+"&api='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'></td>
								<td><span class="atributovista">'.$this->atributo[$this->id][$dim][$subdim][$atrib]['nombre'].'</span></td>
								';
					foreach($this->valores[$this->id][$dim] as $grado => $elemvalue){
						echo '<td><input type="radio" name="radio'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
						';
					}	
								
					echo '</tr>';
				}
			}
			echo '</table>
					</div>
			';
			
			flush();
		}
		
		function print_tool($global_comment = 'global_comment'){
			include($this->filediccionario);
			$id = $this->id;
			
			echo '
								<table class="tabla" border=1 cellpadding=5px >
								
								<!--TITULO-INSTRUMENTO------------>
			';
			if(is_numeric($this->porcentage)){
				echo '
								<tr>
								   <td colspan="4">'. $string['mixed_por']. ': ' . $this->porcentage.'%</td>
								</tr>
				';
			}
			
			echo '
								<tr>
								   <th colspan="4">'.htmlspecialchars($this->titulo).'</th>
								</tr>

								<tr>
								   <th colspan="4"></th>
								</tr>

								
								<tr>
								   <td></td>
								   <td></td>
								</tr>';
			$i = 0;
			foreach($this->dimension[$id] as $dim => $value){
				echo '	
								<tr id="dim">
									<!--DIMENSIÓN-TITLE----------->
									<td class="pordim">
									'.$this->dimpor[$this->id][$dim].'%
									</td>
									<td class="bold" colspan="1">
										<span>'.htmlspecialchars($this->dimension[$this->id][$dim]['nombre']).'</span>
									</td>
				';
				foreach($this->valores[$this->id][$dim] as $grado => $elemvalue){
					echo '
									<td class="td">'.htmlspecialchars($this->valores[$this->id][$dim][$grado]['nombre']).'</td>
					';
				}
				
				echo '
								</tr>
				';
				
				$l = 0;
				foreach($this->subdimension[$this->id][$dim] as $subdim => $elemsubdim){
					echo '
								<!--TITULO-SUBDIMENSIÓN------------>
								<tr>
									<td class="subdimpor">'.$this->subdimpor[$this->id][$dim][$subdim].'%</td>
									<td class="subdim" colspan="3">'.htmlspecialchars($this->subdimension[$this->id][$dim][$subdim]['nombre']).'</td></tr>
					';
					$j = 0;
					if(isset($this->atributo[$this->id][$dim][$subdim])){
						foreach($this->atributo[$this->id][$dim][$subdim] as $atrib => $elematrib){

							echo '
								<!--ATRIBUTOS---------------------->
								<tr rowspan=0>
									<td class="atribpor">'.$this->atribpor[$this->id][$dim][$subdim][$atrib].'%</td>
									<td colspan="1">'.htmlspecialchars($this->atributo[$this->id][$dim][$subdim][$atrib]['nombre']).'</td>
							';
							$k = 1;
							foreach($this->valores[$id][$dim] as $grado => $elemvalue){
								$checked = '';

								if(isset($this->valueattribute[$id][$dim][$subdim][$atrib]) && $this->valueattribute[$id][$dim][$subdim][$atrib] == $this->valores[$id][$dim][$grado]['nombre']){
									$checked = 'checked';
								}
								
								echo "
								<td class='td'><input type='radio' name='radio".$i.$l.$j."' value='".$k."' ".$checked." style='width:100%'></td>
								";
								++$k;
							}
							
							echo '
								</tr>
							';
							
							if(isset($this->commentAtr[$id][$dim][$subdim][$atrib]) && $this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
								$vcomment = '';
								if(isset($this->valuecommentAtr[$id][$dim][$subdim][$atrib])){
									$vcomment = htmlspecialchars($this->valuecommentAtr[$id][$dim][$subdim][$atrib]);
								}
								
								echo '
								<tr>
									<td colspan="2"></td>
									<td colspan="5">
										<textarea rows="2" style="height:6em;width:100%" id=""observaciones'.$i.'_'.$l.'_'.$j.'" name="observaciones'.$i.'_'.$l.'_'.$j.'" style="width:100%">'.$vcomment.'</textarea>
									</td>
								</tr>
								';
							}
							
							++$j;
						}
						
					}
					++$l;
				}
				++$i;
			}
			
			echo '
							</table>
			';
			if($global_comment == 'global_comment'){
				echo "<br><label for='observaciones'>". strtoupper($string['comments'])."</label><br>
                           <textarea name='observaciones' id='observaciones' rows=4 cols=20 style='width:100%'>".htmlspecialchars($this->observation[$id])."</textarea>";
			}
		}
	}
?>
