<?php
require_once('db.php');
class grade{
	private $grades; //array

	function __construct($grades = '')
	{
		$this->grades = $grades;
	}

/*MAX_GRADE()-------------------------------------------------
It receives "$tool" (any assessment tool)
If "$tool" is not a mixed assessment tool and has got a numeric scale for all dimensions, it'll
return the maximum value of the scale. In other case, it returns 10.
------------------------------------------------------------*/
	function max_grade($tool)
	{
		require_once('plantilla.php');
		require_once('dimension.php');
		$plantilla = plantilla::fetch(array('id' => $tool));
		$type = $plantilla->pla_tip;
		$sql = '';
		if($type == 'mixto'){
			return 10;
		}
		else{	
			if(!$this->same_scale_for_dimensions($tool)){
				return 10;
			}
			
			//Check if scale is numeric. For this, to check the first dimension scale
			//is enought
			$dimensions = dimension::fetch_all(array('dim_pla' => $tool));
			
			$scale = $this->get_scale($dimensions[0]->id);
			if(!$this->scale_is_numeric($scale)){
				return 10;
			}
			
			$count = sizeof($scale); 
			if($scale[$count - 1] > $scale[0])
			{
				return $scale[$count - 1];
			}
			else
			{
				return $scale[0];
			}
		}//elseif($infoTool[1] == 'pla'])	
	}

/*GET_SCALE()--------------------------------------------------
It receives $tool (a simple assessment tool like a Checklist, scale, list+scale or rubric. It's numeric)
  and $dimension (a dimension of $tool).
  It recovers grades.
  Return an array with grade scale of the dimension of the tool
--------------------------------------------------------------*/
	function get_scale($dimension)
	{
		$this->grades = array();
		$sql = "SELECT *
					FROM plaeva, dimen, plaval
					WHERE dim_cod = $dimension AND dim_pla = ple_pla AND plv_pla = dim_pla";

		$rst = db::query($sql);	
		if(db::row_count($rst) != 0){
			$i = 0;
			while($row = db::next_row($rst))
			{
				$this->grades[$i] = $row['plv_val'];
				$i++;
			}
		}
		else{
			$sql = "SELECT rav_ran
   	           FROM dimval, ranval
					  WHERE div_dim = $dimension AND rav_dim = div_dim AND div_val = rav_val
					  ORDER BY rav_pos"; 
			$rst = db::query($sql);	
			if(db::row_count($rst) != 0)
			{
				$i = 0;
				while($row = db::next_row($rst))
				{
					$this->grades[$i] = $row['rav_ran'];
					$i++;
				}
			}
			else
			{
				$sql = "SELECT div_val
	              FROM dimval
					  WHERE div_dim = $dimension
					  ORDER BY div_pos";
				$rst = db::query($sql);
				$i = 0;
				while($row = db::next_row($rst))
				{
					$this->grades[$i] = $row['div_val'];
					$i++;
				}
			}
		}
		return $this->grades;
	}



/*SCALE_TO_NUMERIC_VALUES--------------------------------------
  It receives $marks (an array with grades assigned during assessment process with an assessent tool
  and $grades (an array with grades of the previous assessment tool).
  If scale isn't numeric, each one is converted in a value between 1 and 10 and associated with grades of $marks array.
  Return an array with the numeric values of the array.
--------------------------------------------------------------*/
	function scale_to_numeric_values($marks, $grades)
	{

		//we create the numeric scale
		$num_grade = sizeof($grades);
		
		$max = $num_grade - 1;
		$min = 0;

		if(is_numeric($grades[0]) && is_numeric($grades[$num_grade - 1]) && $grades[0] > $grades[$num_grade - 1])
		{
			$max = 0;
			$min = $num_grade - 1;
		}
		elseif($grades[0] < $grades[$num_grade - 1])
		{
			$max = $num_grade - 1;
			$min = 0;
		}

		$distance = 10 / ($num_grade);

		$numeric_grade = array();

		$numeric_grade[$grades[$max]] = 10;

		$accumulator = $distance;

		if($max > $min)
		{
			for($i = $min; $i < $max; $i++)
			{
				$numeric_grade[$grades[$i]] = $accumulator;
				$accumulator += $distance;
			}
		}
		else
		{
			for($i = $min; $i > $max; $i--)
			{
				$numeric_grade[$grades[$i]] = $accumulator; //echo "i = $i; numeric_grade[$grades[$i]]=".	$numeric_grade[$grades[$i]] .'<br>';
				$accumulator += $distance;
			}
		}
		//we associate numeric marks to values of $marks array
		$num_mark = sizeof($marks);
		$numeric_marks = array();
		for($i = 0; $i < $num_mark; $i++)
		{
			$value = '';
			if($marks[$i] == '0'){//if type == lista+escala value can be 0 althout scale hasn't this value
				$value = 0;
			}
			else{
				$value = $numeric_grade[$marks[$i]];
			}

			$numeric_marks[$i] = $value;
		}

		return $numeric_marks;
	}


	function scale_to_original_values($marks, $grades)
	{
		//we create the numeric scale
		$min = '';
		$max = '';

		$num_grade = sizeof($grades);
		
		if(is_numeric($grades[0]) && is_numeric($grades[$num_grade - 1]) && $grades[0] > $grades[$num_grade - 1])
		{
			$max = 0;
			$min = $num_grade - 1;
		}
		elseif($grades[0] < $grades[$num_grade - 1])
		{
			$max = $num_grade - 1;
			$min = 0;
		}

		$distance = 10 / ($num_grade);

		$numeric_grade = array();

		$numeric_grade[$grades[$max]] = 10;

		$accumulator = $distance;

		if($max > $min)
		{
			for($i = $min; $i < $max; $i++)
			{
				$numeric_grade[$grades[$i]] = $accumulator; //echo "i = $i; numeric_grade[$grades[$i]]=".	$numeric_grade[$grades[$i]] .'<br>';
				$accumulator += $distance;
			}
		}
		else
		{
			for($i = $min; $i > $max; $i--)
			{
				$numeric_grade[$grades[$i]] = $accumulator; //echo "i = $i; numeric_grade[$grades[$i]]=".	$numeric_grade[$grades[$i]] .'<br>';
				$accumulator += $distance;
			}
		}
		//we associate numeric marks to values of $marks array
		$num_mark = sizeof($marks);
		$numeric_marks = array();
		for($i = 0; $i < $num_mark; $i++)
		{
			$value = '';
			if($marks[$i] == '0'){//if type == lista+escala value can be 0 althout scale hasn't this value
				$value = 0;
			}
			else{
				$value = $numeric_grade[$marks[$i]];
			}

			$numeric_marks[$i] = $value;
		}

	}

/*GET_AVERAGE-------------------------------------------------
  It receives an array with numeric grades.
  It returns the average.
------------------------------------------------------------*/
	function get_average($marks)
	{
		$count = sizeof($marks);
		if($this->scale_is_numeric($marks) && $count)
		{
			$sum = 0; //It'll save the sum of elements of $marks
			$calificated = 0; //Boolean. If at least an element of the $marks is distinct to -1, It'll save 1. -1 means $marks hasn't got any calification.
			for($i = 0; $i < $count; $i++)
			{
				if($marks[$i] != -1){
					$calificated = 1;
					$sum += $marks[$i];
				}
			}
			if($calificated){
				return $sum / $count;
			}
		}
		
		return -1;
	}


/*SCALE_IS_NUMERIC--------------------------------------------
  It checks if grades are numeric.
  If they are, it returns 1. In other case, it returns 0.
------------------------------------------------------------*/
	function scale_is_numeric($scale)
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
	}

	/*
	it receives "$dimension", numeric code of a tool dimension, and "$assessment" (numeric code of an assessment).
	It returns count of assessed attributes of "$dimension"
	*/
	function count_attributes($dimension, $assessment)
	{
		$sql = "SELECT count(atr_cod) AS \"count\"
				  FROM atributo, atreva, subdimension, dimval
				  WHERE atr_cod = ate_atr AND ate_eva = $assessment AND atr_sub = sub_cod AND sub_dim = $dimension AND div_dim = $dimension AND div_val = ate_val";

		$rst = db::query($sql);
		if($row = db::next_row($rst))
		{
			return $row['count'];
		}
		
		return 0;
	}

	/*
	It receves "$dimension" (numeric code of a tool dimension) and "$assessment" (numeric code of an assessment)
	It returns count of attributes of the dimension assessed positively
	*/
	function get_checklist_mark($dimension, $assessment)
	{
		$sql = "SELECT count(atr_cod) AS \"count\"
				  FROM atributo, atreva, subdimension, dimval
				  WHERE atr_cod = ate_atr AND ate_eva = $assessment AND atr_sub = sub_cod AND sub_dim = $dimension AND div_dim = $dimension AND div_pos = 1 AND div_val = ate_val";
		$rst = db::query($sql);
		
		if($row = db::next_row($rst))
		{
			return $row['count'];
		}

		return 0;
	}	


/*GET_GLOBAL_MARK------------------------------------------------------
  It receives 
  ------"$tool" (Numeric code of a simple assessment tool (checklist, scale, list+scale or rubric)
  ------"dimension" (Numeric code of a dimension of "$tool")
  ------"$assessment" (Numeric code of the assessment)
  ------"$mix" (boolean. 1 means the tool es mixed therefore all scales have to be converted)
  It returns the global mark of the dimension
----------------------------------------------------------------------*/
	function get_global_mark($tool, $dimension, $assessment, $mix)
	{
		//$marks will content all valorations of dimension
		$marks = array();

		//we check if global mark exists. In that case, we return it.
		$sql = "SELECT die_val, die_ran
				  FROM dimeva
				  WHERE die_dim = $dimension AND die_eva = $assessment";
		$rst = db::query($sql);
		if($row = db::next_row($rst))
		{
			if($row['die_ran']){
				$marks[0] = $row['die_ran'];
			}
			else{
				$marks[0] = $row['die_val'];
			}
		}
		else
		{
		//In other case, we calculate it
			$sql = "SELECT ate_val AS \"value\", ate_ran AS \"rubric_rank_value\"
					  FROM atreva, atributo, subdimension
					  WHERE ate_eva = $assessment AND ate_atr = atr_cod AND atr_sub = sub_cod AND sub_dim = $dimension";
			$rst1 = db::query($sql);		
	
			$i = 0;
			//for each valoration of each attribute of $dimension
			while($row = db::next_row($rst1))
			{
				$value = '';
				if($row['rubric_rank_value']){ //only for rubrics
					$value = $row['rubric_rank_value']; 
				}
				else{ //for rest of assessment tools or rubrics without numeric rank
					$value = $row['value'];
				}
				$marks[$i] = $value;
				$i++;
			}	
		}

		$scale = $this->get_scale($dimension);//print_r($scale);
		if(!$this->scale_is_numeric($scale) || $mix == 1 || !$this->same_scale_for_dimensions($tool)){
			$numericMarks = $this->scale_to_numeric_values($marks, $scale);
		}
		else{
			$numericMarks = $marks;
		}
		
		$global_mark = $this->get_average($numericMarks);

		return $global_mark; 
	}


/*GET_FINAL_MARK------------------------------------------------------------
   It receives "tool" --> Numeric code of a simple assessment tool (checklist, scale, list+scale or rubric).
	It returns the final mark of "$tool"
--------------------------------------------------------------------------*/
	function get_final_mark($tool, $assessment, $mix)
	{
		//we check if final mark exists. In that case, we return it.
		$sql = "SELECT ple_val AS \"finalmark\"
				  FROM plaeva
				  WHERE ple_pla = $tool AND ple_eva = $assessment"; 
		$rst = db::query($sql);
		if($row = db::next_row($rst))
		{
			$sql2 = "SELECT plv_val AS \"finalgrade\"
				     FROM plaval
				     WHERE plv_pla = $tool
					  ORDER BY plv_pos"; 
			$rst2 = db::query($sql2);
			$final_scale = array();

			$i=0;
			while($row2 = db::next_row($rst2))
			{
				$final_scale[$i] = $row2['finalgrade'];
				$i++;
			}

			$mark = $row['finalmark'];
			if(!$this->scale_is_numeric($final_scale)){
				$marks[0] = $mark;
				$numericMarks = $this->scale_to_numeric_values($marks, $final_scale);
			}
			else{
				$numericMarks[0] = $mark;
			}

			return $this->get_average($numericMarks);
		}

		//if final mark doesn't exist, we calculate it
		$sql = "SELECT dim_cod AS \"dimension\", pla_tip AS \"type\"
				  FROM plantilla, dimen
				  WHERE pla_cod = $tool AND dim_pla = pla_cod";
		$rst = db::query($sql);
	
		$global_marks = array();
		$dimensions = array();
		$count = array(); //if tool type is checklist, it will keep count of attributes by dimensions
		$i = 0;
		$type = '';
		while($row = db::next_row($rst))
		{  
			if($row['type'] == 'lista')
			{
				$type = 'lista';
				$count[$i] = $this->count_attributes($row['dimension'], $assessment);
				$global_marks[$i] = $this->get_checklist_mark($row['dimension'], $assessment);
			}
			else
			{
				$dimensions[$i] = $row['dimension'];
				$global_marks[$i] = $this->get_global_mark($tool, $row['dimension'], $assessment, $mix);
			}
			$i++;
		}

		if($type == 'lista'){
			$num_attributes = array_sum($count); 
			$num_yes_attributes = array_sum($global_marks);
			if($num_attributes && $num_yes_attributes)
			{
				//$final_mark = $num_yes_attributes . '/' . $num_attributes;
				$final_mark = ($num_yes_attributes * 10) / $num_attributes;
			}
			else
			{
				$final_mark = -1;
			}
		}
		else{	
			$final_mark = $this->get_average($global_marks);
		}

		return $final_mark;
	}


/*GET_FINAL_ASSESSMENT------------------------------------------------------
  It receives "$tool" --> assessment tool (mixed, checklist, scale, list+scale or rubric. It's alphanumeric: 1_pla, 5_mix...)
  It returns the final mark of the assessment tool
--------------------------------------------------------------------------*/
	function get_final_assessment($tool, $assessment)
	{
		$final_assessment = -1; //variable to return

		//check type (mixed or simple tool)
		$infoTool = explode('_', $tool);
		$sql = '';
		$countTool = 0; //number of simple tools
		$simpleTool = array(); //array with code of simple tools
		if($infoTool[1] == 'mix')
		{
			$sql = "SELECT mip_pla
					  FROM mixtopla
					  WHERE mip_mix = " . $infoTool[0];
			$rst = db::query($sql);

			$i = 0;
			while($row = db::next_row($rst))
			{
				$countTool++;
				$simpleTool[$i] = $row['mip_pla'];
				$i++;
			}
		}
		elseif($infoTool[1] == 'pla')
		{
			$countTool++;
			$simpleTool[0] = $infoTool[0];
		}

		//get final mark for each simple tool
		$final_marks = array();
		for($i = 0; $i < $countTool; $i++)
		{  
			$mix = 0;
			if($countTool > 1){
				$mix = 1;
			}

			$final_marks[$i] = $this->get_final_mark($simpleTool[$i], $assessment, $mix);//echo "<br>partial:".$final_marks[$i];
			$final_marks[$i] = round($final_marks[$i], 1);
		}
	
		$final_assessment = $this->get_average($final_marks);
		if($final_assessment == -1){
			return '';
		}
		return $final_assessment;
	}


	/*
	It receives "$tool" (numeric code of an assessment tool).
	It returns 1 if all its dimensions has got the same scale, 0 in other case
	*/
	function same_scale_for_dimensions($tool)
	{
		$sql = "SELECT div_val, div_pos
				  FROM dimen, plantilla, dimval
				  WHERE pla_cod = $tool AND dim_pla = pla_cod AND div_dim = dim_cod
				  ORDER BY dim_cod, div_pos";
		$rst = db::query($sql);
		$dimension;
		$i = 0;
		$j = -1;
		while($row = db::next_row($rst))
		{
			if($row['div_pos'] == '0')
			{
				$j++;
			}
			$dimension[$j][$i] = $row['div_val'];
			$i++;
		}
		
		for($k = 0; $k < $j-1; $k++)
		{
			$tam_array1 = sizeof($dimension[$k]);
			$tam_array2 = sizeof($dimension[$k+1]);
			if($tam_array1 != $tam_array2)
				return 0;

			for($i = 0; $i < $tam_array1; $i++)
			{
				if($dimension[$k][$i] != $dimension[$k+1][$i])
				{
					return 0;	
				}
			}
		}
		
		return 1;	
	}
}