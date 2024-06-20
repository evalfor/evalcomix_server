<?php	
require_once('export_object.php');

/**
* Export a tool to XML format
*/
class export_xml extends export_object{

	/**
     * Constructor.
     * @param array $params an array with required parameters for this object.
	 */
	public function __construct($tool){
		if(!isset($tool) or !is_object($tool) or !isset($tool->id)){
			throw new Exception("Tool is not an object valid");
		}
		$this->tool = $tool;
	}
	
	/**
	* @retunr string XML Document of $tool
	*/
	public function export($mode = 'print', $flush = 'flush'){
		$simple_tools = $this->tool->get_tools();
		if($this->tool->mixed == true) {
			if($mode === 'print'){
				$result = '<mt:MixTool xmlns:mt="http://avanza.uca.es/assessmentservice/mixtool"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://avanza.uca.es/assessmentservice/mixtool http://avanza.uca.es/assessmentservice/MixTool.xsd"
name="' . htmlspecialchars($this->tool->title) . '" instruments="' . count($simple_tools) .'">
			';
			}
			else{
				$result = '<MixTool name="' . htmlspecialchars($this->tool->title) . '" instruments="' . count($simple_tools) .'">
			';
			}
		
			//DESCRIPTION----------------
			if($this->tool->description){
				$result .= '<Description>' . htmlspecialchars($this->tool->description) . '</Description>
				';
			}
			
			foreach($simple_tools as $simple_tool){
				$result .= $this->export_simple_tool($simple_tool, 'composed');
			}
			
			if($mode == 'print'){
				$result .= '</mt:MixTool>';
			}
			else{
				$result .= '</MixTool>';
			}
		}
		else {
			$result = $this->export_simple_tool($simple_tools[0], 'simple', $mode);
		}
		
		if($flush === 'flush'){
			// Header for XML----------------------------------------------------
			header('Content-type: text/xml; charset="utf-8"', true);
			echo $result;
		} else {
			return $result;
		}
		
	}
	
	/**
	* @param object $simple_tool
	* @param string $mixed in order to indicate if $simple_tool is 'simple' (individual tool) or 'composed' (it is part of a mixed tool)
	* @retunr string XML Document of $simple_tool
	*/
	private function export_simple_tool($simple_tool, $mixed, $mode='print'){
		if(!isset($simple_tool->type)){
			return false;
		}
		
		switch($simple_tool->type){
			case 'lista':{
				return $this->export_checklist($simple_tool, $mixed, $mode);
			}break;
			case 'escala':{
				return $this->export_scale($simple_tool, $mixed, $mode);
			}break;
			case 'rubrica':	{
				return $this->export_rubric($simple_tool, $mixed, $mode);
			}break;
			case 'lista+escala':{
				return $this->export_list_scale($simple_tool, $mixed, $mode);
			}break;
			case 'diferencial':{
				return $this->export_differential($simple_tool, $mixed, $mode);
			}break;
			case 'argumentario':{
				return $this->export_argumentset($simple_tool, $mixed, $mode);
			}break;
		}
	}
	
	/**
	* @param object $simple_tool of a checklist tool
	* @param string $mixed in order to indicate if $simple_tool is 'simple' (individual tool) or 'composed' (it is part of a mixed tool)
	* @retunr string XML Document of $simple_tool
	*/
	public function export_checklist($simple_tool, $mixed, $mode = 'print'){
		if(!isset($simple_tool) or !is_object($simple_tool)){
			return false;
		}
		
		$root = '';
		$rootend = '';
		$percentage1 = '';
		if($mixed == 'simple' && $mode == 'print'){
			$root = '<cl:ControlList xmlns:cl="http://avanza.uca.es/assessmentservice/controllist"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/controllist http://avanza.uca.es/assessmentservice/ControlList.xsd"
	';
			$rootend = '</cl:ControlList>
	';
		}
		elseif($mixed == 'composed' || $mode != 'print'){
			$root = '<ControlList ';
			$rootend = '</ControlList>';
			$percentage1 = ' percentage="' . $simple_tool->percentage . '"';
		}
		
		//ROOT-----------------------
		$xml = $root . ' id="'.$simple_tool->pla_cod .'" name="' . htmlspecialchars($simple_tool->title) . '" dimensions="' . $simple_tool->num_dimensions .'" ' . $percentage1 . '>
		';
		//DESCRIPTION----------------
		if(isset($simple_tool->description)){
			$xml .= '<Description>' . htmlspecialchars($simple_tool->description) . '</Description>
		';
		}
		if(isset($simple_tool->observation)){
			$xml .= '<Comment>' . htmlspecialchars($simple_tool->observation) . '</Comment>
		';
		}

		//DIMENSIONS------------------
		for($i = 0; $i < $simple_tool->num_dimensions; $i++)
		{
			$xml .=  '<Dimension id="'.encrypt_tool_element($simple_tool->dimen_code[$i]).'" name="' . htmlspecialchars($simple_tool->values_dim[$i][0]) . '" subdimensions="' . $simple_tool->num_subdimension[$i] . '" values="2" percentage="' .$simple_tool->percentages_dim[$i] . '">
			';
			//VALUES-----------------------
			$xml .=  "<Values>\n";
			for($j = 1; $j <= $simple_tool->num_values_dim[$i]; $j++)
			{
				$xml .= '<Value id="'.encrypt_tool_element($simple_tool->values_dimension_id[$i][$j]).'">'. htmlspecialchars($simple_tool->values_dim[$i][$j]) . "</Value>\n";
			}

			$xml .=  "</Values>\n";
			
			//SUBDIMENSIONS-----------------
			for($l = 0; $l < $simple_tool->num_subdimension[$i]; $l++)
			{
				$xml .=  '<Subdimension id="'.$simple_tool->subdimension_id[$i][$l].'" name="' . htmlspecialchars($simple_tool->name_subdimension[$i][$l]) . '" attributes="' . $simple_tool->num_atr_dim[$i][$l] . '" percentage="' .$simple_tool->percentage_subdimension[$i][$l] . '">
				';
				//ATTRIBUTES--------------------
				for($k = 0; $k < $simple_tool->num_atr_dim[$i][$l]; $k++)
				{ 
					$comment = '';
					if($simple_tool->attributes_com[$i][$l][$k] == '1' || $simple_tool->attributes_com[$i][$l][$k] == 't'){
						$comment = 1;
					
						if(isset($simple_tool->comment_attribute[$i][$l][$k]) && $simple_tool->comment_attribute[$i][$l][$k] != ''){
							$comment = htmlspecialchars($simple_tool->comment_attribute[$i][$l][$k]);
						}
					}
					$gradeattribute = (isset($simple_tool->grade_attribute[$i][$l][$k])) ? $simple_tool->grade_attribute[$i][$l][$k] : '';
					$xml .=  '<Attribute id="'.encrypt_tool_element($simple_tool->attributes_code[$i][$l][$k]).
					'" name="' . htmlspecialchars($simple_tool->attributes[$i][$l][$k]) . '"  comment="'. $comment .
					'" percentage="' . $simple_tool->attributes_percentage[$i][$l][$k] . '">'.
					htmlspecialchars($gradeattribute) .'</Attribute>
					';
				}

				$xml .=  "</Subdimension>\n";
			}
			$xml .=  "</Dimension>\n";
		}

		$xml .= $rootend;
		return $xml;
	}
	
	/**
	* @param object $simple_tool of a scale tool
	* @param string $mixed in order to indicate if $simple_tool is 'simple' (individual tool) or 'composed' (it is part of a mixed tool)
	* @retunr string XML Document of $simple_tool
	*/
	public function export_scale($simple_tool, $mixed, $mode = 'print'){
		if(!isset($simple_tool) or !is_object($simple_tool)){
			return false;
		}
		$root = '';
		$rootend = '';
		$percentage1 = '';
		if($mixed == 'simple' && $mode == 'print'){
			$root = '<es:EvaluationSet xmlns:es="http://avanza.uca.es/assessmentservice/evaluationset"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/evaluationset http://avanza.uca.es/assessmentservice/EvaluationSet.xsd"';
			$rootend = '</es:EvaluationSet>
			';
		}
		elseif($mixed == 'composed' || $mode != 'print'){
			$root = '<EvaluationSet ';
			$rootend = '</EvaluationSet>';
			$percentage1 = ' percentage="' . $simple_tool->percentage . '"';
		}
		
		//ROOT-----------------------
		$xml = $root . ' id="'.$simple_tool->pla_cod .'" name="' . htmlspecialchars($simple_tool->title) . '" dimensions="' . $simple_tool->num_dimensions .'" ' . $percentage1 . '>
	';
		
		//DESCRIPTION----------------
		if(isset($simple_tool->description)){
			$xml .= '<Description>' . htmlspecialchars($simple_tool->description) . '</Description>
		';
		}
		if(isset($simple_tool->observation)){
			$xml .= '<Comment>' . htmlspecialchars($simple_tool->observation) . '</Comment>
		';
		}

		//DIMENSIONS------------------
		for($i = 0; $i < $simple_tool->num_dimensions; $i++)
		{
			$xml .= '<Dimension id="'.encrypt_tool_element($simple_tool->dimen_code[$i]).'" name="' . htmlspecialchars($simple_tool->values_dim[$i][0], ENT_COMPAT, 'UTF-8') . '" subdimensions="' . $simple_tool->num_subdimension[$i] . '" values="' . $simple_tool->num_values_dim[$i] . '" percentage="' . $simple_tool->percentages_dim[$i] . '">
			';
			$xml .= '<Values>';
			//VALUES-----------------------
			for($j = 1; $j <= $simple_tool->num_values_dim[$i]; $j++)
			{
				$xml .= '<Value id="'.encrypt_tool_element($simple_tool->values_dimension_id[$i][$j]).'">'. htmlspecialchars($simple_tool->values_dim[$i][$j]) . "</Value>\n";
			}
			$xml .= "</Values>\n";
			
			//SUBDIMENSIONS-----------------
			for($l = 0; $l < $simple_tool->num_subdimension[$i]; $l++)
			{
				$xml .= '<Subdimension id="'.$simple_tool->subdimension_id[$i][$l].'" name="' . htmlspecialchars($simple_tool->name_subdimension[$i][$l]) . '" attributes="' . $simple_tool->num_atr_dim[$i][$l] . '" percentage="' . $simple_tool->percentage_subdimension[$i][$l] . '">
	';
				//ATTRIBUTES--------------------
				for($k = 0; $k < $simple_tool->num_atr_dim[$i][$l]; $k++)
				{
					$comment = '';
					if($simple_tool->attributes_com[$i][$l][$k] == '1' || $simple_tool->attributes_com[$i][$l][$k] == 't'){
						$comment = 1;
						
						if(isset($simple_tool->comment_attribute[$i][$l][$k]) && $simple_tool->comment_attribute[$i][$l][$k] != ''){
							$comment = htmlspecialchars($simple_tool->comment_attribute[$i][$l][$k]);
						}
					}
					$gradeattribute = (isset($simple_tool->grade_attribute[$i][$l][$k])) ? $simple_tool->grade_attribute[$i][$l][$k] : '';
					$xml .= '<Attribute id="'.encrypt_tool_element($simple_tool->attributes_code[$i][$l][$k]).
					'" name="' . htmlspecialchars($simple_tool->attributes[$i][$l][$k]) . 
					'" comment="'.$comment.'" percentage="' .$simple_tool->attributes_percentage[$i][$l][$k] . '">'.
					htmlspecialchars($gradeattribute) . '</Attribute>
	';
				}

				$xml .= "</Subdimension>\n";
			}
			//GLOBAL VALUE-------------------
			if($simple_tool->global_value[$i] == 't' || $simple_tool->global_value[$i] == '1')
			{
				$comment = '';
				if($simple_tool->dimen_com[$i] == '1' || $simple_tool->dimen_com[$i] == 't'){
					$comment = 1;
				
					if(isset($simple_tool->comment_dimension[$i]) && $simple_tool->comment_dimension[$i] != ''){
						$comment = htmlspecialchars($simple_tool->comment_dimension[$i]);
					}
				}
				
				$gvalue = '';
				if(isset($simple_tool->grade_dimension[$i])){
					$gvalue = htmlspecialchars($simple_tool->grade_dimension[$i]);
				}
				
				//$xml .= '<DimensionAssessment percentage="' . (100 - array_sum($simple_tool->percentage_subdimension[$i])). '">
				$xml .= '<DimensionAssessment percentage="' . ($simple_tool->global_value_por[$i]). '">
				<Attribute name="Global assessment" comment="'. $comment .'" percentage="0">' . $gvalue . '</Attribute>
			</DimensionAssessment>';
			}

			$xml .= "</Dimension>\n";
		}

		if($simple_tool->yesnovglobal == 't' || $simple_tool->yesnovglobal == '1')
		{	
			//$xml .= '<GlobalAssessment values="' . htmlspecialchars($simple_tool->num_total_value) . '" percentage="' .(100 - array_sum($simple_tool->percentages_dim)) . '">
			$xml .= '<GlobalAssessment values="' . htmlspecialchars($simple_tool->num_total_value) . '" percentage="' .($simple_tool->total_value_por) . '">
			<Values>
	';
			for($j = 0; $j < $simple_tool->num_total_value; $j++)
			{
				$xml .= '<Value id="'.encrypt_tool_element($simple_tool->cod_total_values[$j]).'">'. htmlspecialchars($simple_tool->name_total_values[$j]) . "</Value>\n";
			}
			$xml .= '</Values>

			<Attribute name="Global assessment" percentage="0">' . htmlspecialchars($simple_tool->grade_tool) . '</Attribute>
		</GlobalAssessment>
	';
		}
		$xml .= $rootend;
		return $xml;
		
	}
	
	/**
	* @param object $simple_tool of a listscale tool
	* @param string $mixed in order to indicate if $simple_tool is 'simple' (individual tool) or 'composed' (it is part of a mixed tool)
	* @retunr string XML Document of $simple_tool
	*/
	public function export_list_scale($simple_tool, $mixed, $mode = 'print'){
		if(!isset($simple_tool) or !is_object($simple_tool)){
			return false;
		}
		
		$root = '';
		$rootend = '';
		$percentage1 = '';
		if($mixed == 'simple' && $mode == 'print'){
			$root = '<ce:ControlListEvaluationSet xmlns:ce="http://avanza.uca.es/assessmentservice/controllistevaluationset"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/controllistevaluationset http://avanza.uca.es/assessmentservice/ControlListEvaluationSet.xsd"
			';
			$rootend = '</ce:ControlListEvaluationSet>
			';
		}
		elseif($mixed == 'composed' || $mode != 'print'){
			$root = '<ControlListEvaluationSet ';
			$rootend = '</ControlListEvaluationSet>';
			$percentage1 = ' percentage="' . $simple_tool->percentage . '"';
		}

		//ROOT-----------------------
		$xml = $root . ' id="'.$simple_tool->pla_cod .'" name="' . htmlspecialchars($simple_tool->title) . '" dimensions="' . $simple_tool->num_dimensions .'" ' . $percentage1 . '>
		';
		//DESCRIPTION----------------
		if(isset($simple_tool->description)){
			$xml .= '<Description>' . htmlspecialchars($simple_tool->description) . '</Description>
		';
		}
		if(isset($simple_tool->observation)){
			$xml .= '<Comment>' . htmlspecialchars($simple_tool->observation) . '</Comment>
		';
		}

		//DIMENSIONS------------------
		for($i = 0; $i < $simple_tool->num_dimensions; $i++)
	   {
			$xml .= '<Dimension id="'.encrypt_tool_element($simple_tool->dimen_code[$i]).'" name="' . htmlspecialchars($simple_tool->values_dim[$i][0]) . '" subdimensions="' . $simple_tool->num_subdimension[$i] . '" values="' . ($simple_tool->num_values_dim[$i] - 2) . '" percentage="' . $simple_tool->percentages_dim[$i] .'">
			';
			//CHECK LIST VALUES------------
			$xml .= "<ControlListValues>\n";
			for($j = 1; $j <= 2; $j++)
			{
				$xml .= '<Value id="'.encrypt_tool_element($simple_tool->values_dimension_id[$i][$j]).'">' . htmlspecialchars($simple_tool->values_dim[$i][$j]) . "</Value>\n";
			}
			$xml .= "</ControlListValues>\n";

			//VALUES-----------------------
			$xml .= "<Values>\n";
			for($j = 3; $j <= $simple_tool->num_values_dim[$i]; $j++)
			{
				$xml .= '<Value id="'.encrypt_tool_element($simple_tool->values_dimension_id[$i][$j]).'">'. htmlspecialchars($simple_tool->values_dim[$i][$j]) . "</Value>\n";
			}
			$xml .= "</Values>\n";
			
			//SUBDIMENSIONS-----------------
			for($l = 0; $l < $simple_tool->num_subdimension[$i]; $l++){
				$xml .= '<Subdimension id="'.$simple_tool->subdimension_id[$i][$l].'" name="' . htmlspecialchars($simple_tool->name_subdimension[$i][$l]) . '" attributes="' . $simple_tool->num_atr_dim[$i][$l] . '" percentage="' . $simple_tool->percentage_subdimension[$i][$l] . '">
				';
				//ATTRIBUTES--------------------
				for($k = 0; $k < $simple_tool->num_atr_dim[$i][$l]; $k++)
				{					
					$comment = '';
					if($simple_tool->attributes_com[$i][$l][$k] == '1' || $simple_tool->attributes_com[$i][$l][$k] == 't')
						$comment = 1;
					//print_r($simple_tool->comment_attribute[$i][$l]);
					//echo "i = $i, l = $l y k = $k <br>";
					if(isset($simple_tool->comment_attribute[$i][$l][$k]) && $simple_tool->comment_attribute[$i][$l][$k] != ''){
						$comment = htmlspecialchars($simple_tool->comment_attribute[$i][$l][$k]);
					}
					$gradeattribute = (isset($simple_tool->grade_attribute[$i][$l][$k])) ? $simple_tool->grade_attribute[$i][$l][$k] : '';
					$xml .= '<Attribute id="'.encrypt_tool_element($simple_tool->attributes_code[$i][$l][$k]).'" name="' . htmlspecialchars($simple_tool->attributes[$i][$l][$k]) . '"  comment="'.$comment.'" percentage="' . $simple_tool->attributes_percentage[$i][$l][$k] . '">
		<selectionControlList>1</selectionControlList>
		<selection>' . htmlspecialchars($gradeattribute) . '</selection>
	</Attribute>
	';
				}

				$xml .= "</Subdimension>\n";
			}
			//GLOBAL VALUE-------------------
			if($simple_tool->global_value[$i] == 't' || $simple_tool->global_value[$i] == '1')
			{	
				$comment = '';
				if($simple_tool->dimen_com[$i] == '1' || $simple_tool->dimen_com[$i] == 't'){
					$comment = 1;
				
					if(isset($simple_tool->comment_dimension[$i]) && $simple_tool->comment_dimension[$i] != ''){
						$comment = $simple_tool->comment_dimension[$i];
					}
				}
				
				$gvalue = '';
				if(isset($simple_tool->grade_dimension[$i])){
					$gvalue = htmlspecialchars($simple_tool->grade_dimension[$i]);
				}
				
					
				//$percentage = 100 - array_sum($simple_tool->percentage_subdimension[$i]);
				$percentage = $simple_tool->global_value_por[$i];
				$xml .= '<DimensionAssessment percentage="' . $percentage . '">
				<Attribute name="Global assessment" comment="'. htmlspecialchars($comment, ENT_QUOTES,'UTF-8') .'" percentage="100">' . $gvalue . '</Attribute>
			</DimensionAssessment>';
			}

			$xml .= "</Dimension>\n";
		}

		if($simple_tool->yesnovglobal == 't' || $simple_tool->yesnovglobal == '1')
		{	
			//$percentage = 100 - array_sum($simple_tool->percentages_dim);
			$percentage = $simple_tool->total_value_por;
			$xml .= '<GlobalAssessment values="' . $simple_tool->num_total_value . '" percentage="' . $percentage . '">
			<Values>
			';
			for($j = 0; $j < $simple_tool->num_total_value; $j++)
			{
				$xml .= '<Value id="'.encrypt_tool_element($simple_tool->cod_total_values[$j]).'">'. htmlspecialchars($simple_tool->name_total_values[$j]) . "</Value>\n";
			}
			$xml .= '</Values>

			<Attribute name="Global assessment" percentage="100">' . htmlspecialchars($simple_tool->grade_tool) . '</Attribute>
		</GlobalAssessment>
		';
		}
		$xml .= $rootend;
		return $xml;
	}
	
	/**
	* @param object $simple_tool of a rubric tool
	* @param string $mixed in order to indicate if $simple_tool is 'simple' (individual tool) or 'composed' (it is part of a mixed tool)
	* @retunr string XML Document of $simple_tool
	*/
	public function export_rubric($simple_tool, $mixed, $mode = 'print') {
		if(!isset($simple_tool) or !is_object($simple_tool)){
			return false;
		}
		
		$root = '';
		$rootend = '';
		$percentage1 = '';
		if($mixed == 'simple' && $mode == 'print'){
			$root = '<ru:Rubric xmlns:ru="http://avanza.uca.es/assessmentservice/rubric"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/rubric http://avanza.uca.es/assessmentservice/Rubric.xsd"
			';
			$rootend = '</ru:Rubric>
			';
		}
		elseif($mixed == 'composed' || $mode != 'print'){
			$root = '<Rubric ';
			$rootend = '</Rubric>';
			$percentage1 = ' percentage="' . $simple_tool->percentage . '"';
		}

		//ROOT-----------------------
		$xml = $root . ' id="'.$simple_tool->pla_cod .'" name="' . htmlspecialchars($simple_tool->title) . '" dimensions="' . $simple_tool->num_dimensions .'" ' . $percentage1 . '>
	';
		//DESCRIPTION----------------
		if(isset($simple_tool->description)){
			$xml .= '<Description>' . htmlspecialchars($simple_tool->description) . '</Description>
		';
		}
		if(isset($simple_tool->observation)){
			$xml .= '<Comment>' . htmlspecialchars($simple_tool->observation) . '</Comment>
		';
		}

		//DIMENSIONS------------------
		for($i = 0; $i < $simple_tool->num_dimensions; $i++)
		{
			$xml .=  '<Dimension id="'.encrypt_tool_element($simple_tool->dimen_code[$i]).'" name="' . htmlspecialchars($simple_tool->values_dim[$i][0]) . '" subdimensions="' . $simple_tool->num_subdimension[$i] . '" values="' . $simple_tool->num_values_dim[$i] . '" percentage="' . $simple_tool->percentages_dim[$i] . '">
	';
			$xml .=  "<Values>\n";
			//VALUES-----------------------
			for($j = 1; $j <= $simple_tool->num_values_dim[$i]; $j++){
				$xml .=  '<Value id="'.encrypt_tool_element($simple_tool->values_dimension_id[$i][$j]).'" name="' . htmlspecialchars($simple_tool->values_dim[$i][$j]) . "\" instances=\"" . $simple_tool->num_rango[$i][$j-1] . "\">\n";
				for($m = 0; $m < $simple_tool->num_rango[$i][$j-1]; $m++){
					$xml .=  '<instance id="'.encrypt_tool_element($simple_tool->rango_id[$i][$j-1][$m]).'">'. $simple_tool->rango[$i][$j-1][$m] . "</instance>\n";
				}
				$xml .=  "</Value>\n";
			}
			$xml .=  "</Values>\n";
			
			//SUBDIMENSIONS-----------------
			for($l = 0; $l < $simple_tool->num_subdimension[$i]; $l++)
		  {
				$xml .=  '<Subdimension id="'.$simple_tool->subdimension_id[$i][$l].'" name="' . htmlspecialchars($simple_tool->name_subdimension[$i][$l]) . '" attributes="' . $simple_tool->num_atr_dim[$i][$l] . '" percentage="' . $simple_tool->percentage_subdimension[$i][$l] . '">
	';
				//ATTRIBUTES--------------------
				for($k = 0; $k < $simple_tool->num_atr_dim[$i][$l]; $k++)
				{
					$comment = '';
					if($simple_tool->attributes_com[$i][$l][$k] == '1' || $simple_tool->attributes_com[$i][$l][$k] == 't'){
						$comment = 1;
						
						if(isset($simple_tool->comment_attribute[$i][$l][$k]) && $simple_tool->comment_attribute[$i][$l][$k] != ''){
							$comment = htmlspecialchars($simple_tool->comment_attribute[$i][$l][$k]);
						}
					}
					
					$xml .=  '<Attribute id="'.encrypt_tool_element($simple_tool->attributes_code[$i][$l][$k]).'" name="' . htmlspecialchars($simple_tool->attributes[$i][$l][$k]) . '" comment="'.$comment.'" percentage="' . $simple_tool->attributes_percentage[$i][$l][$k] . '">
					<descriptions>'."\n";
					//DESCRIPCIONES DE LAS RÃšBRICAS
					for($j = 0; $j < $simple_tool->num_values_dim[$i]; $j++){
						$description = '';
						if(isset($simple_tool->description_rubric[$i][$l][$k][$j])){
							$description = htmlspecialchars($simple_tool->description_rubric[$i][$l][$k][$j]);
						}
						$descriptionId = '';
						if(isset($simple_tool->description_rubric_id[$i][$l][$k][$j])){
							$descriptionId = encrypt_tool_element($simple_tool->description_rubric_id[$i][$l][$k][$j]);
						}
						$xml .=  '<description id="'.$descriptionId.'" value="' . $j . '">' . $description . "</description>\n";
					}	
					
					$grade_attribute_range = '';
					if(isset($simple_tool->grade_attribute_range[$i][$l][$k])){
						$grade_attribute_range = $simple_tool->grade_attribute_range[$i][$l][$k];
					}
					$gradeattribute = (isset($simple_tool->grade_attribute[$i][$l][$k])) ? $simple_tool->grade_attribute[$i][$l][$k] : '';
					$xml .=  '</descriptions>
					<selection>
						<val>' . htmlspecialchars($gradeattribute) . '</val>
						<instance>'. $grade_attribute_range .'</instance>
					</selection>
	</Attribute>
	';
				}

				$xml .=  "</Subdimension>\n";
			}
			//GLOBAL VALUE-------------------
			if($simple_tool->global_value[$i] == 't' || $simple_tool->global_value[$i] == '1')
			{
				$comment = '';
				if($simple_tool->dimen_com[$i] == '1' || $simple_tool->dimen_com[$i] == 't'){
					$comment = 1;
					
					if(isset($simple_tool->comment_dimension[$i]) && $simple_tool->comment_dimension[$i] != ''){
						$comment = $simple_tool->comment_dimension[$i];
					}
				}
				
				$gvalue = '';
				if(isset($simple_tool->grade_dimension[$i])){
					$gvalue = $simple_tool->grade_dimension[$i];
				}
				$rvalue = '';
				if(isset($simple_tool->grade_dimension_range[$i])){
					$rvalue = $simple_tool->grade_dimension_range[$i];
				}
				
				$xml .=  '<DimensionAssessment percentage="' . ($simple_tool->global_value_por[$i]) . '">
				<Attribute name="Global assessment" comment="'. htmlspecialchars($comment, ENT_QUOTES,'UTF-8') .'" percentage="0">
				<descriptions>'."\n";
					//DESCRIPCIONES DE LAS RÃšBRICAS
				for($j = 0; $j < $simple_tool->num_values_dim[$i]; $j++)
				{
					$xml .=  '<description value="' . $j . '"></description>'."\n";
				}
				
				
				$xml .=  '</descriptions>
					<selection>
						<val>'. htmlspecialchars($gvalue) .'</val>
						<instance>'. $rvalue.'</instance>
					</selection>'."\n";

				$xml .=  '</Attribute>
			</DimensionAssessment>';
			}

			$xml .=  "</Dimension>\n";
		}

		if($simple_tool->yesnovglobal == 't' || $simple_tool->yesnovglobal == '1')
		{	
			$xml .=  '<GlobalAssessment values="' . htmlspecialchars($simple_tool->num_total_value) . '" percentage="' . ($simple_tool->total_value_por) . '">
			<Values>
			';
			for($j = 0; $j < $simple_tool->num_total_value; $j++)
			{
				$xml .=  '<Value id="'.encrypt_tool_element($simple_tool->cod_total_values[$j]).'">'. htmlspecialchars($simple_tool->name_total_values[$j]) . "</Value>\n";
			}
			$xml .=  '</Values>
			
			<Attribute name="Global assessment" percentage="0">'.htmlspecialchars($simple_tool->grade_tool).'</Attribute>
		</GlobalAssessment>
	';
		}
		$xml .= $rootend;
		return $xml;
	}
	
	/**
	* @param object $simple_tool of a rubric tool
	* @param string $mixed in order to indicate if $simple_tool is 'simple' (individual tool) or 'composed' (it is part of a mixed tool)
	* @retunr string XML Document of $simple_tool
	*/
	public function export_differential($simple_tool, $mixed, $mode = 'print') {
		if(!isset($simple_tool) or !is_object($simple_tool)){
			return false;
		}
		$root = '';
		$rootend = '';
		$percentage1 = '';
		if($mixed == 'simple' && $mode == 'print'){
			$root = '<sd:SemanticDifferential xmlns:sd="http://avanza.uca.es/assessmentservice/semanticdifferential"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/semanticdifferential http://avanza.uca.es/assessmentservice/SemanticDifferential.xsd"
			';
			$rootend = '</sd:SemanticDifferential>
			';
		}
		elseif($mixed == 'composed' || $mode != 'print'){
			$root = '<SemanticDifferential ';
			$rootend = '</SemanticDifferential>';
			$percentage1 = ' percentage="' . $simple_tool->percentage . '"';
		}

		//ROOT-----------------------
		$xml = $root . ' id="'.$simple_tool->pla_cod .'" name="' . htmlspecialchars($simple_tool->title) . '" attributes="' . ($simple_tool->num_atr_dim[0][0] / 2) .'" values="' . $simple_tool->num_values_dim[0] . '" ' . $percentage1 . '>
		';
		//DESCRIPTION----------------
		if(isset($simple_tool->description)){
			$xml .= '<Description>' . htmlspecialchars($simple_tool->description) . '</Description>
		';
		}
		if(isset($simple_tool->observation)){
			$xml .= '<Comment>' . htmlspecialchars($simple_tool->observation) . '</Comment>
		';
		}

			//VALUES-----------------------
		$xml .= "<Values>\n";
		for($j = 1; $j <= $simple_tool->num_values_dim[0]; $j++)
		{
		   $xml .= '<Value id="'.encrypt_tool_element($simple_tool->values_dimension_id[0][$j]).'">'. $simple_tool->values_dim[0][$j] . "</Value>\n";
		}
		$xml .= "</Values>\n";
			
		//ATTRIBUTES--------------------
		$attNeg = array();
		$attPos = array();
		$idNeg = array();
		$idPos = array();
		$i = 0;
	    for($k = 0; $k < $simple_tool->num_atr_dim[0][0]; $k++)	{
			if($k % 2 == 0){
				$attNeg[$i] = $simple_tool->attributes[0][0][$k];
				$idNeg[$i] = encrypt_tool_element($simple_tool->attributes_code[0][0][$k]);
			}
			else{ 
				$attPos[$i] = $simple_tool->attributes[0][0][$k];
				$idPos[$i] = encrypt_tool_element($simple_tool->attributes_code[0][0][$k]);
				$i++;
			}
		}

		$num_atr = $simple_tool->num_atr_dim[0][0] / 2;
		$l = 0;
		for($k = 0; $k < $num_atr; $k++){
			$comment = '';
			if($simple_tool->attributes_com[0][0][$l] == '1' || $simple_tool->attributes_com[0][0][$l] == 't'){
				$comment = 1;
				
				if(isset($simple_tool->comment_attribute[0][0][$l]) && $simple_tool->comment_attribute[0][0][$l] != ''){
					$comment = htmlspecialchars($simple_tool->comment_attribute[0][0][$l]);
				}
			}
			$gradeattribute = (isset($simple_tool->grade_attribute[0][0][$l])) ? $simple_tool->grade_attribute[0][0][$l] : '';
			$xml .= '<Attribute idNeg="'.$idNeg[$k].'" idPos="'.$idPos[$k].'" nameN="' .
			htmlspecialchars($attNeg[$k]) . '" nameP="' . htmlspecialchars($attPos[$k]) . '"  comment="'.$comment.
			'" percentage="' .$simple_tool->attributes_percentage[0][0][$l] . '">' .
			$gradeattribute . '</Attribute>
			';
			$l += 2;
		}


		$xml .= $rootend;
		return $xml;
	}
	
	public function export_argumentset($simple_tool, $mixed, $mode = 'print'){
		if(!isset($simple_tool) or !is_object($simple_tool)){
			return false;
		}
		$percentage1 = '';
		$root = '';
		$rootend = '';
		if($mixed == 'simple' && $mode == 'print'){
			$root = '<ar:ArgumentSet xmlns:ar="http://avanza.uca.es/assessmentservice/argument"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/argument http://avanza.uca.es/assessmentservice/Argument.xsd"
	';
			$rootend = '</ar:ArgumentSet>
	';
		}
		elseif($mixed == 'composed' || $mode != 'print'){
			$root = '<ArgumentSet ';
			$rootend = '</ArgumentSet>';
			$percentage1 = ' percentage="' . $simple_tool->percentage . '"';
		}

		//ROOT-----------------------
		$xml = $root . ' id="'.$simple_tool->pla_cod .'" name="' . htmlspecialchars($simple_tool->title) . '" dimensions="' . $simple_tool->num_dimensions .'" ' . $percentage1 . '>
		';
		//DESCRIPTION----------------
		if(isset($simple_tool->description)){
			$xml .= '<Description>' . htmlspecialchars($simple_tool->description) . '</Description>
		';
		}
		if(isset($simple_tool->observation)){
			$xml .= '<Comment>' . htmlspecialchars($simple_tool->observation) . '</Comment>
		';
		}

		//DIMENSIONS------------------
		for($i = 0; $i < $simple_tool->num_dimensions; $i++)
		{
			$xml .=  '<Dimension id="'.encrypt_tool_element($simple_tool->dimen_code[$i]).'" name="' . htmlspecialchars($simple_tool->values_dim[$i][0]) . '" subdimensions="' . $simple_tool->num_subdimension[$i] . '" values="0" percentage="' .$simple_tool->percentages_dim[$i] . '">
			';
			//VALUES-----------------------
			
			//SUBDIMENSIONS-----------------
			for($l = 0; $l < $simple_tool->num_subdimension[$i]; $l++)
			{
				$xml .=  '<Subdimension id="'.$simple_tool->subdimension_id[$i][$l].'" name="' . htmlspecialchars($simple_tool->name_subdimension[$i][$l]) . '" attributes="' . $simple_tool->num_atr_dim[$i][$l] . '" percentage="' .$simple_tool->percentage_subdimension[$i][$l] . '">
				';
				//ATTRIBUTES--------------------
				for($k = 0; $k < $simple_tool->num_atr_dim[$i][$l]; $k++)
				{
					$comment = 1;
					if($simple_tool->attributes_com[$i][$l][$k] == '1' || $simple_tool->attributes_com[$i][$l][$k] == 't')
						$comment = 1;
						
					if(isset($simple_tool->comment_attribute[$i][$l][$k]) && $simple_tool->comment_attribute[$i][$l][$k] != ''){
						$comment = htmlspecialchars($simple_tool->comment_attribute[$i][$l][$k]);
					}
					$gradeattribute = (isset($simple_tool->grade_attribute[$i][$l][$k])) ? $simple_tool->grade_attribute[$i][$l][$k] : '';
					$xml .=  '<Attribute id="'.encrypt_tool_element($simple_tool->attributes_code[$i][$l][$k]).
					'" name="' . htmlspecialchars($simple_tool->attributes[$i][$l][$k]) .
					'"  comment="'.$comment.'" percentage="' .
					$simple_tool->attributes_percentage[$i][$l][$k] . '">' . $gradeattribute . '</Attribute>
					';
				}

				$xml .=  "</Subdimension>\n";
			}
			$xml .=  "</Dimension>\n";
		}

		$xml .= $rootend;
		return $xml;
	}
}