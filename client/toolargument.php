<?php
	/**
		Representa un instrumento de evaluación genérico
	*/
	class toolargument{
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
		
		//integer -- En caso de formar parte de un instrumento mixto, almacenará el valor porcentaje
		private $porcentage;
		
		//string -- comentarios
		private $observation;

		//'view' | 'design' -- indica si el instrumento está en modo diseño o vista previa
		private $view;
		
		//Array -- Almacena si los atributos tienen activados los comentarios o no
		private $commentAtr;
		
		private $valuecommentAtr;
		
		//Array -- Almacena los IDs de la BD relativos a las dimensiones
		private $dimensionsId;
		
		//Array -- Almacena los IDs de la BD relativos a las subdimensiones
		private $subdimensionsId;
		
		//Array -- Almacena los IDs de la BD relativos a los atributos
		private $atributosId;
		
		function get_tool($id){}
		function get_titulo(){return $this->titulo;}
		function get_dimension(){return $this->dimension[$this->id];}
		function get_numdim(){return $this->numdim[$this->id];}
		function get_subdimension(){return $this->subdimension[$this->id];}
		function get_numsubdim(){return $this->numsubdim[$this->id];}
		function get_atributo(){return $this->atributo[$this->id];}
		function get_numatr(){return $this->numatr[$this->id];}
		function get_dimpor(){return $this->dimpor[$this->id];}
		function get_subdimpor(){return $this->subdimpor[$this->id];}
		function get_atribpor(){return $this->atribpor[$this->id];}
		function get_commentAtr($id = 0){return $this->commentAtr[$this->id];}
		function get_porcentage(){return $this->porcentage;}

		function get_valores($id = 0){return array();}
		function get_numvalores($id){return array();}
		function get_valtotal($id){return array();}
		function get_numtotal($id){return array();}
		function get_valtotalpor($id){return array();}
		function get_valorestotal($id){return array();}
		function get_valglobal($id){return array();}
		function get_valglobalpor($id){return array();}
		function get_dimensionsId(){return $this->dimensionsId[$this->id];}
		function get_subdimensionsId(){return $this->subdimensionsId[$this->id];}
		function get_atributosId(){return $this->atributosId[$this->id];}
		function get_valoresId($id = 0){return array();}
		function get_valorestotalesId($id = 0){return array();}
		
		function set_titulo($titulo){$this->titulo = $titulo;}
		function set_dimension($dimension){$this->dimension[$this->id] = $dimension;}
		function set_numdim($numdim){$this->numdim[$this->id] = $numdim;}
		function set_subdimension($subdimension){$this->subdimension[$this->id] = $subdimension;}
		function set_numsubdim($numsubdim){$this->numsubdim[$this->id] = $numsubdim;}
		function set_atributo($atributo){$this->atributo[$this->id] = $atributo;}
		function set_numatr($numatr){$this->numatr[$this->id] = $numatr;}
		function set_dimpor($dimpor, $id=0){$this->dimpor[$this->id] = $dimpor;}
		function set_subdimpor($subdimpor){$this->subdimpor[$this->id] = $subdimpor;}
		function set_atribpor($atribpor){$this->atribpor[$this->id] = $atribpor;}
		function set_view($view, $id=''){$this->view = $view;}
		function set_commentAtr($comment){$this->commentAtr[$this->id] = $comment;}
		
		function set_valores($valores){}
		function set_numvalores($numvalores){}
		function set_valtotal($valtotal){}
		function set_numtotal($numtotal){}
		function set_valtotalpor($valtotalpor){}
		function set_valorestotal($valorestotal){}
		function set_valglobal($valglobal){}
		function set_valglobalpor($valglobalpor, $id=0){}
		function set_dimensionsId($dimensionsId, $id = ''){$this->dimensionsId[$this->id] = $dimensionsId;}
		function set_subdimensionsId($subdimensionsId, $id = ''){$this->subdimensionsId[$this->id] = $subdimensionsId;}
		function set_atributosId($atributosId, $id = ''){$this->atributosId[$this->id] = $atributosId;}
		function set_valoresId($valoresId){}
		function set_valorestotalesId($valoresId){}
		
		function __construct($lang='es_utf8', $titulo, $dimension, $numdim = 1, $subdimension, $numsubdim = 1, $atributo, $numatr = 1, $dimpor, $subdimpor, $atribpor, $commentAtr, $id = 0, $observation = '', $porcentage=0, $valuecommentAtr = '', $params = array()){
			$this->filediccionario = 'lang/'.$lang.'/evalcomix.php';
			$this->titulo = $titulo;
			$this->dimension = $dimension;
			$this->numdim = $numdim;
			$this->subdimension = $subdimension;
			$this->numsubdim = $numsubdim;
			$this->atributo = $atributo;
			$this->numatr = $numatr;
			$this->dimpor = $dimpor;
			$this->subdimpor = $subdimpor;
			$this->atribpor = $atribpor;
			$this->id = $id;
			$this->observation = $observation;
			$this->porcentage = $porcentage;
			$this->view = 'design';
			$this->commentAtr = $commentAtr;			
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
		}
		
		function addDimension($dim, $key){
			require($this->filediccionario);
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
		}
		
		
		function addSubdimension($dim, $subdim, $key){
			require($this->filediccionario);
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
			require($this->filediccionario);
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
		
		function eliminaDimension($dim, $id = 0){			
			if($this->numdim[$this->id] > 1){
				if($this->numsubdim[$this->id][$dim] > 0)
					$this->numsubdim[$this->id][$dim]--;
				$this->dimension[$this->id] = $this->arrayElimina($this->dimension[$this->id], $dim);
				$this->subdimension[$this->id] = $this->arrayElimina($this->subdimension[$this->id], $dim);
				$this->atributo[$this->id] = $this->arrayElimina($this->atributo[$this->id], $dim);	
				$this->numsubdim[$this->id] = $this->arrayElimina($this->numsubdim[$this->id], $dim);
				$this->numatr[$this->id] = $this->arrayElimina($this->numatr[$this->id], $dim);
				$this->numdim[$this->id]--;
			}
			else{
				require($this->filediccionario);
				echo '<span class="mensaje">'.$string['alertdimension'].'</span>';
			}
			return 1;
		}
		
		function eliminaSubdimension($dim, $subdim){ 
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
				require($this->filediccionario);
				echo '<span class="mensaje">'.$string['alertsubdimension'].'</span>';
			}
			return 1;
		}
		
		function eliminaAtributo($dim, $subdim, $atrib, $id){
			if(isset($this->atributo[$this->id][$dim][$subdim][$atrib])){
				if($this->numatr[$this->id][$dim][$subdim] > 1){
					$this->numatr[$this->id][$dim][$subdim]--;
					
					$this->atributo[$this->id][$dim][$subdim] = $this->arrayElimina($this->atributo[$this->id][$dim][$subdim], $atrib);
					$this->atribpor[$this->id][$dim][$subdim] = $this->arrayElimina($this->atribpor[$this->id][$dim][$subdim], $atrib);
				}
				else{
					require($this->filediccionario);
					echo '<span class="mensaje">'.$string['alertatrib'].'</span>';
				}
			}
			return 1;
		}
		function upBlock($params){
			require($this->filediccionario);
			require_once('array.class.php');
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
			require($this->filediccionario);
			require_once('array.class.php');
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
	
				<body id="body" >
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
		
		function display_body($data, $mix = '', $porcentage=''){		
			if($porcentage != '')
				$this->porcentage = $porcentage;
			if(isset($data['titulo'.$this->id]))
				$this->titulo = stripslashes($data['titulo'.$this->id]);
	
			require($this->filediccionario);
			$numdimen = count($this->dimension[$this->id]);
			
			if($this->view == 'view' && !is_numeric($mix)){
				echo '<input type="button" style="width:10em" value="'.$string['view'].'" onclick=\'javascript:location.href="generator.php?op=design"\'><br>';
			}
			$id = $this->id;
			//----------------------------------------------TODO
			echo '
			<div id="cuerpo'.$id.'"  class="cuerpo">
				<br>
				<label for="titulo'.$id.'" style="margin-left:1em">'.$string['argument'].':</label><span class="labelcampo">
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
				$this->observation[$id] = '';
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

			
			
			$checked = '';
			require($this->filediccionario);
			
			if($this->view == 'design')
				echo '
			<div>
				<input type="button" class="delete" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addDim=1&dd='.$dim.'", "mainform0");\'>
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
				
				<input class="flecha" type="button" id="addSubDim'.$id.'" name="addSubDim'.$id.'" onclick=\'javascript:if(!validarEntero(document.getElementById("numsubdimensiones'.$id.'_'.$dim.'").value)){alert("' . $string['ASubdimension'] . '"); return false;}sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim="+this.value+"&numsubdimensiones'.$dim.'="+ document.getElementById("numsubdimensiones'.$id.'_'.$dim.'").value +"", "mainform0");\' style="font-size:1px" value="'.$dim.'"/>		
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
						<input type="button" class="down" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&moveDim=1&numvalores="+document.getElementById("numvalores'.$id.'").value + "&dDown='.$dim.'", "mainform0");\'>
					<br></div>
					';
			flush();
		}		
		function display_subdimension($dim, $subdim, $data, $id='0', $mix=''){
			$id = $this->id;
			require($this->filediccionario);
			if(isset($data['subdimension'.$id.'_'.$dim.'_'.$subdim])) 
				$this->subdimension[$id][$dim][$subdim]['nombre'] = stripslashes($data['subdimension'.$id.'_'.$dim.'_'.$subdim]);
				
			
			if($this->view == 'design')
				echo '
				<input type="hidden" id="sumpor'.$id.'_'.$dim.'_'.$subdim.'" value=""/>
				<div>
					<input type="button" class="delete" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim='.$dim.'&dS=1&sd='.$subdim.'", "mainform0");\'>
					<input type="button" class="up" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&moveSub='.$dim.'&sUp='.$subdim.'", "mainform0");\'>	
					<br><br></div>
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
							<th style="text-align:right;"><span class="font">'.$string['attribute'].'</span></th>
							<th/>
				
				
				';
			
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

						echo '<td style="width:60%">
							<textarea disabled style="width:97%;" id="atributocomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'"></textarea>
						</td>';
							
					echo '</tr>';
					
					
				
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
		
		function save($cod = ''){
			$id = $this->id;
			if($cod == ''){
				throw new InvalidArgumentException('Missing scale cod');
			}
			
			require_once(DIRROOT . '/classes/plantilla.php');
			require_once(DIRROOT . '/classes/dimension.php');
			require_once(DIRROOT . '/classes/subdimension.php');
			require_once(DIRROOT . '/classes/atributo.php');
			require_once(DIRROOT . '/classes/atrcomment.php');
			require_once(DIRROOT . '/classes/db.php');
			
			$type = 'argumentario';
			$tableid = 0;
			
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
	
			$destroy = false;
			$recalculate = false;
			
			$dimensionsCod = array();
			$subdimensionsCod = array();
			$subdimensions = array();
			$atributosCod = array();
			$atributos = array();
			$dimensions = array();
			
			if($modify == 0){
				$params['pla_cod'] = $cod;
				$params['pla_tit'] = $this->titulo;
				$params['pla_tip'] = $type;
				$params['pla_gpr'] = '0';
				$params['pla_glo'] = '0';
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
				
				$plantilla->pla_gpr = '0';
				$plantilla->pla_glo = '0';
				$plantilla->pla_tit = $this->titulo;
				$plantilla->pla_des = $observation;			
				$plantilla->pla_por = $porcentage;
				
				if($updateplantilla == true){
					plantilla::set_properties($plantilla, array('id' => $tableid));
					$plantilla->update();
				}
			

				$numdim = 0;
				$numsubdim = 0;
				$numatributos = 0;
				$numvalores = 0;

				
				$dimensions = dimension::fetch_all(array('dim_pla' => $tableid));//print_r($dimensions);
				$numdim = count($dimensions);
				
				foreach($dimensions as $keydim => $object){
					$codDim = encrypt_tool_element($keydim);
					$dimensionsCod[$codDim] = $keydim;
									
					
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
				$dim_pos = 0;
				foreach($this->dimension[$id] as $dim => $value){
					if($numdim != 0 && $numdim != $this->numdim[$id]){
						//$destroy = true;
					}
					$dim_glo = '0';
					$dim_com = '0';
					$dim_gpr = '0';
					if(isset($this->valglobal[$id][$dim]) && ($this->valglobal[$id][$dim] == 'true' || $this->valglobal[$id][$dim] == 't')){
						$dim_glo = '1';
						if(isset($this->valglobalpor[$id][$dim])){
							$dim_gpr = $this->valglobalpor[$id][$dim];
						}
						
						if(isset($this->commentDim[$id][$dim]) && $this->commentDim[$id][$dim] == 'visible'){
							$dim_com = '1';
						}
					}
					$idDim = $this->dimensionsId[$id][$dim];
					if(isset($dimensionsCod[$idDim])){						
						$update = false;
						$id_plane = $dimensionsCod[$idDim];
						if($dimensions[$id_plane]->dim_por != $this->dimpor[$id][$dim] || $dimensions[$id_plane]->dim_sub != $this->numsubdim[$id][$dim] || $dimensions[$id_plane]->dim_gpr != $dim_gpr){
							$update = true;
						}
						if($dimensions[$id_plane]->dim_nom != $this->dimension[$id][$dim]['nombre'] || $dimensions[$id_plane]->dim_pos != $dim_pos || $dimensions[$id_plane]->dim_com != $dim_com){
							$update = true;
						}
						if($dimensions[$id_plane]->dim_glo != $dim_glo){
							$update = true;
						}
						
						if($update == true){
							$dimensions[$id_plane]->dim_glo = $dim_glo;
							$dimensions[$id_plane]->dim_com = $dim_com;
							$dimensions[$id_plane]->dim_nom = $this->dimension[$id][$dim]['nombre'];
							$dimensions[$id_plane]->dim_pos = $dim_pos;
							$dimensions[$id_plane]->dim_por = $this->dimpor[$id][$dim];
							$dimensions[$id_plane]->dim_gpr = $dim_gpr;
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
						$params_dimension['dim_gpr'] = $dim_gpr;
						$dimension = new dimension($params_dimension);
						$dimensionid = $dimension->insert();
						$did = $dimensionid; 
						$codDim = encrypt_tool_element($dimensionid);
						$dimensionsCod[$codDim] = $did;						
						$this->dimensionsId[$id][$dim] = $codDim;						
						
					}
					
					$sub_pos = 0;
					foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
						$idSubdim = $this->subdimensionsId[$id][$dim][$subdim];
						if(isset($subdimensionsCod[$idSubdim])){ 
							$update = false;
							$id_plane_sub = $subdimensionsCod[$idSubdim];
							if($subdimensions[$id_plane_sub]->sub_por != $this->subdimpor[$id][$dim][$subdim]){
								$update = true;
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
									//$recalculate = true;
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
				}
				
				if(!empty($subdimensions)){
					foreach($subdimensions as $subdimension){
						$subdimension->delete();
					}
				}
				
				if(!empty($atributos)){
					foreach($atributos as $atributo){
						$atributo->delete();
					}
				}			
			}
			elseif($destroy == true){
				$dimensions = dimension::fetch_all(array('dim_pla' => $tableid));
				foreach($dimensions as $object){
					$subdimens = subdimension::fetch_all(array('sub_dim' => $object->id));
					foreach($subdimens as $sub){
						$atribs = atributo::fetch_all(array('atr_sub' => $sub->id));
						foreach($atribs as $atr){
							$atrcomments = atrcomment::fetch_all(array('atc_atr' => $atr->id));
							foreach($atrcomments as $atrcom){
								$atrcom->delete();
							}
						}
					}
					$object->delete();
				}
			

			//DIMENSIONS------------------
				$dim_pos = 0;
				foreach($this->dimension[$id] as $dim => $itemdim){
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
					$codDim = encrypt_tool_element($dimensionid);
					$this->dimensionsId[$id][$dim] = $codDim;
					
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
					$dim_pos++;
				}
			}
			
			$params['xml'] = $this->export(array('mixed' => '1', 'id' => $cod));
			return $params;
		}
		
		/*Exporta el instrumento en formato XML
		  @param $mixed
			0 --> No forma parte de un instrumento mixto
			1 --> Sí forma parte de un instrumento mixto
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
				$root = '<ar:ArgumentSet xmlns:ar="http://avanza.uca.es/assessmentservice/argument"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/argument http://avanza.uca.es/assessmentservice/Argument.xsd"
	';
				$rootend = '</ar:ArgumentSet>
	';
			}
			elseif($mixed == '1'){
				$root = '<ArgumentSet ';
				$rootend = '</ArgumentSet>';
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
				//SUBDIMENSIONS-----------------
				foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
					$xml .=  '<Subdimension id="'.$this->subdimensionsId[$id][$dim][$subdim].'" name="' . htmlspecialchars($this->subdimension[$id][$dim][$subdim]['nombre']) . '" attributes="' . $this->numatr[$id][$dim][$subdim] . '" percentage="' . $this->subdimpor[$id][$dim][$subdim] . '">
	';
					//ATTRIBUTES--------------------
					foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
						$comment = '0';
						if($this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible')
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
			
	
			require($this->filediccionario);
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
			
			$checked = '';
			
			require($this->filediccionario);
			

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
			require($this->filediccionario);
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
			echo '<th/>';
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
						echo '<td style="width:60%">
							<textarea disabled style="width:97%;" id="atributocomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'"></textarea>
						</td>';
								
					echo '</tr>';
				}
			}
			echo '</table>
					</div>
			';
			
			flush();
		}
		
		function print_tool($root = ''){
			$id = $this->id;
			require($this->filediccionario);
			$colspan = 0;
			
			echo '
								<table class="tabla" border=1 cellpadding=5px >
								
								<!--TITULO-INSTRUMENTO------------>
								<tr>
								   <th colspan="2">'.htmlspecialchars($this->titulo).'</th>
								</tr>

								<tr>
								   <th colspan="2"></th>
								</tr>

								
								<tr>
								   <td></td>
								   <td></td>
								</tr>';
			$i = 0;
			foreach($this->dimension[$id] as $dim => $value){
				$colspandim = 0;
				
				echo '	
								<tr id="dim">
									<!--DIMENSIÓN-TITLE----------->
									<td class="bold" colspan="2">
										<span>'.htmlspecialchars($this->dimension[$this->id][$dim]['nombre']).'</span>
									</td>
				';
				
				
				echo '
								</tr>
				';
				$l = 0;
				foreach($this->subdimension[$this->id][$dim] as $subdim => $elemsubdim){
					echo '
								<!--TITULO-SUBDIMENSIÓN------------>
								<tr><td class="subdim" colspan="2">'.htmlspecialchars($this->subdimension[$this->id][$dim][$subdim]['nombre']).'</td></tr>
					';
						
					if(isset($this->atributo[$this->id][$dim][$subdim])){
						$j = 0;
						foreach($this->atributo[$this->id][$dim][$subdim] as $atrib => $elematrib){
							$vcomment = '';
							if(isset($this->valuecommentAtr[$id][$dim][$subdim][$atrib])){
								$vcomment = htmlspecialchars($this->valuecommentAtr[$id][$dim][$subdim][$atrib]);
							}
							
							echo '
								<!--ATRIBUTOS---------------------->
								<tr rowspan=0><td colspan="'.($colspan - $colspandim + 1) .'">'.htmlspecialchars($this->atributo[$this->id][$dim][$subdim][$atrib]['nombre']).'</td>
												
									<td colspan="'.$colspan.'">
										<textarea rows="4" style="height:8em;width:100%" id="observaciones'.$i.'_'.$l.'_'.$j.'" name="observaciones'.$i.'_'.$l.'_'.$j.'" style="width:100%">'.$vcomment.'</textarea>
									</td>
			
							';

							echo '
								</tr>

							';
							

							++$j;
						}
					}
					++$l;
				}
				
				echo "
				
					<tr>
						<td colspan='".($colspan - $colspandim + 1) ."'></td>
				";
				if(isset($this->commentDim[$id][$dim]) && $this->commentDim[$id][$dim] == 'visible'){
					echo "
						<td colspan='".$colspandim."'>
							<textarea rows='3' style='height:4em;width:100%' id='observaciones".$dim."' name='observaciones".$dim."' style='width:100%'></textarea>
						</td>
					";
				}
				echo "
					</tr>
				";
				++$i;
			}
			
			echo '
							</table>
			';
			echo "<br><label for='observaciones'>". strtoupper($string['comments'])."</label><br>
                           <textarea name='observaciones' id='observaciones' rows=4 cols=20 style='width:100%'>".htmlspecialchars($this->observation[$id])."</textarea>";
		}
	}