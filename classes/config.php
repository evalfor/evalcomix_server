<?php
include_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX config class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class config extends evalcomix_object {
	 public $table = 'config';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'name', 'value');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array();
	
	
	/**
	* name
	* @var string $name
	*/
	public $name;
	
	/**
	* value
	* @var string $value
	*/
	public $value;
		
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	/**
     * Updates this object in the Database, based on its object variables. ID must be set.
     * @return boolean success
     */
	public function update(){

		if (empty($this->id)) {
			return false;
		}
		
		if(empty($this->ate_ran)){
			$this->ate_ran = 'NULL';
		}
		
		$data = $this->get_record_data();
		DB::update_record($this->table, $data);

		return true;
	}
	
	/**
     * Finds and returns a config instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object config instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('config', 'config', $params);
    }
	
	 /**
     * Finds and returns all config instances.
     * @static abstract
     *
     * @return array array of config instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('config', 'config', $params);
	}	
	

 }
