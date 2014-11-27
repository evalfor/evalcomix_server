<?php

include_once('../configuration/conf.php');
include_once(DIRROOT . '/classes/db.php');
include_once(DIRROOT . '/classes/dbpdo.php');
include_once('evalcomix_table.php');
include_once('evalcomix_constant.php');
include_once('lib.php');

set_time_limit(600);
function upgrader($version){
	$result = array();
	if (ob_get_level() == 0){ 
		ob_start();
	}
	
//CAMBIOS PARA ACTUALIZAR EVALCOMIX 4.0.0 A EVALCOMIX 4.1.0------------	
	if($version < 2014040701){
		//Eliminar claves foráneas de todas las tablas
		$tables = array('mixtopla', 'dimen', 'subdimension', 'atributo', 'atrdiferencial', 'atribdes', 'dimval', 'ranval', 'plaval', 'plaeva', 'dimeva', 'atreva', 'atrcomment', 'dimcomment');
		$table = new evalcomix_table();
		$table->delete_fk($tables);
		
//plantilla----------------------------------------------------------------------------------------------------
		$table = new evalcomix_table(array('name' => 'plantilla'));
		
		//Renombramos 'pla_cod VARCHAR(255)'
		if($table->field_exist('pla_cod')){
			$newfield = new evalcomix_field(array('name' => 'pla_cod', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255'));
			$table->rename_field(array('oldname' => 'pla_cod', 'newfield' => $newfield));
		}
	
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table->field_exist('id')){
			if($table->key_exist(array('keytype' => 'pk'))){
				$table->delete_key('PRIMARY');
			}
			$table->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
		//Añadimos nuevo tipo 'mixto'
		if($table->field_exist('pla_tip')){
			$sql = "ALTER TABLE plantilla MODIFY pla_tip ENUM('lista', 'escala', 'rubrica', 'lista+escala', 'diferencial', 'argumentario', 'mixto');";
			ejecutar($sql);
		}
		
		//Modificamos 'pla_glo' para añadirle el DEFAULT false		
		if($table->field_exist('pla_glo')){
			$new_pla_glo = new evalcomix_field(array('name' => 'pla_glo', 'type' => EVALCOMIX_TYPE_BOOL, 'default' => 'FALSE'));
			$table->rename_field(array('oldname' => 'pla_glo', 'newfield' => $new_pla_glo));
		}
		
		//Añadir 'pla_gpr INTEGER'
		if(!$table->field_exist('pla_gpr')){
			$table->add_field(array('name' => 'pla_gpr', 'type' => EVALCOMIX_TYPE_INTEGER));
		}
		
		//Añadir 'pla_mod INTEGER(1) DEFAULT 0
		if(!$table->field_exist('pla_mod')){
			$table->add_field(array('name' => 'pla_mod', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 1, 'default' => '0', 'table_exist' => 'true'));
		}
		
		//Eliminamos 'pla_ins', 'pla_com', 'pla_del', 'pla_sam'
		if($table->field_exist('pla_ins')){
			$table->delete_field('pla_ins');
		}
		
		if($table->field_exist('pla_com')){
			$table->delete_field('pla_com');
		}
		
		if($table->field_exist('pla_del')){
			$table->delete_field('pla_del');
		}
		
		if($table->field_exist('pla_sam')){
			$table->delete_field('pla_sam');
		}
		
//Mixtopla----------------------------------------------------------------------------------------------------------
		$table_mixtopla = new evalcomix_table(array('name' => 'mixtopla'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_mixtopla->field_exist('id')){
			//Eliminamos la clave primaria
			if($table_mixtopla->key_exist(array('keytype' => 'pk'))){
				$table_mixtopla->delete_key('PRIMARY');
			}
			$table_mixtopla->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
		//Añadimos campo 'mip_pos INTEGER'	
		if(!$table_mixtopla->field_exist('mip_pos')){
			$table_mixtopla->add_field(array('name' => 'mip_pos', 'type' => EVALCOMIX_TYPE_INTEGER));
		}
		
//Dimen--------------------------------------------------------------------------------------------------------------		
		$table_dimen = new evalcomix_table(array('name' => 'dimen'));
		
		if($table_dimen->field_exist('dim_cod') && !$table_dimen->field_exist('id')){
			$newfield = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE));
			$table_dimen->rename_field(array('oldname' => 'dim_cod', 'newfield' => $newfield));
		}
		
		//Añadir 'dim_gpr INTEGER'
		if(!$table_dimen->field_exist('dim_gpr')){
			$table_dimen->add_field(array('name' => 'dim_gpr', 'type' => EVALCOMIX_TYPE_INTEGER));
		}
		
		//Añadir 'dim_pos INTEGER(10)'
		if(!$table_dimen->field_exist('dim_pos')){
			$table_dimen->add_field(array('name' => 'dim_pos', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 10));
		}
		
//Subdimension-------------------------------------------------------------------------------------------------------
		$table_subdimension = new evalcomix_table(array('name' => 'subdimension'));
		if($table_subdimension->field_exist('sub_cod') && !$table_subdimension->field_exist('id')){
			$newfield = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE));
			$table_subdimension->rename_field(array('oldname' => 'sub_cod', 'newfield' => $newfield));
		}
		
		if(!$table_subdimension->field_exist('sub_pos')){
			$table_subdimension->add_field(array('name' => 'sub_pos', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 10));
		}
		
//Atributo-----------------------------------------------------------------------------------------------------------
		$table_atributo = new evalcomix_table(array('name' => 'atributo'));
		if($table_atributo->field_exist('atr_cod') && !$table_atributo->field_exist('id')){
			$newfield = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE));
			$table_atributo->rename_field(array('oldname' => 'atr_cod', 'newfield' => $newfield));
		}
		if(!$table_atributo->field_exist('atr_pos')){
			$table_atributo->add_field(array('name' => 'atr_pos', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 10));
		}

//Atrdiferencial-----------------------------------------------------------------------------------------------------
		$table_atrdiferencial = new evalcomix_table(array('name' => 'atrdiferencial'));
		if($table_atrdiferencial->field_exist('atf_cod') && !$table_atrdiferencial->field_exist('id')){
			$newfield = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE));
			$table_atrdiferencial->rename_field(array('oldname' => 'atf_cod', 'newfield' => $newfield));
		}

//Valoracion----------------------------------------------------------------------------------------------------------
		$table_valoracion = new evalcomix_table(array('name' => 'valoracion'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'
		if(!$table_valoracion->field_exist('id')){
			//Eliminamos la clave primaria
			if($table_valoracion->key_exist(array('keytype' => 'pk'))){
				$table_valoracion->delete_key('PRIMARY');
			}
			$table_valoracion->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
		//Modificamos campo 'val_cod VARCHAR(100) UNIQUE
		if($table_valoracion->field_exist('val_cod')){
			$newfield = new evalcomix_field(array('name' => 'val_cod', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '100', 'unique' => true));
			$table_valoracion->rename_field(array('oldname' => 'val_cod', 'newfield' => $newfield));
		}

//Rango---------------------------------------------------------------------------------------------------------------
		$table_rango = new evalcomix_table(array('name' => 'rango'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'
		if(!$table_rango->field_exist('id')){		
			//Eliminamos la clave primaria
			if($table_rango->key_exist(array('keytype' => 'pk'))){
				$table_rango->delete_key('PRIMARY');
			}		
			$table_rango->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
		//Modificamos campo 'ran_cod VARCHAR(100) UNIQUE
		if($table_rango->field_exist('ran_cod')){	
			$newfield = new evalcomix_field(array('name' => 'ran_cod', 'type' => EVALCOMIX_TYPE_INTEGER, 'unique' => true));
			$table_rango->rename_field(array('oldname' => 'ran_cod', 'newfield' => $newfield));
		}
		
//Atribdes------------------------------------------------------------------------------------------------------------
		$table_atribdes = new evalcomix_table(array('name' => 'atribdes'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_atribdes->field_exist('id')){	
			if($table_atribdes->key_exist(array('keytype' => 'pk'))){
				$table_atribdes->delete_key('PRIMARY');
			}
			$table_atribdes->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}

//Dimval--------------------------------------------------------------------------------------------------------------
		$table_dimval = new evalcomix_table(array('name' => 'dimval'));
				
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_dimval->field_exist('id')){	
			if($table_dimval->key_exist(array('keytype' => 'pk'))){
				$table_dimval->delete_key('PRIMARY');
			}
			$table_dimval->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}

//Ranval--------------------------------------------------------------------------------------------------------------
		$table_ranval = new evalcomix_table(array('name' => 'ranval'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_ranval->field_exist('id')){	
			if($table_ranval->key_exist(array('keytype' => 'pk'))){
				$table_ranval->delete_key('PRIMARY');
			}
			$table_ranval->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}

//Plaval--------------------------------------------------------------------------------------------------------------
		$table_plaval = new evalcomix_table(array('name' => 'plaval'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_plaval->field_exist('id')){	
			if($table_plaval->key_exist(array('keytype' => 'pk'))){
				$table_plaval->delete_key('PRIMARY');
			}
			$table_plaval->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
//Assessment----------------------------------------------------------------------------------------------------------
		$table_assessment = new evalcomix_table(array('name' => 'assessment'));
		
		if($table_assessment->field_exist('ass_cod') && !$table_assessment->field_exist('id')){	
			$newfield = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE));
			$table_assessment->rename_field(array('oldname' => 'ass_cod', 'newfield' => $newfield));
		}
		
//		$newfield = new evalcomix_field(array('name' => 'ass_pla', 'type' => EVALCOMIX_TYPE_INTEGER));
//		$table_assessment->rename_field(array('oldname' => 'ass_pla', 'newfield' => $newfield));

//Plaeva--------------------------------------------------------------------------------------------------------------
		$table_plaeva = new evalcomix_table(array('name' => 'plaeva'));
				
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_plaeva->field_exist('id')){
			if($table_plaeva->key_exist(array('keytype' => 'pk'))){
				$table_plaeva->delete_key('PRIMARY');
			}
			$table_plaeva->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
//Dimeva--------------------------------------------------------------------------------------------------------------
		$table_dimeva = new evalcomix_table(array('name' => 'dimeva'));

		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_dimeva->field_exist('id')){
			if($table_dimeva->key_exist(array('keytype' => 'pk'))){
				$table_dimeva->delete_key('PRIMARY');
			}
			$table_dimeva->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
//Atreva--------------------------------------------------------------------------------------------------------------
		$table_atreva = new evalcomix_table(array('name' => 'atreva'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_atreva->field_exist('id')){	
			if($table_atreva->key_exist(array('keytype' => 'pk'))){
				$table_atreva->delete_key('PRIMARY');
			}
			$table_atreva->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
//Atrcomment--------------------------------------------------------------------------------------------------------------
		$table_atrcomment = new evalcomix_table(array('name' => 'atrcomment'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_atrcomment->field_exist('id')){
			if($table_atrcomment->key_exist(array('keytype' => 'pk'))){
				$table_atrcomment->delete_key('PRIMARY');
			}
			$table_atrcomment->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
//Dimcomment--------------------------------------------------------------------------------------------------------------
		$table_dimcomment = new evalcomix_table(array('name' => 'dimcomment'));
		
		//Añadimos campo 'id INTEGER AUTO_INCREMENT PRIMARY KEY'	
		if(!$table_dimcomment->field_exist('id')){
			if($table_dimcomment->key_exist(array('keytype' => 'pk'))){
				$table_dimcomment->delete_key('PRIMARY');
			}
			$table_dimcomment->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY));
		}
		
//Inserción de datos-------------------------------------------------------------------------------------------------------
		include_once(DIRROOT . '/classes/mixtopla.php');
		include_once(DIRROOT . '/classes/plantilla.php');
		include_once(DIRROOT . '/classes/dimension.php');
		include_once(DIRROOT . '/classes/subdimension.php');
		include_once(DIRROOT . '/classes/atributo.php');
		include_once(DIRROOT . '/classes/atrdiferencial.php');
		include_once(DIRROOT . '/classes/plaval.php');
		include_once(DIRROOT . '/classes/assessment.php');
		include_once(DIRROOT . '/classes/plaeva.php');

		
		if($plantillas = plantilla::fetch_all(array())){
			$dimens = dimension::fetch_all(array());
			$subdimensions = subdimension::fetch_all(array());
			$atributos = atributo::fetch_all(array());
			
			print_message('Cálculo de plantilla::pla_grp');
			foreach($plantillas as $plantilla){
				$index = $plantilla->pla_cod;
				$id_pla_cod[$index] = $plantilla->id;	
				
				//Cálculo de plantilla::pla_gpr
				if($plantilla->pla_glo == '1'){
					if(!empty($dimens)){
						$suma_porcentages = 0;
						foreach($dimens as $dimen){			
							if($dimen->dim_pla == $index){
								$suma_porcentages += (int)$dimen->dim_por;
							}
						}
						if($suma_porcentages >= 0 && $suma_porcentages <= 100){
							$pla_gpr = 100 - $suma_porcentages;
							$plantilla->pla_gpr = $pla_gpr;
							$plantilla->pla_tit = addslashes($plantilla->pla_tit);
							$plantilla->pla_des = addslashes($plantilla->pla_des);
							$plantilla->update();
						}
					}
				}
			}
	
			//Actualizamos plaeva::ple_pla-----------------------
			print_message('Actualización de plaeva::ple_pla');
			if($plaevas = plaeva::fetch_all(array())){
				foreach($plaevas as $plaeva){
					$old_value = $plaeva->ple_pla;
					if(isset($id_pla_cod[$old_value])){
						$plaeva->ple_pla = $id_pla_cod[$old_value];
						$plaeva->update();
					}
				}
			}
		
			//Actualizamos plaval::plv_pla-----------------------
			print_message('Actualización de plaval::plv_pla');
			if($plavals = plaval::fetch_all(array())){
				foreach($plavals as $plaval){
					$old_value = $plaval->plv_pla;
					if(isset($id_pla_cod[$old_value])){
						$plaval->plv_pla = $id_pla_cod[$old_value];
						$plaval->update();
					}
				}	
			}
			
		
			//Actualización de dimen::dim_pla y cálculo de dimen::dim_gpr-----------------------
			print_message('Actualización de dimen::dim_pla y dimen::dim_pos y cálculo de dimen::dim_gpr');
			if(!empty($dimens)){
				foreach($dimens as $dimen){
					$old_value = $dimen->dim_pla;
					if(isset($id_pla_cod[$old_value])){
						$dimen->dim_pla = $id_pla_cod[$old_value];
						$dimen->dim_pos = $dimen->id;
						$dimen->update();		
					}
					
					if($dimen->dim_glo == '1'){
						$sumaporcentajes = 0;
						if(!empty($subdimensions)){
							foreach($subdimensions as $subdimension){
								$sumaporcentajes += $subdimension->sub_por;
							}
							if($sumaporcentajes >= 0 && $sumaporcentajes <= 100){
								$dim_gpr = 100 - $sumaporcentajes;
								$dimen->dim_gpr = $dim_gpr;
								$dimen->update();
							}
						}
					}
				}
			}
		
			print_message('Cálculo de subdimension::sub_pos');
			if($subdimensions){
				foreach($subdimensions as $subdimension){
					$subdimension->sub_pos = $subdimension->id;
					$subdimension->update();
				}
			}
			
			print_message('Cálculo de atributo::atr_pos');
			if(!empty($atributos)){
				foreach($atributos as $atributo){
					$atributo->atr_pos = $atributo->id;
					$atributo->update();
				}
			}
			
			//Inserción de instrumentos Mixtos en la tabla Plantilla-----------------------
			print_message('Inserción de instrumentos Mixtos en la tabla Plantilla');
			$sql_mixto = "SELECT * 
						FROM mixto";
			if($result_mixto = DB::query($sql_mixto)){
				$rst_mixto = $result_mixto->fetchAll();

				$mixtopla = mixtopla::fetch_all(array());

				$id_pla_mix = array(); //Asocia los valores del campo mixto::mix_cod con su nuevo id en plantilla
				foreach($rst_mixto as $mixto){
				//	if(fallo_en_la_insercion){
					$mix_cod = $mixto['mix_cod'];
					$params['pla_cod'] = $mix_cod;
					$params['pla_tit'] = $mixto['mix_tit'];
					$params['pla_tip'] = 'mixto';
					$params['pla_des'] = $mixto['mix_obs'];
					$params['pla_glo'] = '0';
					$params['pla_por'] = '100';
					$params['pla_gpr'] = '0';
					$params['pla_mod'] = '0';
					if(!$plantilla = plantilla::fetch(array('pla_cod' => $mix_cod))){
						$plantilla = new plantilla($params);
						$id_pla_mix[$mix_cod] = $plantilla->insert();
						$id_pla_cod[$mix_cod] = $id_pla_mix[$mix_cod];
					}			
					else{
						if(empty($plantilla->pla_tip)){
							$plantilla->pla_cod = $mix_cod . '_null';
							$plantilla->update();
							$newplantilla = new plantilla($params);
							$id_pla_mix[$mix_cod] = $newplantilla->insert();
							$id_pla_cod[$mix_cod] = $id_pla_mix[$mix_cod];
						}
						elseif($plantilla->pla_tip == 'mixto'){
							$mixtosinsertados = true;
						}
						//print_error('Error al insertar instrumentos mixtos en la tabla plantilla. Ya existe una tupla con pla_cod = '. $mix_cod);
					}
					
					$position = 0;
					foreach($mixtopla as $mixpla){					
						if($mixpla->mip_mix == $mix_cod){
						//Actualizo el campo mixtopla::mip_mix
							$old_mip_pla = $mixpla->mip_pla;
							if(isset($id_pla_mix[$mix_cod]) && isset($id_pla_cod[$old_mip_pla])){
								$mixpla->mip_mix = $id_pla_mix[$mix_cod];
								$mixpla->mip_pla = $id_pla_cod[$old_mip_pla];
								$mixpla->mip_pos = $position;
								$mixpla->update();
							//Actualizo el nuevo campo mixtopla::mip_pos
								++$position;
							}
						}
					}
				}
			}
			else{
				echo "<br>Error: No se puede ejecutar la sentencia:
				$sql_mixto";
				exit;
			}
			
			//Actualizamos assessment::ass_pla-----------------------
			print_message('Actualización de assessment::ass_pla');
			if($assessments = assessment::fetch_all(array())){
				foreach($assessments as $assessment){
					$old_value = $assessment->ass_pla;
					if(isset($id_pla_cod[$old_value])){ 
						$assessment->ass_pla = $id_pla_cod[$old_value];
						$assessment->ass_com = htmlspecialchars($assessment->ass_com, ENT_QUOTES);
						$assessment->update();
					}
					else{
						$assessment->ass_pla = 'NULL';
						$assessment->ass_com = htmlspecialchars($assessment->ass_com, ENT_QUOTES);
						$assessment->update();
					}
				}
			}
			//Assessment----------------------------------------------------------------------------------------------------------		
			$newfield = new evalcomix_field(array('name' => 'ass_pla', 'type' => EVALCOMIX_TYPE_INTEGER));
			$table_assessment->rename_field(array('oldname' => 'ass_pla', 'newfield' => $newfield));
	
		}
		
		if($table_mixtopla->field_exist('mip_mix')){	
			$newfield = new evalcomix_field(array('name' => 'mip_mix', 'type' => EVALCOMIX_TYPE_INTEGER));
			$table_mixtopla->rename_field(array('oldname' => 'mip_mix', 'newfield' => $newfield));
		}
		
		if($table_mixtopla->field_exist('mip_pla')){
			$newfield = new evalcomix_field(array('name' => 'mip_pla', 'type' => EVALCOMIX_TYPE_INTEGER));
			$table_mixtopla->rename_field(array('oldname' => 'mip_pla', 'newfield' => $newfield));
		}
		
		if($table_dimen->field_exist('dim_pla')){
			$newfield = new evalcomix_field(array('name' => 'dim_pla', 'type' => EVALCOMIX_TYPE_INTEGER));
			$table_dimen->rename_field(array('oldname' => 'dim_pla', 'newfield' => $newfield));
		}
		
		if($table_plaval->field_exist('plv_pla')){
			$newfield = new evalcomix_field(array('name' => 'plv_pla', 'type' => EVALCOMIX_TYPE_INTEGER));
			$table_plaval->rename_field(array('oldname' => 'plv_pla', 'newfield' => $newfield));
		}
		
		if($table_plaeva->field_exist('ple_pla')){
			$newfield = new evalcomix_field(array('name' => 'ple_pla', 'type' => EVALCOMIX_TYPE_INTEGER));
			$table_plaeva->rename_field(array('oldname' => 'ple_pla', 'newfield' => $newfield));
		}
		
		//Añadimos las claves foráneas
		
		//Mixtopla
		if(!$table_mixtopla->key_exist(array('keyname' => 'fk_mixtopla_mip_mix', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_mixtopla_mip_mix', 'fields' => array('mip_mix'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'plantilla', 'reffield' => 'id');
			$table_mixtopla->add_key($params);
		}
		
		if(!$table_mixtopla->key_exist(array('keyname' => 'fk_mixtopla_mip_pla', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_mixtopla_mip_pla', 'fields' => array('mip_pla'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'plantilla', 'reffield' => 'id');
			$table_mixtopla->add_key($params);
		}
		
		//Dimen
		if(!$table_dimen->key_exist(array('keyname' => 'fk_dimen_dim_pla', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimen_dim_pla', 'fields' => array('dim_pla'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'plantilla', 'reffield' => 'id');
			$table_dimen->add_key($params);
		}
		
		//Subdimension
		if(!$table_subdimension->key_exist(array('keyname' => 'fk_subdimension_sub_dim', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_subdimension_sub_dim', 'fields' => array('sub_dim'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'dimen', 'reffield' => 'id');
			$table_subdimension->add_key($params);
		}
		
		//Atributo
		if(!$table_atributo->key_exist(array('keyname' => 'fk_atributo_atr_sub', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atributo_atr_sub', 'fields' => array('atr_sub'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'subdimension', 'reffield' => 'id');
			$table_atributo->add_key($params);
		}
		
		//Atrdiferencial
		if(!$table_atrdiferencial->key_exist(array('keyname' => 'fk_atrdiferencial_atf_atn', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atrdiferencial_atf_atn', 'fields' => array('atf_atn'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'atributo', 'reffield' => 'id');
			$table_atrdiferencial->add_key($params);
		}
		
		if(!$table_atrdiferencial->key_exist(array('keyname' => 'fk_atrdiferencial_atf_atp', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atrdiferencial_atf_atp', 'fields' => array('atf_atp'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'atributo', 'reffield' => 'id');
			$table_atrdiferencial->add_key($params);
		}
		
		//Atribdes
		if(!$table_atribdes->key_exist(array('keyname' => 'fk_atribdes_atd_atr', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atribdes_atd_atr', 'fields' => array('atd_atr'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'atributo', 'reffield' => 'id');
			$table_atribdes->add_key($params);
		}
		
		if(!$table_atribdes->key_exist(array('keyname' => 'fk_atribdes_atd_val', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atribdes_atd_val', 'fields' => array('atd_val'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'valoracion', 'reffield' => 'val_cod');
			$table_atribdes->add_key($params);
		}
		
		//Dimval
		if(!$table_dimval->key_exist(array('keyname' => 'fk_dimval_div_dim', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimval_div_dim', 'fields' => array('div_dim'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'dimen', 'reffield' => 'id');
			$table_dimval->add_key($params);
		}
		
		if(!$table_dimval->key_exist(array('keyname' => 'fk_dimval_div_val', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimval_div_val', 'fields' => array('div_val'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'valoracion', 'reffield' => 'val_cod');
			$table_dimval->add_key($params);
		}
		
		//ranval
		if(!$table_ranval->key_exist(array('keyname' => 'fk_ranval_rav_dim', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_ranval_rav_dim', 'fields' => array('rav_dim'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'dimen', 'reffield' => 'id');
			$table_ranval->add_key($params);
		}
		
		if(!$table_ranval->key_exist(array('keyname' => 'fk_ranval_rav_val', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_ranval_rav_val', 'fields' => array('rav_val'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'valoracion', 'reffield' => 'val_cod');
			$table_ranval->add_key($params);
		}
		
		if(!$table_ranval->key_exist(array('keyname' => 'fk_ranval_rav_ran', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_ranval_rav_ran', 'fields' => array('rav_ran'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'rango', 'reffield' => 'ran_cod');
			$table_ranval->add_key($params);
		}
		
		//plaval
		if(!$table_plaval->key_exist(array('keyname' => 'fk_plaval_plv_pla', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_plaval_plv_pla', 'fields' => array('plv_pla'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'plantilla', 'reffield' => 'id');
			$table_plaval->add_key($params);
		}
		
		if(!$table_plaval->key_exist(array('keyname' => 'fk_plaval_plv_val', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_plaval_plv_val', 'fields' => array('plv_val'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'valoracion', 'reffield' => 'val_cod');
			$table_plaval->add_key($params);
		}
		
		//Assessment
		if(!$table_assessment->key_exist(array('keyname' => 'fk_assessment_ass_pla', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_assessment_ass_pla', 'fields' => array('ass_pla'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'plantilla', 'reffield' => 'id');
			$table_assessment->add_key($params);
		}
		
		//Plaeva
		if(!$table_plaeva->key_exist(array('keyname' => 'fk_plaeva_ple_eva', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_plaeva_ple_eva', 'fields' => array('ple_eva'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'assessment', 'reffield' => 'id');
			$table_plaeva->add_key($params);
		}
		
		if(!$table_plaeva->key_exist(array('keyname' => 'fk_plaeva_ple_pla', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_plaeva_ple_pla', 'fields' => array('ple_pla'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'plantilla', 'reffield' => 'id');
			$table_plaeva->add_key($params);
		}
		
		if(!$table_plaeva->key_exist(array('keyname' => 'fk_plaeva_ple_val', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_plaeva_ple_val', 'fields' => array('ple_val'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'valoracion', 'reffield' => 'val_cod');
			$table_plaeva->add_key($params);
		}

		//Dimeva
		if(!$table_dimeva->key_exist(array('keyname' => 'fk_dimeva_die_eva', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimeva_die_eva', 'fields' => array('die_eva'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'assessment', 'reffield' => 'id');
			$table_dimeva->add_key($params);
		}
		
		if(!$table_dimeva->key_exist(array('keyname' => 'fk_dimeva_die_dim', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimeva_die_dim', 'fields' => array('die_dim'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'dimen', 'reffield' => 'id');
			$table_dimeva->add_key($params);
		}
		
		if(!$table_dimeva->key_exist(array('keyname' => 'fk_dimeva_die_val', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimeva_die_val', 'fields' => array('die_val'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'valoracion', 'reffield' => 'val_cod');
			$table_dimeva->add_key($params);
		}
		
		if(!$table_dimeva->key_exist(array('keyname' => 'fk_dimeva_die_ran', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimeva_die_ran', 'fields' => array('die_ran'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'rango', 'reffield' => 'ran_cod');
			$table_dimeva->add_key($params);
		}
		
		//Atreva
		if(!$table_atreva->key_exist(array('keyname' => 'fk_atreva_ate_eva', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atreva_ate_eva', 'fields' => array('ate_eva'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'assessment', 'reffield' => 'id');
			$table_atreva->add_key($params);
		}
		
		if(!$table_atreva->key_exist(array('keyname' => 'fk_atreva_ate_atr', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atreva_ate_atr', 'fields' => array('ate_atr'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'atributo', 'reffield' => 'id');
			$table_atreva->add_key($params);
		}
			
		if(!$table_atreva->key_exist(array('keyname' => 'fk_atreva_ate_val', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atreva_ate_val', 'fields' => array('ate_val'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'valoracion', 'reffield' => 'val_cod');
			$table_atreva->add_key($params);
		}
		
		if(!$table_atreva->key_exist(array('keyname' => 'fk_atreva_ate_ran', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atreva_ate_ran', 'fields' => array('ate_ran'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'rango', 'reffield' => 'ran_cod');
			$table_atreva->add_key($params);
		}
		
		//Atrcomment
		if(!$table_atrcomment->key_exist(array('keyname' => 'fk_atrcomment_atc_eva', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atrcomment_atc_eva', 'fields' => array('atc_eva'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'assessment', 'reffield' => 'id');
			$table_atrcomment->add_key($params);
		}
		
		if(!$table_atrcomment->key_exist(array('keyname' => 'fk_atrcomment_atc_atr', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_atrcomment_atc_atr', 'fields' => array('atc_atr'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'atributo', 'reffield' => 'id');
			$table_atrcomment->add_key($params);
		}

		//Dimcomment
		if(!$table_dimcomment->key_exist(array('keyname' => 'fk_dimcomment_dic_eva', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimcomment_dic_eva', 'fields' => array('dic_eva'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'assessment', 'reffield' => 'id');
			$table_dimcomment->add_key($params);
		}
		
		if(!$table_dimcomment->key_exist(array('keyname' => 'fk_dimcomment_dic_dim', 'keytype' => 'fk'))){
			$params = array('name' => 'fk_dimcomment_dic_dim', 'fields' => array('dic_dim'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'dimen', 'reffield' => 'id');
			$table_dimcomment->add_key($params);
		}
		
	}
	
//CAMBIOS PARA ACTUALIZAR EVALCOMIX 4.1.0 A EVALCOMIX 4.1.1----------------
	if($version < 2014040701){
		// Define table config to be created
        $table = new evalcomix_table(array('name' => 'config'));

        // Adding fields to table config     
		if(!$table->field_exist('id')){
			$table->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null));
		}
		if(!$table->field_exist('name')){
			$table->add_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
		}
		if(!$table->field_exist('value')){
			$table->add_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
		}
        
        // Adding keys to table config
		if(!$table->key_exist(array('keytype' => 'pk'))){
			$table->add_key(array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY));        
		}
		
        // Conditionally launch create table for block_evalcomix
		$table->create_table();

        // evalcomix savepoint reached
        upgrade_evalcomix_savepoint(2014040701);
	}
	echo "<BR><BR> FIN DE LA ACTUALIZACIÓN <BR><BR><BR>";
	
	
ob_end_flush();
/*exit;	
	if($version < 2014040701){
		//A plantilla se le añade 'pla_mod INT(1) DEFAULT 0'
		
        $table = new evalcomix_table(array('name' => 'plantilla'));
        $table->add_field(array('name' => 'pla_mod', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 1, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => '0', 'table_exist' => 'true'));
		
        // Evalcomix savepoint reached.
        upgrade_evalcomix_savepoint(2014040701);
	}
	
	if($version < 2014040701){
		//A dimen se le añade 'dim_pos INTEGER'
		
        $table = new evalcomix_table(array('name' => 'dimen'));
     	$table->add_field(array('name' => 'dim_pos', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 10, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null, 'table_exist' => 'true'));

		include_once('../classes/dimension.php');
		$dimensions = dimension::fetch_all(array());
		foreach($dimensions as $dimension){
			$dimension->dim_pos = $dimension->id;
			$dimension->update();
		}
		
        // Evalcomix savepoint reached.
        upgrade_evalcomix_savepoint(2014040701);
	}
	
	
	if($version < 2014040701){
		//A subdimension se le añade 'sub_pos INTEGER'
		
		$table = new evalcomix_table(array('name' => 'subdimension'));
        $table->add_field(array('name' => 'sub_pos', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 10, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null, 'table_exist' => 'true'));

        // Evalcomix savepoint reached.
        upgrade_evalcomix_savepoint(2014040701);
        
        include_once('../classes/subdimension.php');
        if($subdimensions = subdimension::fetch_all(array())){
        	foreach($subdimensions as $subdimension){
        		$subdimension->sub_pos = $subdimension->id;
        		$subdimension->update();
        	}
        }
	}
	
	if($version < 2014040701){
		//A atributo se le añade 'atr_pos INTEGER'
		
		$table = new evalcomix_table(array('name' => 'atributo'));
        $table->add_field(array('name' => 'atr_pos', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => 10, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null, 'table_exist' => 'true'));

        // Evalcomix savepoint reached.
        upgrade_evalcomix_savepoint(2014040701);
        
        include_once('../classes/atributo.php');
        if($atributos = atributo::fetch_all(array())){
        	foreach($atributos as $atributo){
        		$atributo->atr_pos = $atributo->id;
        		$atributo->update();
        	}
        }
	}
*/	
	return $result;
}

?>