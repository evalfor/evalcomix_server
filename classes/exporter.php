<?php

require_once('export_xml.php');
	
class exporter {
	/**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $required_fields = array();

	/**
     * Array of optional table fields.
     * @var array $required_fields
     */
    public $optional_fields = array('tool_id', 'assessment');

	/**
	* @var string $tool_id
	*/
	public $tool_id;
	
	/**
	* Assessment object
	* @var object Assessment
	*/
	public $assessment;
		
	/**
	* @var object to export. It depends on format
	*/
	private $exporter_object;
	
	/**
     * Constructor.
     * @param array $params an array with required parameters for this object.
	 * @param string $format is the exportation format 
	 */
	public function __construct($params, $format){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			exporter::set_properties($this, $params);
			
			//$case = $this->get_case();
			$tool_datas = $this->get_tool_datas();
			if (!isset($this->assessment) && !isset($this->tool_id)){
				throw new Exception('Exporter: Missing Parameters');
			}
			switch ($format){
				case 'xml':{
					$this->set_exporter_xml($tool_datas);
				}break;
			}
		}
	}
	
	/** 
	*	CASES:
	*	'1' ==> ($modality == ['teacher' | 'self' | 'peer']) --> XML without grades
	*	'2' ==> ($modality == 'self' && isset($student_id)) --> XML with self grades
	*	'3' ==> ($modality == 'teacher' && isset($student_id)) --> XML with average of teacher grades
	*	'4' ==> ($modality == 'peer' && isset($student_id)) --> XML with average of peer grades
	*	'5' ==> ($modality == ['peer' | 'teacher'] && isset($student_id) && isset($assessor_id)) --> XML with assessor's grade
	*    @return int case or false
	*/	
	private function get_case(){
		if (!isset($this->tool_id) and !isset($this->modality)){
			return false;
		}
		$case = 0;
		if (!isset($this->student_id) || isset($this->tool_id)){
			$case = 1;
		}
		elseif ($this->modality == 'self'){
			$case = 2;
		}
		elseif ($this->modality == 'teacher' and !isset($this->assessor_id)){
			$case = 3;
		}
		elseif ($this->modality == 'peer' and !isset($this->assessor_id)){
			$case = 4;
		}
		elseif (($this->modality == 'teacher' or $this->modality == 'peer') and isset($this->assessor_id)){
			$case = 5;
		}
		return $case;
	}
		
	function get_tool_datas(){
		require_once('assessment.php');
		require_once('plantilla.php');
		
		if($tool = plantilla::fetch(array('id' => $this->tool_id))){
			$type = '';
			$pla_tip = $tool->pla_tip;
			if($pla_tip == 'mixto'){
				$type = 'composed';
			}
			else{
				$type = 'single';
			}
		}
		
		$assessments = array();
		if(isset($this->assessment)){
			array_push($assessments, $this->assessment);
		}
		else{
			$assessments = array();
		}
		
		require_once('collector_tool.php');
		$collector = new collector_tool($this->tool_id, $type, $assessments);
		return $collector;
	}
	
	/**
     * Given an associated array or object, it cycles through each key/variable
     * and assigns the value to the corresponding variable in this object.
     * @static final
     */
	public static function set_properties(&$instance, $params){
		$params = (array) $params;
		
        foreach ($params as $var => $value) {
            if (in_array($var, $instance->required_fields) or in_array($var, $instance->optional_fields)) {
                $instance->$var = $value;
            }
        }
	}
	
	public function set_exporter_xml($params){
		$this->exporter_object = new export_xml($params);
	}
	
	public function export($flush = 'flush', $mode = 'print'){
		if($mode === 'flush'){
			$this->exporter_object->export($mode, $flush);
		}
		else{
			return $this->exporter_object->export($mode, $flush);
		}
	}
}