<?php
include_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX atribdes class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class atribdes extends evalcomix_object {
	 public $table = 'atribdes';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'atd_val', 'atd_atr');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('atd_des');
	
	
	/**
	* atribdes comments
	* @var string $atd_des
	*/
	public $atd_des;
	
	/**
	* Foreign key atributo
	* @var string $atd_atr
	*/
	public $atd_atr;
	
	/**
	* Foreign key valoracion
	* @var string $atd_val
	*/
	public $atd_val;
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			atribdes::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
		
	private static function check_params($atribdes, $params) {
		if(!isset($params['id']) && !isset($params['atd_atr']) && !isset($params['atd_val'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a atribdes instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object atribdes instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('atribdes', 'atribdes', $params);
    }
	
	 /**
     * Finds and returns all atribdes instances.
     * @static abstract
     *
     * @return array array of atribdes instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('atribdes', 'atribdes', $params);
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
