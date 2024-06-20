<?php
//Representa un intrumento mixto
class toolmix{
	private $titulo;
	private $listTool = array();
	private $index;
	private $toolpor;
	private $view;
	//string -- comentarios
	private $observation;
	private $plantillasId;
	private $comment;
	
	function __construct($lang='es_utf8', $titulo = '', $observation = '', $params = array()){
		$this->filediccionario = 'lang/'.$lang.'/evalcomix.php';
		$this->titulo = $titulo;
		$this->index = 0;
		$this->toolpor = array();
		$this->observation = $observation;
		$this->view = 'design';
		if(isset($params['plantillasId'])){
			$this->plantillasId = $params['plantillasId'];
		}
		$this->comment = (isset($params['comment'])) ? $params['comment'] : '';
	}

	//function get_toolpor(){return $this->toolpor;}
	//function get_tool($id){return $this->listTool[$id];}
	function get_tools(){return $this->listTool;}
	//function get_numtool(){return count($this->listTool);}
	function get_titulo($id = 0){return $this->titulo;}
	function get_dimension($id = 0){return $this->listTool[$id]->get_dimension();}
	//function get_numdim($id = 0){return $this->listTool[$id]->get_numdim();}
	function get_subdimension($id = 0){return $this->listTool[$id]->get_subdimension();}
	//function get_numsubdim($id = 0){return $this->listTool[$id]->get_numsubdim();}
	function get_atributo($id = 0){return $this->listTool[$id]->get_atributo();}
	//function get_numatr($id = 0){return $this->listTool[$id]->get_numatr();}
	function get_valores($id = 0){return $this->listTool[$id]->get_valores();}
	//function get_numvalores($id = 0){return $this->listTool[$id]->get_numvalores();}
	function get_valtotal($id = 0){return $this->listTool[$id]->get_valtotal();}
	/*function get_numtotal($id = 0){return $this->listTool[$id]->get_numtotal();}
	function get_valtotalpor($id = 0){return $this->listTool[$id]->get_valtotalpor();}
	function get_valorestotal($id = 0){return $this->listTool[$id]->get_valorestotal();}*/
	function get_valglobal($id = 0){return $this->listTool[$id]->get_valglobal();}
	/*function get_valglobalpor($id = 0){return $this->listTool[$id]->get_valglobalpor();}
	function get_dimpor($id = 0){return $this->listTool[$id]->get_dimpor();}
	function get_subdimpor($id = 0){return $this->listTool[$id]->get_subdimpor();}
	function get_atribpor($id = 0){return $this->listTool[$id]->get_atribpor();}
	function get_numrango($id = 0){return $this->listTool[$id]->get_numrango();;}*/
	function get_rango($id = 0){return $this->listTool[$id]->get_rango();}
	/*function get_dimensionsId(){return array();}
	function get_subdimensionsId(){return array();}
	function get_atributosId(){return array();}
	function get_valoresId(){return array();}
	function get_valorestotalesId(){return array();}
	function get_plantillasId($id = 0){return $this->plantillasId;}
	
	function set_titulo($titulo, $id = 0){$this->listTool[$id]->set_titulo($titulo);}
	function set_dimension($dimension, $id = 0){$this->listTool[$id]->set_dimension($dimension);}
	function set_numdim($numdim, $id = 0){$this->listTool[$id]->set_numdim($numdim);}
	function set_subdimension($subdimension, $id = 0){$this->listTool[$id]->set_subdimension($subdimension);}
	function set_numsubdim($numsubdim, $id = 0){$this->listTool[$id]->set_numsubdim($numsubdim);}
	function set_atributo($atributo, $id = 0){$this->listTool[$id]->set_atributo($atributo);}
	function set_numatr($numatr, $id = 0){$this->listTool[$id]->set_numatr($numatr);}
	function set_valores($valores, $id = 0){$this->listTool[$id]->set_valores($valores);}
	function set_numvalores($numvalores, $id = 0){$this->listTool[$id]->set_numvalores($numvalores);}
	function set_valtotal($valtotal, $id = 0){$this->listTool[$id]->set_valtotal($valtotal);}
	function set_numtotal($numtotal, $id = 0){$this->listTool[$id]->set_numtotal($numtotal);}
	function set_valtotalpor($valtotalpor, $id = 0){$this->listTool[$id]->set_valtotalpor($valtotalpor, $id);}
	function set_valorestotal($valorestotal, $id = 0){$this->listTool[$id]->set_valorestotal($valorestotal);}
	function set_valglobal($valglobal, $id = 0){$this->listTool[$id]->set_valglobal($valglobal);}
	function set_valglobalpor($valglobalpor, $id = 0){$this->listTool[$id]->set_valglobalpor($valglobalpor);}
	function set_dimpor($dimpor, $id){$this->listTool[$id]->set_dimpor($dimpor, $id);}
	function set_subdimpor($subdimpor, $id=0){$this->listTool[$id]->set_subdimpor($subdimpor);}
	function set_atribpor($atribpor, $id){$this->listTool[$id]->set_atribpor($atribpor, $id);}
	function set_rango($rango, $id = 0){$this->listTool[$id]->set_rango($rango);}
	function set_dimensionsId($dimensionsId, $id = ''){}
	function set_subdimensionsId($subdimensionsId, $id = ''){}
	function set_atributosId($atributosId, $id = ''){}
	function set_valoresId($valoresId, $id = ''){}
	function set_valorestotalesId($valoresId, $id = ''){}*/
	function set_plantillasId($plantillas, $id = ''){$this->plantillasId = $plantillas;}
		
	//function set_toolpor($porcentages){$this->toolpor = $porcentages;}
	function set_tools($listTool){
		$this->listTool = $listTool;
		foreach($listTool as $id => $tool){
			$this->toolpor[$id] = $tool->get_porcentage();
			$this->index = $id;
		}
		$this->index++;
	}
	/*function set_view($view, $id=''){
		$this->view = $view;
		foreach($this->listTool as $key => $tool){
			$this->listTool[$key]->set_view($view, $id);
		}
	}*/
	
	/*function addDimension($dim, $key, $id){
		$this->listTool[$id]->addDimension($dim, $key, $id);
	}
	
	function eliminaDimension($dim, $id){
		return $this->listTool[$id]->eliminaDimension($dim, $id);
	}
	
	function addSubdimension($dim, $subdim, $key, $id){
		return $this->listTool[$id]->addSubdimension($dim, $subdim, $key, $id);
	}
	
	function eliminaSubdimension($dim, $subdim, $id=0){
		return $this->listTool[$id]->eliminaSubdimension($dim, $subdim, $id);
	}
	
	function addValores($dim, $key, $id){
		return $this->listTool[$id]->addValores($dim, $key, $id);
	}
	
	function eliminaValores($dim, $grado, $id=0){
		return $this->listTool[$id]->eliminaValores($dim, $grado, $id);
	}
	function addAtributo($dim, $subdim, $atrib, $key, $id = 0){
		return $this->listTool[$id]->addAtributo($dim, $subdim, $atrib, $key, $id);
	}
	
	function eliminaAtributo($dim, $subdim, $atrib, $id){
		return $this->listTool[$id]->eliminaAtributo($dim, $subdim, $atrib, $id);
	}
	
	function addValoresTotal($key, $id){
		return $this->listTool[$id]->addValoresTotal($key, $id);
	}
		
	function eliminaValoresTotal($grado, $id){
		return $this->listTool[$id]->eliminaValoresTotal($grado, $id);
	}
	
	function addRango($dim, $grado, $key, $id){
		return $this->listTool[$id]->addRango($dim, $grado, $key, $id);
	}
		
	function eliminaRango($dim, $grado, $key, $id){
		return $this->listTool[$id]->eliminaRango($dim, $grado, $key, $id);
	}*/
	/*function upAtributo($dim, $subdim, $atrib,$id){
		return $this->listTool[$id]->upAtributo($dim, $subdim, $atrib);	
	}
	
	function downAtributo($dim, $subdim, $atrib,$id){
		return $this->listTool[$id]->downAtributo($dim, $subdim, $atrib);
	}*/
	
	/*function upBlock($params){
		require($this->filediccionario);
		require_once('array.class.php');
		
		if(!isset($params['mixed'])){
			$id = $params['id'];
			return $this->listTool[$id]->upBlock($params);
		}
		$id = $params['id'];
		$instance = $params['instance'];
		$blockData = $params['blockData'];
		$blockIndex = $params['blockIndex'];
		$blockName = $params['blockName'];
			
			
		if(isset($blockData)){
			$previousIndex = array_util::getPrevElement($blockData, $blockIndex);
			if($previousIndex !== false){
				$elem = $instance;
				$blockData = $this->arrayElimina($blockData, $blockIndex);
				$blockData = array_util::arrayAddLeft($blockData, $previousIndex, $elem, $blockIndex);
			}
		}
		$this->listTool = $blockData;
	}
	
	function downBlock($params){
		require($this->filediccionario);
		require_once('array.class.php');
		
		
		if(!isset($params['mixed'])){
			$id = $params['id'];
			return $this->listTool[$id]->downBlock($params);
		}
		
		$id = $params['id'];
		$instance = $params['instance'];
		$blockData = $params['blockData'];
		$blockIndex = $params['blockIndex'];
		$blockName = $params['blockName'];
		
	
		if(isset($blockData)){
			$nextIndex = array_util::getNextElement($blockData, $blockIndex);
			if($nextIndex !== false){
				$elem = $instance;
				$blockData = $this->arrayElimina($blockData, $blockIndex);
				$blockData = array_util::arrayAddRight($blockData, $nextIndex, $elem, $blockIndex);
			}
		}
		$this->listTool = $blockData;
	}
	
	
	function add($type, $index=null){
		require($this->filediccionario);
		$id = $this->index;
		
		$langAux = explode('/',$this->filediccionario);
		$language = $langAux[1];
		$titulo = $string['title'];
		list($usec, $sec) = explode(' ', microtime());
		$seed =  (float) $sec + ((float) $usec * 100000);	
		mt_srand($seed);
		$dim = mt_rand();
		$numdim[$id] = 1;
		$dimension[$id][$dim]['nombre'] = $string['titledim'];
		$commentDim[$id][$dim] = 'hidden';
		$valglobal[$id][$dim] = false;
		$valglobalpor[$id][$dim] = null;
		$dimpor[$id][$dim] = 100;
	
		$subdim = 0;
		$subdimension[$id][$dim][$subdim]['nombre'] = $string['titlesubdim'];
		$numsubdim[$id][$dim] = 1;
		$subdimpor[$id][$dim][$subdim] = 100;
	
		$atrib = 0;
		$atributo[$id][$dim][$subdim][$atrib]['nombre'] = $string['titleatrib'];
		$numatr[$id][$dim][$subdim] = 1;
		$commentAtr[$id][$dim][$subdim][$atrib] = 'hidden';
		$atribpor[$id][$dim][$subdim][$atrib] = 100;
	
		$numvalores[$id][$dim] = 2;
		$valores[$id][$dim][0]['nombre'] = $string['titlevalue'].'1';
		$valores[$id][$dim][1]['nombre'] = $string['titlevalue'].'2';
		if($type == 'lista'){
			$valores[$id][$dim][0]['nombre'] = $string['no'];
			$valores[$id][$dim][1]['nombre'] = $string['yes'];
		}
		
		$numtotal = array($id => 0);
		$valorestotal = array();
		$valtotal = null;
		$tool;
		switch($type){
			case 'lista':{
				$tool = new toollist($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr,
					$valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor,
					$atribpor, $commentAtr, $id);
			}break;
			case 'escala':{
				$tool = new toolscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr,
					$valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor,
					$atribpor, $commentAtr, $commentDim, $id);
			}break;
			case 'listaescala':{
				$tool = new toollistscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr,
					$valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, 
					$atribpor, $commentAtr, $commentDim, $id);
			}break;
			case 'diferencial':{
				$tool = new tooldifferential($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo,
					$numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor,
					$subdimpor, $atribpor, $commentAtr, $id, 1);
			}break;
			case 'rubrica':{
				$tool = new toolrubric($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr,
					$valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor,
					$atribpor, $commentAtr, $commentDim, $id);
			}break;
			case 'mixta':{
				$tool = new toolmix($language, $titulo);
			}break;*/
			/*case 'argumentario':{
				$tool = new toolargument($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $dimpor, $subdimpor, $atribpor, $commentAtr, $id);
			}break;*//*
		}
		if(isset($index) && $index != ''){
			$this->listTool = $this->arrayAdd($this->listTool, $index, $tool, $this->index);
			$this->index++;
		}
		else{
			$this->listTool[$this->index] = $tool;
			$this->index++;
		}
		
	}
	
	function remove($index){
		$this->listTool = $this->arrayElimina($this->listTool, $index);
	}
	
	function display_body($data){
		require($this->filediccionario);
		if($this->view == 'view'){
				echo '<input type="button" style="width:10em" value="'.$string['view'].'" onclick=\'javascript:location.href="generator.php?op=design"\'><br>';
			}
		if(isset($data['titulo']))
				$this->titulo = stripslashes($data['titulo']);
				
		echo '
		<div id="cuerpomix">
				<label for="titulo">'.$string['mix'].'</label>
				<span class="labelcampo">
					<textarea class="width" id="titulo" name="titulo" rows="3" cols="10">'.$this->titulo.'</textarea>
				</span>
		';
		if($this->view == 'design')
			echo '
				<select id="seltool" name="seltool" onchange=\'javascript:sendPost("body", "nopor=1&observation0="+document.getElementById("observation0").value + "&titulo="+document.getElementById("titulo").value+"&at=1&addtool="+this.value+"", "mainform0");\'>
					<option value="0">'.$string['addtool'].'</option>
					<option value="escala">'.$string['ratescale'].'</option>
					<option value="listaescala">'.$string['listrate'].'</option>
					<option value="lista">'.$string['checklist'].'</option>
					<option value="rubrica">'.$string['rubric'].'</option>
					<option value="diferencial">'.$string['differentail'].'</option>
				</select>
				<input type="hidden" id="sumpor" value=""/>
			';
		$mix = '';
		foreach($this->listTool as $id => $value){
			echo '
				<div class="bordertool">
			';
			if($this->view == 'design')
				echo '
					<div>
						<input type="button" class="delete" onclick=\'javascript:sendPost("body","nopor=1&mix='.$mix.'&amp;id='.$id.'&amp;titulo="+document.getElementById("titulo").value+"&amp;addtool'.$id.'=1&amp;observation0="+document.getElementById("observation0").value + "&amp;dt=1", "mainform0");\'>
						<input type="button" class="up" onclick=\'javascript:sendPost("body","nopor=1&mix='.$mix.'&amp;id='.$id.'&amp;titulo="+document.getElementById("titulo").value+"&amp;tUp='.$id.'&amp;observation0="+document.getElementById("observation0").value + "&amp;moveTool=1", "mainform0");\'>
						<br>
					</div>
				';
				
				$value->display_body($data, $id, $this->toolpor[$id]);;
			if($this->view == 'design')
				echo '
					<div>
						<input type="button" class="add" onclick=\'javascript:mostrar("newtool'.$id.'")\'>
						<span id="newtool'.$id.'">
							<select id="seltool'.$id.'" name="addtool'.$id.'" onchange=\'javascript:sendPost("body", "nopor=1&id='.$id.'&observation0="+document.getElementById("observation0").value + "&at=1&titulo="+document.getElementById("titulo").value+"&addtool'.$id.'="+this.value+"", "mainform0");\'>
								<option value="0">'.$string['addtool'].'</option>
								<option value="escala">'.$string['ratescale'].'</option>
								<option value="listaescala">'.$string['listrate'].'</option>
								<option value="lista">'.$string['checklist'].'</option>
								<option value="rubrica">'.$string['rubric'].'</option>
								<option value="diferencial">'.$string['differentail'].'</option>
							</select>
						</span>
					</div>
					<div>
						<input type="button" class="down" onclick=\'javascript:sendPost("body","nopor=1&mix='.$mix.'&amp;id='.$id.'&amp;titulo="+document.getElementById("titulo").value+"&amp;tDown='.$id.'&amp;observation0="+document.getElementById("observation0").value + "&amp;moveTool=1", "mainform0");\'>			
					</div>
				';
			echo '
				</div>';
		}
		
		
		if(isset($data['observation0']))
			$this->observation = stripslashes($data['observation0']);
				
		echo '
				<div id="comentario">
					<div id="marco">
						<label for="observation0">' . $string['observation']. ':</label>
						<textarea id="observation0" style="width:100%" rows="4" cols="200">' . $this->observation . '</textarea>
					</div>
				</div>
			';
			
		echo '
			
		</div>
		';
	}
	
	function display_dimension($dim, $data, $id){
		$this->listTool[$id]->display_dimension($dim, $data);
	}
	
	function display_subdimension($dim, $subdim, $data, $id){
		$this->listTool[$id]->display_subdimension($dim, $subdim, $data);
	}*/
	
	/*
	@param $array 
	@param $i índice del elemento a eliminar en $array
	@return $array sin el elemento
	Elimina de @array el elemento $i
	*/
	/*function arrayElimina($array, $i){
		$arrayAux = array();
		if(is_array($array)){
			foreach($array as $key => $value){
				if($key != $i)
					$arrayAux[$key] = $value;
			}
		}
		return $arrayAux;
	}*/
	
	/*
	@param $array - array o tabla hash
	@param $i índice del elemento a partir del que introducirá el elemento $elem en $array
	@param $elem nuevo elemento a añadir
	@param $index indice del nuevo elemento. Si no se especifica, el nuevo índice será $i+1
	@return $array con el nuevo elemento
	Añade $elem a @array a continuación de $i.
	*/
	/*function arrayAdd($array, $i, $elem, $index){
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
	}*/
	
	function export($params = array())
	{
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
		if($mixed == '0'){
			$root = '<mt:MixTool xmlns:mt="http://avanza.uca.es/assessmentservice/mixtool"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://avanza.uca.es/assessmentservice/mixtool http://avanza.uca.es/assessmentservice/MixTool.xsd"';
			$rootend = '</mt:MixTool>';
		}
		elseif($mixed == '1'){
			$root = '<MixTool ';
			$rootend = '</MixTool>';
		}
		
		$xml = $root . ' id="'. $idtool .'" name="' . htmlspecialchars($this->titulo) . '" instruments="' . count($this->listTool) .'">';
		
		//DESCRIPTION----------------
		if(isset($this->observation)){
			$xml .= '<Description>' . htmlspecialchars($this->observation) . '</Description>
';
		}

		foreach($this->listTool as $id => $value){
			$tid = (isset($this->plantillasId[$id])) ? $this->plantillasId[$id] : '';
			$xml .= $this->listTool[$id]->export(array('mixed' => '1', 'id' => $tid));
		}
		$xml .= $rootend;
		return $xml;
	}
	
	/*function display_body_view($data){
		require($this->filediccionario);

		if(isset($data['titulo']))
				$this->titulo = stripslashes($data['titulo']);
				
		echo '
		<div id="cuerpomix">
				<label for="titulo">'.$string['mix'].'</label>
				<span class="labelcampo">
					<span class="titulovista">'.$this->titulo.'</span>
				</span>
		';
		foreach($this->listTool as $id => $value){
			echo '
				<div class="bordertool">
			';
				
			$value->display_body_view($data, $id, $this->toolpor[$id]);;
			
			echo '<br>
				</div>';
		}
		
		
		if(isset($data['observation0']))
			$this->observation = stripslashes($data['observation0']);
				
		echo '
				<div id="comentario">
					<div id="marco">
						<label for="observation0">' . $string['observation']. ':</label>
						<textarea id="observation0" style="width:100%" rows="4" cols="200">' . $this->observation . '</textarea>
					</div>
				</div>
			';
			
		echo '
			
		</div>
		';
	}*/
	
	function print_tool($root = ''){
		require_once($this->filediccionario);
		foreach($this->listTool as $tool){
			$tool->print_tool();
			echo '<br><br><br>';
		}
	}
	
	function save($cod = ''){
		if($cod == ''){
			throw new InvalidArgumentException('Missing scale cod');
		}
			
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/dimension.php');
		require_once(DIRROOT . '/classes/subdimension.php');
		require_once(DIRROOT . '/classes/atributo.php');	
		require_once(DIRROOT . '/classes/atreva.php');
		require_once(DIRROOT . '/classes/dimeva.php');
		require_once(DIRROOT . '/classes/mixtopla.php');
		require_once(DIRROOT . '/classes/db.php');
			
		$type = 'mixto';
		$tableid = 0;
			
		$modify = 0;
		if($plantillamain = plantilla::fetch(array('pla_cod' => $cod))){
			$modify = 1;
			$tableid = $plantillamain->id;
		}
	
		$observation = '';
		if(isset($this->observation)){
			$observation = $this->observation;
		}

		$mixtoplas = array();
		$mixtotools = array(); //mixtotool[$mip_pla] = $mixtopla;
		$plantillas = array();
		$plantillasCod = array();
		$destroy = false;
		$recalculate = false;
		
		if($modify == 0){
			$params['pla_cod'] = $cod;
			$params['pla_tit'] = $this->titulo;
			$params['pla_tip'] = $type;
			$params['pla_gpr'] = '0';
			$params['pla_glo'] = '0';
			$params['pla_des'] = $observation;			
				
			$plantillamain = new plantilla($params);
			$tableid = $plantillamain->insert();
			$destroy = true;
		}
		else{
			$updateplantilla = false;
			if($plantillamain->pla_tit != $this->titulo || $plantillamain->pla_des != $this->observation ){
				$updateplantilla = true;
			}
			
			$plantillamain->pla_tit = $this->titulo;
			$plantillamain->pla_des = $observation;			
				
			if($updateplantilla == true){
				$plantillamain->pla_glo = '0';
				plantilla::set_properties($plantillamain, array('id' => $tableid));
				$plantillamain->update();
			}
			
			if($mixtoplas = mixtopla::fetch_all(array('mip_mix' => $tableid))){
				foreach($mixtoplas as $mixtopla){
					if($tool = plantilla::fetch(array('id' => $mixtopla->mip_pla))){
						$keyplantilla = $tool->id;
						$codPlantilla = $tool->pla_cod;
						$plantillasCod[$codPlantilla] = $keyplantilla;
						$plantillas[$keyplantilla] = $tool;
						$mixtotools[$keyplantilla] = $mixtopla;
					}
				}
			}
		}
		
		if($destroy == false){
			$position = 0;
			foreach($this->listTool as $id => $tool){ 
				$idPla = $this->plantillasId[$id];
				if(isset($plantillasCod[$idPla])){
					$update = false;
					$id_plane = $plantillasCod[$idPla];
					$porcentage = $tool->get_porcentage();
				
					if($porcentage != $plantillas[$id_plane]->pla_por || $mixtotools[$id_plane]->mip_pos != $position){
						$update = true;
					}
					if($update == true){
						$plantillas[$id_plane]->pla_por = $porcentage;
						
						$pla_glo = '0';
						if(isset($plantilla->pla_glo)){
						    $pla_glo = (string)$plantilla->pla_glo;
						}
						$plantillas[$id_plane]->pla_glo = $pla_glo;
						$plantillas[$id_plane]->update();
						$mixtotools[$id_plane]->mip_pos = $position;
						$mixtotools[$id_plane]->update();
					}
					unset($plantillas[$id_plane]);
					unset($mixtotools[$id_plane]);
					$result_params1 = $tool->save($idPla);
					if(isset($result_params1['recalculate'])){
						$recalculate = $result_params1['recalculate'];
					}
				}
				else{
					$singlecod = uniqid();
					$tool->save($singlecod);
					$singleid = 0;
			
					if($plantilla = plantilla::fetch(array('pla_cod' => $singlecod))){
						$singleid = $plantilla->id;
						$codPlantilla = $plantilla->pla_cod;
						$plantillasCod[$codPlantilla] = $singleid;
						$this->plantillasId[$id] = $codPlantilla;
					}
				
					$params_mip['mip_pla'] = $singleid;
					$params_mip['mip_mix'] = $tableid;
					$params_mip['mip_pos'] = $position;
					$mixtopla = new mixtopla($params_mip);
					$mixtoplaId = $mixtopla->insert();
					
					$recalculate = true;
				}
				$position++;
			}
			if(!empty($plantillas)){
				foreach($plantillas as $plantilla){
					$plantilla->delete();
				}
				$recalculate = true;
			}
			
			if(!empty($mixtotools)){
				foreach($mixtotools as $mixtopla){
					$mixtopla->delete();
				}
				$recalculate = true;
			}
		}
		elseif($destroy == true){
			foreach($mixtoplas as $mip){
				$dimensions = dimension::fetch_all(array('dim_pla' => $mip->mip_pla));
				foreach($dimensions as $object){
					$subdimens = subdimension::fetch_all(array('sub_dim' => $object->id));
					foreach($subdimens as $sub){
						$atribs = atributo::fetch_all(array('atr_sub' => $sub->id));
						foreach($atribs as $atr){
							if($atreva = atreva::fetch(array('ate_atr' => $atr->id))){
								$atreva->delete();
							}
						}
					}
					if($dimeva = dimeva::fetch(array('die_dim' => $object->id))){
						$dimeva->delete();
					}
				}
				$mip->delete();
			}
			
			$position = 0;
			foreach($this->listTool as $key => $tool){
				$singlecod = uniqid();
				$tool->save($singlecod);
				$singleid = 0;
		
				if($plantilla = plantilla::fetch(array('pla_cod' => $singlecod))){
					$singleid = $plantilla->id;
					$this->plantillasId[$key] = $plantilla->pla_cod;
				}
			
				$params_mip['mip_pla'] = $singleid;
				$params_mip['mip_mix'] = $tableid;
				$params_mip['mip_pos'] = $position;
				$mixtopla = new mixtopla($params_mip);
				$mixtopla->insert();
				$position++;
			}
		}
		
		$params_result= array();
		if($recalculate == true){				
			require_once(DIRROOT . '/classes/assessment.php');
			if($assessments = assessment::fetch_all(array('ass_pla' => $tableid))){
				$plantillamain->pla_mod = '1';
				$plantillamain->pla_glo = '0';
				$plantillamain->update();
				require_once(DIRROOT . '/lib/finalgrade.php');
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
			
		//$xml = $this->export('1');
		$xml = $this->export(array('mixed' => '1', 'id' => $cod));
		$params_result['xml'] = $xml;
		return $params_result;
	}
}
