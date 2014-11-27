<?php
	/*
	@param $array 
	@param $i índice del elemento a eliminar en $array
	@return $array sin el elemento
	Elimina de @array el elemento $i
	*/
	function arrayElimina($array, $i){
		$arrayAux = array();
		if(is_array($array)){
			foreach($array as $key => $value){
				if($key != $i)
					$arrayAux[$key] = $value;
			}
		}
		return $arrayAux;
	}
	
	/*
	@param $array - array o tabla hash
	@param $i índice del elemento a partir del que introducirá el elemento $elem en $array
	@param $elem nuevo elemento a añadir
	@param $index indice del nuevo elemento. Si no se especifica, el nuevo índice será $i+1
	@return $array con el nuevo elemento
	Añade $elem a @array a continuación de $i.
	*/
	function arrayAdd($array, $i, $elem, $index){
		$arrayAux = array();
		$flag = false;
		if(is_array($array)){
			foreach($array as $key => $value){
				$arrayAux[$key] = $value;
				if($key == $i)
					$flag = true;
				if($flag == true){
					$newkey = $key + 1;
					if(isset($index))
						$newkey = $index;
					$arrayAux[$newkey] = $elem;
					$flag = false;
				}
			}
		}
		return $arrayAux;
	}
	
	/*
	@param $variable variable a comprobar
	@param $default valor por defecto
	@return $variable comprobada
	Comprueba y limpia $variable. Si variable no es un entero devuelve el valor por defecto
	*/
	function getParamInt($variable, $default = 0){
		if(!intval($variable))
			return $default;
		
		return $variable;
	}
	
	/**
	@param $variable variable a comprobar
	@param $default valor por defecto
	@return $variable comprobada
	Comprueba y limpia $variable. Si variable no está establecida devuelve el valor por defecto
	*/
	function getParam($variable, $default = ''){
		/*if(!isset($variable))
			return $default;
		*/
		if(is_array($variable)){
			foreach($variable as $key => $value){
				$variable[$key] = str_replace('<<_mas_>>', '+', $value);
			}
			return $variable;
		}
		elseif(isset($variable))
			return htmlentities($variable, ENT_QUOTES, "UTF-8");
		else
			return $default;
	}
	
?>