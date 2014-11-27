<?php
include_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX dimcomment class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class dimcomment extends evalcomix_object {
	 public $table = 'dimcomment';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'dic_eva', 'dic_dim');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('dic_obs');
	
	
	/**
	* dimcomment comments
	* @var string $dic_obs
	*/
	public $dic_obs;
	
	/**
	* Foreign key dimenson
	* @var string $dic_dim
	*/
	public $dic_dim;
	
	/**
	* Foreign key assessment
	* @var string $dic_eva
	*/
	public $dic_eva;
		
		
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			dimcomment::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($dimcomment, $params) {
		if(!isset($params['id']) && !isset($params['dic_dim']) && !isset($params['dic_eva'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a dimcomment instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object dimcomment instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('dimcomment', 'dimcomment', $params);
    }
	
	 /**
     * Finds and returns all dimcomment instances.
     * @static abstract
     *
     * @return array array of dimcomment instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('dimcomment', 'dimcomment', $params);
	}	
	
	/**
     * Called immediately after the object data has been inserted, updated, or
     * deleted in the database. Default does nothing, can be overridden to
     * hook in special behaviour.
     *
     * @param bool $deleted
     */
    function notify_changed($deleted) {
    }
	
	static function duplicate($params)
	{
		$ass1 = $params['ass_old'];
		$ass2 = $params['ass_new'];
		$dimension_code = $params['dimensions'];
		
		$dimcomment_old = dimcomment::fetch_all(array('dic_eva' => $ass1));
		
		foreach($dimcomment_old as $dic){
			$old_dimension_id = $dic->dic_dim;
			if(isset($dimension_code[$old_dimension_id])){
				$new_dimension_id = $dimension_code[$old_dimension_id];
			
				if(!$dimcomment = dimcomment::fetch(array('dic_eva' => $ass2, 'dic_dim' => $new_dimension_id))){
					$dimcomment = new dimcomment(array('dic_eva' => $ass2, 'dic_dim' => $new_dimension_id, 'dic_obs' => $dic->dic_obs));
					$dimcomment->insert();
				}
			}
		}
	}
 }
