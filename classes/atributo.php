<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX atributo class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class atributo extends evalcomix_object {
	 public $table = 'atributo';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'atr_sub');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('atr_des', 'atr_por', 'atr_com', 'atr_pos');
	
	
	/**
	* name atributo
	* @var string $atr_des
	*/
	public $atr_des;
	
	/**
	* Foreign key subdimension
	* @var string $atr_sub
	*/
	public $atr_sub;
	
	/**
	* atributo porcentage
	* @var string $atr_por
	*/
	public $atr_por;
	
	/**
	* atributo comment
	* @var int $atr_com
	*/
	public $atr_com;
	
	/**
	* atributo position
	* @var int $atr_pos
	*/
	public $atr_pos;

	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			atributo::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($atributo, $params) {
		if(!isset($params['id']) && !isset($params['atr_sub'])){
			throw new InvalidArgumentException('Missing subdimension id into atributo');
		}
	}
	
	
	/**
     * Finds and returns a atributo instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object atributo instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('atributo', 'atributo', $params);
    }
	
	 /**
     * Finds and returns all atributo instances.
     * @static abstract
     *
     * @return array array of atributo instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('atributo', 'atributo', $params, $sortfields);
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
