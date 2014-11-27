<?php 
	//session_start();
	unset($_SESSION['tool']);
	include_once('selectlanguage.php');	
	
	if (isset($_GET['type'])){
		$postType = getParam($_GET['type']);
	}
	else {
		$postType = '';
	}
	$type = 'escala';
	if($postType == 'lista' || $postType == 'escala' || $postType == 'listaescala' || $postType == 'rubrica' || $postType == 'mixta' || $postType == 'diferencial' || $postType == 'importar' || $postType == 'argumentario')
		$type = $postType;
	
	$titulo = $string['title'];//"Título";
	$secuencia = 0; 
	$dimension = null;
	$numdim = null; 
	$subdimension = null;
	$numsubdim = null;
	$atributo = null;
	$numatr = null;
	$valores = null;
	$numvalores = null;
	$numtotal = null;
	$valorestotal = null;
	$valglobal = null;
	$valglobalpor = null;
	$dimpor = null;
	$subdimpor = null;
	$atribpor = null;
	$commentAtr = null;
	$commentDim = null;
	if($type != 'mixta' && $type != 'importar' && !isset($_SESSION['open'])){
		//unset($_SESSION['id']);
		$indexTool = 0;
		$dim = $secuencia;
		$numdim[$indexTool] = 1;
		$dimension[$indexTool][$dim]['nombre'] = $string['titledim'] . '1';//"Dimensión1";
		$commentDim[$indexTool][$dim] = 'hidden';
		$valglobal[$indexTool][$dim] = false;
		$valglobalpor[$indexTool][$dim] = null;
		$dimpor[$indexTool][$dim] = 100;

		$subdim = $secuencia++;
		$subdimension[$indexTool][$dim][$subdim]['nombre'] = $string['titlesubdim'].'1';//'Subdimensión1';
		$numsubdim[$indexTool][$dim] = 1;
		$subdimpor[$indexTool][$dim][$subdim] = 100;
	
		$atrib = $secuencia++;
		$atributo[$indexTool][$dim][$subdim][$atrib]['nombre'] = $string['titleatrib'].'1';//'Atributo1';
		$commentAtr[$indexTool][$dim][$subdim][$atrib] = 'hidden';
		$numatr[$indexTool][$dim][$subdim] = 1;
		$atribpor[$indexTool][$dim][$subdim][$atrib] = 100;
	
		$numvalores[$indexTool][$dim] = 2;
		$valores[$indexTool][$dim][0]['nombre'] = $string['titlevalue'].'1';//'Valor1';
		$valores[$indexTool][$dim][1]['nombre'] = $string['titlevalue'].'2';//'Valor2';
		if($type == 'lista'){
			$valores[$indexTool][$dim][0]['nombre'] = $string['no'];//'No';
			$valores[$indexTool][$dim][1]['nombre'] = $string['yes'];//'Sí';
		}
		
		$numtotal = array();
		$valorestotal = array();
		
	}
	
	$secuencia++;
	$language = 'es_utf8';
	if(isset($_SESSION['lang']))
		$language = $_SESSION['lang'];

	include_once('tool.php');
	$tool = new tool($language, $type, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, "false", $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim);
	$toolObj = serialize($tool);
	$_SESSION['tool'] = $toolObj;
	$_SESSION['secuencia'] = $secuencia;
?>
