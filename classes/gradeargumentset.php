<?php
	include_once('gradebase.php');

	class gradeargumentset extends gradebase{
		function __construct($assessment1, $tool){
			parent::__construct($assessment1, $tool);
		}
		
		function get_grade(){
			$result = $this->assessment->get_ass_grd();
			if(isset($result)){
				$this->calificated = true;
			}
			if($this->calificated == false){
				return NO_CALIFICATED;
			}
			return $result;
		}
		
		function get_grade_dimension($dimension){}
		
		function get_grade_subdimension($subdimension, $dimension){}
		
		function get_final_value(){}
		
		function get_global_value($dimension){}
		
	}
?>