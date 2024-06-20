<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX atreva class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class atreva extends evalcomix_object {
	 public $table = 'atreva';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'ate_eva', 'ate_atr');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('ate_val', 'ate_ran');
	
	
	/**
	* atreva value
	* @var string $ate_val
	*/
	public $ate_val;
	
	/**
	* atreva range value
	* @var string $ate_ran
	*/
	public $ate_ran = 'NULL';
	
	/**
	* Foreign key atributo
	* @var string $ate_atr
	*/
	public $ate_atr;
	
	/**
	* Foreign key assessment
	* @var string $ate_eva
	*/
	public $ate_eva;
		
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			//atreva::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	/*private static function check_params($atreva, $params) {
	}*/
	
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
     * Finds and returns a atreva instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object atreva instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('atreva', 'atreva', $params);
    }
	
	 /**
     * Finds and returns all atreva instances.
     * @static abstract
     *
     * @return array array of atreva instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('atreva', 'atreva', $params);
	}	
	
	/**
     * Called immediately after the object data has been inserted, updated, or
     * deleted in the database. Default does nothing, can be overridden to
     * hook in special behaviour.
     *
     * @param bool $deleted
     */
    /*function notify_changed($deleted) {
    }*/
	
	static function duplicate($params)
	{
		$ass1 = $params['ass_old'];
		$ass2 = $params['ass_new'];
		$attributes_code = $params['attributes'];
		
		if($atreva_old = atreva::fetch_all(array('ate_eva' => $ass1))){
			foreach($atreva_old as $ate){
				$ate_ran = $ate->ate_ran;
				if(!$ate->ate_ran){
					$ate_ran = 'NULL';
				}
				
				$old_attribute_id = $ate->ate_atr;
				if(isset($attributes_code[$old_attribute_id])){
					$new_attribute_id = $attributes_code[$old_attribute_id];
				
					$params_atreva['ate_eva'] = $ass2;
					$params_atreva['ate_atr'] = $new_attribute_id;
					$params_atreva['ate_val'] = $ate->ate_val;
					$params_atreva['ate_ran'] = $ate_ran;
					if(!$atreva = atreva::fetch(array('ate_eva' => $ass2, 'ate_atr' => $new_attribute_id))){
						$atreva = new atreva($params_atreva);
						$atreva->insert();
					}
				}
			}
		}
	}
 }
