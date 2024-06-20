<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX plaeva class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class plaeva extends evalcomix_object {
	 public $table = 'plaeva';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'ple_eva', 'ple_pla');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('ple_val', 'ple_obs');
	
	
	/**
	* plaeva value
	* @var string $ple_val
	*/
	public $ple_val;
	
	/**
	* plaeva comments
	* @var string $ple_obs
	*/
	public $ple_obs = '';
	
	/**
	* Foreign key plantilla
	* @var string $ple_pla
	*/
	public $ple_dim;
	
	/**
	* Foreign key assessment
	* @var string $ple_eva
	*/
	public $ple_eva;
	

	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			plaeva::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($plaeva, $params) {
		if(!isset($params['id']) && !isset($params['ple_pla']) && !isset($params['ple_eva'])){
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
			
		if(empty($this->ple_obs)){
			$this->ple_obs = '';
		}
		
		$data = $this->get_record_data();
		DB::update_record($this->table, $data);

		return true;
	}
	
	/**
     * Finds and returns a plaeva instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object plaeva instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('plaeva', 'plaeva', $params);
    }
	
	 /**
     * Finds and returns all plaeva instances.
     * @static abstract
     *
     * @return array array of plaeva instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('plaeva', 'plaeva', $params);
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
		$tool_code = $params['hashtools'];
		
		//if($plaeva_old = plaeva::fetch(array('ple_eva' => $ass1))){
		if($plaeva_old = plaeva::fetch_all(array('ple_eva' => $ass1))){
			foreach($plaeva_old as $value){
				//$old_tool_id = $plaeva_old->ple_pla;
				$old_tool_id = $value->ple_pla;
			
				if (!isset($tool_code[$old_tool_id]) || $tool_code[$old_tool_id] == null){
					$old_tool_id = $old_tool_id;
				}
				else{
					$new_tool_id = $tool_code[$old_tool_id];//de antes
				
					if(!$plaeva = plaeva::fetch(array('ple_eva' => $ass2, 'ple_pla' => $new_tool_id))){
						$plaeva = new plaeva(array('ple_eva' => $ass2, 'ple_pla' => $new_tool_id, 'ple_val' => $value->ple_val, 'ple_obs' => $value->ple_obs));
						$plaeva->insert();
					}
				}
			}
		}
	}
 }
