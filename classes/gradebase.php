<?php

	require_once('dimension.php');
	require_once('assessment.php');
	require_once('plantilla.php');
	require_once('subdimension.php');
	require_once('plaeva.php');
	require_once('plaval.php');
	define("NO_CALIFICATED", "");

	class gradebase extends grade {
		protected $assessment;
		protected $tool;
		protected $dimensions;
		protected $countDimensions;
		protected $subdimensions;
		protected $countSubdimensions;
		protected $minGrade = 0;
		protected $maxGrade = 100;
		protected $calificated = false;

		function __construct($assessment, $tool)
		{
			//get the tool associated---------
			$this->assessment = assessment::fetch(array('id' => $assessment));
			$this->tool = plantilla::fetch(array('id' => $tool));

			//get the tool dimensions ID------
			$this->dimensions = dimension::fetch_all(array('dim_pla' => $tool));
			$this->countDimensions = count($this->dimensions);
		}


		//@return the grade of the tool. It's suposed that porcentages are saved correctly in the system
		function get_grade()
		{

			$dimensionGrade = 0;
			$dimensionPorcentages = array();
			$result = 0; 
			$sumPorcentages = 0;
			
			//Check porcentages sum 100 in other case, add the difference until
			//to reach 100
			foreach($this->dimensions as $dim){
				$id = $dim->id;
				$sumPorcentages += $dim->dim_por;
				$dimensionPorcentages[$id] = $dim->dim_por;
			}
						
			if((string)$this->tool->pla_glo == 'f' || (string)$this->tool->pla_glo == '0' || $this->tool->pla_glo == false){
				$diffPorcentages = 100 - $sumPorcentages;
				if($diffPorcentages != 0){
					foreach($dimensionPorcentages as $key => $item){
						if($diffPorcentages > 0){
							$dimensionPorcentages[$key] += 1;
							$diffPorcentages--;
						}
						else{
							break;
						}
					}
				}
			}

			//calculate grade of all dimensions
			$i = 0;
			foreach($this->dimensions as $dim){
				$id = $dim->id;
				$dimensionGrade = $this->get_grade_dimension($dim);
				if($dimensionGrade){
					$weightedValue = $dimensionGrade * ($dimensionPorcentages[$id] / 100);
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
			//exit;
			
			if($this->calificated == false){
				return NO_CALIFICATED;
			}

			return ceil($result);
		}


		//@param $dimension: dimension object
		//@return dimension grade
		/*function get_grade_dimension($dimension){	
			//Subdimensions-objects--------------------
			$subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id));

			//work-out dimension grade---------------------------------
			$subdimensionGrade = 0;
			$subdimensionPorcentages = array();
			$result = 0;

			//Check porcentages sum 100 in other case, add the difference until
			//to reach 100
			$i = 0;
			foreach($subdimensions as $sub){
				$sumPorcentages += $sub->sub_por;
				$subdimensionPorcentages[$i] = $sub->sub_por;
				++$i;
			}
			
			if($dimension->dim_glo == 'f' || $dimension->dim_glo == 0){
				$diffPorcentages = 100 - $sumPorcentages;	
				if($diffPorcentages != 0){
					for($p = 0; $p < $diffPorcentages; $p++){
						$subdimensionPorcentages[$p] += 1;
					}
				}	
			}

			for($i = 0; $i < $countSubdimensions; $i++){
				$subdimensionGrade = $this->get_grade_subdimension($subdimensions[$i], $dimension);
				$weightedValue = $subdimensionGrade * ($subdimensionPorcentages[$i] / 100);
				$result += $weightedValue; 
			}

			//work-out--global-value------------------
			if($dimension->dim_glo == 't' || $dimension->dim_glo == 1){
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
		}*/


		//@param $subdimension: sudimension object
		//@return subdimension grade
		function get_grade_subdimension($subdimension, $dimension)
		{
			//Attributes-objects--------------------
			$attributes = atributo::fetch_all(array('atr_sub' => $subdimension->id));

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

			return ceil($result);
		}

		/*function get_attribute_grade($attribute, $dimension)
		{	
		}*/

		//@return tool final value
		function get_final_value()
		{
			if($finalValue = plaeva::fetch(array('ple_eva' => $this->assessment->id, 'ple_pla' => $this->tool->id))){
				$mark = $finalValue->ple_val;
				$scale = array(); 
				$plaval = plaval::fetch_all(array('plv_pla' => $this->tool->id));
				foreach($plaval as $plv){
					$scale[] = $plv->plv_val;
				}
				
				$this->minGrade = 0;
				$numericMarks = $this->scale_to_numeric_values($scale);
				if(isset($numericMarks[$mark])){
					return $numericMarks[$mark];
				}
			
				return $mark;
			}
		}

		//@return dimension global value
		/*function get_global_value($dimension)
		{
			$dimensionId = $dimension->dim_cod;
			$globalValue = dimeva::fetch(array('die_eva' => $this->assessment->ass_cod, 'die_dim' => $dimensionId));
			$mark = $globalValue->die_val;
			
			
			return $mark;
		}*/

		//@param $grades -- unidimensional vector of grades
		//@return hash table where the Keys = $grades and the Values = numeric conversion of $grades 
		//between $minGrade and $maxGrade
		function scale_to_numeric_values($grades)
		{
			//we create the numeric scale
			$num_grade = sizeof($grades);
			$max = $num_grade - 1;
			$min = 0;
	
			/*if(is_numeric($grades[0]) && is_numeric($grades[$num_grade - 1]) && $grades[0] > $grades[$num_grade - 1]){
				$max = 0;
				$min = $num_grade - 1;
			}
			else*/ if($grades[0] < $grades[$num_grade - 1]){
				$max = $num_grade - 1;
				$min = 0;
			}
	
			$distance = $this->maxGrade / ($num_grade - 1);
			$numeric_grade = array();
			$numeric_grade[$grades[$max]] = $this->maxGrade;
			$accumulator = $this->minGrade;
	
			if($max > $min){
				for($i = $min; $i < $max; $i++){
					$numeric_grade[$grades[$i]] = $accumulator; 
					$accumulator += $distance;
				}
			}
			/*else{
				for($i = $min; $i > $max; $i--){
					$numeric_grade[$grades[$i]] = $accumulator; //echo "i = $i; numeric_grade[$grades[$i]]	=".	$numeric_grade[$grades[$i]] .'<br>';
					$accumulator += $distance;
				}
			}*/
			
			return $numeric_grade; 
		}

		/*
		It returns 1 if all dimensions has got the same scale, 0 in other case
		*/
		/*function same_scale_for_dimensions()
		{		
			for($k = 0; $k < $countDimensions; $k++)
			{
				$tam_array1 = sizeof($this->scales[$k]);
				$tam_array2 = sizeof($this->scales[$k+1]);
				if($tam_array1 != $tam_array2)
					return 0;
	
				for($i = 0; $i < $tam_array1; $i++)
				{
					if($this->scales[$k][$i] != $this->scales[$k+1][$i])
					{
						return 0;	
					}
				}
			}
			
			return 1;	
		}*/
	
		/*SCALE_IS_NUMERIC--------------------------------------------
		It checks if grades are numeric.
		If they are, it returns 1. In other case, it returns 0.
		------------------------------------------------------------*/
		/*function scale_is_numeric($scale)
		{
			$num_grade = sizeof($scale);
			for($i = 0; $i < $num_grade; $i++)
			{
				if(!is_numeric($scale[$i]))
				{
					return 0;
				}
			}
	
			return 1;
		}*/

		function max_grade(){
			return $this->maxGrade;
		}

		/*function same_ponderation($ponderations)
		{
			$count = count($ponderations);
			for($i = 0; $i < $count; $i++){
				if($i + 1 < $count)
					if($ponderations[$i] != $ponderations[$i+1])
						return 0;
			}
			return 1;
		}*/

		/*GET_AVERAGE-------------------------------------------------
		It receives an array with numeric grades.
		It returns the average.
		------------------------------------------------------------*/
		/*function get_average($marks)
		{ 
			$count = sizeof($marks);
			if($this->scale_is_numeric($marks) && $count)
			{
				$sum = 0; //It'll save the sum of elements of $marks
				for($i = 0; $i < $count; $i++)
				{
					if($marks[$i] != NO_CALIFICATED){
						$sum += $marks[$i];
					}
				}
				if($this->calificated){
					return $sum / $count;
				}
			}
			
			return -1;
		}*/

	}