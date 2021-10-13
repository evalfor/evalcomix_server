<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX plaval class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class plaval extends evalcomix_object {
	 public $table = 'plaval';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'plv_pla');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('plv_val', 'plv_pos');
	
	
	/**
	* plaval value
	* @var string $plv_val
	*/
	public $plv_val;
	
	/**
	* plaval comments
	* @var string $plv_pos
	*/
	public $plv_pos;
	
	/**
	* Foreign key plantilla
	* @var string $plv_pla
	*/
	public $plv_pla;
	
		
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			plaval::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($plaval, $params) {
		if(!isset($params['id']) && !isset($params['plv_pla']) && !isset($params['plv_val'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a plaval instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object plaval instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('plaval', 'plaval', $params);
    }
	
	 /**
     * Finds and returns all plaval instances.
     * @static abstract
     *
     * @return array array of plaval instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('plaval', 'plaval', $params);
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
