<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX dimeva class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class dimeva extends evalcomix_object {
	 public $table = 'dimeva';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'die_eva', 'die_dim');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('die_val', 'die_ran', 'die_obs');
	
	
	/**
	* dimeva value
	* @var string $die_val
	*/
	public $die_val;
	
	/**
	* dimeva comments
	* @var string $die_obs
	*/
	public $die_obs;
	
	/**
	* dimeva range value
	* @var string $die_ran
	*/
	public $die_ran;
	
	/**
	* Foreign key dimension
	* @var string $die_dim
	*/
	public $die_dim;
	
	/**
	* Foreign key assessment
	* @var string $die_eva
	*/
	public $die_eva;
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			dimeva::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
		
	private static function check_params($dimeva, $params) {
		if(!isset($params['id']) && !isset($params['die_dim']) && !isset($params['die_eva'])){
			throw new InvalidArgumentException('Missing parameters');
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
		
		if(empty($this->die_ran)){
			$this->die_ran = 'NULL';
		}
		
		if(empty($this->die_obs)){
			$this->die_obs = '';
		}
		
		$data = $this->get_record_data();
		DB::update_record($this->table, $data);

		return true;
	}
	
	/**
     * Finds and returns a dimeva instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object dimeva instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('dimeva', 'dimeva', $params);
    }
	
	 /**
     * Finds and returns all dimeva instances.
     * @static abstract
     *
     * @return array array of dimeva instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('dimeva', 'dimeva', $params);
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
		$dimension_code = $params['dimensions'];
		
		$dimeva_old = dimeva::fetch_all(array('die_eva' => $ass1));
		foreach($dimeva_old as $die){
			$die_ran = $die->die_ran;
			if(!$die->die_ran){
				$die_ran = 'NULL';
			}
				
			$old_dimension_id = $die->die_dim;
			if(isset($dimension_code[$old_dimension_id])){
				$new_dimension_id = $dimension_code[$old_dimension_id];
				if(!$dimeva = dimeva::fetch(array('die_eva' => $ass2, 'die_dim' => $new_dimension_id))){
					$die_ran = 'NULL';
					if(isset($die->die_ran)){
						$die_ran = $die->die_ran;
					}
					$params_dimeva = array('die_eva' => $ass2, 'die_dim' => $new_dimension_id, 'die_val' => $die->die_val, 'die_ran' => $die_ran);
					$dimeva = new dimeva($params_dimeva);
					$dimeva->insert();
				}				
			}
		}
	}
 }
