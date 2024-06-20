<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX atrdiferencial class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class atrdiferencial extends evalcomix_object {
	 public $table = 'atrdiferencial';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'atf_atn', 'atf_atp');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array();
	
	
	/**
	* Foreign key atributo
	* @var string $atf_atp
	*/
	public $atf_atp;
	
	/**
	* Foreign key atributo
	* @var string $atf_atp
	*/
	public $atf_atn;

	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			atrdiferencial::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($atrdiferencial, $params) {
		if(!isset($params['id']) && !isset($params['atf_atn']) && !isset($params['atf_atp'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a atrdiferencial instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object atrdiferencial instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('atrdiferencial', 'atrdiferencial', $params);
    }
	
	 /**
     * Finds and returns all atrdiferencial instances.
     * @static abstract
     *
     * @return array array of atrdiferencial instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('atrdiferencial', 'atrdiferencial', $params);
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
