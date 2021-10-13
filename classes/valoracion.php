<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX valoracion class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class valoracion extends evalcomix_object {
	 public $table = 'valoracion';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'val_cod');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array();
	
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($valoracion, $params) {
	}
	
	
	/**
     * Finds and returns a valoracion instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object valoracion instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('valoracion', 'valoracion', $params);
    }
	
	 /**
     * Finds and returns all valoracion instances.
     * @static abstract
     *
     * @return array array of valoracion instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('valoracion', 'valoracion', $params);
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
