<?php

require_once('simple_tool.php');
class collector_tool{
	
	public $id;
	public $title;
	public $comments;
	public $mixed = false;
	/**
	* @var array of tool objects
	*/
	public $tools;
	
	function __construct($id, $type = 'single', $assessments = array()){
		if (isset($id)){
			$this->id = $id;
			if ($type == 'single'){
				$this->mixed = false;
				$single_tool = new simple_tool($this->id);
				$single_tool->recovery();
				if(!empty($assessments)){
					$single_tool->recovery_grades($assessments);
				}
				$this->tools = array($single_tool);
			}
			elseif ($type == 'composed'){
				$mixed_datas = $this->get_mixed_datas($id);
				$this->title = $mixed_datas->title;
				$this->comments = $mixed_datas->comments;
				$this->mixed = true;
				$id_tools = $mixed_datas->tools_id;
				foreach($id_tools as $id_tool){
					$single_tool = new simple_tool($id_tool);
					$single_tool->recovery();
					if(!empty($assessments)){
						$single_tool->recovery_grades($assessments);
					}
					$this->tools[] = $single_tool;
				}
			}
		}
	}
	
	public function get_mixed_datas(){
		require_once('plantilla.php');
		require_once('mixtopla.php');

		$mixto = plantilla::fetch(array('id' => $this->id));
		$mixtopla = mixtopla::fetch_all(array('mip_mix' => $mixto->id), array('mip_pos'));

		$result = new stdClass();
		$result->title = $mixto->pla_tit;
		$result->comments = $mixto->pla_des;
		foreach($mixtopla as $tool){
			$result->tools_id[] = $tool->mip_pla;
		}
	
		return $result;
	}
	
	public function get_tools(){
		return $this->tools;
	}
}