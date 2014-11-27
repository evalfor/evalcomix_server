<?php

class simple_tool{
	public $id;
	public $title;
	public $observation;
	public $percentage;
	public $num_dimensions;
	public $type;
	public $yesnovglobal;
	public $total_value_por;
	public $pla_cod;
	
	public $num_values_dim;
	public $values_dim;
	public $values_dimension_id;
	public $dimen_code;
	public $dimen_com;
	public $global_value;
	public $global_value_por;
	public $percentages_dim;
	
	public $num_subdimension;
	public $name_subdimension;
	public $subdimension_code;
	public $percentage_subdimension;
	
	public $num_atr_dim;
	public $attributes;
	public $attributes_percentage;
	public $attributes_code;
	public $attributes_com;
	
	public $num_total_value;
	public $name_total_values;
	public $cod_total_values;
	
	public $num_rango;
	public $rango;
	public $rango_id;
	public $description_rubric;
	public $description_rubric_id;

	public $grade_attribute;
	public $grade_attribute_range;
	public $grade_dimension;
	public $grade_dimension_range;
	public $grade_tool;	
	public $comment_attribute;
	public $comment_dimension;
	
	function __construct($id){
		if (isset($id) and is_numeric($id)){
			$this->id = $id;
		}
	}

	function recovery_grades($assessments){
		include_once('db.php');
		if(empty($assessments)){
			return false;
		}
		
		$grade_attribute = array();
		$grade_attribute_range = array();
		$grade_dimension = array();
		$grade_dimension_range = array();
		$grade_tool = array();
		$as = -1;
		$rate = array();
		$rate_range = array();
		$rate_dimension = array();
		$rate_dimension_range = array();
		$rate_tool = array();
		foreach($assessments as $assessment){
			/*$finalgrade = $assessment->get_ass_grd();
			if(!$finalgrade){
				continue;
			}*/
			$as++;
			$assessment_id = $assessment->id;
			$this->observation = $assessment->ass_com;
	
			$sql_atr = "SELECT atributo.id AS atributoid, ate_val, ate_ran
						FROM atreva, atributo, subdimension, dimen 
						WHERE ate_atr = atributo.id AND atr_sub = subdimension.id AND sub_dim = dimen.id AND dim_pla = ".$this->id." AND ate_eva = ". $assessment_id ." ORDER BY dimen.dim_pos, subdimension.sub_pos, atributo.atr_pos";// $sql_atr;
			$rst_atr = db::query($sql_atr);
		
			
			$sql_atrcom = "SELECT atributo.id AS atributoid, atc_obs
				FROM atrcomment, atributo, subdimension, dimen 
				WHERE atc_atr = atributo.id AND atr_sub = subdimension.id AND sub_dim = dimen.id AND dim_pla = ".$this->id." AND atc_eva = ". $assessment_id ." ORDER BY dimen.dim_pos, subdimension.sub_pos, atributo.atr_pos";
			$rst_atrcom = db::query($sql_atrcom);//echo $sql_atrcom;
			
			
			$rate_values = array();
			$read_next_attribute = 1;
			$read_next_attribute_comment = 1;
			
			for($i = 0; $i < $this->num_dimensions; $i++){
				//$scale = simple_tool::get_numeric_scale($this->values_dim[$i]);
				for($l = 0; $l < $this->num_subdimension[$i]; $l++){
					for($j = 0; $j < $this->num_atr_dim[$i][$l]; $j++){
						if($read_next_attribute == 1){
							$row_atr = db::next_row($rst_atr);
						}
						$read_next_attribute = 0;
						
						if($this->attributes_code[$i][$l][$j] == $row_atr['atributoid']){
							$value = $row_atr['ate_val'];
							//$valoracion = valoracion::fetch(array('id' => $value));
							//$value_cod = $valoracion->val_cod;
							//if(!isset($rate[$i][$l][$j][$value_cod])){
							//	$rate[$i][$l][$j][$value_cod] = 0;
							//}
							if(!isset($rate[$i][$l][$j][$value])){
								$rate[$i][$l][$j][$value] = 0;
							}
							
							//$rate[$i][$l][$j][$value_cod]++;
							//$grade_attribute[$as][$i][$l][$j] = $value_cod;
							$rate[$i][$l][$j][$value]++;
							$grade_attribute[$as][$i][$l][$j] = $value;
							
							if($this->type == 'rubrica'){
								$range = $row_atr['ate_ran'];
								//$rango = rango::fetch(array('id' => $range));
								//$range_cod = $rango->ran_cod;
								if(isset($range)){
									/*if(!isset($rate_range[$i][$l][$j][$range_cod])){
										$rate_range[$i][$l][$j][$range_cod] = 0;
									}

									$rate_range[$i][$l][$j][$range_cod]++;
									$grade_attribute_range[$as][$i][$l][$j] = $range;*/
									if(!isset($rate_range[$i][$l][$j][$range])){
										$rate_range[$i][$l][$j][$range] = 0;
									}
									$rate_range[$i][$l][$j][$range]++;
									$grade_attribute_range[$as][$i][$l][$j] = $range;
								}
							}	
					
							$read_next_attribute = 1;
						}
						else{
							$value = '';
							if(!isset($rate[$i][$l][$j][$value])){
								$rate[$i][$l][$j][$value] = 0;
							}
							$rate[$i][$l][$j][$value]++;
							if($this->type == 'rubrica'){
								if(!isset($rate_range[$i][$l][$j][$value])){
									$rate_range[$i][$l][$j][$value] = 0;
								}
								$rate_range[$i][$l][$j][$value]++;
								$grade_attribute_range[$as][$i][$l][$j] = $value;
							}
						}
						
						if($read_next_attribute_comment == 1){
							$row_atrcom = db::next_row($rst_atrcom);
						}
						$read_next_attribute_comment = 0;
						if($this->attributes_code[$i][$l][$j] == $row_atrcom['atributoid']){
							$value_com = $row_atrcom['atc_obs'];
							
							$this->comment_attribute[$i][$l][$j] = $value_com;
					//print_r($this->comment_attribute);
							$read_next_attribute_comment = 1;
						}
					}
				}
			}
			
			$sql_dim = "SELECT dimen.id AS dimensionid, die_val, die_ran
						FROM dimeva, dimen 
						WHERE die_dim = dimen.id AND dim_pla = ".$this->id." and die_eva = ".$assessment_id." ORDER BY die_dim";
			$rst_dim = db::query($sql_dim);
			$sql_dimcom = 	"SELECT dimen.id AS dimensionid, dic_obs
							FROM dimcomment, dimen 
							WHERE dic_dim = dimen.id AND dim_pla = ".$this->id." and dic_eva = ".$assessment_id." ORDER BY dic_dim";
			$rst_dimcom = db::query($sql_dimcom);//echo $sql_dimcom;
	
			$read_next_dimension = 1;
			$read_next_dimension_comment = 1;
			for($i = 0; $i < $this->num_dimensions; $i++){
				if($read_next_dimension == 1){
					$row_dim = db::next_row($rst_dim);
				}
				$read_next_dimension = 0;
				if($this->dimen_code[$i] == $row_dim['dimensionid']){
					$read_next_dimension = 1;
					$value = $row_dim['die_val'];
					/*$valoracion = valoracion::fetch(array('id' => $value));
					$value_cod = $valoracion->val_cod;
					if(!isset($rate_dimension[$i][$value_cod])){
						$rate_dimension[$i][$value_cod] = 0;
					}
					$rate_dimension[$i][$value_cod]++;
					$grade_dimension[$as][$i] = $value_cod;*/
					if(!isset($rate_dimension[$i][$value])){
						$rate_dimension[$i][$value] = 0;
					}
					$rate_dimension[$i][$value]++;
					$grade_dimension[$as][$i] = $value;
					if($this->type == 'rubrica'){
						$range = $row_dim['die_ran'];
						//$rango = rango::fetch(array('id' => $range));
						//$range_cod = $rango->ran_cod;
						if(isset($range)){
							/*if(!isset($rate_dimension_range[$i][$range_cod])){
								$rate_dimension_range[$i][$range_cod] = 0;
							}
							$rate_dimension_range[$i][$range_cod]++;
							$grade_dimension_range[$as][$i] = $range_cod;*/
							if(!isset($rate_dimension_range[$i][$range])){
								$rate_dimension_range[$i][$range] = 0;
							}
							$rate_dimension_range[$i][$range]++;
							$grade_dimension_range[$as][$i] = $range;
						}
					}
				}
				else{
					$value = '';
					if(!isset($rate_dimension[$i][$value])){
						$rate_dimension[$i][$value] = 0;
					}
					$rate_dimension[$i][$value]++;
					if($this->type == 'rubrica'){
						if(!isset($rate_dimension_range[$i][$value])){
							$rate_dimension_range[$i][$value] = 0;
						}
						$rate_dimension_range[$i][$value]++;
						$grade_dimension_range[$as][$i] = $value;
					}
				}
						
				if($read_next_dimension_comment == 1){
					$row_dimcom = db::next_row($rst_dimcom);
				}
				$read_next_dimension_comment = 0;
				if($this->dimen_code[$i] == $row_dimcom['dimensionid']){
					$value_com = $row_dimcom['dic_obs'];
					
					$this->comment_dimension[$i] = $value_com;
				
					$read_next_dimension_comment = 1;
				}
			}
			
			$sql_pla = "SELECT * 
						FROM plaeva 

						WHERE ple_pla = ".$this->id." AND ple_eva = ".$assessment_id;
			$rst_pla = db::query($sql_pla);
			if($row_pla = db::next_row($rst_pla)){
				//$this->grade_tool = $row_pla['ple_val'];
				$value = $row_pla['ple_val'];
				//$valoracion = valoracion::fetch(array('id' => $value));
				if(!isset($rate_tool[$value])){
					$rate_tool[$value] = 0;
				}
				else{
					$rate_tool[$value]++;
				}
				//$this->grade_tool = $valoracion->val_cod;
				$this->grade_tool = $value;
			}	
			else{
				$value = '';
				if(!isset($rate_tool[$value])){
					$rate_tool[$value] = 0;
				}
				$rate_tool[$value]++;
			}
		}
		if(isset($grade_dimension[$as])){
			$this->grade_dimension = $grade_dimension[0];
		}
		
		foreach($grade_attribute as $grade){ 
			for($i = 0; $i < $this->num_dimensions; $i++){
				$max_dim = 0;
				foreach($rate_dimension[$i] as $key_dim => $value_dim){
					if($value_dim > $max_dim){
						$max_dim = $value_dim;
						$this->grade_dimension[$i] = $key_dim;
					}
				}
				for($l = 0; $l < $this->num_subdimension[$i]; $l++){
					for($j = 0; $j < $this->num_atr_dim[$i][$l]; $j++){
						$max = 0;
						foreach($rate[$i][$l][$j] as $key =>$value){
							if($value > $max){
								$max = $value;
								$this->grade_attribute[$i][$l][$j] = $key;
							}
						}
					}
				}
			}
		}
		//print_r($this->grade_attribute);
		foreach($grade_attribute_range as $grade){ 
			for($i = 0; $i < $this->num_dimensions; $i++){
				$max_dim = 0;
				if(isset($rate_dimension_range[$i])){
					foreach($rate_dimension_range[$i] as $key_dim => $value_dim){
						if($value_dim > $max_dim){
							$max_dim = $value_dim;
							$this->grade_dimension_range[$i] = $key_dim;
						}
					}
				}
				for($l = 0; $l < $this->num_subdimension[$i]; $l++){
					for($j = 0; $j < $this->num_atr_dim[$i][$l]; $j++){						
						$max = 0;
						if(isset($rate_range[$i][$l][$j])){
							foreach($rate_range[$i][$l][$j] as $key =>$value){
								if($value > $max){
									$max = $value;
									$this->grade_attribute_range[$i][$l][$j] = $key;
								}
							}
						}
					}
				}
			}
		}
	}
	
	function recovery(){
		include_once('plantilla.php');
		include_once('dimension.php');
		include_once('subdimension.php');
		include_once('atributo.php');
		include_once('dimval.php');
		include_once('rango.php');
		include_once('ranval.php');
		include_once('atribdes.php');
		include_once('plaval.php');
		include_once('valoracion.php');
		$plantilla = plantilla::fetch(array('id' => $this->id));

		$this->title = $plantilla->pla_tit;
		$this->observation = $plantilla->pla_des;
		$this->percentage = $plantilla->pla_por;		
		$this->type = $plantilla->pla_tip;
		$this->yesnovglobal = $plantilla->pla_glo;
		$this->total_value_por = $plantilla->pla_gpr;
		$this->pla_cod = $plantilla->pla_cod;
		
		if($plaval = plaval::fetch_all(array('plv_pla' => $this->id))){
			$this->num_total_value = count($plaval);
			$i = 0;
			foreach($plaval as $plv){
				//$value = valoracion::fetch(array('id' => $plv->plv_val));
				//$this->name_total_values[$i] = $value->val_cod;
				$this->name_total_values[$i] = $plv->plv_val;
				$this->cod_total_values[$i] = $plv->id;
				++$i;
			}
		}
		
		$dimensions = dimension::fetch_all(array('dim_pla' => $this->id), array('dim_pos'));
		$this->num_dimensions = count($dimensions);
		$i = 0;
		foreach($dimensions as $dimension){
			$this->dimen_code[$i] = $dimension->id;
			$this->dimen_com[$i] = $dimension->dim_com;
			$this->global_value[$i] = $dimension->dim_glo;
			$this->global_value_por[$i] = $dimension->dim_gpr;
			$this->percentages_dim[$i] = $dimension->dim_por;
			
			$dimval = dimval::fetch_all(array('div_dim' => $dimension->id), array('div_pos'));
			$this->num_values_dim[$i] = count($dimval);
			$this->values_dim[$i][0] = $dimension->dim_nom;
			$v = 1;
			foreach($dimval as $div){
				//$value = valoracion::fetch(array('id' => $div->div_val));
				//$this->values_dim[$i][$v] = $value->val_cod;
				$this->values_dim[$i][$v] = $div->div_val;
				$this->values_dimension_id[$i][$v] = $div->id;
				if($ranval = ranval::fetch_all(array('rav_dim' => $dimension->id, 'rav_val' => $div->div_val), array('rav_pos'))){
					$this->num_rango[$i][$v-1] = count($ranval);
					$r = 0;
					foreach($ranval as $rav){
						//$rango = rango::fetch(array('id' => $rav->rav_ran));
						//$this->rango[$i][$v-1][$r] = $rango->ran_cod;
						$this->rango[$i][$v-1][$r] = $rav->rav_ran;
						$this->rango_id[$i][$v-1][$r] = $rav->id;
						++$r;
					}
				}
				++$v;
			}
			
			$subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id), array('sub_pos'));
			$this->num_subdimension[$i] = count($subdimensions);
			$j = 0;
			foreach($subdimensions as $subdimension){
				$this->name_subdimension[$i][$j] = $subdimension->sub_nom;
				$this->subdimension_code[$i][$j] = $subdimension->id;
				$this->percentage_subdimension[$i][$j] = $subdimension->sub_por;
				
				$order = array('atr_pos');
				if($this->type == 'diferencial'){
					$order = array('atr_pos', 'id');
				}
				
				$attributes = atributo::fetch_all(array('atr_sub' => $subdimension->id), $order);
				$this->num_atr_dim[$i][$j] = count($attributes);
				$k = 0;
				foreach($attributes as $attribute){
					$this->attributes[$i][$j][$k] = $attribute->atr_des;
					$this->attributes_percentage[$i][$j][$k] = $attribute->atr_por;
					$this->attributes_code[$i][$j][$k] = $attribute->id;
					$this->attributes_com[$i][$j][$k] = $attribute->atr_com;
			
					$l = 0;
					foreach($dimval as $div){
						if($atribdes = atribdes::fetch(array('atd_val' => $div->div_val, 'atd_atr' => $attribute->id))){
							$this->description_rubric[$i][$j][$k][$l] = $atribdes->atd_des;
							$this->description_rubric_id[$i][$j][$k][$l] = $atribdes->id;
						}
						++$l;
					}
					++$k;
				}
				++$j;
			}
			++$i;
		}
	}
	
	/**
	* Converts $scale in numeric $scale from 0 to 100
	* @param array $scale array of values alphanumeric
	* @return array with numeric scale
	*/
	public static function get_numeric_scale($scale){
		if(!is_array($scale)){
			return false;
		}
		$is_numeric = true;
		foreach($scale as $grade){
			if(!is_numeric($grade)){
				$is_numeric = false;
			}
		}
		
		if($is_numeric){
			return $scale;
		}
		
		$result = array();
		
		//First Value
		$key = $scale[0];
		$result[$key] = 0;
		
		//Next Values
		$size = count($scale);
		$distance = 100 / ($size - 1);
		$accumulator = 0;
		for($i = 1; $i <= ($size - 1); $i++){
			$accumulator += $distance;
			$key = $scale[$i];
			$result[$key] = $accumulator;
			if($i == ($size - 1)){
				$result[$key] = 100;
			}
		}		
		return $result;
	}
}
?>