<?php
	/**
		Representa un instrumento de evaluación genérico
	*/
	class tooldifferential{
		//string
		private $titulo;
		
		//array -- titulo de cada dimensiones
		private $dimension;
		
		//array -- número de dimensiones de cada dimensión
		private $numdim;
		
		//array -- titulo de cada subdimensión de cada dimensión
		private $subdimension;
		
		//array -- número de subdimensiones de cada subdimensión
		private $numsubdim;
		
		//array -- titulo de cada atributo de cada subdimensión de cada dimensión
		private $atributo;
		
		//array -- número de atributos de cada subdimensión
		private $numatr;
		
		//array -- valores de cada dimensión
		private $valores;
		
		//array -- número de valores de cada dimensión
		private $numvalores;
		
		//boolean -- indica si el instrumento tiene activada la valoración total
		private $valtotal;
		
		//integer -- número de grados de la valoración total
		private $numtotal;
		
		//array -- grados de la valoración total
		private $valorestotal;
		
		//integer -- porcentaje de la valoración total
		private $valtotalpor;
		
		//array -- indica si está activada la valoración global por cada dimensión
		private $valglobal;
		
		//array -- porcentaje de la valoración global de cada dimensión
		private $valglobalpor;
		
		//string -- url del diccionario por defecto
		private $filediccionario;
		
		//array -- porcentaje de las dimensiones
		private $dimpor;
		
		//array -- porcentaje de las subdimensiones
		private $subdimpor;
	
		//array -- porcentaje de los atributos
		private $atribpor;
		
		//array -- atributos positivos
		private $atributopos;
		
		//id
		private $id;
		
		//En caso de formar parte de un instrumento mixto, almacenará el valor porcentaje
		private $porcentage;
			
		//string -- comentarios
		private $observation;
		
		//'view' | 'design' -- indica si el instrumento está en modo diseño o vista previa
		private $view;
		
		//Array -- Almacena si los atributos tienen activados los comentarios o no
		private $commentAtr;
		
		private $dimensionsId;
		
		//Array -- Almacena los IDs de la BD relativos a las subdimensiones
		private $subdimensionsId;
		
		//Array -- Almacena los IDs de la BD relativos a los atributos
		private $atributosId;
		
		//Array -- Almacena los IDs de la BD relativos a los atributos
		private $atributosposId;
		
		//Array -- Almacena los IDs de la BD relativos a los valores de las dimensiones
		private $valoresId;
		
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
		function get_valglobalpor(){return $this->valglobalpor[$this->id];}
		function get_dimpor(){return $this->dimpor[$this->id];}
		function get_subdimpor(){return $this->subdimpor[$this->id];}
		function get_atribpor(){return $this->atribpor[$this->id];}
		function get_commentAtr($id = 0){return $this->commentAtr[$this->id];}
		function get_porcentage(){return $this->porcentage;}
		function get_dimensionsId(){return $this->dimensionsId[$this->id];}
		function get_subdimensionsId(){return $this->subdimensionsId[$this->id];}
		function get_atributosId(){return $this->atributosId[$this->id];}
		function get_valoresId(){return $this->valoresId[$this->id];}
		function get_valorestotalesId(){return null;}
		function get_atributopos(){return $this->atributopos[$this->id];}
		function get_atributosposId(){return $this->atributosposId[$this->id];}
		
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
		function set_atributopos($atributo){$this->atributopos[$this->id] = $atributo;}
		function set_atributosposId($atributo, $id){$this->atributosposId[$this->id] = $atributo;}

		
		function __construct($lang='es_utf8', $titulo, $dimension, $numdim = 1, $subdimension, $numsubdim = 1, $atributo, $numatr = 1, $valores, $numvalores = 2, $valtotal, $numtotal = 0, $valorestotal, $valglobal = false, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $id=0, $observation='', $porcentage=0, $atributopos = null, $valueattribute = '', $valuecommentAtr = '', $params = array()){
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
			$this->atributopos = $atributopos;
			$this->view = 'design';
			$this->commentAtr = $commentAtr;
			
			$this->valueattribute = $valueattribute;
			$this->valuecommentAtr = $valuecommentAtr;
		
			if(!isset($this->atributopos)){
				include($this->filediccionario);
				foreach($this->atributo[$this->id] as $dim => $value1){
					$this->numvalores[$this->id][$dim]++;
					$this->valores[$this->id][$dim][3]['nombre'] = $string['titlevalue'].$this->numvalores[$this->id][$dim];
					foreach($value1 as $subdim => $value2){
						foreach ($value2 as $atrib => $value3){
							$this->atributo[$this->id][$dim][$subdim][$atrib]['nombre'] = $string['noatrib'].$this->numatr[$this->id][$dim][$subdim];
							$this->atributopos[$this->id][$dim][$subdim][$atrib]['nombre'] = $string['yesatrib'].$this->numatr[$this->id][$dim][$subdim];
						}
					}
				}
			}
			
			if(!empty($params['dimensionsId'])){
				$this->dimensionsId = $params['dimensionsId'];
			}
			if(!empty($params['subdimensionsId'])){
				$this->subdimensionsId = $params['subdimensionsId'];
			}
			if(!empty($params['atributosId'])){
				$this->atributosId = $params['atributosId'];
			}
			if(!empty($params['atributosposId'])){
				$this->atributosposId = $params['atributosposId'];
			}
			if(!empty($params['valoresId'])){
				$this->valoresId = $params['valoresId'];
			}
			$this->dimensionsId[$this->id] = array('0' => 'aux');
			$this->subdimensionsId[$this->id][0][0] = 'aux';
		}
		
		function addAtributo($dim, $subdim, $atrib, $key){
			include($this->filediccionario);
			$id = $this->id;
			$this->numatr[$id][$dim][$subdim]++;
	
			if(!isset($atrib)){
				$atrib = $key;
				$this->atributo[$id][$dim][$subdim][$atrib]['nombre'] = $string['noatrib'].$this->numatr[$id][$dim][$subdim];
				$this->atributopos[$id][$dim][$subdim][$atrib]['nombre'] = $string['yesatrib'].$this->numatr[$id][$dim][$subdim];
			}
			else{
				$newindex = $key;
				$elem['nombre'] = $string['noatrib'].$this->numatr[$id][$dim][$subdim];
				$this->atributo[$id][$dim][$subdim] = $this->arrayAdd($this->atributo[$id][$dim][$subdim], $atrib, $elem, $newindex);
				$elem['nombre'] = $string['yesatrib'].$this->numatr[$id][$dim][$subdim];
				$this->atributopos[$id][$dim][$subdim] = $this->arrayAdd($this->atributopos[$id][$dim][$subdim], $atrib, $elem, $newindex);
				$this->commentAtr[$id][$dim][$subdim][$newindex]= 'hidden';
			}			
		}
		
		
		function addValores($dim, $key){
			include($this->filediccionario);
			$id = $this->id;
			$this->numvalores[$id][$dim]++;
			$this->valores[$id][$dim][$key]['nombre'] = $string['titlevalue'].$this->numvalores[$id][$dim];
		}
		
		
		
		function eliminaDimension($dim){			
		}
		
		function eliminaSubdimension($dim, $subdim){
		}
		
		function eliminaAtributo($dim, $subdim, $atrib){
			$id = $this->id;
			if(isset($this->atributo[$id][$dim][$subdim][$atrib])){
				if($this->numatr[$id][$dim][$subdim] > 1){
					$this->numatr[$id][$dim][$subdim]--;		
					$this->atributo[$id][$dim][$subdim] = $this->arrayElimina($this->atributo[$id][$dim][$subdim], $atrib);
					$this->atribpor[$id][$dim][$subdim] = $this->arrayElimina($this->atribpor[$id][$dim][$subdim], $atrib);
					$this->atributopos[$id][$dim][$subdim] = $this->arrayElimina($this->atributopos[$id][$dim][$subdim], $atrib);
				}
			}
			return 1;
		}
		
		
		function eliminaValores($dim, $grado){
			$id = $this->id;
			if($this->numvalores[$id][$dim] > 2){
				$this->numvalores[$id][$dim]--;
				$this->valores[$id][$dim] = $this->arrayElimina($this->valores[$id][$dim], $grado);	
			}
		}
		
		function display_header(){
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<link href="style/copia.css" type="text/css" rel="stylesheet">
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<script type="text/javascript" src="javascript/tamaño.js"></script>
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
								//patron =/[A-Za-zñÑ\s/./-/_/:/;]/;
								patron = /\d/;
							te = String.fromCharCode(tecla);
							return patron.test(te);
						} 
					</script>
				</head>
	
				<body id="body" class="cuerpo">
					<div id="cabecera">
						<div id="menu">				
							<img id="guardar" src="images/guardar.png" onmouseover="javascript:cAmbiaOver(this.id, \'images/guardarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/guardar.png\');" alt="Guardar" title="Guardar"/>
							<img id="importar" src="images/importar.png" alt="Importar" title="Importar" onmouseover="javascript:cAmbiaOver(this.id, \'images/importarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/importar.png\');"/>
							<img id="exportar" src="images/exportar.png" alt="Exportar" title="Exportar" onmouseover="javascript:cAmbiaOver(this.id, \'images/exportarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/exportar.png\');"/>
							<a onClick="MasTxt(\'cuerpo\');" href=#><img id="aumentar" src="images/aumentar.png" alt="Aumentar" title="Aumentar tamaño de fuente" onmouseover="javascript:cAmbiaOver(this.id, \'images/aumentarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/aumentar.png\');"/></a>
							<a onClick="MenosTxt(\'cuerpo\');" href=#><img id="disminuir" src="images/disminuir.png" alt="Disminuir" title="Disminuir tamaño de fuente" onmouseover="javascript:cAmbiaOver(this.id, \'images/disminuirhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/disminuir.png\');"/></a>
							<img id="imprimir" src="images/imprimir.png" alt="Imprimir" title="Imprimir" onmouseover="javascript:cAmbiaOver(this.id, \'images/imprimirhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/imprimir.png\');"/>
							<img id="ayudar" src="images/ayuda.png" alt="Ayuda" title="Ayuda" onmouseover="javascript:cAmbiaOver(this.id, \'images/ayudahover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/ayuda.png\');"/>
							<img id="acerca" src="images/acerca.png" alt="Acerca de" title="Acerca de" onmouseover="javascript:cAmbiaOver(this.id, \'images/acercahover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/acerca.png\');"/>
						</div>
					</div>';						
			flush();
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
				case 'atributopos':{
					$this->atributopos[$id][$dim][$subdim] = $blockData;
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
		
		function display_body($data, $mix='', $porcentage=''){
			$id = $this->id;
			if($porcentage != '')
				$this->porcentage = $porcentage;
			foreach($this->dimension[$id] as $dim => $elemdim){
				foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
					echo '<div id="subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'">';
					$this->display_subdimension($dim, $subdim, $data, $id, $mix);
					echo '</div>';					
				}
			}
		}
		
		function display_footer(){
			echo '
				</body>
			</html>';
		}

		function display_dimension($dim, $data, $id=0, $mix=''){
		}		
		
		function display_subdimension($dim, $subdim, $data, $id=0, $mix=''){
			$id = $this->id;
			if(isset($data['titulo'.$this->id]))
				$this->titulo = stripslashes($data['titulo'.$this->id]);
			if(isset($data['numvalores'.$id.'_'.$dim]) && $data['numvalores'.$id.'_'.$dim] > 0){ 
				$this->numvalores[$id][$dim] = stripslashes($data['numvalores'.$id.'_'.$dim]);
			}

			$checked = '';
			$disabled = 'disabled';
	
			include($this->filediccionario);
			if($this->view == 'view' && !is_numeric($mix)){
				echo '<input type="button" style="width:10em" value="'.$string['view'].'" onclick=\'javascript:location.href="generator.php?op=design"\'><br>';
			}
			
			$numdimen = 1;
			//----------------------------------------------
			$id = $this->id;
			//----------------------------------------------
			echo '
			<div id="cuerpo'.$id.'">
				<label for="titulo'.$id.'">'.$string['differentail'].':</label><span class="labelcampo">
					<textarea class="width" id="titulo'.$id.'" name="titulo'.$id.'">'.$this->titulo.'</textarea></span>
			';
			if($this->view == 'design')
				echo '
				<label for="numatributos'.$id.'_'.$dim.'_'.$subdim.'">'.$string['numattributes'].'</label>
				<span class="labelcampo"><input type="text" id="numatributos'.$id.'_'.$dim.'_'.$subdim.'" name="numatributos'.$id.'_'.$dim.'_'.$subdim.'" value="'.$this->numatr[$id][$dim][$subdim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
				<label for="numvalores'.$id.'_'.$dim.'">'.$string['numvalues'].'</label>
				<span class="labelcampo"><input type="text" id="numvalores'.$id.'_'.$dim.'" name="numvalores'.$id.'_'.$dim.'" value="'.$this->numvalores[$id][$dim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
				<input class="flecha" type="button" id="addAtr" name="addAtr" style="font-size:1px" 
				onclick=\'javascript:if(!validarEntero(document.getElementById("numatributos'.$id.'_'.$dim.'_'.$subdim.'").value)){alert("' . $string['AAttribute'] . '");} 
				if((!validarEntero(document.getElementById("numvalores'.$id.'_'.$dim.'").value) ||
				(document.getElementById("numvalores'.$id.'_'.$dim.'").value)%2==0)){alert("' . $string['ADiferencial'] . '"); return false;}sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addAtr="+this.value+"", "mainform0", "mainform0");\' value="'.$dim.'_'.$subdim.'"/>
			';
			if(isset($mix) && is_numeric($mix)){
				echo '
				<span class="labelcampo">
					<label for="toolpor_'.$id.'">'.$string['porvalue'].'</label>
					<input class="porcentaje" type="text" name="toolpor_'.$id.'" id="toolpor_'.$id.'" value="'.$this->porcentage.'" onchange=\'document.getElementById("sumpor").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("toolpor_'.$id.'").value > 100)document.getElementById("toolpor_'.$id.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
					<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("body", "id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&toolpor_'.$id.'="+document.getElementById("toolpor_'.$id.'").value+"&addtool'.$id.'=1", "mainform0");\'>
				</span>';
			}
			
			echo '<br/><br/>';
			include($this->filediccionario);
			if(isset($data['subdimension'.$id.'_'.$dim.'_'.$subdim])) 
				$this->subdimension[$id][$dim][$subdim]['nombre'] = stripslashes($data['subdimension'.$id.'_'.$dim.'_'.$subdim]);
				
			echo '
					<input type="hidden" id="sumpor'.$id.'_'.$dim.'_'.$subdim.'" value=""/>
					<div class="margin">
						<table class="maintable">
							<th/><th/><th/>
							<th style="background-color:#BFE4AB;text-align:right;">'.$string['novalue'].'</th>
						';
			$inicio = (int)($this->numvalores[$id][$dim] / 2);
			$valores = array();
			for($i = 0; $i < $this->numvalores[$id][$dim]; $i++){					
				$valores[$id][$dim][$i]['nombre'] = ((-1)*$inicio + $i);
				echo '<th class="grado" style="background-color:#BFE4AB;">'.((-1)*$inicio + $i).'</th>
				';
			}
			echo '<th style="text-align:left;background-color:#BFE4AB;">'.$string['yesvalue'].'</th>';
			$this->valores = $valores;
			
			$numAtributo = count($this->atributo[$id][$dim][$subdim]);
			if(isset($this->atributo[$id][$dim][$subdim])){
				foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
					if(isset($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributo[$id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					if(isset($data['atributopos'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributopos[$id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributopos'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					
					echo '	<tr>
								<td style="">
					';
			if($this->view == 'design')
				echo '
									<div style="margin-bottom:2em;">					
										<input type="button" class="delete" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addAtr='.$dim.'_'.$subdim.'&dt='.$atrib.'", "mainform0");\'>
											</div>
												<div style="margin-top:2em;">
													<input type="button" class="add" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addAtr='.$dim.'_'.$subdim.'&at='.$atrib.'", "mainform0");\'>
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
								<td><input class="porcentaje" type="text" onchange=\'document.getElementById("sumpor'.$id.'_'.$dim.'_'.$subdim.'").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value > 100)document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'  maxlength="3" name="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" id="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" value="'.$this->atribpor[$id][$dim][$subdim][$atrib].'"/></span>
								<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&atribpor="+document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value+"&api='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'></td>
								<td><span class="font"><textarea class="width" id="atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" name="atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'">'.$this->atributo[$id][$dim][$subdim][$atrib]['nombre'].'</textarea></span></td>
								';
					
					for($i = 0; $i < $this->numvalores[$id][$dim]; $i++){
						echo '<td><input type="radio" name="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
						';
					}	
					echo '					<td><span class="font"><textarea class="width" id="atributopos'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" name="atributopos'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'">'.$this->atributopos[$id][$dim][$subdim][$atrib]['nombre'].'</textarea></span></td>';
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
					</td><td/><td/>
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
					</td><td></td>
					';
				
					echo '</tr>';
					//--------------------------------------------------------
				}
			}
						echo '</table>
					</div>
				
			';
						
			echo '<input type="hidden" id="sumpor3'.$id.'" value=""/>
			</div>
			';
			flush();
		}
		
		/*
		@param $array 
		@param $i índice del elemento a eliminar en $array
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
		@param $i índice del elemento a partir del que introducirá el elemento $elem en $array
		@param $elem nuevo elemento a añadir
		@param $index indice del nuevo elemento. Si no se especifica, el nuevo índice será $i+1
		@return $array con el nuevo elemento
		Añade $elem a @array a continuación de $i.
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
		
		/**Exporta el instrumento en formato XML
			@param $mixed
				0 --> No forma parte de un instrumento mixto o no se desea cabecera xsd
				1 --> Sí forma parte de un instrumento mixto o sí se desea cabecera xsd
			@param $id 
		*/
		function export($params = array())
		{
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
				$root = '<sd:SemanticDifferential xmlns:sd="http://avanza.uca.es/assessmentservice/semanticdifferential"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://avanza.uca.es/assessmentservice/semanticdifferential http://avanza.uca.es/assessmentservice/SemanticDifferential.xsd"
		';
				$rootend = '</sd:SemanticDifferential>
		';
			}
			elseif($mixed == '1'){
				$root = '<SemanticDifferential ';
				$rootend = '</SemanticDifferential>';
				$percentage1 = ' percentage="' . $this->porcentage . '"';
			}

			foreach($this->atributo[$this->id] as $dim => $value1){
				foreach($value1 as $subdim => $value2){
					//ROOT-----------------------
					$xml = $root . ' id="'.$idtool .'" name="' . htmlspecialchars($this->titulo) . '" attributes="' . $this->numatr[$this->id][$dim][$subdim] .'" values="' . $this->numvalores[$id][$dim] . '" ' . $percentage1 . '>
';
					//DESCRIPTION----------------
					if(isset($this->observation[$id])){
						$xml .= '<Description>' . htmlspecialchars($this->observation[$id]) . '</Description>
';
					}
					//VALUES-----------------------
					$xml .= "<Values>\n";
					$inicio = (int)($this->numvalores[$id][$dim] / 2);
		
					//for($i = 0; $i < $this->numvalores[$id][$dim]; $i++){		
					//$i = 0;
					
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						//$xml .= '<Value	 id="'.$this->valoresId[$id][$dim][$i].'">'. ((-1)*$inicio + $i) . "</Value>\n";
						$xml .= '<Value id="'.$this->valoresId[$id][$dim][$grado].'">'. $elemvalue['nombre'] . "</Value>\n";
					}
					$xml .= "</Values>\n";

					foreach ($value2 as $atrib => $value3){
						$comment = '';
						if(isset($this->commentAtr[$id][$dim][$subdim][$atrib]) && $this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible')
							$comment = '1';
							
						$xml .= '<Attribute idNeg="'.$this->atributosId[$id][$dim][$subdim][$atrib].'" idPos="'.
						$this->atributosposId[$id][$dim][$subdim][$atrib].'" nameN="'
						. htmlspecialchars($this->atributo[$id][$dim][$subdim][$atrib]['nombre']) . '" nameP="' . htmlspecialchars($this->atributopos[$this->id][$dim][$subdim][$atrib]['nombre']) . '" comment="'. $comment .'" percentage="' . $this->atribpor[$id][$dim][$subdim][$atrib] . '">0</Attribute>
';
					}
				}
			}
		
			$xml .= $rootend;
			
			return $xml;
		}
		
		function display_body_view($data, $mix='', $porcentage=''){
			$id = $this->id;
			if($porcentage != '')
				$this->porcentage = $porcentage;
			foreach($this->dimension[$id] as $dim => $elemdim){
				foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
					echo '<div id="subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'">';
					$this->display_subdimension_view($dim, $subdim, $data, $id, $mix);
					echo '</div>';					
				}
			}
		}
		
		function display_dimension_view($dim, $data, $id=0, $mix=''){
		}		
		
		function display_subdimension_view($dim, $subdim, $data, $id=0, $mix=''){
			$id = $this->id;
			if(isset($data['titulo'.$this->id]))
				$this->titulo = stripslashes($data['titulo'.$this->id]);
			if(isset($data['numvalores'.$id.'_'.$dim]) && $data['numvalores'.$id.'_'.$dim] > 0) 
				$this->numvalores[$id][$dim] = stripslashes($data['numvalores'.$id.'_'.$dim]);

			$checked = '';
			$disabled = 'disabled';
	
			include($this->filediccionario);
			
			$numdimen = 1;
			//----------------------------------------------
			$id = $this->id;
			//----------------------------------------------
			echo '
			<div id="cuerpo'.$id.'">
				<label for="titulo'.$id.'">'.$string['differentail'].':</label><span class="labelcampo">
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
			
			echo '<br/><br/>';
			include($this->filediccionario);
			if(isset($data['subdimension'.$id.'_'.$dim.'_'.$subdim])) 
				$this->subdimension[$id][$dim][$subdim]['nombre'] = stripslashes($data['subdimension'.$id.'_'.$dim.'_'.$subdim]);
				
			echo '
					<div class="margin">
						<table class="maintable">
							<th/><th/>
							<th style="background-color:#BFE4AB;text-align:right;">'.$string['novalue'].'</th>
						';
			$inicio = (int)($this->numvalores[$id][$dim] / 2);
			for($i = 0; $i < $this->numvalores[$id][$dim]; $i++){					
				echo '<th class="grado" style="background-color:#BFE4AB;">'.((-1)*$inicio + $i).'</th>
				';
			}
			echo '<th style="text-align:left;background-color:#BFE4AB;">'.$string['yesvalue'].'</th>';
			
			$numAtributo = count($this->atributo[$id][$dim][$subdim]);
			if(isset($this->atributo[$id][$dim][$subdim])){
				foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
					if(isset($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributo[$id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					if(isset($data['atributopos'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributopos[$id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributopos'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					
					echo '	<tr>
								<td style="">
					';
			if($this->view == 'design')
				echo '
									<div style="margin-bottom:2em;">					
										<input type="button" class="delete" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&addAtr='.$dim.'_'.$subdim.'&dt='.$atrib.'", "mainform0");\'>
											</div>
												<div style="margin-top:2em;">
													<input type="button" class="add" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&addAtr='.$dim.'_'.$subdim.'&at='.$atrib.'", "mainform0");\'>
												</div>
				';
			echo '
											</td>
											
											<td><input class="porcentaje" type="text" onkeyup=\'javascript:if(document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value > 100)document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'  maxlength="3" name="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" id="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" value="'.$this->atribpor[$id][$dim][$subdim][$atrib].'"/></span>
											<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&atribpor="+document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value+"&api='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'></td>
											<td><span class="font"><span class="atributovista">'.$this->atributo[$id][$dim][$subdim][$atrib]['nombre'].'</span></span></td>
								';
					
					for($i = 0; $i < $this->numvalores[$id][$dim]; $i++){
						echo '<td><input type="radio" name="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
						';
					}	
					echo '					<td><span class="font">
					<span class="atributovista">'.$this->atributopos[$id][$dim][$subdim][$atrib]['nombre'].'</span>
					</span></td>';
					echo '</tr>';
				}
			}
						echo '</table>
					</div>
				
			';
						
			echo '</div>
			';
			flush();
		}
		
		function print_tool($global_comment = 'global_comment'){
			$id = $this->id;
			include($this->filediccionario);
			$colspan = max($this->numvalores[$id]);
			
			echo '
								<table class="tabla" border=1 cellpadding=5px >
								
								<!--TITULO-INSTRUMENTO------------>
			';
			if(is_numeric($this->porcentage)){
				echo '
								<tr>
								   <td colspan="'.($colspan + 3) .'">'. $string['mixed_por']. ': ' . $this->porcentage.'%</td>
								</tr>
				';
			}
			
			echo '
								<tr>
								   <th colspan="'.($colspan + 3) .'">'.htmlspecialchars($this->titulo).'</th>
								</tr>

								<tr>
								   <th colspan="'.($colspan + 3) .'"></th>
								</tr>

								
								<tr>
								   <td></td>
								   <td></td>
								</tr>';
			$i = 0;
			foreach($this->dimension[$id] as $dim => $value){
				$colspandim = $this->numvalores[$this->id][$dim];
				
				echo '	
								<tr id="dim">
									<!--DIMENSIÓN-TITLE----------->
									<td class="bold" colspan="'.($colspan - $colspandim + 2) .'"></td>
				';
				foreach($this->valores[$this->id][$dim] as $grado => $elemvalue){
					echo '
									<td class="td">'.htmlspecialchars($this->valores[$this->id][$dim][$grado]['nombre']).'</td>
					';
				}
				
				echo '	<td></td>
								</tr>
				';
				
				$l = 0;
				foreach($this->subdimension[$this->id][$dim] as $subdim => $elemsubdim){
					echo '
								<!--TITULO-SUBDIMENSIÓN------------>
								<tr><td class="subdim" colspan="'.($colspan + 1).'"></td><td></td></tr>
					';
						
					if(isset($this->atributo[$this->id][$dim][$subdim])){
						$j = 0;
						foreach($this->atributo[$this->id][$dim][$subdim] as $atrib => $elematrib){
							$indexdif = $j * 2;
							echo '
								<!--ATRIBUTOS---------------------->
								<tr rowspan=0>
									<td class="atribpor">'.$this->atribpor[$this->id][$dim][$subdim][$atrib].'%</td>
									<td colspan="'.($colspan - $colspandim + 1) .'">'.htmlspecialchars($this->atributo[$this->id][$dim][$subdim][$atrib]['nombre']).'</td>
							';

							$k = 1;
							foreach($this->valores[$id][$dim] as $grado => $elemvalue){
								$checked = '';
								if(isset($this->valueattribute[$id][$dim][$subdim][$atrib]) && $this->valueattribute[$id][$dim][$subdim][$atrib] == $this->valores[$id][$dim][$grado]['nombre']){
									$checked = 'checked';
								}
								echo '
								<td><input type="radio" name="radio'.$i.$l.$indexdif.'" value="'.$k.'" '. $checked .' style="width:100%"></td>
								';
								++$k;
							}
							echo '<td>'.htmlspecialchars($this->atributopos[$id][$dim][$subdim][$atrib]['nombre']).'</td>';
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
									<td colspan="'.$colspan.'">
										<textarea rows="2" style="height:6em;width:100%" id="observaciones'.$i.'_'.$l.'_'.$indexdif.'" name="observaciones'.$i.'_'.$l.'_'.$indexdif.'" style="width:100%">'.$vcomment.'</textarea>
									</td>
									</tr>
								';
							}
							echo '
								
								<tr></tr>
								<tr></tr>
							';
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
			if(isset($this->valorestotal[$id])){
				echo '
					<table class="tabla" border=1 cellpadding=5px >
								<tr><td class="global" colspan="1">'.strtoupper($string['totalvalue']).'</td>
				';
				
				foreach($this->valorestotal[$id] as $grado => $elemvalue){
					echo '<th>'.htmlspecialchars($this->valorestotal[$id][$grado]['nombre']).'</th>
					';
				}
			
				echo '<tr><td class="global" colspan="1"></td>';
				foreach($this->valorestotal[$id] as $grado => $elemvalue){
					echo '<td><input type="radio" name="radio'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
					';
				}					
			}

			echo '
								</tr>
							</table>
			';
			if($global_comment == 'global_comment'){
				echo "<br><label for='observaciones'>". strtoupper($string['comments'])."</label><br>
                           <textarea name='observaciones' id='observaciones' rows=4 cols=20 style='width:100%'>".htmlspecialchars($this->observation[$id])."</textarea>";
			}
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
			include_once('../classes/subdimension.php');
			include_once('../classes/atributo.php');
			include_once('../classes/atreva.php');
			include_once('../classes/atrcomment.php');
			include_once('../classes/atrdiferencial.php');
			include_once('../classes/db.php');
			include_once('../lib/weblib.php');
			
			$type = 'diferencial';
			$tableid = 0;
			
			$recalculate = false;
			$destroy = false;
			$dimvalsCod = array();
			$dimvals = array();
			$subdimensions = array();
			$atributosCod = array();
			$atributos = array();
			$maindimension = array();
			$mainsubdimension = array();
			
			$modify = 0;
			if($plantilla = plantilla::fetch(array('pla_cod' => $cod))){
				$modify = 1;
				$tableid = $plantilla->id;
			}
	
			$observation = '';
			if(isset($this->observation[$id])){
				$observation = $this->observation[$id];
			}
			$porcentage = '100';
			if(isset($this->porcentage) && $this->porcentage != ''){
				$porcentage = $this->porcentage;
			}	
			if($modify == 0){
				$params['pla_cod'] = $cod;
				$params['pla_tit'] = $this->titulo;
				$params['pla_tip'] = $type;
				$params['pla_gpr'] = 0;
				$params['pla_glo'] = 0;
				$params['pla_des'] = $observation;			
				$params['pla_por'] = $porcentage;
				
				$plantilla = new plantilla($params);
				$tableid = $plantilla->insert();
				$destroy = true;
			}
			else{
				//Comprobamos los elementos estructurales. Si no se han modificado
				$updateplantilla = false;
				if($plantilla->pla_tit != $this->titulo || $plantilla->pla_des != $this->observation[$id] || $plantilla->pla_por != $porcentage){
					$updateplantilla = true;
				}
				
				$plantilla->pla_tit = $this->titulo;
				$plantilla->pla_des = $observation;			
				$plantilla->pla_por = $porcentage;
				
				if($updateplantilla == true){
					plantilla::set_properties($plantilla, array('id' => $tableid, 'pla_glo' => '0'));
					$plantilla->update();
				}
			

				$numdim = 0;
				$numsubdim = 0;
				$numatributos = 0;
				$numvalores = 0;

				$dimensions = dimension::fetch_all(array('dim_pla' => $tableid));//print_r($dimensions);
				$numdim = count($dimensions);
				
				foreach($dimensions as $keydim => $object){					
					$maindimension = $object;
					if($dimvals_aux = dimval::fetch_all(array('div_dim' => $keydim))){
						foreach($dimvals_aux as $keydimval => $dimval_aux){
							$codDimval = encrypt_tool_element($keydimval);
							$dimvalsCod[$codDimval] = $keydimval;
							$dimvals[$keydimval] = $dimval_aux;
						}
					}

					if($subdimensions_aux = subdimension::fetch_all(array('sub_dim' => $keydim))){//print_r($dimensions);
						foreach($subdimensions_aux as $keysubdim => $subdimension_aux){							
							$mainsubdimension = $subdimension_aux;
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
				foreach($this->dimension[$id] as $dim => $elemdim){
					$div_pos = 0;
					//$inicio = (int)($this->numvalores[$id][$dim] / 2);
					//for($i = 0; $i < $this->numvalores[$id][$dim]; $i++){
						//$value = ((-1)*$inicio + $i);						
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){						
						$idDimval = $this->valoresId[$id][$dim][$grado];
						if(!isset($dimvalsCod[$idDimval])){
							//$value = ((-1)*$inicio + $i);
							$value = $elemvalue['nombre'];
							$params_value['val_cod'] = $value;
							if(!$valoracion = valoracion::fetch($params_value)){
								$valoracion = new valoracion($params_value);
								$valoracionid = $valoracion->insert();
							}

							$params_dimval['div_dim'] = $maindimension->id;
							$params_dimval['div_val'] = $value;
							$params_dimval['div_pos'] = $div_pos;
							$dimval = new dimval($params_dimval);
							$dimvalid = $dimval->insert();
							$dvid = $dimvalid;
							$codDimval = encrypt_tool_element($dimvalid);
							$dimvalsCod[$codDimval] = $dvid;			
		
							$this->valoresId[$id][$dim][$grado] = $codDimval;
							
							$recalculate = true;
						}
						else{
							$params_value['val_cod'] = $elemvalue['nombre'];
							if(!$valoracion = valoracion::fetch($params_value)){
								$valoracion = new valoracion($params_value);
								$valoracionid = $valoracion->insert();
							}
							$id_plane = $dimvalsCod[$idDimval];
							$update = false; 
							if($dimvals[$id_plane]->div_pos != $div_pos || $dimvals[$id_plane]->div_val != $elemvalue['nombre']){
								$update = true;
							}
							if($update == true){
								$dimvals[$id_plane]->div_val = $elemvalue['nombre'];
								$dimvals[$id_plane]->div_pos = $div_pos;
								$dimvals[$id_plane]->update();
							}
							unset($dimvals[$id_plane]);
						}
						++$div_pos;
					}
					
					foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
						$atr_pos = 0;
						
						$atrpos_pos = 0;
						foreach($this->atributopos[$id][$dim][$subdim] as $atrib => $elematrib){
							$atr_com = '0';
							if($this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
								$atr_com = '1';
							}
							
							$idAtributopos = $this->atributosposId[$id][$dim][$subdim][$atrib];
							if(isset($atributosCod[$idAtributopos])){
								$id_plane_atr_pos = $atributosCod[$idAtributopos];
								$update = false;
								if($atributos[$id_plane_atr_pos]->atr_por != $this->atribpor[$id][$dim][$subdim][$atrib]){
									$update = true;
									$recalculate = true;
								}
								if($atributos[$id_plane_atr_pos]->atr_des != $this->atributopos[$id][$dim][$subdim][$atrib]['nombre'] || 
									$atributos[$id_plane_atr_pos]->atr_com != $atr_com || $atributos[$id_plane_atr_pos]->atr_pos != $atrpos_pos){
									$update = true;
								}
								if($update == true){
									$atributos[$id_plane_atr_pos]->atr_por = $this->atribpor[$id][$dim][$subdim][$atrib];
									$atributos[$id_plane_atr_pos]->atr_des = $this->atributopos[$id][$dim][$subdim][$atrib]['nombre'];
									$atributos[$id_plane_atr_pos]->atr_com = $atr_com;
									$atributos[$id_plane_atr_pos]->atr_pos = $atrpos_pos;
									$atributos[$id_plane_atr_pos]->update();
								}
								unset($atributos[$id_plane_atr_pos]);
							}
							$atrpos_pos++;
						}
						
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
								$params_attribute['atr_sub'] = $mainsubdimension->id;
								$params_attribute['atr_des'] = $this->atributo[$id][$dim][$subdim][$atrib]['nombre'];
								$params_attribute['atr_por'] = $this->atribpor[$id][$dim][$subdim][$atrib];
								$params_attribute['atr_com'] = $atr_com;
								$params_attribute['atr_pos'] = $atr_pos;
								
								$atributo = new atributo($params_attribute);
								$attributeid = $atributo->insert();
								$aid = $attributeid;
								$codatributo = encrypt_tool_element($aid);
								$atributosCod[$codatributo] = $aid;
								$this->atributosId[$id][$dim][$subdim][$atrib] = $codatributo;
								
								$params_attribute_positive['atr_sub'] = $mainsubdimension->id;
								$params_attribute_positive['atr_des'] = $this->atributopos[$id][$dim][$subdim][$atrib]['nombre'];
								$params_attribute_positive['atr_por'] = $this->atribpor[$id][$dim][$subdim][$atrib];
								$params_attribute_positive['atr_com'] = $atr_com;
								$params_attribute_positive['atr_pos'] = $atr_pos;
								$atributo_positive = new atributo($params_attribute_positive);
								$attribute_positive_id = $atributo_positive->insert();
								$apid = $attribute_positive_id;
								$codatributo = encrypt_tool_element($apid);
								$atributosCod[$codatributo] = $apid;
								$this->atributosposId[$id][$dim][$subdim][$atrib] = $codatributo;
								
								$params_atrdiferencial['atf_atn'] = $aid;
								$params_atrdiferencial['atf_atp'] = $apid;
								$atrdiferencial = new atrdiferencial($params_atrdiferencial);
								$atrdiferencial->insert();
								
								$recalculate = true;
							}
							
							$atr_pos++;
						}
						
						/*$atr_pos = 0;
						foreach($this->atributopos[$id][$dim][$subdim] as $atrib => $elematrib){
							$atr_com = '0';
							if($this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
								$atr_com = '1';
							}
							$idAtributo = $this->atributosposId[$id][$dim][$subdim][$atrib];
							if(isset($atributosCod[$idAtributo])){
								$id_plane_atr = $atributosCod[$idAtributo];
								$update = false;
								if($atributos[$id_plane_atr]->atr_por != $this->atribpor[$id][$dim][$subdim][$atrib]){
									$update = true;
									$recalculate = true;
								}
								if($atributos[$id_plane_atr]->atr_des != $this->atributopos[$id][$dim][$subdim][$atrib]['nombre'] || 
									$atributos[$id_plane_atr]->atr_com != $atr_com || $atributos[$id_plane_atr]->atr_pos != $atr_pos){
									$update = true;
								}
								if($update == true){
									$atributos[$id_plane_atr]->atr_por = $this->atribpor[$id][$dim][$subdim][$atrib];
									$atributos[$id_plane_atr]->atr_des = $this->atributopos[$id][$dim][$subdim][$atrib]['nombre'];
									$atributos[$id_plane_atr]->atr_com = $atr_com;
									$atributos[$id_plane_atr]->atr_pos = $atr_pos;
									$atributos[$id_plane_atr]->update();
								}
								unset($atributos[$id_plane_atr]);
							}
							$atr_pos++;
						}*/
					}
				}
				if(!empty($dimvals)){
					foreach($dimvals as $dimval){
						$dimval->delete();
					}
					$recalculate = true;
				}
				if(!empty($atributos)){
					foreach($atributos as $atributo){
						$atributo->delete();
					}
					$recalculate = true;
				}
			}
			elseif($destroy == true){
				$dimensions = dimension::fetch_all(array('dim_pla' => $tableid));
				foreach($dimensions as $object){
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
			
     
				//DIMENSIONS------------------
				foreach($this->dimension[$id] as $dim => $itemdim){
					$dim_glo = '0';
					$dim_com = '0';
					
					$params_dimension['dim_pla'] = $tableid;
					$params_dimension['dim_nom'] = $this->dimension[$id][$dim]['nombre'];
					$params_dimension['dim_por'] = $this->dimpor[$id][$dim];
					$params_dimension['dim_glo'] = $dim_glo;
					$params_dimension['dim_sub'] = $this->numsubdim[$id][$dim];
					$params_dimension['dim_com'] = $dim_com;
					$dimension = new dimension($params_dimension);
					$dimensionid = $dimension->insert();
					
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
						$dimvalid = $dimval->insert();
						$codDimval = encrypt_tool_element($dimvalid);
						$dimvalsCod[$codDimval] = $dimvalid;						
						$this->valoresId[$id][$dim][$grado] = $codDimval;
						
						$dim_pos++;
					}
					
					foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
						$params_subdimension['sub_dim'] = $dimensionid;
						$params_subdimension['sub_nom'] = $this->subdimension[$id][$dim][$subdim]['nombre'];
						$params_subdimension['sub_por'] = $this->subdimpor[$id][$dim][$subdim];
						$subdimension = new subdimension($params_subdimension);
						$subdimensionid = $subdimension->insert();
						
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
							$codatributo = encrypt_tool_element($attributeid);
							$atributosCod[$codatributo] = $attributeid;						
							$this->atributosId[$id][$dim][$subdim][$atrib] = $codatributo;						
							
							$params_attribute_positive['atr_sub'] = $subdimensionid;
							$params_attribute_positive['atr_des'] = $this->atributopos[$id][$dim][$subdim][$atrib]['nombre'];
							$params_attribute_positive['atr_por'] = $this->atribpor[$id][$dim][$subdim][$atrib];
							$params_attribute_positive['atr_com'] = $atr_com;
							$params_attribute_positive['atr_pos'] = $atr_pos;
							$atributo_positive = new atributo($params_attribute_positive);
							$attribute_positive_id = $atributo_positive->insert();
							$codatributopos = encrypt_tool_element($attribute_positive_id);
							$atributosCod[$codatributopos] = $attribute_positive_id;						
							$this->atributosposId[$id][$dim][$subdim][$atrib] = $codatributopos;
							
							$params_atrdiferencial['atf_atn'] = $attributeid;
							$params_atrdiferencial['atf_atp'] = $attribute_positive_id;
							$atrdiferencial = new atrdiferencial($params_atrdiferencial);	
							$atrdiferencial->insert();
							
							$atr_pos++;
						}
					}
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
				$params_result['recalculte'] = true;
			}

			$params_result['xml'] = $this->export(array('mixed' => '1', 'id' => $cod));
			return $params_result;
		}
	}
?>
