<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX dimension class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class dimension extends evalcomix_object {
	 public $table = 'dimen';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'dim_pla');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('dim_nom', 'dim_glo', 'dim_sub', 'dim_por', 'dim_com', 'dim_gpr', 'dim_pos');
	
	
	/**
	* name dimension
	* @var string $dim_nom
	*/
	public $dim_nom;
	
	/**
	* Foreign key plantilla
	* @var string $dim_pla
	*/
	public $dim_pla;
	
	/**
	* dimension comments
	* @var string $dim_com
	*/
	public $dim_com;
	
	/**
	* indicates if dimension has got global value ('1') or not ('0')
	* @var int $dim_glo
	*/
	public $dim_glo;
	
	/**
	* number of its subdimensions
	* @var int $dim_sub
	*/
	public $dim_sub;
	
	/**
	* dimension porcentage
	* @var int $dim_por
	*/
	public $dim_por;
	
	/**
	 * dimension global value porcentage
	 * @var int $dim_gpr
	 */
	public $dim_gpr;
	
	/**
	 * position into tool
	 * @var int $dim_pos
	 */
	public $dim_pos;
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			dimension::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($dimension, $params) {
		if(!isset($params['id']) && !isset($params['dim_pla'])){
			throw new InvalidArgumentException('Missing tool id into dimension');
		}
	}
	
	
	/**
     * Finds and returns a dimension instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object dimension instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('dimen', 'dimension', $params);
    }
	
	 /**
     * Finds and returns all dimension instances.
     * @static abstract
     *
     * @return array array of dimension instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('dimen', 'dimension', $params, $sortfields);
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
