<?php

	include_once('dimension.php');
	include_once('assessment.php');
	include_once('plantilla.php');
	include_once('subdimension.php');
	include_once('plaeva.php');
	include_once('plaval.php');
	include_once('ranval.php');
	include_once('gradebase.php');
	include_once('valoracion.php');
	include_once('atreva.php');

	class graderubrica extends gradebase{

		private $scales;
		private $numericScales;

		function __construct($assessment1, $tool)
		{
			parent::__construct($assessment1, $tool);			

			//get the tool dimensions ID------
			$dimensionIDs = dimension::fetch_all(array('dim_pla' => $this->tool->id));
			foreach($dimensionIDs as $dim){
				$id = $dim->id;
				$scale = array();
				$ranval = ranval::fetch_all(array('rav_dim' => $id), array('rav_pos'));
				foreach($ranval as $value){
					$scale[] = $value->rav_ran;
				}
				$this->scales[$id] = $scale;
				$this->numericScales[$id] = $this->scale_to_numeric_values($this->scales[$id]); 
			}
		}

				//@return the grade of the tool. It's suposed that porcentages are saved correctly in the system
		function get_grade()
		{

			$dimensionGrade = 0;
			$dimensionPorcentages = array();
			$result = 0; 
			
			//Check porcentages sum 100 in other case, add the difference until
			//to reach 100
			$sumPorcentages = 0;
			$i = 0;
			foreach($this->dimensions as $dim){
				$sumPorcentages += $dim->dim_por;
				$dimensionPorcentages[$i] = $dim->dim_por;
				++$i;
			}
			if($this->tool->pla_glo === 'f' || $this->tool->pla_glo === '0' || $this->tool->pla_glo == false){
				$diffPorcentages = 100 - $sumPorcentages;	
				if($diffPorcentages != 0){
					for($p = 0; $p < $diffPorcentages; $p++){
						$dimensionPorcentages[$p] += 1;
					}
				}	
			}

			//calculate grade of all dimensions
			$i = 0;
			foreach($this->dimensions as $dim){
				$dimensionGrade = $this->get_grade_dimension($dim);
				if(trim($dimensionGrade) != ''){
					$weightedValue = $dimensionGrade * ($dimensionPorcentages[$i] / 100);
					$result += $weightedValue;
				}
				++$i;
			}		
			if($this->tool->pla_glo == 't' || $this->tool->pla_glo == '1'){
				$finalValuePorcentage = 100 - array_sum($dimensionPorcentages);
				$finalValue = $this->get_final_value();
				if(isset($finalValue)){
					$this->calificated = true;
				}
				$result += $finalValue * ($finalValuePorcentage / 100);
			}

			if($this->calificated == false){
				return NO_CALIFICATED;
			}
			
			return ceil($result);
		}
		
		//@param $dimension: dimension object
		//@return dimension grade
		function get_grade_dimension($dimension){	
			//Subdimensions-objects--------------------
			$subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id));
			$countSubdimensions = count($subdimensions);

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
				if(trim($subdimensionGrade) != ''){
					$weightedValue = $subdimensionGrade * ($subdimensionPorcentages[$i] / 100); 
					$result += $weightedValue;
				}
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

		//@param $subdimension: sudimension object
		//@return subdimension grade
		function get_grade_subdimension($subdimension, $dimension)
		{
			//Attributes-objects--------------------
			$attributes = atributo::fetch_all(array('atr_sub' => $subdimension->id));
			$attributeGrade = array();

			//work-out-------------------------------
			$attributeGrade = 0;
			$attributePorcentages = array();
			$result = 0;
			$grades = array();
			$sumPorcentages = 0;
			//Check porcentages sum 100 in other case, add the difference until
			//to reach 100
			foreach($attributes as $att){
				$id = $att->id;
				$sumPorcentages += $att->atr_por;
				$attributePorcentages[$id] = $att->atr_por;
			}
			
			$diffPorcentages = 100 - $sumPorcentages;
			if($diffPorcentages != 0){
				foreach($attributePorcentages as $key => $item){
					if($diffPorcentages > 0){
						$attributePorcentages[$key] += 1;
						$diffPorcentages--;
					}
					else{
						break;
					}
				}
			}	
			$i = 0;
			foreach($attributes as $att){
				$id = $att->id;
				$grades[$i] = $this->get_attribute_grade($att, $dimension);
				if(isset($grades[$i])){
					$this->calificated = true;
				}
				$weightedValue = $grades[$i] * ($attributePorcentages[$id] / 100);
				$result += $weightedValue;
				++$i;
			}

			if($this->calificated == false){
				return NO_CALIFICATED;
			}
			
			return $result;
		}

		function get_attribute_grade($attribute, $dimension)
		{ 
			if($gradeObject = atreva::fetch(array('ate_eva' => $this->assessment->id, 'ate_atr' => $attribute->id))){
				$mark = $gradeObject->ate_ran;
				$dimensionId = $dimension->id;
				if(isset($this->numericScales[$dimensionId][$mark])){
					return $this->numericScales[$dimensionId][$mark]; 
				}
				return $mark;				
			}
		}


		//@return dimension global value
		function get_global_value($dimension)
		{
			$dimensionId = $dimension->id;
			if($globalValue = dimeva::fetch(array('die_eva' => $this->assessment->id, 'die_dim' => $dimensionId))){
				$mark = $globalValue->die_ran; 
				if(isset($this->numericScales[$dimensionId][$mark])){
					return $this->numericScales[$dimensionId][$mark];
				}
			
				return $mark;
			}
		}

	}
?>
