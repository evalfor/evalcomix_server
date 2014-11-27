<?php

	include_once('dimension.php');
	include_once('assessment.php');
	include_once('plantilla.php');
	include_once('subdimension.php');
	include_once('plaeva.php');
	include_once('plaval.php');
	include_once('gradebase.php');
	include_once('atrdiferencial.php');
	include_once('atributo.php');
	include_once('atreva.php');
	include_once('dimeva.php');
	include_once('dimval.php');

	class gradedifferential extends gradebase{

		private $scales;
		private $numericScales;

		function __construct($assessment1, $tool)
		{
			parent::__construct($assessment1, $tool);			

			//get the tool dimensions ID------
			$dimensionIDs = dimension::fetch_all(array('dim_pla' => $this->tool->id));
			$countDimensions = count($dimensionIDs);
			foreach($dimensionIDs as $dim){
				$id = $dim->id;
				$scale = array();
				$dimval = dimval::fetch_all(array('div_dim' => $id));
				foreach($dimval as $value){
					$scale[] = $value->div_val;
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
			
			if(!$dimension->dim_glo){
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
			if($dimension->dim_glo){
				$globalValuePorcentage = 100 - array_sum($subdimensionPorcentages);
				$globalValue = $this->get_global_value($dimension);
				$weightedValue = $globalValue * ($globalValuePorcentage / 100);
				$result += $weightedValue;
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

		
		//@param $subdimension: sudimension object
		//@return subdimension grade
		function get_grade_subdimension($subdimension, $dimension)
		{
			//Attributes-objects--------------------
			$allattributes = atributo::fetch_all(array('atr_sub' => $subdimension->id));
			$attributesdifferential = array();
			foreach($allattributes as $attribute){
				if($att = atrdiferencial::fetch(array('atf_atn' => $attribute->id))){
					$attributesdifferential[] = $att;
					$attributes[] = $attribute;
				}
			}
			
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

			return ceil($result);
		}


	}
?>
