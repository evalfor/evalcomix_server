<?php
//INICIALIZAMOS EL INSTRUMENTO DE EVALUACIÓN
	$session_id = session_id();
	if($session_id == ""){
		session_start();
	}
	require_once('tool.php');
	require_once('toolscale.php');
	require_once('toollist.php');
	require_once('weblib.php');
	if(!isset($_SESSION['tool'])){
		require_once('inicio.php');
	}
		
	$toolObj = $_SESSION['tool'];
	//servirá para generar identificadores
	$secuencia = $_SESSION['secuencia'];
	//representa el instrumento
	$tool = unserialize($toolObj);

	//-------------------------------------------------------
	//OPCIONES DEL MENÚ HORIZONTAL---------------------------
	//-------------------------------------------------------
	$op = '';
	if(isset($_GET['op'])){
		$op = getParam($_GET['op']);
	}
	switch($op){
		case 'export':{
			$xml1 = $tool->export();
			if(isset($xml1)){
				$filename = 'temp/evalcomix_file.evx';
				$fp = fopen($filename, 'wb');
				fwrite($fp, $xml1);
				header("Location: download.php?fic=".$filename);
			}
		}break;
		case 'import':{
			$tool->display_dialog();
			exit;
		}break;
		case 'view':{
			if(!isset($id)){
				$id = null;
			}
			$tool->set_view('view',$id);
		}break;
		case 'design':{
			if(!isset($id)){
				$id = null;
			}
			$tool->set_view('design',$id);
		}break;
	}
	//-------------------------------------------------------
	//FIN----------------------------------------------------
	//-------------------------------------------------------
	
	if($secuencia < 100)
		$secuencia = 100;
//LIMPIEZA DE LAS VARIABLES OBTENIDAS POR POST
	$id = '';
	if(isset($_POST['id'])){
		$id = getParam($_POST['id']);
	}
	if(isset($_POST['numdimensiones']))
		$postNumDim = getParam($_POST['numdimensiones']);
	if(isset($_POST['addDim']))
		$postAddDim = getParam($_POST['addDim']);
	if(isset($_POST['addSubDim']))
		$postSubDim = getParam($_POST['addSubDim']);
	if(isset($_POST['ad']))
		$addim = getParam($_POST['ad']);
	if(isset($_POST['dd']))
		$deldim = getParam($_POST['dd']);
	if(isset($_POST['addAtr']))
		$postAddAtr = getParam($_POST['addAtr']);
	if(isset($_POST['at']))
		$postAddAtrib = getParam($_POST['at']);
	if(isset($_POST['dt']))
		$postDelAtrib = getParam($_POST['dt']);
	if(isset($_POST['numvalores'.$id]))
		$postNumValorTotal = getParam($_POST['numvalores'.$id]);
	$postValorTotal = '';
	if(isset($_POST['valtotal'.$id]))
		$postValorTotal = getParam($_POST['valtotal'.$id], '');
	if(isset($_POST['moveAtr']))
		$postMoveAtr = getParam($_POST['moveAtr']);
	if(isset($_POST['aUp']))
		$postUpAtr = getParam($_POST['aUp']);
	if(isset($_POST['aDown']))
		$postDownAtr = getParam($_POST['aDown']);
	if(isset($_POST['moveSub']))
		$postMoveSub = getParam($_POST['moveSub']);
	if(isset($_POST['sUp']))
		$postUpSub = getParam($_POST['sUp']);
	if(isset($_POST['sDown']))
		$postDownSub = getParam($_POST['sDown']);
	if(isset($_POST['moveDim']))
		$postMoveDim = getParam($_POST['moveDim']);
	if(isset($_POST['dUp']))
		$postUpDim = getParam($_POST['dUp']);
	if(isset($_POST['dDown']))
		$postDownDim = getParam($_POST['dDown']);
	if(isset($_POST['moveTool']))
		$postMoveTool = getParam($_POST['moveTool']);
	if(isset($_POST['tUp']))
		$postUpTool = getParam($_POST['tUp']);
	if(isset($_POST['tDown']))
		$postDownTool = getParam($_POST['tDown']);
	
//DETERMINACIÓN Y MANEJO DE EVENTOS-------------------------------------------------------------------------------->

/***********************************************************************************
************************************************************************************
Evento Añadir/Eliminar Instrumentos
************************************************************************************
************************************************************************************/
	if(isset($_POST['addtool'.$id])){
		$postTypeTool = getParam($_POST['addtool'.$id]);
	}
	if(isset($postTypeTool)){	
		if(isset($_POST['dt'])){
			$postDeleteTool = getParam($_POST['dt'],null);
		}
		if(isset($_POST['at'])){
			$postAddTool = getParam($_POST['at']);
		}
		if(isset($postDeleteTool)){
			$tool->remove($id);
		}
		elseif(isset($postAddTool) && $postAddTool != ''){
			$tool->add($postTypeTool, $id);
		}
//----------------------------------------------------------
//PORCENTAJE INSTRUMENTOS-----------------------------------
//----------------------------------------------------------
		if(isset($_POST['toolpor_'.$id])){
			$posttoolPor = getParam($_POST['toolpor_'.$id]);
		}
		//porcentaje de las dimensiones
		$toolpor = $tool->get_toolpor();
		$postItemMod = getParam($_POST['sumpor']);
		if(isset($_POST['nopor'])){
			$postNoPor = getParam($_POST['nopor']); //indica que no se ha pulsado un botón de porcentaje.
		}
		if((!isset($postNoPor) || $postNoPor == '') && isset($posttoolPor) && is_numeric($posttoolPor) && $posttoolPor >= 0 && $posttoolPor <= 100 && !isset($postDeleteTool)){
			$portool = $posttoolPor;
			$index = $id;
			$numtool = $tool->get_numtool();
			$porcentage = $portool;
			if($numtool > 1){
				$porcentage = floor((100 - $portool) / ($numtool-1));
			}
			
			//conjunto de porcentajes introducidos por el usuario y que hay que intentar mantener
			//id-id-id-...
			$aux = explode('-', $postItemMod);
			$idItemMod = array_unique($aux); 
			array_pop($idItemMod);
			//--------------------------------------
			
			//Sumo los valores de idItemMod
			$sumaMod = 0;
			$numMod = 0;
			$ponInput = array();
			$samebutton = 1;//indica si el usuario a mandado ha pulsado un botÃ³n relacionado con alguno de los valores recibidos o no
			foreach($idItemMod as $key => $cod){
				$postPor = getParam($_POST[$cod]);
				if(isset($postPor)){
					$numMod++;
					$sumaMod += $postPor;
					$aux = explode('_', $cod);
					$ponInput[$aux[1]] = $postPor;
					if($aux[1] == $index)
						$samebutton = 0;
				}
			}
			if($samebutton){
				$numMod++;
				$ponInput[$index] = $portool;
				$sumaMod += $portool;
			}
		
//			echo "sumamod = $sumaMod y numMod = $numMod y numtool:". $numtool;
			$state = 0;
			if($numMod == $numtool && $sumaMod != 100){
				$state = 0;
				//echo "<span class='error'>Error: La suma de porcentajes es distinta a 100. Se establecerÃ¡n valores correctos</span>";
			}
			elseif($numMod != $numtool && $sumaMod > 100 ){
				$state = 0;
				//echo "<span class='error'>Error: La suma de porcentajes es distinta a 100. Se establecerÃ¡n valores correctos</span>";
			}
			elseif($numMod == $numtool && $sumaMod == 100)
				$state = 2;
			else{
				$state = 1;
			}
		
			if($state == 0){
				//porcentage a repartir por el resto de atributos
				$porcentage = $portool;
				if($numtool > 1){
					$porcentage = floor((100 - $portool) / ($numtool - 1));
					foreach($toolpor as $key => $value){
					if((string)$key != (string)$index)
						$toolpor[$key] = $porcentage;
					}			
					$portool[$index] = $portool;
				}
				else{
					$portool[$index] = 100;
				}
			}
			elseif($state == 1){
				$porcentage;
				$sumpercentage = array_sum($ponInput);//echo "(100-$sumpercentage) / ($numtoo:$sumpercentage; numtool:$numtool;<br>";
				if($numtool > 1){
					$porcentage = floor((100 - $sumpercentage) / ($numtool-$numMod));
				}
				else{
					$toolpor[$index] = 100;
				}
				//echo $sumpercentage;
				foreach($toolpor as $key => $value){
					if(isset($ponInput[$key]))
						$toolpor[$key] = $ponInput[$key];
					elseif((string)$key == (string)$index)
						$toolpor[$index] = $poratrib;
					else
						$toolpor[$key] = $porcentage;
				}
			}
			elseif($state == 2){
				foreach($toolpor as $key => $value){
					$toolpor[$key] = $ponInput[$key];
				}
			}
			/*$tools = $tool->get_tools();
			foreach($tools as $key => $value){
				$toolpor[$key] = $porcentage;
				if((string)$key == (string)$index)
					$toolpor[$key] = $portool;
			}*/
			
			$tool->set_toolpor($toolpor);
		}
		elseif(!isset($_POST['save'])){
			$numtool = $tool->get_numtool();
			if($numtool > 0){
				$porcentage = floor(100 / $numtool);
				$tools = $tool->get_tools();
				foreach($tools as $key => $value){
					$toolpor[$key] = $porcentage;
				}
				$tool->set_toolpor($toolpor);
			}
		}
	}
/***********************************************************************************
************************************************************************************
Evento Añadir/Eliminar dimensiones
************************************************************************************
************************************************************************************/
	if(isset($postAddDim)){
		//número de dimensiones
		$numdim = count($tool->get_dimension($id));
		if(isset($postNumDim) && !isset($addim) && !isset($deldim)){
			if($postNumDim > $numdim){
				$nd = $numdim;
				for($i = $nd; $i < $postNumDim; $i++){
					$key = $secuencia;
					$tool->addDimension(null, $key, $id);
					$secuencia++;
					$_SESSION['secuencia'] = $secuencia;
				}
			}
			elseif($postNumDim < $numdim){
				$i = 0;
				//array[][] - datos de las dimensiones
				$dimension = $tool->get_dimension($id);
				foreach($dimension as $key => $value){
					if($i >= $postNumDim){
						$dim = $key;
						$tool->eliminaDimension($dim);
					}
					$i++;
				}
			}
		}
		elseif(isset($addim)){
			$key = $secuencia;
			$dim = $addim;
			$tool->addDimension($dim, $key, $id);
			$secuencia++;
			$_SESSION['secuencia'] = $secuencia;
		}
		elseif(isset($deldim)){
			$dim = $deldim;
			$tool->eliminaDimension($dim, $id);
		}
		
//----------------------------------------------------------
//PORCENTAJE DIMENSIONES------------------------------------
//----------------------------------------------------------
		if(isset($_POST['dimpor'.$id])){
			$postDimPor = getParam($_POST['dimpor'.$id]); 
		}
		if(isset($_POST['dpi'])){
			$postdimIndex = getParam($_POST['dpi']);
		}
		if(isset($_POST['sumpor3'.$id])){
			$postItemMod = getParam($_POST['sumpor3'.$id]);
		}
		//porcentaje de las dimensiones
		$dimpor = $tool->get_dimpor($id);
		if(isset($postDimPor) && is_numeric($postDimPor) && $postDimPor >= 0 && $postDimPor <= 100 && isset($postdimIndex)){
			$pordim = $postDimPor;
			$index = $postdimIndex;
			$numdimen = $tool->get_numdim($id);
			if($tool->get_valtotal($id) == 'true' || $tool->get_valtotal($id) == 't')
				$numdimen++;
			$porcentage = $pordim;
			if($numdimen > 1){
				$porcentage = floor((100 - $pordim) / ($numdimen-1));
			}
			else{
				$dimpor[$index] = 100;
			}
			
			//conjunto de porcentajes introducidos por el usuario y que hay que intentar mantener
			//id-id-id-...
			$aux = explode('-', $postItemMod);
			$idItemMod = array_unique($aux); 
			array_pop($idItemMod);
			//--------------------------------------
		
			//Sumo los valores de idItemMod
			$sumaMod = 0;
			$numMod = 0;
			$ponInput = array();
			$samebutton = 1;//indica si el usuario ha pulsado un botÃ³n relacionado con alguno de los valores recibidos o no
			foreach($idItemMod as $key => $cod){
				$postPor = getParam($_POST[$cod]);
				if(isset($postPor)){	
					$numMod++;
					$sumaMod += $postPor;
					$aux = explode('_', $cod);
					if($aux[0] == 'valtotalpor'.$id){
						$ponInput['vt'] = $postPor;
						if($index == 'vt')
							$samebutton = 0;
					}
					else{
						$ponInput[$aux[1]] = $postPor;
						if($aux[1] == $index)
							$samebutton = 0;
					}
				}
			}
			if($samebutton){
				$numMod++;
				$ponInput[$index] = $pordim;
				$sumaMod += $pordim;
			}
		
			$state = 0;
			if($numMod == $numdimen && $sumaMod != 100){
				$state = 0;
			}
			elseif($numMod != $numdimen && $sumaMod > 100 ){
				$state = 0;
			}
			elseif($numMod == $numdimen && $sumaMod == 100)
				$state = 2;
			else{
				$state = 1;
			}

			if($state == 0){
				//porcentage a repartir por el resto de atributos
				$porcentage = $pordim;
				if($numdimen > 1){
					$porcentage = floor((100 - $pordim) / ($numdimen - 1));
					foreach($dimpor as $key => $value){
						$dimpor[$key] = $porcentage;
						if((string)$key == (string)$index)
							$dimpor[$key] = $pordim;
					}
					if($index == 'vt')
						$valtotalpor = $pordim;
					elseif($valtotal == 'true')
						$valtotalpor = $porcentage;
				}
				else{
					$dimpor[$index] = 100;
				}
			}
			elseif($state == 1){
				$porcentage;
				$sumpercentage = array_sum($ponInput);
				if($numdimen > 1){
					$porcentage = floor((100 - $sumpercentage) / ($numdimen - $numMod));
				}
				else{
					$dimpor[$index] = 100;
				}
				foreach($dimpor as $key => $value){
					if(isset($ponInput[$key])){
						$dimpor[$key] = $ponInput[$key];}
					elseif((string)$key == (string)$index){
						$dimpor[$index] = $pordim;}
					else{
						$dimpor[$key] = $porcentage;}
				}
				if(isset($ponInput['vt']))
					$valtotalpor = $ponInput['vt'];
				else
					$valtotalpor = $porcentage;
			}
			elseif($state == 2){
				foreach($dimpor as $key => $value){
					$dimpor[$key] = $ponInput[$key];
				}
				if(isset($valtotal) && $valtotal == 'true')
					$valtotalpor = $ponInput['vt'];
			}
			
			if(isset($valtotalpor)){
				$tool->set_valtotalpor($valtotalpor, $id);
			}
			$tool->set_dimpor($dimpor, $id);
		}
		elseif(!isset($_POST['save'])){
			$numdimen = $tool->get_numdim($id);
			$booltotal = '';
			if(isset($_POST['valtotal'.$id])){
				$booltotal = getParam($_POST['valtotal'.$id]);
			}
			if($booltotal == 'true')
				$numdimen++;
			$porcentage = floor(100 / $numdimen);
			$dimen = $tool->get_dimension($id);
			foreach($dimen as $key => $value){
				$dimpor[$key] = $porcentage;
			}
			if($booltotal == 'true'){
				$tool->set_valtotalpor($porcentage, $id);
			}				
			$tool->set_dimpor($dimpor, $id);
		}
//-----------------------------------------------------
//VALORACIÃ“N TOTAL-------------------------------------
//-----------------------------------------------------
		if($postValorTotal == 'true' && isset($postNumValorTotal)){
			//nÃºmero de valores--------------------------------------
			$numtotal = $tool->get_numtotal($id); 
			if($postNumValorTotal > $numtotal){
				$nvalores = $numtotal;
				//Como mÃ­nimo habrÃ¡ 2 valores. Controlamos el caso de que el nÃºmero de valores introducido sea 1
				$numvalortotal = $postNumValorTotal;
				if($postNumValorTotal < 2)
					$numvalortotal = 2;
				for($i = $nvalores; $i < $numvalortotal; $i++){
					$key = $secuencia;
					$tool->addValoresTotal($key, $id);
					$secuencia++;
					$_SESSION['secuencia'] = $secuencia;
				}
			}
			elseif($postNumValorTotal < $numtotal){
				$i = 0; 
				$valorestotal = $tool->get_valorestotal($id); 
				foreach($valorestotal as $key => $value){
					if($i >= $postNumValorTotal){
						$grado = $key;
						$tool->eliminaValoresTotal($grado, $id);
					}
					$i++;
				}
			}
		}
	}
/*****************************************************************************************
******************************************************************************************
		Evento AÃ±adir/Eliminar subdimensiones y valores
******************************************************************************************	
*******************************************************************************************/
	elseif(isset($postSubDim)){
		$dim = getParam($postSubDim);
		if(isset($_POST['sd']))
			$subdim = getParam($_POST['sd']);
		if(isset($_POST['aS']))
			$postAddSubDim = getParam($_POST['aS']);
		if(isset($_POST['dS']))
			$postDelSubDim = getParam($_POST['dS']);
		$postNumValues = '';
		if(isset($_POST['numvalores'.$id.'_'.$dim]))
			$postNumValues = getParam($_POST['numvalores'.$id.'_'.$dim]);
		if(isset($_POST['numsubdimensiones'.$id.'_'.$dim]))
			$postNumSubDim = getParam($_POST['numsubdimensiones'.$id.'_'.$dim]);
//-------------------------------------------------------
//nÃºmero de valores--------------------------------------
//-------------------------------------------------------
		//array[] - nÃºmero de grados de las dimensiones
		$numvalores = $tool->get_numvalores($id);
		if(isset($numvalores[$dim]) && $postNumValues > $numvalores[$dim]){
			$nvalores = $numvalores[$dim]; 
			for($i = $nvalores; $i < $postNumValues; $i++){
				$key = $secuencia;
				$tool->addValores($dim, $key, $id);
				$secuencia++;
				$_SESSION['secuencia'] = $secuencia;
			}
		}
		elseif(isset($numvalores[$dim]) && $postNumValues < $numvalores[$dim]){
			$i = 0;
			//array[][] - datos de los grados de las dimensiones
			$valores = $tool->get_valores($id);
			foreach($valores[$dim] as $key => $value){
				if($i >= $postNumValues){
					$grado = $key;
					$tool->eliminaValores($dim, $grado, $id);
				}
				$i++;
			}
		}

//-------------------------------------------------------		
//nÃºmero de subdimensiones-------------------------------
//-------------------------------------------------------
		if(isset($postNumSubDim) && !isset($postAddSubDim) && !isset($postDelSubDim)){
			//array[] - nÃºmero de subdimensiones por subdimension
			$numsubdim =  $tool->get_numsubdim($id);
			if($postNumSubDim > $numsubdim[$dim]){
				$ns = $numsubdim[$dim];
				for($i = $ns; $i < $postNumSubDim; $i++){
					$key = $secuencia;
					$tool->addSubdimension($dim, null, $key, $id);
					$secuencia++;
					$_SESSION['secuencia'] = $secuencia;
				}
			}
			elseif($postNumSubDim < $numsubdim[$dim]){
				$i = 0;
				//array[][][] - datos de las subdimensiones
				$subdimension = $tool->get_subdimension($id);
				foreach($subdimension[$dim] as $key => $value){
					if($i >= $postNumSubDim){
						$subdim = $key;
						$tool->eliminaSubdimension($dim, $subdim, $id);
					}
					$i++;
				}
			}
		}
		elseif(isset($postAddSubDim)){
			$key = $secuencia;
			$tool->addSubdimension($dim, $subdim, $key, $id);
			$secuencia++;
			$_SESSION['secuencia'] = $secuencia;
		}
		elseif(isset($postDelSubDim)){
			$tool->eliminaSubdimension($dim, $subdim, $id);
		}

//-----------------------------------------------
//Rango------------------------------------------
//-----------------------------------------------
		if(isset($_POST['addrango'])){
			$postAddRango = getParam($_POST['addrango']);
		}
		if(isset($_POST['idrango'])){
			$postIdRango = getParam($_POST['idrango']);
		}
		if(isset($postAddRango)){
			if(isset($_POST['sel'])){
				$postSelect = getParam($_POST['sel']);
			}
			$rango[$id] = $tool->get_rango($id);

			if(isset($postAddRango)){
				$aux = explode('_', $postAddRango);
				$grado = $aux[1];
			}
			if(isset($postIdRango)){
				$aux2 = explode('_', $postIdRango);
				$key = $aux2[3];
			}
			if(isset($postSelect) && $postSelect >= 0 && $postSelect <= 100 && isset($grado) && isset($key)){
				$rango[$id][$dim][$grado][$key] = $postSelect;
				$tool->set_rango($rango, $id);

			}
			$postNumRango = getParam($_POST['numrango'.$id.'_'.$dim.'_'.$grado]);
			$numrango = $tool->get_numrango($id);
			if(isset($numrango) && $postNumRango > $numrango[$id][$dim][$grado]){
				$nvalores = $numrango[$id][$dim][$grado];
				for($i = $nvalores; $i < $postNumRango; $i++){
					$key = $secuencia;
					$tool->addRango($dim, $grado, $key, $id);
					$secuencia++;
					$_SESSION['secuencia'] = $secuencia;
				}
			}
			elseif(isset($numrango) && $postNumRango < $numrango[$id][$dim][$grado]){
				$i = 0;
				$rango[$id] = $tool->get_rango($id);
				foreach($rango[$id][$dim][$grado] as $key => $value){
					if($i >= $postNumRango){
						$tool->eliminaRango($dim, $grado, $key, $id);
					}
					$i++;
				}
			}
		}

//-----------------------------------------------
//Porcentaje de subdimensiones-------------------
//-----------------------------------------------
		if(isset($_POST['subdimpor'])){
			$postSubdimPor = getParam($_POST['subdimpor']);
		}
		if(isset($_POST['spi'])){
			$postSubdimIndex = getParam($_POST['spi']);
		}
		if(isset($_POST['sumpor2'.$id.'_'.$dim])){
			$postItemMod = getParam($_POST['sumpor2'.$id.'_'.$dim]);
		}
		if(isset($postSubdimPor) && is_numeric($postSubdimPor) && $postSubdimPor >= 0 && $postSubdimPor <= 100 && isset($postSubdimIndex)){
			$porsubdim = $postSubdimPor;
			$subdimpor = $tool->get_subdimpor($id);
			$index = $postSubdimIndex;
			$numsubdimen = $tool->get_numsubdim($id);
			$valglobal = $tool->get_valglobal($id);
			$valglobalpor = $tool->get_valglobalpor($id);
			$subdimen = $tool->get_subdimension($id);			
			if(isset($valglobal[$dim]) && $valglobal[$dim] == 'true'){
				$numsubdimen[$dim]++;
			}
			
			//conjunto de porcentajes introducidos por el usuario y que hay que intentar mantener
			//id-id-id-...
			$aux = explode('-', $postItemMod);
			$idItemMod = array_unique($aux); 
			array_pop($idItemMod);
			//--------------------------------------
		
			//Sumo los valores de idItemMod
			$sumaMod = 0;
			$numMod = 0;
			$ponInput = array();
			$samebutton = 1;//indica si el usuario a mandado ha pulsado un botÃ³n relacionado con alguno de los valores recibidos o no
			foreach($idItemMod as $key => $cod){
				$postPor = getParam($_POST[$cod]);
				if(isset($postPor)){
					$numMod++;
					$sumaMod += $postPor;
					$aux = explode('_', $cod);
					if($aux[0] == 'valglobalpor'.$id){
						$ponInput['vg'] = $postPor;
						if($index == 'vg')
							$samebutton = 0;
					}
					else{
						$ponInput[$aux[2]] = $postPor;
						if($aux[2] == $index)
							$samebutton = 0;
					}
				}
			}
			if($samebutton){
				$numMod++;
				$ponInput[$index] = $porsubdim;
				$sumaMod += $porsubdim;
			}
			
			//echo "sumamod = $sumaMod y numMod = $numMod y numsubdim:". $numsubdimen[$dim];
			$state = 0;
			if($numMod == $numsubdimen[$dim] && $sumaMod != 100){
				$state = 0;
			}
			elseif($numMod != $numsubdimen[$dim] && $sumaMod > 100 ){
				$state = 0;
			}
			elseif($numMod == $numsubdimen[$dim] && $sumaMod == 100)
				$state = 2;
			else{
				$state = 1;
			}
		
			if($state == 0){
				//porcentage a repartir por el resto de atributos
				$porcentage = $porsubdim;
				if($numsubdimen[$dim] > 1){
					$porcentage = floor((100 - $porsubdim) / ($numsubdimen[$dim]-1));
					foreach($subdimpor[$dim] as $key => $value){
						$subdimpor[$dim][$key] = $porcentage;
						if((string)$key == (string)$index)
							$subdimpor[$dim][$key] = $porsubdim;
					}	
					if($index == 'vg')
						$valglobalpor[$dim] = $porsubdim;
					elseif($valglobal[$dim] == 'true')
						$valglobalpor[$dim] = $porcentage;
				}
				else{
					$subdimpor[$dim][$index] = 100;
				}
			}
			elseif($state == 1){
				$porcentage;
				$sumpercentage = array_sum($ponInput);
				if($numsubdimen[$dim] > 1){
					$porcentage = floor((100 - $sumpercentage) / ($numsubdimen[$dim]-$numMod));
				}
				else{
					$subdimpor[$dim][$index] = 100;
				}
			
				foreach($subdimpor[$dim] as $key => $value){
					if(isset($ponInput[$key])){
						$subdimpor[$dim][$key] = $ponInput[$key];}
					elseif((string)$key == (string)$index){
						$subdimpor[$dim][$index] = $porsubdim;}
					else{
						$subdimpor[$dim][$key] = $porcentage;}
				}
				if(isset($ponInput['vg']))
					$valglobalpor[$dim] = $ponInput['vg'];
				else
					$valglobalpor[$dim] = $porcentage;
			}
			elseif($state == 2){
				foreach($subdimpor[$dim] as $key => $value){
					$subdimpor[$dim][$key] = $ponInput[$key];
				}
				if(isset($valglobal[$dim]) && $valglobal[$dim] == 'true')
					$valglobalpor[$dim] = $ponInput['vg'];
			}
			
			$tool->set_subdimpor($subdimpor, $id);
	
			if(isset($valglobalpor[$dim])){
				$tool->set_valglobalpor($valglobalpor, $id);
			}
		}
		elseif(!isset($_POST['comDim'])){
			$numsubdim = $tool->get_numsubdim($id);
			//$valglobal = $tool->get_valglobal();
			$valglobalpor = $tool->get_valglobalpor($id);
			$postvalglobal = '';
			if(isset($_POST['valglobal'.$id.'_'.$dim])){
				$postvalglobal = getParam($_POST['valglobal'.$id.'_'.$dim]);
			}
			if($postvalglobal == 'true')
				$numsubdim[$dim]++;
			$porcentage = floor(100 / $numsubdim[$dim]);
			$subdimen = $tool->get_subdimension($id);
			$subdimpor = $tool->get_subdimpor($id);
			foreach($subdimen as $idDim => $value){
				if((string)$idDim == (string)$dim){
					foreach($value as $key => $value2){
						$subdimpor[$dim][$key] = $porcentage;
					}
				}
			}
			
			if($postvalglobal == 'true'){
				$valglobalpor[$dim] = $porcentage;
				$tool->set_valglobalpor($valglobalpor, $id);
			}
				
			$tool->set_subdimpor($subdimpor, $id);
		}
	}
	
/************************************************************
/************************************************************
		Evento AÃ±adir/Eliminar atributos
*************************************************************	
*************************************************************/
	elseif(isset($postAddAtr)){
		$data = explode('_', $postAddAtr);
		$dim = $data[0];
		$subdim = $data[1];
		
		//array[][] - nÃºmero de atributos por dimensiÃ³n/subdimensiÃ³n
		$numatr = $tool->get_numatr($id);
		if(isset($_POST['numatributos'.$id.'_'.$dim.'_'.$subdim]))
			$postNumAtr = getParam($_POST['numatributos'.$id.'_'.$dim.'_'.$subdim]);
		if(!isset($postDelAtrib) && !isset($postAddAtrib) && isset($postNumAtr)){ 
			if($postNumAtr > $numatr[$dim][$subdim]){
				$na = $numatr[$dim][$subdim];
				for($i = $na; $i < $postNumAtr; $i++){
					$key = $secuencia;
					$tool->addAtributo($dim, $subdim, null, $key, $id);
					$secuencia++;
					$_SESSION['secuencia'] = $secuencia;
				}
			}
			elseif($postNumAtr < $numatr[$dim][$subdim]){
				$na = $numatr[$dim][$subdim];
				$diferencia = $na - $postNumAtr;
				$i = 0;
				//array[][][][] - datos de los atributos
				$atributo = $tool->get_atributo($id);
				foreach($atributo[$dim][$subdim] as $key => $value){
					if($i >= $postNumAtr){
						$atrib = $key;
						$tool->eliminaAtributo($dim, $subdim, $atrib, $id);
					}
					$i++;
				}
			}		
		}
		elseif(isset($postAddAtrib)){
			$key = $secuencia;
			$tool->addAtributo($dim, $subdim, $postAddAtrib, $key, $id);
			$secuencia++;
			$_SESSION['secuencia'] = $secuencia;
		}
		elseif(isset($postDelAtrib)){
			$tool->eliminaAtributo($dim, $subdim, $postDelAtrib, $id);
		}
//------------------------------------------------
//COMENTARIO ATRIBUTO
//------------------------------------------------
		
//-----------------------------------------------
//PORCENTAJE ATRIBUTO ---------------------------
//-----------------------------------------------
		if(isset($_POST['atribpor'])){
			$postAtribPor = getParam($_POST['atribpor']);
		}
		if(isset($_POST['api'])){
			$postAtribIndex = getParam($_POST['api']);
		}
		$postItemMod = getParam($_POST['sumpor'.$id.'_'.$dim.'_'.$subdim]);
		//porcentaje de los atributos
		$atribpor = $tool->get_atribpor($id);
		if(isset($postAtribPor) && is_numeric($postAtribPor) && $postAtribPor >= 0 && $postAtribPor <= 100 && isset($postAtribIndex)){
			//conjunto de porcentajes introducidos por el usuario y que hay que intentar mantener
			//id-id-id-...
			$aux = explode('-', $postItemMod);
			$idItemMod = array_unique($aux); 
			array_pop($idItemMod);
			//--------------------------------------
			
			//atributo enviado por el usuario. Corresponde al botÃ³n porcentaje pulsado
			$poratrib = $postAtribPor;
			$index = $postAtribIndex;
			//---------------------------------------
			
			//Sumo los valores de idItemMod
			$sumaMod = 0;
			$numatribb = $tool->get_numatr($id);
			$numMod = 0;
			$ponInput = array();
			$samebutton = 1;//indica si el usuario ha pulsado un botÃ³n relacionado con alguno de los valores recibidos o no
			foreach($idItemMod as $key => $cod){
				$postPor = getParam($_POST[$cod]);
				if(isset($postPor)){
					$numMod++;
					$sumaMod += $postPor;
					$aux = explode('_', $cod);
					$ponInput[$aux[3]] = $postPor;
					if($aux[3] == $index)
						$samebutton = 0;
				}
			}
			if($samebutton){
				$numMod++;
				$ponInput[$index] = $poratrib;
				$sumaMod += $poratrib;
			}
		
			/*
			* state == 0 se produce cuando se ha introducido un valor porcentual en cada atributo de la subdimensión en cuestión y la suma es distinta de 100
			*			 se produce cuando, independientemente del número de valores porcentuales instroducidos, la suma es mayor que 100
			* state == 1 se produce cuando se introduce algunos valores porcentuales en cada atributo de la subdimensión y la suma es menor que 100			 
			* state == 2 se produce cuando se ha introducido un valor porcentual en cada atributo de la subdimensión en cuestión y la suma vale 100
			*/
			
			//echo "sumamod = $sumaMod y numMod = $numMod y numatr:". $numatribb[$dim][$subdim];
			$state = 0;
			if($numMod == $numatribb[$dim][$subdim] && $sumaMod != 100){
				$state = 0;
			}
			elseif($numMod != $numatribb[$dim][$subdim] && $sumaMod > 100 ){
				$state = 0;
			}
			elseif($numMod == $numatribb[$dim][$subdim] && $sumaMod == 100)
				$state = 2;
			else{
				$state = 1;
			}

			if($state == 0){
				//porcentage a repartir por el resto de atributos
				if($numatribb[$dim][$subdim] > 1){
					$porcentage = floor((100 - $poratrib) / ($numatribb[$dim][$subdim]-1));
					foreach($atribpor[$dim][$subdim] as $key => $value){
					if((string)$key != (string)$index)
						$atribpor[$dim][$subdim][$key] = $porcentage;
					}			
					$atribpor[$dim][$subdim][$index] = $poratrib;
				}
				else{
					$atribpor[$dim][$subdim][$index] = 100;
				}
			}
			elseif($state == 1){
				$apor = array(); //contiene el valor porcentual de cada atributo de la subdimensión en cuestión
				foreach($atribpor[$dim][$subdim] as $keypor => $vpor){
					if(isset($_POST['atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$keypor])){
						$apor[$keypor] = getParam($_POST['atribpor'.$id.'_'.$dim.'_'.$subdim.'_'.$keypor]);
					}
					$sumapor = array_sum($apor);					
				}
				if($sumapor == 100){
					foreach($atribpor[$dim][$subdim] as $key => $value){
						$atribpor[$dim][$subdim][$key] = $apor[$key];
					}
				}
				else{
					$porcentage;
					$sumpercentage = array_sum($ponInput);
					if($numatribb[$dim][$subdim] > 1){
						$porcentage = floor((100 - $sumpercentage) / ($numatribb[$dim][$subdim]-$numMod));
					}
					else{
						$atribpor[$dim][$subdim][$index] = 100;
					}
					foreach($atribpor[$dim][$subdim] as $key => $value){
						if(isset($ponInput[$key]))
							$atribpor[$dim][$subdim][$key] = $ponInput[$key];
						elseif((string)$key == (string)$index)
							$atribpor[$dim][$subdim][$index] = $poratrib;
						else
							$atribpor[$dim][$subdim][$key] = $porcentage;
					}
				}
			}
			elseif($state == 2){
				foreach($atribpor[$dim][$subdim] as $key => $value){
					$atribpor[$dim][$subdim][$key] = $ponInput[$key];
				}
			}
			$tool->set_atribpor($atribpor, $id);
		}
		elseif(!isset($_POST['comAtr'])){
			$numatrib = $tool->get_numatr($id);
			$porcentage = floor(100 / $numatrib[$dim][$subdim]);
			$atrib = $tool->get_atributo($id);
			foreach($atrib[$dim][$subdim] as $key => $value){
				$atribpor[$dim][$subdim][$key] = $porcentage;
			}
			$tool->set_atribpor($atribpor, $id);
		}
	}
/************************************************************
 Evento Mover atributos arriba/abajo
*************************************************************
*************************************************************/
	if(isset($postMoveAtr)){
		$data = explode('_', $postMoveAtr);
		$dim = $data[0];
		$subdim = $data[1];
		
		$atributo = $tool->get_atributo($id);
		$params['dim'] = $dim;
		$params['subdim'] = $subdim;
		$params['blockData'] = $atributo[$dim][$subdim];
		$params['blockName'] = 'atributo';
		$params['id'] = $id;
		
		if(isset($postUpAtr)){
			$params['blockIndex'] = $postUpAtr;
			$params['instanceName'] = $atributo[$dim][$subdim][$postUpAtr]['nombre'];
			$tool->upBlock($params);
			
			if($tool->type == 'diferencial'){
				$atributopos = $tool->get_atributopos($id);
				$params['blockIndex'] = $postUpAtr;
				$params['instanceName'] = $atributopos[$dim][$subdim][$postUpAtr]['nombre'];
				$tool->upBlock($params);
			}
		}
		elseif(isset($postDownAtr)){
			$params['blockIndex'] = $postDownAtr;
			$params['instanceName'] = $atributo[$dim][$subdim][$postDownAtr]['nombre'];
			$tool->downBlock($params);
			if($tool->type == 'diferencial'){
				$atributopos = $tool->get_atributopos($id);
				$params['blockIndex'] = $postDownAtr;
				$params['blockName'] = 'atributopos';
				$params['instanceName'] = $atributopos[$dim][$subdim][$postDownAtr]['nombre'];
				$tool->downBlock($params);
			}
		}
	}
/************************************************************
 Evento Mover subdimensiones arriba/abajo
*************************************************************
*************************************************************/
	if(isset($postMoveSub)){
		$dim = getParam($postMoveSub);
		$subdimension = $tool->get_subdimension($id);
		$params['dim'] = $dim;
		$params['blockData'] = $subdimension[$dim];
		$params['blockName'] = 'subdimension';
		$params['id'] = $id;
		if(isset($postUpSub)){
			$params['blockIndex'] = $postUpSub;
			$params['instanceName'] = $subdimension[$dim][$postUpSub]['nombre'];
			$tool->upBlock($params);
		}
		elseif(isset($postDownSub)){
			$params['blockIndex'] = $postDownSub;
			$params['instanceName'] = $subdimension[$dim][$postDownSub]['nombre'];
			$tool->downBlock($params);
			//$tool->downSubdimension($dim, $postDownSub, $id);
		}
	}
/************************************************************
 Evento Mover dimensiones arriba/abajo
*************************************************************
*************************************************************/
	if(isset($postMoveDim)){
		$dimension = $tool->get_dimension($id);
		$params['blockData'] = $dimension;
		$params['blockName'] = 'dimension';
		$params['id'] = $id;
		if(isset($postUpDim)){
			$params['blockIndex'] = $postUpDim;
			$params['instanceName'] = $dimension[$postUpDim]['nombre'];
			$tool->upBlock($params);
		}
		elseif(isset($postDownDim)){
			$params['blockIndex'] = $postDownDim;
			$params['instanceName'] = $dimension[$postDownDim]['nombre'];
			$tool->downBlock($params);
			//$tool->downSubdimension($dim, $postDownSub, $id);
		}
	}
/************************************************************
 Evento Mover instrumentos arriba/abajo
*************************************************************
*************************************************************/
	if(isset($postMoveTool)){
		$tools = $tool->get_tools();
		$params['blockData'] = $tools;
		$params['blockName'] = 'tool';
		$params['mixed'] = 'mixed';
		if(isset($postUpTool)){
			$params['id'] = $postUpTool;
			$params['blockIndex'] = $postUpTool;
			$params['instance'] = $tools[$postUpTool];
			$tool->upBlock($params);
		}
		elseif(isset($postDownTool)){
			$params['id'] = $postDownTool;
			$params['blockIndex'] = $postDownTool;
			$params['instance'] = $tools[$postDownTool];
			$tool->downBlock($params);
		}
	}
	
//----------------------------------------------------------------------------------------------->
