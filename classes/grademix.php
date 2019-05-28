<?php
	include_once('grade.php');
	include_once('assessment.php');
	include_once('plantilla.php');
	include_once('mixtopla.php');
	
	class grademix extends grade{
		private $tools;
		private $assessment;
		protected $calificated = false;
	
		function __construct($assessment){
			$this->assessment = assessment::fetch(array('id' => $assessment));

			$toolId = $this->assessment->ass_pla;
			$mixta = plantilla::fetch(array('id' => $toolId));
			$tools = mixtopla::fetch_all(array('mip_mix' => $toolId));
			foreach($tools as $tool){
				$this->tools[] = plantilla::fetch(array('id' => $tool->mip_pla));
			}
		}

		function get_grade()
		{ 
			$countTools = count($this->tools);
			$toolPorcentages = array();
			$sumPorcentages = 0;
			for($i = 0; $i < $countTools; $i++){
				$sumPorcentages += $this->tools[$i]->pla_por;
				$toolPorcentages[$i] = $this->tools[$i]->pla_por;
			}
			$diffPorcentages = 100 - $sumPorcentages;	
			if($diffPorcentages != 0){
				for($p = 0; $p < $diffPorcentages; $p++){
					$toolPorcentages[$p] += 1;
				}
			}	
			
			$grade = array();
			$result = 0;
			for($i = 0; $i < $countTools; $i++){
				$gradeObject = new grade($this->assessment->id, $this->tools[$i]->id);
				$grade[$i] = $gradeObject->get_grade();
				if(trim($grade[$i]) != ''){
					$this->calificated = true;
					$result += $grade[$i] * ($toolPorcentages[$i] / 100);
				}
			}
			
			if(isset($this->calificated) && $this->calificated == false){
				return NO_CALIFICATED;
			}
			
			return ceil($result);
		}

		function max_grade(){
			return 100;
		}
	}

?>
