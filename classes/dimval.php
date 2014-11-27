<?php
include_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX dimval class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class dimval extends evalcomix_object {
	 public $table = 'dimval';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'div_dim');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('div_val', 'div_ran', 'div_pos');
	
	
	/**
	* dimval value
	* @var string $div_val
	*/
	public $div_val;
	
	/**
	* dimval comments
	* @var string $div_pos
	*/
	public $div_pos;
	
	/**
	* dimval range value
	* @var string $div_ran
	*/
	public $div_ran;
	
	/**
	* Foreign key dimension
	* @var string $div_dim
	*/
	public $div_dim;
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			dimval::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
		
	private static function check_params($dimval, $params) {
		if(!isset($params['id']) && !isset($params['div_dim']) && !isset($params['div_val'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a dimval instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object dimval instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('dimval', 'dimval', $params);
    }
	
	 /**
     * Finds and returns all dimval instances.
     * @static abstract
     *
     * @return array array of dimval instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('dimval', 'dimval', $params, $sortfields);
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
