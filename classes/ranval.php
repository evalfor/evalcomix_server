<?php
include_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX ranval class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class ranval extends evalcomix_object {
	 public $table = 'ranval';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'rav_dim');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('rav_val', 'rav_ran', 'rav_pos');
	
	
	/**
	* ranval value
	* @var string $rav_val
	*/
	public $rav_val;
	
	/**
	* ranval comments
	* @var string $rav_pos
	*/
	public $rav_pos;
	
	/**
	* ranval range value
	* @var string $rav_ran
	*/
	public $rav_ran;
	
	/**
	* Foreign key dimension
	* @var string $rav_dim
	*/
	public $rav_dim;
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			ranval::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
		
	private static function check_params($ranval, $params) {
		if(!isset($params['id']) && !isset($params['rav_dim']) && !isset($params['rav_val'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a ranval instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object ranval instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('ranval', 'ranval', $params);
    }
	
	 /**
     * Finds and returns all ranval instances.
     * @static abstract
     *
     * @return array array of ranval instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('ranval', 'ranval', $params, $sortfields);
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
 }
