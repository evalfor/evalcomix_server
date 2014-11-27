<?php
	include_once('gradescale.php');
	include_once('gradelistscale.php');
	include_once('grademix.php');
	include_once('graderubrica.php');
	include_once('gradedifferential.php');
	include_once('gradeargumentset.php');
	include_once('plantilla.php');

	class grade {
		private $object;

		function __construct($assessmentId, $toolId)
		{ 
			$tool = plantilla::fetch(array('id' => $toolId));
			$type = $tool->pla_tip;			
			
			switch($type){
				case 'lista': $this->object = new gradescale($assessmentId, $toolId);break;
				case 'escala': $this->object = new gradescale($assessmentId, $toolId);break;
				case 'lista+escala': $this->object = new gradelistscale($assessmentId, $toolId);break;
				case 'rubrica': $this->object = new graderubrica($assessmentId, $toolId);break;
				case 'diferencial': $this->object = new gradedifferential($assessmentId, $toolId);break;
				case 'argumentario': $this->object = new gradeargumentset($assessmentId, $toolId);break;
				case 'mixto': $this->object = new grademix($assessmentId);break;
			}
		}
		
		function get_grade(){
			return $this->object->get_grade();
		}

		function max_grade(){
			return $this->object->max_grade();
		}

		function get_average($marks){
			$count = sizeof($marks);
			$calificated = 0;

			$sum = 0; //It'll save the sum of elements of $marks
			for($i = 0; $i < $count; $i++)
			{
				if($marks[$i] != ''){
					$sum += $marks[$i];
					$calificated = 1;
				}
			}
			if($calificated){
				return $sum / $count;
			}
						
			return -1;

		}

	}
?>
