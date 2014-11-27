<?php

	include_once('dimension.php');
	include_once('subdimension.php');
	include_once('assessment.php');
	include_once('plantilla.php');
	include_once('subdimension.php');
	include_once('plaeva.php');
	include_once('plaval.php');
	include_once('dimval.php');
	include_once('gradebase.php');
	include_once('valoracion.php');

	class gradescale extends gradebase{

		private $scales;
		private $numericScales;

		function __construct($assessment1, $tool)
		{
			parent::__construct($assessment1, $tool);			

			//get the tool dimensions ID------
			$dimensions = dimension::fetch_all(array('dim_pla' => $this->tool->id));
			foreach($dimensions as $dim){
				$id = $dim->id;
				$dimval = dimval::fetch_all(array('div_dim' => $id));
				$scale = array();
				foreach($dimval as $div){
					$scale[] = $div->div_val;
				}
				$this->scales[$id] = $scale;
				$this->numericScales[$id] = $this->scale_to_numeric_values($this->scales[$id]);
			}
		}
		
		//@param $dimension: dimension object
		//@return dimension grade
		function get_grade_dimension($dimension){	
			//Subdimensions-objects--------------------
			$subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id));

			//work-out dimension grade---------------------------------
			$subdimensionGrade = 0;
			$subdimensionPorcentages = array();
			$result = 0;
			$sumPorcentages = 0;

			//Check porcentages sum 100 in other case, add the difference until
			//to reach 100
			$i = 0;
			foreach($subdimensions as $sub){
				$sumPorcentages += $sub->sub_por;
				$subdimensionPorcentages[$i] = $sub->sub_por;
				++$i;
			}
			
			if($dimension->dim_glo === 'f' || $dimension->dim_glo === '0' || $dimension->dim_glo == false){
				$diffPorcentages = 100 - $sumPorcentages;	
				if($diffPorcentages != 0){
					for($p = 0; $p < $diffPorcentages; $p++){
						$subdimensionPorcentages[$p] += 1;
					}
				}	
			}
			
			$i = 0;
			foreach($subdimensions as $sub){
				$subdimensionGrade = $this->get_grade_subdimension($sub, $dimension); 
				$weightedValue = $subdimensionGrade * ($subdimensionPorcentages[$i] / 100); 
				$result += $weightedValue;
				++$i;
			}

			//work-out--global-value------------------
			if($dimension->dim_glo == 't' || $dimension->dim_glo == '1'){
				$globalValuePorcentage = 100 - array_sum($subdimensionPorcentages);
				$globalValue = $this->get_global_value($dimension);
				if(isset($globalValue)){
					$this->calificated = true;
				}
				$weightedValue = $globalValue * ($globalValuePorcentage / 100);
				$result += $weightedValue;
			}
			if($this->calificated == false){
				return NO_CALIFICATED;
			}

			return ceil($result);
		}

		function get_attribute_grade($attribute, $dimension)
		{ 
			if($gradeObject = atreva::fetch(array('ate_eva' => $this->assessment->id, 'ate_atr' => $attribute->id))){
				$mark = $gradeObject->ate_val; 
				$dimensionId = $dimension->id;
				if(isset($this->numericScales[$dimensionId][$mark])){
					return $this->numericScales[$dimensionId][$mark]; 
				}
				
				return $mark;		
			}
			return null;
		}


		//@return dimension global value
		function get_global_value($dimension)
		{
			$dimensionId = $dimension->id;
			if($globalValue = dimeva::fetch(array('die_eva' => $this->assessment->id, 'die_dim' => $dimensionId))){
				$mark = $globalValue->die_val;
				if(isset($this->numericScales[$dimensionId][$mark])){
					return $this->numericScales[$dimensionId][$mark];
				}
			
				return $mark;
			}
			return null;
		}
	}
?>
