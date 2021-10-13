<?php
	/**
		Representa un instrumento de evaluaciÃ³n genÃ©rico
	*/
	class toolrubric{
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
		
		//array -- nÃºmero de rango por valor por dimensiÃ³n
		private $numrango;
		
		//array -- rango por valor por dimensiÃ³n
		private $rango;
		
		//array -- descripciÃ³n por atributo/valor
		private $description;
		
		//id
		private $id;
		
		//En caso de formar parte de un instrumento mixto, almacenarÃ¡ el valor porcentaje
		private $porcentage;
		
		//string -- comentarios
		private $observation;
		
		//'view' | 'design' -- indica si el instrumento estÃ¡ en modo diseÃ±o o vista previa
		private $view;
		
		//Array -- Almacena si los atributos tienen activados los comentarios o no
		private $commentAtr;
		
		//Array -- Almacena si las dimensiones tienen activadas los comentarios o no
		private $commentDim;
		
		//Array -- Almacena los comentarios de los atributos otorgados durante el proceso de evaluación
		private $valuecommentAtr;
		
		//Array -- Almacena los comentarios de las dimensiones otorgados durante el proceso de evaluación
		private $valuecommentDim;
		
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
		
		public $rangoId;
		
		public $descriptionsId;
		
		function get_tool($id){}
		function get_titulo(){return $this->titulo;}
		function get_dimension(){return $this->dimension[$this->id];}
		function get_numdim(){return $this->numdim[$this->id];}
		function get_subdimension(){return $this->subdimension[$this->id];}
		function get_numsubdim(){if(isset($this->numsubdim[$this->id]))return $this->numsubdim[$this->id];}
		function get_atributo(){return $this->atributo[$this->id];}
		function get_numatr(){return $this->numatr[$this->id];}
		function get_valores(){return $this->valores[$this->id];}
		function get_numvalores(){return $this->numvalores[$this->id];}
		function get_valtotal(){return $this->valtotal[$this->id];}
		function get_numtotal($id=0){
			if (isset($this->numtotal[$this->id])){
				return $this->numtotal[$this->id];
			}
			else{
				return null;
			}
		}
		function get_valtotalpor(){return $this->valtotalpor[$this->id];}
		function get_valorestotal($id=0){if(isset($this->valorestotal[$this->id]))return $this->valorestotal[$this->id];}
		function get_valglobal(){if(isset($this->valglobal[$this->id]))return $this->valglobal[$this->id];}
		function get_valglobalpor(){if(isset($this->valglobalpor[$this->id]))return $this->valglobalpor[$this->id];}
		function get_dimpor(){return $this->dimpor[$this->id];}
		function get_subdimpor(){return $this->subdimpor[$this->id];}
		function get_atribpor(){return $this->atribpor[$this->id];}
		function get_numrango(){return $this->numrango;}
		function get_rango(){return $this->rango[$this->id];}
		function get_commentAtr($id = 0){return $this->commentAtr[$this->id];}
		function get_commentDim($id = 0){return $this->commentDim[$this->id];}
		function get_porcentage(){return $this->porcentage;}
		function get_dimensionsId(){return $this->dimensionsId[$this->id];}
		function get_subdimensionsId(){return $this->subdimensionsId[$this->id];}
		function get_atributosId(){return $this->atributosId[$this->id];}
		function get_valoresId(){return $this->valoresId[$this->id];}
		function get_valorestotalesId(){return $this->valorestotalesId[$this->id];}
		function get_rangoId(){return $this->rangoId[$this->id];}
		function get_descriptionsId(){return $this->descriptionsId[$this->id];}
		function get_description(){return $this->description[$this->id];}

		
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
		function set_commentDim($comment){$this->commentDim[$this->id] = $comment;}
		function set_rango($rango){
			$this->rango = $rango;
		}
		function set_dimensionsId($dimensionsId, $id = ''){$this->dimensionsId[$this->id] = $dimensionsId;}
		function set_subdimensionsId($subdimensionsId, $id = ''){$this->subdimensionsId[$this->id] = $subdimensionsId;}
		function set_atributosId($atributosId, $id = ''){$this->atributosId[$this->id] = $atributosId;}
		function set_valoresId($valoresId, $id = ''){$this->valoresId[$this->id] = $valoresId;}
		function set_valorestotalesId($valoresId, $id = ''){$this->valorestotalesId[$this->id] = $valoresId;}
		function set_rangoId($valoresId, $id = ''){$this->rangoId[$this->id] = $valoresId;}
		function set_descriptionsId($valoresId, $id = ''){$this->descriptionsId[$this->id] = $valoresId;}
		
		function __construct($lang='es_utf8', $titulo, $dimension, $numdim = 1, $subdimension, $numsubdim = 1, $atributo, $numatr = 1, $valores, $numvalores = 2, $valtotal, $numtotal = 0, $valorestotal, $valglobal = false, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim, $id=0, $observation = '', $porcentage = 0, $valtotalpor = array(), $rango = null, $numrango = null, $description = null, $valueattribute = null, $valueglobaldim = null, $valuetotalvalue = null, $valuecommentAtr = null, $valuecommentDim = null, $params = array()){
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
			$this->valtotalpor = $valtotalpor;
			$this->rango = $rango;
			$this->numrango = $numrango;
			$this->view = 'design';
			$this->description = $description;
			$this->commentAtr = $commentAtr;
			$this->commentDim = $commentDim;
			$this->valueattribute = $valueattribute;
			$this->valueglobaldim = $valueglobaldim;
			$this->valuetotalvalue = $valuetotalvalue;
			$this->valuecommentAtr = $valuecommentAtr;
			$this->valuecommentDim = $valuecommentDim;
			
			if(!isset($this->numrango)){
				$i = 0;
				foreach($this->valores[$this->id] as $dim => $valor){
					$i = 0;
					foreach($valor as $key => $elem){
						$this->numrango[$this->id][$dim][$key] = 2;
						$i++;
						$this->rango[$this->id][$dim][$key][0] = $i;
						$i++;
						$this->rango[$this->id][$dim][$key][1] = $i;
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
			if(!empty($params['valoresId'])){
				$this->valoresId = $params['valoresId'];
			}
			if(!empty($params['valorestotalesId'])){
				$this->valorestotalesId = $params['valorestotalesId'];
			}
			if(!empty($params['rangoId'])){
				$this->rangoId = $params['rangoId'];
			}
			if(!empty($params['descriptionsId'])){
				$this->descriptionsId = $params['descriptionsId'];
			}
		}
		
		function addDimension($dim, $key, $id){
			require($this->filediccionario);
			$id = $this->id;
			$dimen;
			$this->numdim[$id] += 1;
			if(!isset($dim)){
				$dim = $key;
				$dimen = $dim;
				$key++;
				$this->dimension[$id][$dim]['nombre'] = $string['titledim'].$this->numdim[$id];
			}
			else{
				$newindex = $key;
				$dimen = $newindex;
				$elem['nombre'] = $string['titledim'].$this->numdim[$id];
				$this->dimension[$id] = $this->arrayAdd($this->dimension[$id], $dim, $elem, $newindex);
				$this->commentDim[$this->id][$newindex] = 'hidden';
			}
			
			$subdim = $key;
			$key++;
			$this->numatr[$id][$dimen][$subdim] = 1;
			$this->numsubdim[$id][$dimen] = 1;
			$this->atributo[$id][$dimen][$subdim][0]['nombre'] = $string['titleatrib'].$this->numatr[$id][$dimen][$subdim];
			$this->atribpor[$id][$dimen][$subdim][0] = 100;
			$this->subdimension[$id][$dimen][$subdim]['nombre'] = $string['titlesubdim'].$this->numsubdim[$id][$dimen];
			$this->subdimpor[$id][$dimen][$subdim] = 100;
			$this->valores[$id][$dimen][0]['nombre'] = $string['titlevalue'].'1';
			$this->valores[$id][$dimen][1]['nombre'] = $string['titlevalue'].'2';
			$this->numvalores[$id][$dimen] = 2;
			$this->numrango[$id][$dimen][0] = 2;
			$this->numrango[$id][$dimen][1] = 2;
			$this->rango[$id][$dimen][0][0] = 1;
			$this->rango[$id][$dimen][0][1] = 2;
			$this->rango[$id][$dimen][1][0] = 3;
			$this->rango[$id][$dimen][1][1] = 4;
		}
		
		
		function addSubdimension($dim, $subdim, $key, $id){
			require($this->filediccionario);
			$id = $this->id;
			$subdimen;
			$this->numsubdim[$id][$dim] += 1; 
			if(!isset($subdim)){
				$subdim = $key;
				$subdimen = $subdim;
				$this->subdimension[$id][$dim][$subdim]['nombre'] = $string['titlesubdim'].$this->numsubdim[$id][$dim];	
			}
			else{
				$newindex = $key;
				$subdimen = $newindex;
				$elem['nombre'] = $string['titlesubdim'].$this->numsubdim[$id][$dim];
				$this->subdimension[$id][$dim] = $this->arrayAdd($this->subdimension[$id][$dim], $subdim, $elem, $newindex);
			}
			$this->numatr[$id][$dim][$subdimen] = 1;
			$atrib = $key++;
			$this->atributo[$id][$dim][$subdimen][$atrib]['nombre'] = $string['titleatrib'].$this->numatr[$id][$dim][$subdim];
			$this->atribpor[$id][$dim][$subdimen][$atrib] = 100;
		}
		
		
		function addAtributo($dim, $subdim, $atrib, $key, $id){
			require($this->filediccionario);
			$id = $this->id;
			$this->numatr[$id][$dim][$subdim]++;
	
			if(!isset($atrib)){
				$atrib = $key;
				$this->atributo[$id][$dim][$subdim][$atrib]['nombre'] = $string['titleatrib'].$this->numatr[$id][$dim][$subdim];
			}
			else{
				$newindex = $key;
				$elem['nombre'] = $string['titleatrib'].$this->numatr[$id][$dim][$subdim];
				$this->atributo[$id][$dim][$subdim] = $this->arrayAdd($this->atributo[$id][$dim][$subdim], $atrib, $elem, $newindex);
				$this->commentAtr[$id][$dim][$subdim][$newindex]= 'hidden';
			}
		}
		
		
		function addValores($dim, $key, $id){	
			require($this->filediccionario);
			$id = $this->id;
			$this->numvalores[$id][$dim]++;
			$this->valores[$id][$dim][$key]['nombre'] = $string['titlevalue'].$this->numvalores[$id][$dim];
			$this->numrango[$id][$dim][$key] = 2;
			$this->rango[$id][$dim][$key][0] = 0;
			$this->rango[$id][$dim][$key][1] = 0;
		}
		
		function addValoresTotal($key, $id){
			require($this->filediccionario);
			$id = $this->id;
			if (isset($this->numtotal[$id])){
				$this->numtotal[$id]++;
			}
			else{
				$this->numtotal[$id] = 1;
			}
			$this->valorestotal[$id][$key]['nombre'] = $string['titlevalue'].$this->numtotal[$id];
		}
		
		function eliminaValoresTotal($grado, $id){
			$id = $this->id;
			if($this->numtotal > 2){
				$this->numtotal[$id]--;
				$this->valorestotal[$id] = $this->arrayElimina($this->valorestotal[$id], $grado);	
			}
		}
		
		function eliminaDimension($dim, $id){			
			$id = $this->id;
			if($this->numdim[$id] > 1){
				if($this->numsubdim[$id][$dim] > 0)
					$this->numsubdim[$id][$dim]--;
				if($this->numvalores[$id][$dim] > 2)
					$this->numvalores[$id][$dim]--;
				$this->dimension[$id] = $this->arrayElimina($this->dimension[$id], $dim);
				$this->subdimension[$id] = $this->arrayElimina($this->subdimension[$id], $dim);
				$this->atributo[$id] = $this->arrayElimina($this->atributo[$id], $dim);
				$this->description[$id] = $this->arrayElimina($this->description[$id], $dim);
				$this->valores[$id] = $this->arrayElimina($this->valores[$id], $dim);
				$this->numsubdim = $this->arrayElimina($this->numsubdim, $dim);
				$this->numatr = $this->arrayElimina($this->numatr, $dim);
				$this->numdim[$id]--;
			}
			else{
				require($this->filediccionario);
				echo '<span class="mensaje">'.$string['alertdimension'].'</span>';
			}

			return 1;
		}
		
		function eliminaSubdimension($dim, $subdim, $id){
			$id = $this->id;
			if($this->numsubdim[$id][$dim] > 1){
				$this->numsubdim[$id][$dim]--;
				$this->subdimension[$id][$dim] = $this->arrayElimina($this->subdimension[$id][$dim], $subdim);
				$this->subdimpor[$this->id][$dim] = $this->arrayElimina($this->subdimpor[$this->id][$dim], $subdim);
				if(empty($this->subdimension[$id][$dim]))
					unset($this->subdimension[$id][$dim]);
				$this->atributo[$id][$dim] = $this->arrayElimina($this->atributo[$id][$dim], $subdim);
				$this->numatr[$id][$dim] = $this->arrayElimina($this->numatr[$id][$dim], $subdim);
			}
			else{
				require($this->filediccionario);
				echo '<span class="mensaje">'.$string['alertsubdimension'].'</span>';
			}
			return 1;
		}
		
		function eliminaAtributo($dim, $subdim, $atrib, $id){
			$id = $this->id;
			if(isset($this->atributo[$id][$dim][$subdim][$atrib])){
				if($this->numatr[$id][$dim][$subdim] > 1){
					$this->numatr[$id][$dim][$subdim]--;
					
					$this->atributo[$id][$dim][$subdim] = $this->arrayElimina($this->atributo[$id][$dim][$subdim], $atrib);
					$this->atribpor[$id][$dim][$subdim] = $this->arrayElimina($this->atribpor[$id][$dim][$subdim], $atrib);
				}
				else{
					require($this->filediccionario);
					echo '<span class="mensaje">'.$string['alertatrib'].'</span>';
				}
			}
			return 1;
		}
		
		function eliminaValores($dim, $grado, $id){
			$id = $this->id;
			if($this->numvalores[$id][$dim] > 2){
				$this->numvalores[$id][$dim]--;
				$this->valores[$id][$dim] = $this->arrayElimina($this->valores[$id][$dim], $grado);	
				$this->rango[$id][$dim] = $this->arrayElimina($this->rango[$id][$dim], $grado);	
				$this->numrango[$id][$dim] = $this->arrayElimina($this->numrango[$id][$dim], $grado);	
			}
		}
		
		function addRango($dim, $grado, $key, $id){
			$id = $this->id;
			$this->numrango[$id][$dim][$grado]++;
			$this->rango[$id][$dim][$grado][$key] = 0;
			
		}
		
		
		function sort_range(&$array, $key, $value){
			foreach($array as $index => $content){
				if($index >= $key){
					while($item = current($content)){
						$key_content = key($content);
						$array[$index][$key_content] = ++$value;
						next($content);
					}
				}	
			}
		}
		
		function eliminaRango($dim, $grado, $key, $id){
			$id = $this->id;
			if($this->numrango[$id][$dim][$grado] > 0){
				$this->numrango[$id][$dim][$grado]--;
				$this->rango[$id][$dim][$grado] = $this->arrayElimina($this->rango[$id][$dim][$grado], $key);	
			}
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
					<script type="text/javascript" src="javascript/tamaÃ±o.js"></script>
					<script type="text/javascript" src="javascript/rollover.js"></script>					
					<script type="text/javascript" src="javascript/ajax.js"></script>
					<script type="text/javascript" src="javascript/check.js"></script>
					<script language="JavaScript" type="text/javascript">

						document.onkeydown = function(e){ 
							if(window.event && window.event.keyCode == 116){
								window.event.keyCode = 505;
							}
							if(window.event && window.event.keyCode == 505){
								return false;
								// window.frame(main).location.reload(True);
							}
						}
						document.onkeypress = function(e){
							if(e.which == 116){
								e.which = 505;
							}
							if(e.which == 505){
								return false;
								// window.frame(main).location.reload(True);
							}
							 

						}

						document.oncontextmenu=function(){return false;} 
					
					</script>
				</head>
	
				<body id="body">
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
		
		function display_body($data, $mix='', $porcentage=''){
			if($porcentage != '')
				$this->porcentage = $porcentage;
			if(isset($data['titulo'.$this->id]))
				$this->titulo = stripslashes($data['titulo'.$this->id]);

			if(isset($data['valtotal'.$this->id]))
				$this->valtotal[$this->id] = stripslashes($data['valtotal'.$this->id]);
	
			$id = $this->id;
			if(isset($data['numvalores'.$this->id]) && $data['numvalores'.$this->id] >= 2)
				$this->numtotal[$this->id] = stripslashes($data['numvalores'.$id]);
			
			$checked = '';
			$disabled = 'disabled';
			if(isset($this->valtotal[$this->id]) && ($this->valtotal[$this->id] == 'true' || $this->valtotal[$this->id] == 't')){
				$checked = 'checked';
				$disabled = '';
			}
			require($this->filediccionario);
			if($this->view == 'view' && !is_numeric($mix)){
				echo '<input type="button" style="width:10em" value="'.$string['view'].'" onclick=\'javascript:location.href="generator.php?op=design"\'><br>';
			}
			
			$numdimen = count($this->dimension[$this->id]);
			
			
			$dim = null;
			$subdim = null;
			$atrib = null;
			//----------------------------------------------
			echo '
			<div id="cuerpo'.$id.'" class="cuerpo">
				<br>
				<label for="titulo'.$id.'" style="margin-left:1em">'.$string['rubric'].':</label><span class="labelcampo">
					<textarea class="width" id="titulo'.$id.'" name="titulo'.$id.'">'.$this->titulo.'</textarea></span>
			';
			if($this->view == 'design')
				echo '
				<label for="numdimensiones'.$id.'">'.$string['numdimensions'].'</label>
				<span class="labelcampo">
					<input type="text" id="numdimensiones'.$id.'" name="numdimensiones'.$id.'" value="'.$this->numdim[$id].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/>
				</span>
				<label for="valtotal'.$id.'">'.$string['totalvalue'].'</label>
				<input type="checkbox" id="valtotal'.$id.'" name="valtotal'.$id.'" '.$checked.' onclick="javascript:if(this.checked)document.getElementById(\'numvalores'.$id.'\').disabled=false;else document.getElementById(\'numvalores'.$id.'\').disabled=true;"/>
				
				<label for="numvalores'.$id.'">'.$string['numvalues'].'</label>
				<span class="labelcampo">';
				$numtotal = '';
				if(isset($this->numtotal[$id])){
					$numtotal = $this->numtotal[$id];
				}
				echo '
					<input type="text" id="numvalores'.$id.'" name="numvalores'.$id.'" '.$disabled.' value="'.$numtotal.'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/>
				</span>
				<input class="flecha" type="button" id="addDim" onclick=\'javascript:if(!validarEntero(document.getElementById("numdimensiones'.$id.'").value) || (document.getElementById("valtotal'.$id.'").checked && !validarEntero(document.getElementById("numvalores'.$id.'").value))){alert("' . $string['ADimension'] . '"); return false;} sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&addDim=1&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&numvalores="+document.getElementById("numvalores'.$id.'").value + "&numdimensiones="+ document.getElementById("numdimensiones'.$id.'").value +"", "mainform0");\' name="addDim" value=""/>				
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
				echo '<div class="dimension" id="dimensiontag'.$id.'_'.$dim.'">
					<input type="hidden" name="dimensiontagname" value="'.$id.'_'.$dim.'">
				';
				$this->display_dimension($dim, $data, $id, $mix);
				echo '</div>';
			}
			if(isset($this->valtotal[$this->id]) && ($this->valtotal[$this->id] == 'true' || $this->valtotal[$this->id] == 't')){
				echo '
					<div class="valoraciontotal">
				';
			if($this->view == 'design')
				echo '
						<input type="button" class="delete" onclick=\'javascript:document.getElementById("valtotal'.$id.'").checked=false;sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&addDim=1&valtotal=false", "mainform0");\'>					
				';
			echo '
						<div class="margin">
							<label for="numdimensiones">'.strtoupper($string['totalvalue']).':</label>
							<span class="labelcampo"></span>						
			';
			if($this->view == 'design')
				echo '
							<label for="numvalorestotal">'.$string['numvalues'].'</label>
							<span class="labelcampo">
							<input type="text" id="numvalores_'.$id.'" name="numvalores'.$id.'" value="'.$this->numtotal[$id].'" maxlength=2 onkeyup=\'javascript:var valores=document.getElementsByName("numvalores'.$id.'");for(var i=0; i<valores.length; i++){valores[i].value=this.value;}\' onkeypress=\'javascript:return validar(event);\'/>				
							<input class="flecha" type="button" id="addDim" onclick=\'javascript:if(!validarEntero(document.getElementById("numvalores_'.$id.'").value)){alert("' . $string['ATotal'] . '"); return false;}sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&addDim=1&numvalores="+document.getElementById("numvalores_'.$id.'").value + "", "mainform0");\' name="addDim" value=""/>
				';
				echo '
							<span class="labelcampo"><label for="dimpor">'.$string['porvalue'].':</label><span class="labelcampo">
							<input class="porcentaje" type="text" name="valtotalpor'.$id.'" id="valtotalpor'.$id.'" value="'.$this->valtotalpor[$id].'" onchange=\'document.getElementById("sumpor3'.$id.'").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("valtotalpor'.$id.'").value > 100)document.getElementById("valtotalpor'.$id.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
							<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&dimpor'.$id.'="+document.getElementById("valtotalpor'.$id.'").value+"&dpi=vt&addDim=1", "mainform0");\'></span>
							
							<table class="maintable">
				';
				
				if(isset($this->valorestotal[$id])){
					foreach($this->valorestotal[$id] as $grado => $elemvalue){
						if(isset($data['valor'.$id.'_'.$grado])) 
							$this->valorestotal[$id][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$grado]);	
						echo '<th class="grado"><input class="valores" type="text" id="valor'.$id.'_'.$grado.'" name="valor'.$id.'_'.$grado.'" value="'.htmlspecialchars($this->valorestotal[$id][$grado]['nombre']).'"/></th>
						';
					}
				}
				echo '<tr>';
				foreach($this->valorestotal[$id] as $grado => $elemvalue){
					echo '<td><input type="radio" name="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
					';
				}					
				echo '</tr></table>
					</div>
				</div>';
			}
			if(!is_numeric($mix)){
				if(!empty($data['observation'.$id])) {
					$this->observation[$id] = stripslashes($data['observation'.$id]);
				}

				$observation = '';
				if(isset($this->observation[$id])){
					$observation = $this->observation[$id];
				}
				echo '
				<div id="comentario">
					<div id="marco">
						<label for="observation'.$id.'">' . $string['observation']. ':</label>
						<textarea id="observation'.$id.'" style="width:100%" rows="4" cols="200">' . $observation . '</textarea>
					</div>
				</div>
				';
			}
			echo '<input type="hidden" id="sumpor3'.$id.'" value=""/>
			</div>
			';
			flush();
		}
		
		function display_footer(){
			echo '
				</body>
			</html>';
		}

		function display_dimension($dim =0, $data, $id=0, $mix=''){
			$id = $this->id;
			$subdim = null;
			$atrib = null;
			if(isset($data['dimension'.$id.'_'.$dim])) 
				$this->dimension[$id][$dim]['nombre'] = stripslashes($data['dimension'.$id.'_'.$dim]);
			
			if(isset($data['valglobal'.$id.'_'.$dim]))
				$this->valglobal[$id][$dim] = stripslashes($data['valglobal'.$id.'_'.$dim]);
			
			$checked = '';
			$globalchecked = '';
			if(isset($this->valglobal[$id][$dim]) && $this->valglobal[$id][$dim] == "true"){
				$globalchecked = 'checked';
			}
			require($this->filediccionario);
			
			
			if($this->view == 'design'){
				$numtotal = '';
				if(isset($this->numtotal[$id])){
					$numtotal = $this->numtotal[$id];
				}
				echo '
			<div>
				<input type="button" class="delete" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addDim=1&numvalores='.$numtotal.'&dd='.$dim.'", "mainform0");\'>
				<input type="button" class="up" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&moveDim=1&numvalores='.$numtotal.'&dUp='.$dim.'", "mainform0");\'>
				<br>
			</div>
				';
			}
			echo '
			<input type="hidden" id="sumpor2'.$id.'_'.$dim.'" value=""/>
			<div class="margin">
				<label for="dimension'.$id.'_'.$dim.'">'.$string['dimension'].'</label>
				<span class="labelcampo">
					<textarea class="width" id="dimension'.$id.'_'.$dim.'" name="dimension'.$id.'_'.$dim.'">'. $this->dimension[$id][$dim]['nombre'] .'</textarea></span>
				';
			if($this->view == 'design')
				echo '			
				<label for="numsubdimensiones'.$id.'_'.$dim.'">'.$string['numsubdimension'].'</label>
				<span class="labelcampo"><input type="text" id="numsubdimensiones'.$id.'_'.$dim.'" name="numsubdimensiones'.$dim.'" value="'.$this->numsubdim[$id][$dim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
		
				<label for="numvalores'.$id.'_'.$dim.'">'.$string['numvalues'].'</label>
				<span class="labelcampo"><input type="text" id="numvalores'.$id.'_'.$dim.'" name="numvalores'.$id.'_'.$dim.'" value="'.$this->numvalores[$id][$dim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
				<label for="valtotal'.$id.'">'.$string['totalvalue'].'</label>
				<input type="checkbox" id="valglobal'.$id.'_'.$dim.'" name="valglobal'.$id.'_'.$dim.'" '.$globalchecked.' />
				
				<input class="flecha" type="button" id="addSubDim" name="addSubDim" onclick=\'javascript:if(!validarEntero(document.getElementById("numvalores'.$id.'_'.$dim.'").value) || !validarEntero(document.getElementById("numsubdimensiones'.$id.'_'.$dim.'").value)){alert("' . $string['ASubdimension'] . '"); return false;}sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim="+this.value+"&numvalores'.$id.'_'.$dim.'="+ document.getElementById("numvalores'.$id.'_'.$dim.'").value +"&numsubdimensiones'.$id.'_'.$dim.'="+ document.getElementById("numsubdimensiones'.$id.'_'.$dim.'").value +"", "mainform0");\' style="font-size:1px" value="'.$dim.'"/>		
				';
			echo '
				<span class="labelcampo"><label for="dimpor'.$id.'_'.$dim.'">'.$string['porvalue'].'</label><span class="labelcampo">
				<input class="porcentaje" type="text" maxlength="3" name="dimpor'.$id.'_'.$dim.'" id="dimpor'.$id.'_'.$dim.'" value="'.$this->dimpor[$id][$dim].'" onchange=\'javascript:document.getElementById("sumpor3'.$id.'").value += this.id +"-";;\' onkeyup=\'javascript:if(document.getElementById("dimpor'.$id.'_'.$dim.'").value > 100)document.getElementById("dimpor'.$id.'_'.$dim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
				<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&dimpor'.$id.'="+document.getElementById("dimpor'.$id.'_'.$dim.'").value+"&dpi='.$dim.'&addDim=1", "mainform0");\'></span>
				<br>
				<div id="rubrica">
				';
			
			if($this->view == 'design'){	
				echo "<i><span style='color:#1c38e2''>
						<!--RECUERDE: Los valores deberán ser colocados de MENOR A MAYOR. En caso contrario, se reordenarán automáticamente<br>-->
						".$string['rubricremember']."<br>
						<!--RECUERDE: El límite MÁXIMO de la escala es 100. Una vez alcanzado el límite no se admitirán nuevos valores-->
					</span></i><br>";
				foreach($this->valores[$id][$dim] as $grado => $elemvalue){
					if(isset($data['valor'.$id.'_'.$dim.'_'.$grado])) 
						$this->valores[$id][$dim][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$dim.'_'.$grado]);
					echo '
					<div class="rango">
						<label for="rango'.$id.'_'.$dim.'_1">'.$string['titlevalue'].':</label><br>
						<input type="text" class="itemrango1" id="valor'.$id.'_'.$dim.'_'.$grado.'" name="valor'.$id.'_'.$dim.'_'.$grado.'" value="'.htmlspecialchars($this->valores[$id][$dim][$grado]['nombre']).'" onkeyup=\'javascript:var valores=document.getElementsByName("valor'.$id.'_'.$dim.'_'.$grado.'");for(var i=0; i<valores.length; i++){valores[i].value=this.value;}\'/><br><br>
						<label for="numrango'.$id.'_'.$dim.'_'.$grado.'">'.$string['numvalues'].'</label><br>
						<input type="text" class="itemrango2" id="numrango'.$id.'_'.$dim.'_'.$grado.'" onkeypress=\'javascript:return validar(event);\' maxlength="2" name="numrango'.$id.'_'.$dim.'_'.$grado.'" value="'.$this->numrango[$id][$dim][$grado].'"/> 
						<input class="flecha" type="button" id="addrango'.$id.'_'.$dim.'_'.$grado.'" name="addrango'.$id.'_'.$dim.'_'.$grado.'" onclick=\'javascript:
							var valor = document.getElementById("numrango'.$id.'_'.$dim.'_'.$grado.'");
							if(valor.value <= 0){
								alert("Debe existir, al menos, un valor en el rango"); 
								return false;
							}
							/*var size = valores.length;
							var last = size - 1;
							if(valores[last].id == valores[last].value == 100){
								alert("El límite máximo de la escala es 100. Ya ha alcanzado el límite máximo. Recuerde que la escala es ascendente, por lo que no podrá añadir valores superiores a 100.\nPara añadir nuevos valores intente reconfigurar la escala.");return false;
							}*/
							sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim="+'.$dim.'+"&addrango="+this.value+"", "mainform0");\' style="font-size:1px" value="'.$dim.'_'.$grado.'"/><br><br>
					';

					foreach($this->rango[$id][$dim][$grado] as $key => $rango){
					
						echo '
						<select id= "select'.$id.'_'.$dim.'_'.$grado.'_'.$key.'" name="select'.$id.'_'.$dim.'" onchange=\'javascript:
						/*var valores=document.getElementsByName("select'.$id.'_'.$dim.'");
						for(var i=0; i<valores.length; i++){
							var repeated = 0;
							if(valores[i].id != this.id && valores[i].value==this.value){
								//alert("Ha introducido un valor que ya existe en la escala. \n\nRecuerde: NO puede haber VALORES REPETIDOS");
								valores[i].style.border="1px solid #f00";
								repeated = 1;
								//this.value = '. $rango .'
								//return false;
								//break;
							}
						}
						if(repeated == 1){
							return false;
						}*/
						sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim="+'.$dim.'+"&idrango="+this.id+"&sel="+this.value+"&addrango='.$dim.'_'.$grado.'", "mainform0");\' id="rango'.$id.'_'.$dim.'_'.$grado.'_'.$key.'">';
						for($i = 0; $i <= 100; $i++){
							$selected = '';
							if($this->rango[$id][$dim][$grado][$key] == $i)
								$selected = 'selected';
							
							echo '<option '.$selected.' value='.$i.'>'.$i.'</option>';
						}
						echo 
						'</select>';
					}
					echo'
					</div>
					';
				}
			}
				echo '<div class="clear"></div>
				</div>
				';
				
				
			if(isset($this->subdimension[$id][$dim])){
				foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
					echo '								
						<div class="subdimension" id="subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'">
					';
					$this->display_subdimension($dim, $subdim, $data, $id, $mix);
					echo '</div>					
					';
				}				
			}
			if(isset($this->valglobal[$id][$dim]) && $this->valglobal[$id][$dim] == "true"){
				echo '
					<div class="valoracionglobal">
				';
				if($this->view == 'design')
					echo '
						<!--<input type="hidden" id="sumpor'.$id.'_'.$dim.'_'.$subdim.'" value=""/>-->
						<input type="button" class="delete" onclick=\'javascript:document.getElementById("valglobal'.$id.'_'.$dim.'").checked=false;sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim='.$dim.'&valglobal'.$id.'_'.$dim.'=false", "mainform0");\'>					
					';
				echo '
						<div class="margin">
							<label>'.$string['globalvalue'].'</label>
							<span class="labelcampo"></span>													
							<span class="labelcampo"><label for="name="valglobalpor'.$id.'_'.$dim.'">'.$string['porvalue'].'</label><span class="labelcampo">
							<input class="porcentaje" type="text" maxlength="3"  name="valglobalpor'.$id.'_'.$dim.'" id="valglobalpor'.$id.'_'.$dim.'" value="'.$this->valglobalpor[$id][$dim].'" onchange=\'document.getElementById("sumpor2'.$id.'_'.$dim.'").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("valglobalpor'.$id.'_'.$dim.'").value > 100)document.getElementById("valglobalpor'.$id.'_'.$dim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
							<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&subdimpor="+document.getElementById("valglobalpor'.$id.'_'.$dim.'").value+"&spi=vg&addSubDim='.$dim.'", "mainform0");\'></span>
							
							<table class="maintable">
				';
				foreach($this->valores[$id][$dim] as $grado => $elemvalue){
					if(isset($data['valor'.$id.'_'.$dim.'_'.$grado])) 
						$this->valores[$id][$dim][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$dim.'_'.$grado]);
					
					echo '<th class="grado" colspan="'.$this->numrango[$id][$dim][$grado].'"><input class="valores" type="text" id="valor'.$id.'_'.$dim.'_'.$grado.'" name="valor'.$id.'_'.$dim.'_'.$grado.'" value="'.htmlspecialchars($this->valores[$id][$dim][$grado]['nombre']).'" onkeyup=\'javascript:var valores=document.getElementsByName("valor'.$id.'_'.$dim.'_'.$grado.'");for(var i=0; i<valores.length; i++){valores[i].value=this.value;}\'/></th>
					';
				}				
				echo '<tr>';
				foreach($this->valores[$id][$dim] as $grado => $elemvalue){
					foreach($this->rango[$id][$dim][$grado] as $key => $rango){
						echo '
						<td class="descripcion">
							<input type="radio" id="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado.'_'.$key.'" name="radio'.$id.'_'.$dim.'_'.$atrib.'" />
							<label for="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado.'_'.$key.'">'.$this->rango[$id][$dim][$grado][$key].'</label>
						</td>
						';
					}		
				}	
									
				echo '</tr>';
				
				//COMENTARIOS-DIMENSIÓN-------------------------
				$visible = null;
				if(isset($data['commentDim'.$id.'_'.$dim])){
					$visible = stripslashes($data['commentDim'.$id.'_'.$dim]);
					$this->commentDim[$id][$dim]= $visible;
				}
				
				if(isset($this->commentDim[$id][$dim]) && $this->commentDim[$id][$dim]== 'visible'){
					$visible = 'visible';
					$novisible = 'hidden';
				}
				else{
					$novisible = 'visible';
					$visible = 'hidden';
				}
				
				$totalrange = 0;
				foreach($this->numrango[$id][$dim] as $grado){
					$totalrange += $grado;
				}
				
				echo '<tr>
					<td colspan="'.$totalrange.'">';
					
				if($this->view == 'design'){
					echo '
					<div>
						<input type="button" class="showcomment" title="'. $string['add_comments'] .'" 
							onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&commentDim'.$id.'_'.$dim.'='.$novisible.'&comDim='.$dim.'&addSubDim='.$dim.'", "mainform0");\'>
					</div>';
				}
				
				echo '
					</td></tr><tr>
					<td colspan="'.$totalrange.'">';
					
				if($visible == 'visible'){
					$divheight = 'height:2.5em';
					$textheight = 'height:2em';
				}
				else{
					$divheight  = 'height:0em';
					$textheight = 'height:0em';
				}
				echo '<div class="atrcomment" id="atribcomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" style="'.$divheight.'">
				<textarea disabled style="width:97%; visibility:'.$visible.'; '.$textheight.'"  id="atributocomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'"></textarea>
					</div>
				</td></tr>
				';
				//-------------------------------------
				
				echo '</table></div>
					</div>';
			}
			
			echo '</div>
			';
			if($this->view == 'design')
				echo '<div>
						<input type="button" class="add" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&addDim=1&numvalores="+document.getElementById("numvalores'.$id.'").value + "&ad='.$dim.'", "mainform0");\'>
						<input type="button" class="down" onclick=\'javascript:sendPost("cuerpo'.$id.'","mix='.$mix.'&mix='.$mix.'&id='.$id.'&titulo'.$id.'="+document.getElementById("titulo'.$id.'").value+"&moveDim=1&numvalores="+document.getElementById("numvalores'.$id.'").value + "&dDown='.$dim.'", "mainform0");\'>
						<br>
					</div>
			';
			flush();
		}		
		function display_subdimension($dim, $subdim, $data, $id=0, $mix=''){
			$id = $this->id;
			require($this->filediccionario);
			if(isset($data['subdimension'.$dim.'_'.$subdim])) 
				$this->subdimension[$id][$dim][$subdim]['nombre'] = stripslashes($data['subdimension'.$dim.'_'.$subdim]);

			
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
						<span class="labelcampo"><textarea  class="width" id="subdimension'.$dim.'_'.$subdim.'" name="subdimension'.$dim.'_'.$subdim.'">'.$this->subdimension[$id][$dim][$subdim]['nombre'].'</textarea></span>
			';
			if($this->view == 'design')
				echo '		
						<label for="numatributos'.$id.'_'.$dim.'_'.$subdim.'">'.$string['numattributes'].'</label>
						<span class="labelcampo"><input type="text" id="numatributos'.$id.'_'.$dim.'_'.$subdim.'" name="numatributos'.$id.'_'.$dim.'_'.$subdim.'" value="'.$this->numatr[$id][$dim][$subdim].'" maxlength=2 onkeypress=\'javascript:return validar(event);\'/></span>
						<input class="flecha" type="button" id="addAtr" name="addAtr" style="font-size:1px" onclick=\'javascript:if(!validarEntero(document.getElementById("numatributos'.$id.'_'.$dim.'_'.$subdim.'").value)){alert("' . $string['AAttribute'] . '"); return false;}sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&addAtr="+this.value+"&numatributos'.$id.'_'.$dim.'_'.$subdim.'="+ document.getElementById("numatributos'.$id.'_'.$dim.'_'.$subdim.'").value +"", "mainform0");\' value="'.$dim.'_'.$subdim.'"/>
				';
			echo '
						<span class="labelcampo"><label for="subdimpor'.$id.'_'.$dim.'_'.$subdim.'">'.$string['porvalue'].'</label><span class="labelcampo">
						<input class="porcentaje" type="text" maxlength="3" id="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" name="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" value="'.$this->subdimpor[$id][$dim][$subdim].'" onchange=\'document.getElementById("sumpor2'.$id.'_'.$dim.'").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value > 100)document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
						<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&subdimpor="+document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value+"&spi='.$subdim.'&addSubDim='.$dim.'", "mainform0");\'>
						</span><br>
				<br>
						<table class="maintable">
							<tr><th/><th/><th/>
							<th style="text-align:right;"><span class="font">'.$string['attribute'].'</span>  <span class="atributovalores" style="font-size:1em">/</span> <span class="atributovalores">'.$string['values'].'</span></th>
						';
			foreach($this->valores[$id][$dim] as $grado => $elemvalue){
				if(isset($data['valor'.$id.'_'.$dim.'_'.$grado])) 
					$this->valores[$id][$dim][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$dim.'_'.$grado]);
					
				echo '
				<th class="grado" colspan="'.$this->numrango[$id][$dim][$grado].'">
					<input style="background-color:#DDE0DD;height:	2em" type="text" class="itemrango1" id="valor'.$id.'_'.$dim.'_'.$grado.'" name="valor'.$id.'_'.$dim.'_'.$grado.'" value="'.htmlspecialchars($this->valores[$id][$dim][$grado]['nombre']).'" onkeyup=\'javascript:var valores=document.getElementsByName("valor'.$id.'_'.$dim.'_'.$grado.'");for(var i=0; i<valores.length; i++){valores[i].value=this.value;}\'/>
				</th>
				';
			}
			echo '</tr>';
			$numAtributo = count($this->atributo[$id][$dim][$subdim]);
			if(isset($this->atributo[$id][$dim][$subdim])){
				foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
					if(isset($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributo[$id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					
					echo '			
					<tr rowspan="2">
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
					
									
						<td>
							<input class="porcentaje" type="text" onchange=\'document.getElementById("sumpor'.$id.'_'.$dim.'_'.$subdim.'").value += this.id + "-";\' onkeyup=\'javascript:if(document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value > 100)document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'  maxlength="3" name="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" id="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" value="'.$this->atribpor[$id][$dim][$subdim][$atrib].'"/>
							<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&atribpor="+document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value+"&api='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'>
						</td>
						<td>
							<span class="font"><textarea class="width" id="atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" name="atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'">'.$this->atributo[$id][$dim][$subdim][$atrib]['nombre'].'</textarea></span>
						</td>
					';

					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						if(isset($data['descripcion'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado])){
							$this->description[$id][$dim][$subdim][$atrib][$grado] = stripslashes($data['descripcion'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado]);
						}
						
						$description = '';
						if(isset($this->description[$id][$dim][$subdim][$atrib][$grado])){
							$description = $this->description[$id][$dim][$subdim][$atrib][$grado];
						}
						echo '
						<td colspan="'.$this->numrango[$id][$dim][$grado].'">
							<textarea rows="3" cols="30" id="descripcion'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado.'">'.$description.'</textarea>
						';
					}
					echo '
					</tr>
					<tr>
						<td></td><td></td><td></td><td/>
					';
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						foreach($this->rango[$id][$dim][$grado] as $key => $rango){
							echo '
						<td class="descripcion">
							<input type="radio" id="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado.'_'.$key.'" name="radio'.$id.'_'.$dim.'_'.$atrib.'" />
							<label for="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado.'_'.$key.'">'.$this->rango[$id][$dim][$grado][$key].'</label>
						</td>
						';
						}		
					}	
								
					echo '</tr>';
					//COMENTARIOS-ATRIBUTOS-------------------------
					$visible = null;
					if(isset($data['commentAtr'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])){
						$visible = stripslashes($data['commentAtr'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
						$this->commentAtr[$id][$dim][$subdim][$atrib] = $visible;
					}
						
					if(isset($this->commentAtr[$id][$dim][$subdim][$atrib]) && $this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
						$visible = 'visible';
						$novisible = 'hidden';
					}
					else{
						$novisible = 'visible';
						$visible = 'hidden';
					}
					echo '
					<tr>
						<td></td>
						<td>';
					if($this->view == 'design'){
						echo '
						<div style="text-align:right">
							<input type="button" class="showcomment" title="'. $string['add_comments'] .'" 
								onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&commentAtr'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'='.$novisible.'&comAtr='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'>
						</div>';
					}
					$totalrange = 0;
					foreach($this->numrango[$id][$dim] as $grado){
						$totalrange += $grado;
					}
					echo '
					</td><td/><td/>
					<td colspan="'.$totalrange.'">';
					
					if($visible == 'visible'){
						$divheight = 'height:2.5em';
						$textheight = 'height:2em';
					}
					else{
						$divheight  = 'height:0.5em';
						$textheight = 'height:0.5em';
					}
					echo '<div class="atrcomment" id="atribcomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" style="'.$divheight.'">
					<textarea disabled style="width:97%; visibility:'.$visible.'; '.$textheight.'; background-color:#ffffb5"  id="atributocomment'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'"></textarea>
						</div>
					</td>
					';
				
					echo '</tr>';
				}
			}
						echo '</table>
					</div>
					';
			if($this->view == 'design')
				echo '
					<div>
						<input type="button" class="add" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim='.$dim.'&sd='.$subdim.'&aS=1'.'", "mainform0");\'>
						<input type="button" class="down" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&moveSub='.$dim.'&sDown='.$subdim.'", "mainform0");\'>
						<br></div>
			';
			flush();
		}
		
		/**
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
		
		/**
		@param $array - array o tabla hash
		@param $i Ã­ndice del elemento a partir del que introducirÃ¡ el elemento $elem en $array
		@param $elem nuevo elemento a aÃ±adir
		@param $index indice del nuevo elemento. Si no se especifica, el nuevo Ã­ndice serÃ¡ $i+1
		@return $array con el nuevo elemento
		Añade $elem a @array a continuaciÃ³n de $i.
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
				$root = '<ru:Rubric xmlns:ru="http://avanza.uca.es/assessmentservice/rubric"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://avanza.uca.es/assessmentservice/rubric http://avanza.uca.es/assessmentservice/Rubric.xsd"
		';
				$rootend = '</ru:Rubric>
		';
			}
			elseif($mixed == '1'){
					$root = '<Rubric ';
				$rootend = '</Rubric>';
				$percentage1 = ' percentage="' . $this->porcentage . '"';
			}

			//ROOT-----------------------
			$xml = $root . ' id="'. $idtool .'" name="' . htmlspecialchars($this->titulo) . '" dimensions="' . $this->numdim[$id] .'" ' . $percentage1 . '>
		';
			//DESCRIPTION----------------
			if(isset($this->observation[$id])){
				$xml .= '<Description>' . htmlspecialchars($this->observation[$id]) . '</Description>
';
			}

			//DIMENSIONS------------------
			foreach($this->dimension[$id] as $dim => $itemdim){
				$dimid = (empty($this->dimensionsId[$id][$dim])) ? '' : $this->dimensionsId[$id][$dim];
				$xml .= '<Dimension id="'.$dimid.'" name="' .
					htmlspecialchars($this->dimension[$id][$dim]['nombre']) .
					'" subdimensions="' . $this->numsubdim[$id][$dim] . 
					'" values="' . $this->numvalores[$id][$dim] . 
					'" percentage="' . $this->dimpor[$id][$dim] . '">
		';
				$xml .=  "<Values>\n";
				//VALUES-----------------------
				foreach($this->valores[$id][$dim] as $grado => $elemvalue){
					$xml .=  '<Value id="'.$this->valoresId[$id][$dim][$grado].'" name="' . htmlspecialchars($this->valores[$id][$dim][$grado]['nombre']) . "\" instances=\"" . $this->numrango[$id][$dim][$grado] . "\">\n";
					foreach($this->rango[$id][$dim][$grado] as $key => $rango){
					   $xml .=  '<instance id="'.$this->rangoId[$id][$dim][$grado][$key].'">'. $this->rango[$id][$dim][$grado][$key] . "</instance>\n";
					}
					$xml .=  "</Value>\n";
				}
				$xml .=  "</Values>\n";
				
				//SUBDIMENSIONS-----------------
				foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
					$xml .= '<Subdimension id="'.$this->subdimensionsId[$id][$dim][$subdim].'" name="' . htmlspecialchars($this->subdimension[$id][$dim][$subdim]['nombre']) . '" attributes="' . $this->numatr[$id][$dim][$subdim] . '" percentage="' . $this->subdimpor[$id][$dim][$subdim] . '">
		';
					//ATTRIBUTES--------------------
					foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
						$comment = '';
						if(isset($this->commentAtr[$id][$dim][$subdim][$atrib]) && $this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible')
							$comment = '1';
							
						$xml .= '<Attribute id="'.$this->atributosId[$id][$dim][$subdim][$atrib].'" name="' . htmlspecialchars($this->atributo[$id][$dim][$subdim][$atrib]['nombre']) . '" comment="'. $comment .'" percentage="' . $this->atribpor[$id][$dim][$subdim][$atrib] . '">
						<descriptions>'."\n";
						//DESCRIPCIONES DE LAS RÃƒÅ¡BRICAS
					$j = 0;
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						$xml .=  '<description id="'.$this->descriptionsId[$id][$dim][$subdim][$atrib][$grado].'" value="' . $j . '">' . htmlspecialchars($this->description[$id][$dim][$subdim][$atrib][$grado]) . "</description>\n";
						$j++;
					}
						$xml .=  '</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		';
					}

					$xml .=  "</Subdimension>\n";
				}
				//GLOBAL VALUE-------------------
				if(isset($this->valglobal[$id][$dim]) && ($this->valglobal[$id][$dim] == 'true' || $this->valglobal[$id][$dim] == 't')){
					$comment = '';
					if($this->commentDim[$id][$dim] == 'visible')
						$comment = '1';
					$xml .=  '<DimensionAssessment percentage="' . $this->valglobalpor[$id][$dim] . '">
					<Attribute name="Global assessment" comment="'.$comment.'" percentage="0">
					<descriptions>'."\n";
						//DESCRIPCIONES DE LAS RÃƒÅ¡BRICAS
					$j = 0;
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						$xml .=  '<description value="' . $j . '"></description>'."\n";
						++$j;
					}
					$xml .=  '</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>'."\n";

					$xml .=  '</Attribute>
				</DimensionAssessment>';
				}

				$xml .=  "</Dimension>\n";
			}

			if(isset($this->valtotal[$id]) && ($this->valtotal[$id] == 'true' || $this->valtotal[$id] == 't')) {
				$xml .=  '<GlobalAssessment values="' . $this->numtotal[$id] . '" percentage="'.$this->valtotalpor[$id].'">
				<Values>
		';
			   foreach($this->valorestotal[$id] as $grado => $elemvalue){
				  $xml .=  '<Value id="'.$this->valorestotalesId[$id][$grado].'">'. htmlspecialchars($this->valorestotal[$id][$grado]['nombre']) . "</Value>\n";
			   }
				$xml .=  '</Values>

				<Attribute name="Global assessment" percentage="0">0</Attribute>
			</GlobalAssessment>
		';
			}
			$xml .= $rootend;
			
			return $xml;
		}
		
		function display_body_view($data, $mix='', $porcentage=''){
			if($porcentage != '')
				$this->porcentage = $porcentage;
			if(isset($data['titulo'.$this->id]))
				$this->titulo = stripslashes($data['titulo'.$this->id]);

			if(isset($data['valtotal'.$this->id]))
				$this->valtotal[$this->id] = stripslashes($data['valtotal'.$this->id]);
	
			if(isset($data['numvalores'.$id]) && $data['numvalores'.$id] >= 2)
				$this->numtotal[$this->id] = stripslashes($data['numvalores'.$id]);
			
			$checked = '';
			$disabled = 'disabled';
			if($this->valtotal[$this->id] == 'true' || $this->valtotal[$this->id] == 't'){
				$checked = 'checked';
				$disabled = '';
			}
			require($this->filediccionario);
		
			
			$numdimen = count($this->dimension[$id]);
			
			$id = $this->id;
			//----------------------------------------------
			echo '
			<div id="cuerpo'.$id.'" class="cuerpo">
				<br>
				<label for="titulo'.$id.'" style="margin-left:1em">'.$string['rubric'].':</label><span class="labelcampo">
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
			if($this->valtotal[$this->id] == 'true' || $this->valtotal[$this->id] == 't'){
				echo '
					<div class="valoraciontotal">
				';
			
			echo '
						<div class="margin">
							<label for="numdimensiones">'.strtoupper($string['totalvalue']).':</label>
							<span class="labelcampo"></span>						
			';
			
			echo '
							<span class="labelcampo"><label for="dimpor">'.$string['porvalue'].':</label><span class="labelcampo">
							<input class="porcentaje" type="text" name="valtotalpor'.$id.'" id="valtotalpor'.$id.'" value="'.$this->valtotalpor[$id].'" onkeyup=\'javascript:if(document.getElementById("valtotalpor'.$id.'").value > 100)document.getElementById("valtotalpor'.$id.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
							<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&dimpor'.$id.'="+document.getElementById("valtotalpor'.$id.'").value+"&dpi=vt&addDim=1", "mainform0");\'></span>
							
							<table class="maintable">
				';
				
				if(isset($this->valorestotal[$id])){
					foreach($this->valorestotal[$id] as $grado => $elemvalue){
						if(isset($data['valor'.$id.'_'.$grado])) 
							$this->valorestotal[$id][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$grado]);	
						echo '<th class="grado"><input class="valores" type="text" id="valor'.$id.'_'.$grado.'" name="valor'.$id.'_'.$grado.'" value="'.$this->valorestotal[$id][$grado]['nombre'].'"/></th>
						';
					}
				}
				echo '<tr>';
				foreach($this->valorestotal[$id] as $grado => $elemvalue){
					echo '<td><input type="radio" name="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
					';
				}					
				echo '</tr></table>
					</div>
				</div>';
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
				$this->dimension[$id][$dim]['nombre'] = stripslashes($data['dimension'.$id.'_'.$dim]);
			
			if(isset($data['numvalores'.$id.'_'.$dim]) && $data['numvalores'.$id.'_'.$dim] > 1) 
				$this->numvalores[$id][$dim] = stripslashes($data['numvalores'.$id.'_'.$dim]);

			if(isset($data['valglobal'.$id.'_'.$dim]))
				$this->valglobal[$id][$dim] = stripslashes($data['valglobal'.$id.'_'.$dim]);
			
			$checked = '';
			if($this->valglobal[$id][$dim] == "true"){
				$globalchecked = 'checked';
			}
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
				<input class="porcentaje" type="text" maxlength="3" name="dimpor'.$id.'_'.$dim.'" id="dimpor'.$id.'_'.$dim.'" value="'.$this->dimpor[$id][$dim].'" onkeyup=\'javascript:if(document.getElementById("dimpor'.$id.'_'.$dim.'").value > 100)document.getElementById("dimpor'.$id.'_'.$dim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
				<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("cuerpo'.$id.'", "mix='.$mix.'&id='.$id.'&dimpor'.$id.'="+document.getElementById("dimpor'.$id.'_'.$dim.'").value+"&dpi='.$dim.'&addDim=1", "mainform0");\'></span>
				<br>
				<div id="rubrica">
				';
			
			
			echo '<div class="clear"></div>
				</div>
				';
				
				
			if(isset($this->subdimension[$id][$dim])){
				foreach($this->subdimension[$id][$dim] as $subdim => $elemsubdim){
					echo '								
						<div class="subdimension" id="subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'">
					';
					$this->display_subdimension_view($dim, $subdim, $data, $id, $mix);
					echo '</div>					
					';
				}				
			}
			if($this->valglobal[$id][$dim] == "true"){
				echo '
					<div class="valoracionglobal">
				';
				echo '
						<div class="margin">
							<label>'.$string['globalvalue'].'</label>
							<span class="labelcampo"></span>													
							<span class="labelcampo"><label for="name="valglobalpor'.$id.'_'.$dim.'">'.$string['porvalue'].'</label><span class="labelcampo">
							<input class="porcentaje" type="text" maxlength="3"  name="valglobalpor'.$id.'_'.$dim.'" id="valglobalpor'.$id.'_'.$dim.'" value="'.$this->valglobalpor[$id][$dim].'" onkeyup=\'javascript:if(document.getElementById("valglobalpor'.$id.'_'.$dim.'").value > 100)document.getElementById("valglobalpor'.$id.'_'.$dim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
							<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&subdimpor="+document.getElementById("valglobalpor'.$id.'_'.$dim.'").value+"&spi=vg&addSubDim='.$dim.'", "mainform0");\'></span>
							
							<table class="maintable">
				';
				foreach($this->valores[$id][$dim] as $grado => $elemvalue){
					if(isset($data['valor'.$id.'_'.$dim.'_'.$grado])) 
						$this->valores[$id][$dim][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$dim.'_'.$grado]);
					
					echo '<th class="grado"><input class="valores" type="text" id="valor'.$id.'_'.$dim.'_'.$grado.'" name="valor'.$id.'_'.$dim.'_'.$grado.'" value="'.$this->valores[$id][$dim][$grado]['nombre'].'" onkeyup=\'javascript:var valores=document.getElementsByName("valor'.$id.'_'.$dim.'_'.$grado.'");for(var i=0; i<valores.length; i++){valores[i].value=this.value;}\'/></th>
					';
				}				
				echo '<tr>';
				foreach($this->valores[$id][$dim] as $grado => $elemvalue){
					echo '<td><input type="radio" name="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" /></td>
					';
				}						
				echo '</tr></table></div>
					</div>';
			}
			
			echo '</div>
			';
			
			flush();
		}		
		function display_subdimension_view($dim, $subdim, $data, $id=0, $mix=''){
			$id = $this->id;
			require($this->filediccionario);
			if(isset($data['subdimension'.$dim.'_'.$subdim])) 
				$this->subdimension[$id][$dim][$subdim]['nombre'] = stripslashes($data['subdimension'.$dim.'_'.$subdim]);

			echo '
					<div class="margin">
						<label for="subdimension'.$id.'_'.$dim.'_'.$subdim.'">'.$string['subdimension'].'</label>
						<span class="labelcampo">
							<span class="subdimensionvista">'.$this->subdimension[$this->id][$dim][$subdim]['nombre'].'</span>
						</span>
			';
			
			echo '
						<span class="labelcampo"><label for="subdimpor'.$id.'_'.$dim.'_'.$subdim.'">'.$string['porvalue'].'</label><span class="labelcampo">
						<input class="porcentaje" type="text" maxlength="3" id="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" name="subdimpor'.$id.'_'.$dim.'_'.$subdim.'" value="'.$this->subdimpor[$id][$dim][$subdim].'" onkeyup=\'javascript:if(document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value > 100)document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'/></span>
						<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&subdimpor="+document.getElementById("subdimpor'.$id.'_'.$dim.'_'.$subdim.'").value+"&spi='.$subdim.'&addSubDim='.$dim.'", "mainform0");\'>
						</span><br>
				<br>
						<table class="maintable">
							<tr><th/><th/>
							<th style="text-align:right;">
								<span class="font">'.$string['attribute'].'</span>  
								<span class="atributovalores" style="font-size:1em">/</span> 
								<span class="atributovalores">'.$string['values'].'</span></th>
						';
			foreach($this->valores[$id][$dim] as $grado => $elemvalue){
				if(isset($data['valor'.$id.'_'.$dim.'_'.$grado])) 
					$this->valores[$id][$dim][$grado]['nombre'] = stripslashes($data['valor'.$id.'_'.$dim.'_'.$grado]);
					
				echo '
					<th class="grado" colspan="'.$this->numrango[$id][$dim][$grado].'">
						<input style="background-color:#DDE0DD;height:	2em" type="text" class="itemrango1" id="valor'.$id.'_'.$dim.'_'.$grado.'" name="valor'.$id.'_'.$dim.'_'.$grado.'" value="'.$this->valores[$id][$dim][$grado]['nombre'].'"/>
					</th>						
				';
			}
			echo '</tr>';
			$numAtributo = count($this->atributo[$id][$dim][$subdim]);
			if(isset($this->atributo[$id][$dim][$subdim])){
				foreach($this->atributo[$id][$dim][$subdim] as $atrib => $elematrib){
					if(isset($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib])) 
						$this->atributo[$id][$dim][$subdim][$atrib]['nombre'] = stripslashes($data['atributo'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib]);
					
					echo '
					<tr rowspan="2">
						<td></td>				
						<td><input class="porcentaje" type="text" onkeyup=\'javascript:if(document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value > 100)document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value = 100;\' onkeypress=\'javascript:return validar(event);\'  maxlength="3" name="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" id="atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'" value="'.$this->atribpor[$id][$dim][$subdim][$atrib].'"/>
							<input class="botonporcentaje" type="button" onclick=\'javascript:sendPost("subdimensiontag'.$id.'_'.$dim.'_'.$subdim.'", "mix='.$mix.'&id='.$id.'&atribpor="+document.getElementById("atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'").value+"&api='.$atrib.'&addAtr='.$dim.'_'.$subdim.'", "mainform0");\'></td>
						<td>
							<span class="atributovista">'.$this->atributo[$id][$dim][$subdim][$atrib]['nombre'].'</span>
						</td>
					';
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						if(isset($data['descripcion'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado]))
							$this->description[$id][$dim][$subdim][$atrib][$grado] = stripslashes($data['descripcion'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado]);
						echo '
						<td colspan="'.$this->numrango[$id][$dim][$grado].'">
							<span>'.$this->description[$id][$dim][$subdim][$atrib][$grado].'</span>
						</td>
						';
					}
					echo '
					</tr>
					<tr>
						<td></td><td></td><td></td>
					';	
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						foreach($this->rango[$id][$dim][$grado] as $key => $rango){
							echo '
							<td class="descripcion">
								<input type="radio" id="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado.'_'.$key.'" name="radio'.$id.'_'.$dim.'_'.$atrib.'" />
								<br><label for="radio'.$id.'_'.$dim.'_'.$subdim.'_'.$atrib.'_'.$grado.'_'.$key.'">'.$this->rango[$id][$dim][$grado][$key].'</label>
							</td>';
						}
						echo '
						</td>';
						
					}			
					echo '</tr>';
				}
			}
						echo '</table>
					</div>
					';
			if($this->view == 'design')
				echo '
					<div><input type="button" class="add" onclick=\'javascript:sendPost("dimensiontag'.$id.'_'.$dim.'", "mix='.$mix.'&id='.$id.'&addSubDim='.$dim.'&sd='.$subdim.'&aS=1'.'", "mainform0");\'><br></div>
			';
			flush();
		}
		
		function print_tool($global_comment = 'global_comment'){
			$id = $this->id;
			require($this->filediccionario);
			$max = 0;
			$maxrango = array();
			foreach($this->dimension[$id] as $dim => $value){
				$maxrango[$dim] = array_sum($this->numrango[$id][$dim]);
			}
			$colspan = max($maxrango);
			
			echo '
								<table class="tabla" border=1 cellpadding=5px >
								
								<!--TITULO-INSTRUMENTO------------>
			';
			if(is_numeric($this->porcentage)){
				echo '
								<tr>
								   <td colspan="'.($colspan + 2) .'">'. $string['mixed_por']. ': ' . $this->porcentage.'%</td>
								</tr>
				';
			}
			
			echo '
								</tr>
								<tr>
								   <th colspan="'.($colspan + 2) .'">'.htmlspecialchars($this->titulo).'</th>
								</tr>

								<tr>
								   <th colspan="'.($colspan + 2) .'"></th>
								</tr>

								
								<tr>
								   <td></td>
								   <td></td>
								</tr>';
			$i = 0;
			foreach($this->dimension[$id] as $dim => $value){
				$colspandim = array_sum($this->numrango[$id][$dim]);
				
				echo '	
								<tr id="dim">
									<!--DIMENSIÓN-TITLE----------->
									<td class="pordim">
									'.$this->dimpor[$this->id][$dim].'%
									</td>
									<td class="bold" colspan="'.($colspan - $colspandim + 1) .'">
										<span>'.htmlspecialchars($this->dimension[$this->id][$dim]['nombre']).'</span>
									</td>
				';
				foreach($this->valores[$this->id][$dim] as $grado => $elemvalue){
					echo '
									<td class="td" colspan='.$this->numrango[$id][$dim][$grado].'>'.htmlspecialchars($this->valores[$this->id][$dim][$grado]['nombre']).'</td>
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
									<td class="subdim" colspan="'.($colspan + 1).'">'.htmlspecialchars($this->subdimension[$this->id][$dim][$subdim]['nombre']).'</td></tr>
					';
						
					if(isset($this->atributo[$this->id][$dim][$subdim])){
						$j = 0;
						foreach($this->atributo[$this->id][$dim][$subdim] as $atrib => $elematrib){
							echo '
								<!--ATRIBUTOS---------------------->
								<tr rowspan=2>
								<td class="atribpor">'.$this->atribpor[$this->id][$dim][$subdim][$atrib].'%</td>
								<td colspan="'. ($colspan - $colspandim + 1) .'">'.htmlspecialchars($this->atributo[$this->id][$dim][$subdim][$atrib]['nombre']).'</td>
							';

							foreach($this->valores[$id][$dim] as $grado => $elemvalue){
								echo '<td colspan="'.$this->numrango[$id][$dim][$grado].'">'.htmlspecialchars($this->description[$id][$dim][$subdim][$atrib][$grado]).'</td>';
							}
							echo '
								</tr>
								<tr><td colspan="'. ($colspan - $colspandim + 2) .'"></td>
							';
							$k = 0;
							foreach($this->valores[$id][$dim] as $grado => $elemvalue){		
								$m = 0;
								foreach($this->rango[$id][$dim][$grado] as $key => $rango){
									$checked = '';
									if(isset($this->valueattribute[$id][$dim][$subdim][$atrib]) && $this->valueattribute[$id][$dim][$subdim][$atrib] == $this->rango[$id][$dim][$grado][$key]){
										$checked = 'checked';
									}
									echo '<td class="descripcion" style="text-align:center"	>' . $this->rango[$id][$dim][$grado][$key] . '
									<div><input type="radio" class="custom-radio" id="radio' . $i . $l . $j . $k . $m . '" name="radio' . $i . $l . $j . '" '. $checked .' value=' . $this->rango[$id][$dim][$grado][$key] . '></div>
									</td>';
									++$m;
								}	
								++$k;
							}	
							
							echo '
								</tr>
								<tr>
									<td colspan="'. ($colspan - $colspandim + 2) .'"></td>
							';
							if(isset($this->commentAtr[$id][$dim][$subdim][$atrib]) && $this->commentAtr[$id][$dim][$subdim][$atrib] == 'visible'){
								$vcomment = '';
								if(isset($this->valuecommentAtr[$id][$dim][$subdim][$atrib])){
									$vcomment = htmlspecialchars($this->valuecommentAtr[$id][$dim][$subdim][$atrib]);
								}
								echo '
									<td colspan="'.$colspan.'">
										<textarea rows="2" style="height:6em;width:100%" id="observaciones'.$dim.'_'.$subdim.'_'.$atrib.'" name="observaciones'.$dim.'_'.$subdim.'_'.$atrib.'" style="width:100%">'.$vcomment.'</textarea>
									</td>
								';
							}
							echo '
								</tr>
								<tr></tr>
								<tr></tr>
							';
							++$j;
						}
					}
					++$l;
				}
				
				if(isset($this->valglobal[$id][$dim]) && $this->valglobal[$id][$dim] == 'true'){
					echo "
						<tr>
							<td class='subdimpor'>".$this->valglobalpor[$id][$dim]."%</td>
							<td class='global' colspan='".($colspan - $colspandim + 1) ."'>".$string['globalvalue']."</td>
					";
					
					
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){			
						foreach($this->rango[$id][$dim][$grado] as $key => $rango){
							$checked = '';
							if(isset($this->valueglobaldim[$id][$dim]) && $this->valueglobaldim[$id][$dim] == $this->rango[$id][$dim][$grado][$key]){
								$checked = 'checked';
							}
							echo '<td class="descripcion" style="text-align:center"	>' . $this->rango[$id][$dim][$grado][$key] . '
								<div><input type="radio" class="custom-radio" id="radio' . $i . '" name="radio' . $i . '" '. $checked .' value=' . $this->rango[$id][$dim][$grado][$key] . '></div>
								</td>';
						}
					}	
					echo "
						</tr>
						<tr>
							<td colspan='".($colspan - $colspandim + 2) ."'></td>
					";
					if(isset($this->commentDim[$id][$dim]) && $this->commentDim[$id][$dim] == 'visible'){
						$vcomment = '';
						if(isset($this->valuecommentDim[$id][$dim])){
							$vcomment = htmlspecialchars($this->valuecommentDim[$id][$dim]);
						}
							
						echo "
							<td colspan='".$colspandim."'>
								<textarea rows='3' style='height:6em;width:100%' id='observaciones".$dim."' name='observaciones".$dim."' style='width:100%'>".$vcomment."</textarea>
							</td>
						";
					}
					echo "
						</tr>
					";
				}
				++$i;
			}
			
			echo '
							</table>
			';
			if(isset($this->valorestotal[$id])){
				echo '
					<table class="tabla" border=1 cellpadding=5px >
								<tr>
									<td class="pordim">'.$this->valtotalpor[$id].'%</td>
									<td class="global" colspan="1">'.strtoupper($string['totalvalue']).'</td>
				';
				
				foreach($this->valorestotal[$id] as $grado => $elemvalue){
					echo '<th>'.htmlspecialchars($this->valorestotal[$id][$grado]['nombre']).'</th>
					';
				}
			
				echo '<tr><td class="global" colspan="2"></td>';
				foreach($this->valorestotal[$id] as $grado => $elemvalue){
					$checked = '';
					if(isset($this->valuetotalvalue[$id]) && $this->valuetotalvalue[$id] == $this->valorestotal[$id][$grado]['nombre']){
						$checked = 'checked';
					}
					
					echo '<td><input type="radio" class="custom-radio" name="total" value="'.htmlspecialchars($this->valorestotal[$id][$grado]['nombre']).'" '.$checked.' /></td>
					';
				}					
				echo '
								</tr>
							</table>
			';
			}

			
			if($global_comment == 'global_comment'){
				echo "<br><label for='observaciones'>". strtoupper($string['comments'])."</label><br>
                           <textarea name='observaciones' id='observaciones' rows=4 cols=20 style='width:100%'>".$this->observation[$id]."</textarea>";
			}
		}
		
		function save($cod = ''){
			$id = $this->id;
			if($cod == ''){
				throw new InvalidArgumentException('Missing scale cod');
			}
			
			require_once(DIRROOT . '/classes/plantilla.php');
			require_once(DIRROOT . '/classes/dimension.php');
			require_once(DIRROOT . '/classes/valoracion.php');
			require_once(DIRROOT . '/classes/dimval.php');
			require_once(DIRROOT . '/classes/subdimension.php');
			require_once(DIRROOT . '/classes/atributo.php');
			require_once(DIRROOT . '/classes/atribdes.php');
			require_once(DIRROOT . '/classes/atreva.php');
			require_once(DIRROOT . '/classes/dimeva.php');
			require_once(DIRROOT . '/classes/atrcomment.php');
			require_once(DIRROOT . '/classes/dimcomment.php');
			require_once(DIRROOT . '/classes/plaval.php');
			require_once(DIRROOT . '/classes/atribdes.php');
			require_once(DIRROOT . '/classes/rango.php');
			require_once(DIRROOT . '/classes/ranval.php');
			require_once(DIRROOT . '/classes/db.php');
			
			$type = 'rubrica';
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
			
			$valtotalpor = 0;
			if($valtotal == '1'){
				$valtotalpor = $this->valtotalpor[$id];
			}			
	
			$destroy = false;
			$recalculate = false;
			
			$dimvals = array();
			$ranvals = array();
			$plavals = array();
			$plavalsCod = array();
			$dimensionsCod = array();
			$dimvalsCod = array();
			$ranvalsCod = array();
			$subdimensionsCod = array();
			$subdimensions = array();
			$atributosCod = array();
			$atributos = array();
			$dimensions = array();
			$atrdesesCod = array();
			$atrdeses = array();
	
			if($modify == 0){
				$params['pla_cod'] = $cod;
				$params['pla_tit'] = $this->titulo;
				$params['pla_tip'] = $type;
				$params['pla_gpr'] = $valtotalpor;
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
				if($plantilla->pla_glo != $valtotal){
					$plantilla->pla_glo = $valtotal;
					$recalculate = true;
				}
				if($valtotal == '1'){
					$plantilla->pla_gpr = $valtotalpor;
				}
				$plantilla->pla_tit = $this->titulo;
				$plantilla->pla_des = $observation;			
				$plantilla->pla_por = $porcentage;
				
				if($updateplantilla == true){
					$pla_glo = '0';
					if(!empty($plantilla->pla_glo)){
					    $pla_glo = (string)$plantilla->pla_glo;
					}
					plantilla::set_properties($plantilla, array('id' => $tableid, 'pla_glo' => $pla_glo));
					$plantilla->update();
				}
			

				$numdim = 0;
				$numsubdim = 0;
				$numatributos = 0;
				$numvalores = 0;

				if($valtotal == '1'){
					if($plavals_aux = plaval::fetch_all(array('plv_pla' => $tableid))){
						foreach($plavals_aux as $keyplaval => $plaval_aux){
							$codPlaval = encrypt_tool_element($keyplaval);
							$plavalsCod[$codPlaval] = $keyplaval;
							$plavals[$keyplaval] = $plaval_aux;
						}
					}
				}
				$dimensions = dimension::fetch_all(array('dim_pla' => $tableid));//print_r($dimensions);
				$numdim = count($dimensions);
				
				foreach($dimensions as $keydim => $object){
					$codDim = encrypt_tool_element($keydim);
					$dimensionsCod[$codDim] = $keydim;
					
					if($dimvals_aux = dimval::fetch_all(array('div_dim' => $keydim))){
						foreach($dimvals_aux as $keydimval => $dimval_aux){
							$codDimval = encrypt_tool_element($keydimval);
							$dimvalsCod[$codDimval] = $keydimval;
							$dimvals[$keydimval] = $dimval_aux;
							
							if($ranvals_aux = ranval::fetch_all(array('rav_dim' => $keydim, 'ran_val' => $dimval_aux->div_val))){
								foreach($ranvals_aux as $keyranval => $ranval_aux){
									$codRanval = encrypt_tool_element($keyranval);
									$ranvalsCod[$codRanval] = $keyranval;
									$ranvals[$keyranval] = $ranval_aux;
								}
							}
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
									
									if($atrdes_aux = atribdes::fetch_all(array('atd_atr' => $keyatributo))){
										foreach($atrdes_aux as $keyatrdes => $atd_aux){
											$codAtrdes = encrypt_tool_element($keyatrdes);
											$atrdesesCod[$codAtrdes] = $keyatrdes;
											$atrdeses[$keyatrdes] = $atd_aux;
										}
									}
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
							$recalculate = true;
						}
						if($dimensions[$id_plane]->dim_nom != $this->dimension[$id][$dim]['nombre'] || $dimensions[$id_plane]->dim_pos != $dim_pos || $dimensions[$id_plane]->dim_com != $dim_com){
							$update = true;
						}
						if($dimensions[$id_plane]->dim_glo != $dim_glo){
							$update = true;
							$recalculate = true;
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
						$dim_gpr = '0';
						if(isset($this->valglobal[$id][$dim]) && ($this->valglobal[$id][$dim] == 'true' || $this->valglobal[$id][$dim] == 't')){
							$dim_glo = '1';
							$dim_gpr = $this->valglobalpor[$id][$dim];
							if($this->commentDim[$id][$dim] == 'visible'){
								$dim_com = '1';
							}
						}
						
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
						
						$recalculate = true;
					}
					
					$dimensionId = $this->dimensionsId[$id][$dim]; 
					$dim_plane = $dimensionsCod[$dimensionId];
					$div_pos = 0;
					$ran_pos = 0;
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
							
							if(isset($this->rango[$id][$dim][$grado])){
								foreach($this->rango[$id][$dim][$grado] as $key => $rango){
									$idRanval = $this->rangoId[$id][$dim][$grado][$key];
									if(isset($ranvalsCod[$idRanval])){
										$update = false;
										$id_plane_rango = $ranvalsCod[$idRanval];
										if($ranvals[$id_plane_rango]->rav_ran != $rango || $ranvals[$id_plane_rango]->rav_val != $elemvalue['nombre']
											|| $ranvals[$id_plane_rango]->rav_pos != $ran_pos){
											$update = true;
										}
										if($update == true){
											$params_range['ran_cod'] = $this->rango[$id][$dim][$grado][$key];
											if(!$rango_object = rango::fetch($params_range)){
												$rango_object = new rango($params_range);
												$rangoid = $rango_object->insert();
											}
											$ranvals[$id_plane_rango]->rav_val = $elemvalue['nombre'];
											$ranvals[$id_plane_rango]->rav_ran = $rango;
											$ranvals[$id_plane_rango]->rav_pos = $ran_pos;
											$ranvals[$id_plane_rango]->update();
										}
									
										unset($ranvals[$id_plane_rango]);
									}
									else{
										$params_range['ran_cod'] = $this->rango[$id][$dim][$grado][$key];
										if(!$rango = rango::fetch($params_range)){
											$rango = new rango($params_range);
											$rangoid = $rango->insert();
										}
									
										$params_ranval['rav_dim'] = $dim_plane;								
										$params_ranval['rav_val'] = $elemvalue['nombre'];							
										$params_ranval['rav_ran'] = $this->rango[$id][$dim][$grado][$key];
										$params_ranval['rav_pos'] = $ran_pos;
										$ranval = new ranval($params_ranval);
										$ranval->insert();
										$recalculate = true;
									}
									$ran_pos++;
								}
							}
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
							$params_dimval['div_val'] = $elemvalue['nombre'];
							$params_dimval['div_pos'] = $div_pos;
							$dimval = new dimval($params_dimval);
							$dimvalid = $dimval->insert();
							$dvid = $dimvalid;
							$codDimval = encrypt_tool_element($dimvalid);
							$dimvalsCod[$codDimval] = $dvid;						
							$this->valoresId[$id][$dim][$grado] = $codDimval;
							
							foreach($this->rango[$id][$dim][$grado] as $key => $rango){
								$params_range['ran_cod'] = $this->rango[$id][$dim][$grado][$key];
								if(!$rango_object = rango::fetch($params_range)){
									$rango_object = new rango($params_range);
									$rangoid = $rango_object->insert();
								}
								
								$params_ranval['rav_dim'] = $dim_plane;								
								$params_ranval['rav_val'] = $elemvalue['nombre'];							
								$params_ranval['rav_ran'] = $this->rango[$id][$dim][$grado][$key];
								$params_ranval['rav_pos'] = $ran_pos;
								$ranval = new ranval($params_ranval);
								$ranval->insert();
								$ran_pos++;
							}
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
								
								foreach($this->valores[$id][$dim] as $grado => $elemvalueatd){
									$idAtribdes = $this->descriptionsId[$id][$dim][$subdim][$atrib][$grado];
									if(isset($atrdesesCod[$idAtribdes])){
										$id_plane_atrd = $atrdesesCod[$idAtribdes];
										$updateAtd = false;
										if($atrdeses[$id_plane_atrd]->atd_des != $this->description[$id][$dim][$subdim][$atrib][$grado] ||
											$atrdeses[$id_plane_atrd]->atd_val != $elemvalueatd['nombre']){
											$updateAtd = true;
										}
										if($updateAtd == true){
											$atrdeses[$id_plane_atrd]->atd_val = $elemvalueatd['nombre'];
											$atrdeses[$id_plane_atrd]->atd_des = $this->description[$id][$dim][$subdim][$atrib][$grado];
											$atrdeses[$id_plane_atrd]->update();
										}
										unset($atrdeses[$id_plane_atrd]);
									}
									else{
										$value = $elemvalueatd['nombre'];
										$params_atribdes['atd_val'] = $value;
										$params_atribdes['atd_atr'] = $id_plane_atr;
										$params_atribdes['atd_des'] = $this->description[$id][$dim][$subdim][$atrib][$grado];
										$atribdes = new atribdes($params_atribdes);
										$atrdesId = $atribdes->insert();
										$codatrdes = encrypt_tool_element($atrdesId);
										$atrdesesCod[$codatrdes] = $atrdesId;
										$this->descriptionsId[$id][$dim][$subdim][$atrib][$grado] = $codatrdes;
									}
								}
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

								foreach($this->valores[$id][$dim] as $grado => $elemvalueatd){
									$value = $elemvalueatd['nombre'];
									$params_atribdes['atd_val'] = $value;
									$params_atribdes['atd_atr'] = $attributeid;
									$params_atribdes['atd_des'] = $this->description[$id][$dim][$subdim][$atrib][$grado];
									$atribdes = new atribdes($params_atribdes);
									$atrdesId = $atribdes->insert();
									$codatrdes = encrypt_tool_element($atrdesId);
									$atrdesesCod[$codatrdes] = $aid;						
									$this->descriptionsId[$id][$dim][$subdim][$atrib][$grado] = $codatributo;						
								}
							}
							
							$atr_pos++;
						}
						$sub_pos++;
					}
					$dim_pos++;
				}
				
				$plv_pos = 0;
				if (isset($this->valtotal[$id]) && ($this->valtotal[$id] == 'true' || $this->valtotal[$id] == 't')){	
					foreach($this->valorestotal[$id] as $grado => $elemvalue){
						$idPlaval = $this->valorestotalesId[$id][$grado];
						if(isset($plavalsCod[$idPlaval])){
							$update = false;
							$id_plane = $plavalsCod[$idPlaval];
							if($plavals[$id_plane]->plv_val != $elemvalue['nombre']){
								$update = true;
								$recalculate = true;
							}
							if($update == true){
								if(!$valoracion = valoracion::fetch(array('val_cod' => $elemvalue['nombre']))){									
									$valoracion = new valoracion(array('val_cod' => $elemvalue['nombre']));
									$valoracion->insert();
								}
								$plavals[$id_plane]->plv_val = $elemvalue['nombre'];
								$plavals[$id_plane]->plv_pos = $plv_pos;
								$plavals[$id_plane]->update();
							}	
							unset($plavals[$id_plane]);
						}
						else{
							$params_value['val_cod'] = $elemvalue['nombre'];
							if(!$valoracion = valoracion::fetch($params_value)){
								$valoracion = new valoracion($params_value);
								$valoracionid = $valoracion->insert();
							}
							
							$params_plaval['plv_pla'] = $tableid;
							$params_plaval['plv_val'] = $elemvalue['nombre'];
							$params_plaval['plv_pos'] = $plv_pos;
							$plaval = new plaval($params_plaval);
							$plavalid = $plaval->insert();
							$pvid = $plavalid;
							$codPlaval = encrypt_tool_element($plavalid);
							$plavalsCod[$codPlaval] = $pvid;						
							$this->valorestotalesId[$id][$grado] = $codPlaval;
							
							$recalculate = true;
						}
						$plv_pos++;
					}
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
				
				if(!empty($ranvals)){
					foreach($ranvals as $ranval){
						$ranval->delete();
					}
					$recalculate = true;
				}
				
				if(!empty($atrdeses)){
					foreach($atrdeses as $atrdes){
						$atrdes->delete();
					}
				}
				
				if(!empty($plavals)){
					foreach($plavals as $plaval){
						$plaval->delete();
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
					if($dimeva = dimeva::fetch(array('die_dim' => $object->id))){
						$dimeva->delete();
					}
					if($dimcom = dimcomment::fetch(array('dic_dim' => $object->id))){
						$dimcom->delete();
					}
					$object->delete();
				}
				if($plaval = plaval::fetch_all(array('plv_pla' => $tableid))){
					foreach($plaval as $plv){
						$plv->delete();
					}
				}
				
				//DIMENSIONS------------------
				$dim_position = 0;
				foreach($this->dimension[$id] as $dim => $itemdim){
					$dim_glo = '0';
					$dim_com = '0';
					$dim_gpr = '0';
					if(isset($this->valglobal[$id][$dim]) && ($this->valglobal[$id][$dim] == 'true' || $this->valglobal[$id][$dim] == 't')){
						$dim_glo = '1';
						$dim_gpr = $this->valglobalpor[$id][$dim];
						if($this->commentDim[$id][$dim] == 'visible'){
							$dim_com = '1';
						}
					}
					$params_dimension['dim_pla'] = $tableid;
					$params_dimension['dim_nom'] = $this->dimension[$id][$dim]['nombre'];
					$params_dimension['dim_por'] = $this->dimpor[$id][$dim];
					$params_dimension['dim_glo'] = $dim_glo;
					$params_dimension['dim_sub'] = $this->numsubdim[$id][$dim];
					$params_dimension['dim_com'] = $dim_com;
					$params_dimension['dim_gpr'] = $dim_gpr;
					$params_dimension['dim_pos'] = $dim_position;
					$dimension = new dimension($params_dimension);
					$dimensionid = $dimension->insert();
					$codDim = encrypt_tool_element($dimensionid);
					$this->dimensionsId[$id][$dim] = $codDim;
					
					$dim_pos = 0;
					$ran_pos = 0;
					foreach($this->valores[$id][$dim] as $grado => $elemvalue){
						$params_value['val_cod'] = $elemvalue['nombre'];
						if(!$valoracion = valoracion::fetch($params_value)){
							$valoracion = new valoracion($params_value);
							$valoracionid = $valoracion->insert();
						}
						
						$params_dimval['div_dim'] = $dimensionid;
						$params_dimval['div_val'] = $elemvalue['nombre'];
						$params_dimval['div_pos'] = $dim_pos;
						$dimval = new dimval($params_dimval);
						$dimvalid = $dimval->insert();
						$codDimval = encrypt_tool_element($dimvalid);
						$this->valoresId[$id][$dim][$grado] = $codDimval;
						
						foreach($this->rango[$id][$dim][$grado] as $key => $rango){
							$params_range['ran_cod'] = $this->rango[$id][$dim][$grado][$key];
							if(!$rango = rango::fetch($params_range)){
								$rango = new rango($params_range);
								$rangoid = $rango->insert();
							}
							
							$params_ranval['rav_dim'] = $dimensionid;
							$params_ranval['rav_val'] = $elemvalue['nombre'];
							$params_ranval['rav_ran'] = $this->rango[$id][$dim][$grado][$key];
							$params_ranval['rav_pos'] = $ran_pos;
							$ranval = new ranval($params_ranval);
							$ranval->insert();
							$ran_pos++;
						}
					
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
							
							foreach($this->valores[$id][$dim] as $grado => $elemvaluev){
								$value = $elemvaluev['nombre'];
								$params_atribdes['atd_val'] = $value;
								$params_atribdes['atd_atr'] = $attributeid;
								$params_atribdes['atd_des'] = $this->description[$id][$dim][$subdim][$atrib][$grado];
								$atribdes = new atribdes($params_atribdes);
								$atribdes->insert();
							}
							$atr_pos++;
						}
						$sub_pos++;
					}
					$dim_position++;
				}
				
				if(isset($this->valtotal[$id]) && ($this->valtotal[$id] == 'true' || $this->valtotal[$id] == 't')){
					$position = 0;
					foreach($this->valorestotal[$id] as $grado => $elemvalue){
						$params_value['val_cod'] = $this->valorestotal[$id][$grado]['nombre'];
						if(!$valoracion = valoracion::fetch($params_value)){
							$valoracion = new valoracion($params_value);
							$valoracionid = $valoracion->insert();
						}
						
						$params_plaval['plv_pla'] = $tableid;
						//$params_plaval['plv_val'] = $valoracionid;
						$params_plaval['plv_val'] = $this->valorestotal[$id][$grado]['nombre'];
						$params_plaval['plv_pos'] = $position;
						$position++;
						$plaval = new plaval($params_plaval);
						$plavalid = $plaval->insert();
						$codPlaval = encrypt_tool_element($plavalid);
						$this->valorestotalesId[$id][$grado] = $codPlaval;
					}
				}	
			}
			
			$params_result = array();
			if($recalculate == true){				
				require_once('../classes/assessment.php');
				if($assessments = assessment::fetch_all(array('ass_pla' => $tableid))){
					$plantilla->pla_mod = '1';
					$pla_glo = '0';
					if(!empty($plantilla->pla_glo)){
						$pla_glo = (string)$plantilla->pla_glo;
					}
					$plantilla->pla_glo = $pla_glo;
					$plantilla->update();
					require_once('../lib/finalgrade.php');
					foreach($assessments as $assessment){
						$finalgrade = finalgrade($assessment->id, $tableid);
						$gradexp = explode('/', $finalgrade);
						$params['ass_grd'] = $gradexp[0];
						$params['ass_mxg'] = $gradexp[1];
						assessment::set_properties($assessment, $params);
						$assessment->update();
					}
				}
				$params_result['recalculate'] = true;
			}
			
     
			$params_result['xml'] = $this->export(array('mixed' => '1', 'id' => $cod));
			return $params_result;
		}
	}