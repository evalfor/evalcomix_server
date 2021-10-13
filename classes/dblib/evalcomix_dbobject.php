<?php

class evalcomix_dbobject{
	/**
	 * Note:
	 *  - Oracle has 30 chars limit for all names,
	 *    2 chars are reserved for prefix.
	 *
	 * @const maximum length of field names
	 */
	const NAME_MAX_LENGTH = 28;
	
	/**
	 * This function will check if one name is ok or no (true/false)
	 * only lowercase a-z, 0-9 and _ are allowed
	 * @return bool
	 */
	public function check_name($name){
		$result = true;
	
		if(empty($name) || strlen($name) > self::NAME_MAX_LENGTH || strlen($name) == 0){
			$result = false;
		}
		
		if ($name != preg_replace('/[^a-z0-9_-]/i', '', $name)) {
			$result = false;
		}
		
		return $result;
	}

}