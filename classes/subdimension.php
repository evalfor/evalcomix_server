<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX subdimension class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class subdimension extends evalcomix_object {
	 public $table = 'subdimension';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'sub_dim');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('sub_nom', 'sub_por', 'sub_pos');
	
	
	/**
	* name subdimension
	* @var string $sub_nom
	*/
	public $sub_nom;
	
	/**
	* Foreign key dimension
	* @var string $sub_dim
	*/
	public $sub_dim;
	
	/**
	* subdimension porcentage
	* @var string $sub_por
	*/
	public $sub_por;
	
	/**
	* subdimension position
	* @var int $sub_pos
	*/
	public $sub_pos;

	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			subdimension::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($subdimension, $params) {
		if(!isset($params['id']) && !isset($params['sub_dim'])){
			throw new InvalidArgumentException('Missing dimension id into subdimension');
		}
	}
	
	
	/**
     * Finds and returns a subdimension instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object subdimension instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('subdimension', 'subdimension', $params);
    }
	
	 /**
     * Finds and returns all subdimension instances.
     * @static abstract
     *
     * @return array array of subdimension instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('subdimension', 'subdimension', $params, $sortfields);
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
