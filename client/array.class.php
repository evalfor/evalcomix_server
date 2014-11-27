<?php
	class array_util{
		
		function __construct(){
			
		}
		
		/*
		@param $array - array o tabla hash
		@param $keyelement Ã­ndice del elemento a partir del que introducirÃ¡ el elemento $elem en $array
		@param $element nuevo elemento a aÃ±adir
		@param $index indice del nuevo elemento.
		@return $array con el nuevo elemento
		AÃ±ade $elem a @array antes de $keyelement.
		*/
		public static function arrayAddLeft($array, $keyelement, $element, $index){
			$arrayAux = array();
			$keyleft = null;
			$flag = false;
			$i = 0;
			if(is_array($array)){
				
				foreach($array as $key => $value){
					//Si keyelement es el primer elemento
					if($i == 0 && $key == $keyelement){
						$result[$index] = $element;
						return $result + $array;
					}
					
					elseif($key == $keyelement){
						break;
					}
					$keyleft = $key;
					++$i;
				}
				
				foreach($array as $key => $value){
					$arrayAux[$key] = $value;
					if($key == $keyleft)
						$flag = true;
					if($flag == true){
						$arrayAux[$index] = $element;
						$flag = false;
					}
				}
			}
			return $arrayAux;
		}
		
		public static function arrayAddRight($array, $keyelement, $element, $index){
			$arrayAux = array();
			$flag = false;
			if(is_array($array)){
				foreach($array as $key => $value){
					$arrayAux[$key] = $value;
					if($key == $keyelement)
						$flag = true;
					if($flag == true){
						$newkey = $key + 1;
						if(isset($index))
							$newkey = $index;
						$arrayAux[$newkey] = $element;
						$flag = false;
					}
				}
			}
			return $arrayAux;
		}
		
		public static function getPrevElement($array, $element){
			$i = 0;
			$arrayaux[$i] = 'null';
			if(is_array($array)){
				foreach($array as $key => $value){
					++$i;
					$arrayaux[$i] = $key;
					if($key == $element){
						$result = $arrayaux[$i-1];
						if($result === 'null'){
							return false;
						}
						else{
							return $result;
						}
					}
				}
			}
			return false;
		}
		
		public static function getNextElement($array, $element){
			$i = 0;
			$arrayaux[$i] = 'null';
			if(is_array($array)){
				foreach($array as $key => $value){
					$previousKey = $arrayaux[$i];
					++$i;
					$arrayaux[$i] = $key;
					if($previousKey == $element){
						return $key;						
					}
				}
			}
			return false;
		}
	}
?>