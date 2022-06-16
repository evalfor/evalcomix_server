<?php
	require_once('../configuration/conf.php');
	require_once(DIRROOT . '/lib/weblib.php');
	require_once(DIRROOT . '/classes/atreva.php');
	require_once(DIRROOT . '/classes/atrcomment.php');
	require_once(DIRROOT . '/classes/dimeva.php');
	require_once(DIRROOT . '/classes/dimcomment.php');
	require_once(DIRROOT . '/classes/plaeva.php');
	require_once(DIRROOT . '/classes/plantilla.php');
	require_once(DIRROOT . '/classes/valoracion.php');
	require_once(DIRROOT . '/classes/assessment.php');
	require_once(DIRROOT . '/classes/simple_tool.php');

	if(isset($_GET['ass'])){
		$idAss = getParam($_GET['ass']);
	}
	if(isset($_GET['tool'])){
		$instrument = getParam($_GET['tool']);
		$plantilla = plantilla::fetch(array('id' => $instrument));
		$toolreturn = $plantilla->pla_cod;
		if(isset($_POST['cod'])){
			$toolmix = $instrument;
			$instrument = getParam($_POST['cod']);
		}
	}

	$assessment = assessment::fetch(array('id' => $idAss));
	$tool = new simple_tool($instrument);
	$tool->recovery();
	
	for($i = 0; $i < $tool->num_dimensions; $i++){
		for($l = 0; $l < $tool->num_subdimension[$i]; $l++){
			for($j = 0; $j < $tool->num_atr_dim[$i][$l] ; $j++){
				$assessed = 0;
				if(isset($tool->num_values_dim[$i])){
					for($k = 1; $k <= $tool->num_values_dim[$i]; $k++){
						if($tool->type == 'rubrica'){
							for($m = 0; $m < $tool->num_rango[$i][($k-1)]; $m++){
								if(isset($_POST['radio'.$i.$l.$j]) && $_POST['radio'.$i.$l.$j] == $tool->rango[$i][($k-1)][$m]){
									if($atreva = atreva::fetch(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j]))){
										$atreva->ate_val = $tool->values_dim[$i][$k];
										$atreva->ate_ran = $tool->rango[$i][$k-1][$m];
										$atreva->update();
									}
									else{
										$atreva = new atreva(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j], 'ate_val' => $tool->values_dim[$i][$k], 'ate_ran' => $tool->rango[$i][$k-1][$m]));
										$atreva->insert();
									}
								}
								elseif(!isset($_POST['radio'.$i.$l.$j])){
									if($atreva = atreva::fetch(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j]))){
										$atreva->delete();
									}
								}
							}//for($m = 0; $m < $num_rango[$i][$k]; $m++)
						}
						elseif(isset($_POST['radio'.$i.$l.$j]) && $_POST['radio'.$i.$l.$j] == $k){
							if($atreva = atreva::fetch(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j]))){
								$atreva->ate_val = $tool->values_dim[$i][$k];
								$atreva->update();
							}
							else{
								$atreva = new atreva(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j], 'ate_val' => $tool->values_dim[$i][$k]));
								$atreva->insert();
							}
							
							$assessed = 1;
						}
						elseif(!isset($_POST['radio'.$i.$l.$j])){
							if($atreva = atreva::fetch(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j]))){
								$atreva->delete();
							}
						}
						if($tool->type=='lista+escala' && isset($_POST['radio'.$i.$l.'_'.$j.'_'.$j]) && $_POST['radio'.$i.$l.'_'.$j.'_'.$j] == 1){ //if checklist of checklist+scale tool has a negative value, we will insert 0 in its value.
							if(!$valoracion = valoracion::fetch(array('val_cod' => '0_0'))){
								$valoracion = new valoracion(array('val_cod' => '0_0'));
								$valueid = $valoracion->insert();
							}
							else{
								$valueid = $valoracion->id;
							}
							
							if($atreva = atreva::fetch(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j]))){
								$atreva->ate_val = $valoracion->val_cod;
								$atreva->update();
							}
							else{
								$atreva = new atreva(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j], 'ate_val' => $valoracion->val_cod));
								$atreva->insert();
							}
							$assessed = 1;
						}
						elseif($tool->type=='lista+escala' && !isset($_POST['radio'.$i.$l.'_'.$j.'_'.$j])){
							if($atreva = atreva::fetch(array('ate_eva' => $idAss, 'ate_atr' => $tool->attributes_code[$i][$l][$j]))){
								$atreva->delete();
							}
						}
					}//for($k = 1; $k <= $num_values_dim[$i]; $k++)
				}
				
				if(isset($_POST['observaciones'.$i.'_'.$l.'_'.$j])){
					$observaciones_atr = htmlspecialchars($_POST['observaciones'.$i.'_'.$l.'_'.$j]);
					if($atrcomment = atrcomment::fetch(array('atc_eva' => $idAss, 'atc_atr' => $tool->attributes_code[$i][$l][$j]))){
						$atrcomment->atc_obs = $observaciones_atr;
						$atrcomment->update();
					}
					else{
						$atrcomment = new atrcomment(array('atc_eva' => $idAss, 'atc_atr' => $tool->attributes_code[$i][$l][$j], 'atc_obs' => $observaciones_atr));
						$atrcomment->insert();
					}
				}
			}//for($j = 0; $j < $num_atr_dim[$i][$l] ; $j++)
		}//for($l = 0; $l < $num_subdimension[$i]; $l++)
	}//for($i = 0; $i < $num_dimensions; $i++)

//GLOBAL VALUE----------------------------------------------------------------------
	for($i = 0; $i < $tool->num_dimensions; $i++){
		for($k = 1; $k <= $tool->num_values_dim[$i]; $k++){ 
			if($tool->global_value[$i] == 't' || $tool->global_value[$i] == '1'){
				if($tool->type == 'rubrica'){
					for($m = 0; $m < $tool->num_rango[$i][($k-1)]; $m++){
						if(isset($_POST['radio'.$i]) && $_POST['radio'.$i] == $tool->rango[$i][($k-1)][$m]){
							if($dimeva = dimeva::fetch(array('die_eva' => $idAss, 'die_dim' => $tool->dimen_code[$i]))){
								$dimeva->die_val = $tool->values_dim[$i][$k];
								$dimeva->die_ran = $tool->rango[$i][($k-1)][$m];
								$dimeva->update();
							}
							else{
								$dimeva = new dimeva(array('die_eva' => $idAss, 'die_dim' => $tool->dimen_code[$i], 'die_val' => $tool->values_dim[$i][$k], 'die_ran' => $tool->rango[$i][($k-1)][$m]));
								$dimeva->insert();
							}
						}//if($_POST['radio'.$i] == $rango[$i][($k-1)])
						elseif(!isset($_POST['radio'.$i])){
							if($dimeva = dimeva::fetch(array('die_eva' => $idAss, 'die_dim' => $tool->dimen_code[$i]))){
								$dimeva->delete();
							}
						}
					}
				}
				elseif(isset($_POST['radio'.$i]) && $_POST['radio'.$i] == $k){
					if($dimeva = dimeva::fetch(array('die_eva' => $idAss, 'die_dim' => $tool->dimen_code[$i]))){
						$dimeva->die_val = $tool->values_dim[$i][$k];
						$dimeva->update();
					}
					else{
						$dimeva = new dimeva(array('die_eva' => $idAss, 'die_dim' => $tool->dimen_code[$i], 'die_val' => $tool->values_dim[$i][$k]));
						$dimeva->insert();
					}
				}
				elseif(!isset($_POST['radio'.$i])){
					if($dimeva = dimeva::fetch(array('die_eva' => $idAss, 'die_dim' => $tool->dimen_code[$i]))){
						$dimeva->delete();
					}
				}
				
				if(isset($_POST['observaciones'.$i])){
					$observaciones_dim = htmlspecialchars($_POST['observaciones'.$i]);
					if($dimcomment = dimcomment::fetch(array('dic_eva' => $idAss, 'dic_dim' => $tool->dimen_code[$i]))){
						$dimcomment->dic_obs = $observaciones_dim;
						$dimcomment->update();
					}
					else{
						$dimcomment = new dimcomment(array('dic_eva' => $idAss, 'dic_dim' => $tool->dimen_code[$i], 'dic_obs' => $observaciones_dim));
						$dimcomment->insert();
					}
				}
			}
		}
	}

//TOTAL VALUE-----------------------------------------------------------------------
	for($j = 0; $j < $tool->num_total_value; $j++){
		if(isset($_POST['total']) && $_POST['total'] == $tool->name_total_values[$j]){
			if($plaeva = plaeva::fetch(array('ple_eva' => $idAss, 'ple_pla' => $instrument))){
				$plaeva->ple_val = $tool->name_total_values[$j];
				$plaeva->update();
			}
			else{
				$plaeva = new plaeva(array('ple_eva' => $idAss, 'ple_pla' => $instrument, 'ple_val' => $tool->name_total_values[$j]));
				$plaeva->insert();
			}
		}
		elseif(!isset($_POST['total'])){
			if($plaeva = plaeva::fetch(array('ple_eva' => $idAss, 'ple_pla' => $instrument))){
				$plaeva->delete();
			}
		}
	}


	if($tool->type != 'argumentario'){
		require_once('../lib/finalgrade.php');
		$finalgrade = finalgrade($idAss, $instrument);
		$gradexp = explode( '/', $finalgrade);
	}
	else{
		$gradexp[0] = $_POST['grade'];
		$gradexp[1] = 100;
		if($gradexp[0] == '-1'){
			$gradexp[1] = '';
			$gradexp[0] = '';
		}
	}	

	if(isset($toolmix)){
		require_once('../lib/finalgrade.php');
		$finalgrade = finalgrade($idAss, $toolmix);
		$gradexp = explode( '/', $finalgrade);
	}
	
	if(isset($_POST['observaciones'])){
		$assessment->ass_com = htmlspecialchars($_POST['observaciones']);
	}		
	assessment::set_properties($assessment, array('ass_grd' => $gradexp[0], 'ass_mxg' => $gradexp[1]));
	$assessment->update();
	
	$grade = $gradexp[0] . '/' . $gradexp[1];
	
	header('Access-Control-Allow-Origin: *');
	echo $grade;