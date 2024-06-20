<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX mixtopla class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class mixtopla extends evalcomix_object {
	 public $table = 'mixtopla';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'mip_mix', 'mip_pla');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('mip_pos');
	
	
	/**
	* Foreign Key plantilla
	* @var string $mip_mix
	*/
	public $mip_mix;
	
	/**
	* Foreign Key plantilla
	* @var string $mip_pla
	*/
	public $mip_pla;
	
	/**
	* position
	* @var string $mip_pos
	*/
	public $mip_pos;
	
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			mixtopla::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
		
	private static function check_params($mixtopla, $params) {
		if(!isset($params['id']) && !isset($params['mip_mix']) && !isset($params['mip_pla'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a mixtopla instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object mixtopla instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('mixtopla', 'mixtopla', $params);
    }
	
	 /**
     * Finds and returns all mixtopla instances.
     * @static abstract
     *
     * @return array array of mixtopla instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('mixtopla', 'mixtopla', $params, $sortfields);
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
 }
