<?php
	//include_once('class.inputfilter.php');
	
	function cleaner($texto){
		//$texto=strip_tags($texto);
		//$texto = htmlentities($texto, ENT_QUOTES);	echo "aaquiiiiiiiiiiiiii" . $texto . "adioooooooooooos";
		//preg_replace('/<(.*)s+ (w+=.*?)>', ' ', $texto);
		$texto = str_replace('&lt;?php', '', $texto);
		$texto = str_replace('<?php', '', $texto);
		$texto = str_replace('&lt;?PHP', '', $texto);
		$texto = str_replace('<?PHP', '', $texto);
		$texto = str_replace('&lt;?', '', $texto);
		$texto = str_replace('<?', '', $texto);
		$texto = str_replace('?&gt;', '', $texto);
		$texto = str_replace('?>', '', $texto);
		$texto = str_replace('%3C%3F', '', $texto);
		$texto = str_replace('%3C%3F%70%68%70', '', $texto);
		$texto = str_replace('%3F%3E', '', $texto);
		
		
		return $texto;
	}
	

	function get_type($xml){
		$tagName = dom_import_simplexml($xml)->tagName;
		$type_tool = ''; 
		if($tagName[2] == ':'){
			$type_evx3 = explode(':', $tagName);
			$type_tool = $type_evx3[1];
		}
		else{
			$type_tool = $tagName;
		}
		return $type_tool;
	}
	
	function cleanxml($xml){
		$type_tool = get_type($xml);
		if($type_tool == 'MixTool')
		{ 
			//$ifilter = new InputFilter();
			$xml['name'] = cleaner((string)$xml['name']);
			foreach($xml as $valor)
			{ 
				$valor = fun_cleanxml($valor);
			}
			return $xml;
		}
		elseif($type_tool == 'SemanticDifferential'){
			//$ifilter = new InputFilter();
			$xml['name'] = cleaner((string)$xml['name']);
			foreach($xml->Attribute as $attribute)
			{
				$attribute['nameN'] = cleaner((string)$attribute['nameN']);
				$attribute['nameP'] = cleaner((string)$attribute['nameP']);
			}//foreach($subdimension->Attribute as $attribute)
			return $xml;
		}
		else
		{
			return fun_cleanxml($xml);
		}
	}
	
	function fun_cleanxml($xml)
	{
		$type_tool = get_type($xml);
	
		$type = '';
		switch($type_tool){
			case 'ControlList':
				$type = 'lista';
				break;
			case 'EvaluationSet':
				$type = 'escala';
				break;
			case 'Rubric':
				$type = 'rubrica';
				break;
			case 'ControlListEvaluationSet':
				$type = 'lista+escala';
				break;
		}	
		
		//$ifilter = new InputFilter();
		
		$xml['name'] = cleaner((string)$xml['name']);
		//echo $xml['name']; 
	
		foreach ($xml->Dimension as $dimension)
		{
			$dimension['name'] = cleaner((string)$dimension['name']);
			if(isset($dimension->Values[0])){
				foreach($dimension->Values[0] as $values){ 
					if($type != 'rubrica'){ 
						$values[0] = cleaner((string)$values);
					}
					else{
						$values['name'] = cleaner((string)$values['name']);
					}				
				}
			}
	
			if($type == 'lista+escala')
			{
				foreach($dimension->ControlListValues[0] as $values)
				{
					$values[0] = cleaner((string)$values);
				}
			}
	
			//DATOS DE LA SUBDIMENSION
			foreach($dimension->Subdimension as $subdimension)
			{
				$subdimension['name'] = cleaner((string)$subdimension['name']);
			
				foreach($subdimension->Attribute as $attribute)
				{
					$attribute['name'] = cleaner((string)$attribute['name']);					
					
					if($type == 'rubrica')
					{
						foreach($attribute->descriptions[0] as $description)
						{
							$description['value'] = cleaner((string)$description['value']);
							$description[0] = cleaner((string)$description);
						}
					}//if($type == 'rubrica')
				}//foreach($subdimension->Attribute as $attribute)
			}//foreach($dimension->Subdimension as $subdimension)     
			if(isset($dimension->DimensionAssessment[0]->Attribute) && $dimension->DimensionAssessment[0]->Attribute){
				$dimension->DimensionAssessment[0]->Attribute['name'] = cleaner((string)$dimension->DimensionAssessment[0]->Attribute['name']);
				if(isset($dimension->DimensionAssessment[0]->Attribute->descriptions[0])){
					foreach($dimension->DimensionAssessment[0]->Attribute->descriptions[0] as $description)
					{
						$description['value'] = cleaner((string)$description['value']);
						$description[0] = cleaner((string)$description);
					}
				}
			}
		}//foreach ($xml->Dimension as $dimension)
  		if(isset($xml->GlobalAssessment[0]->Values[0]->Value) && $xml->GlobalAssessment[0]->Values[0]->Value){ 
			foreach ($xml->GlobalAssessment[0]->Values[0] as $value)
			{
				$value[0] = cleaner((string)$value);
			}	
		}
		return $xml;
	}