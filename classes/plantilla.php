<?php
include_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX plantilla class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class plantilla extends evalcomix_object {
	 public $table = 'plantilla';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'pla_cod', 'pla_tit', 'pla_tip');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('pla_des', 'pla_por', 'pla_glo', 'pla_gpr', 'pla_mod');
	
	/**
     * Array of valid types for tools
     * @var array $valid_types
     */
	public $valid_types = array('lista', 'escala', 'rubrica', 'lista+escala', 'diferencial', 'argumentario', 'mixto');
	
	
	/**
	* code tool
	* @var string $pla_cod
	*/
	public $pla_cod;
	
	/**
	* title tool
	* @var string $pla_tit
	*/
	public $pla_tit;
	
	/**
	* type tool
	* @var string $pla_tip
	*/
	public $pla_tip;
	
	/**
	* Description tool
	* @var string $pla_des
	*/
	public $pla_des;
	
	/**
	* indicates if tool has got global value ('1') or not ('0')
	* @var int $pla_glo
	*/
	public $pla_glo;
	
	/**
	* if tool is part of a mixed tool, indicates its porcentage into one
	* @var int $pla_por
	*/
	public $pla_por = 100;
	
	/**
	 * total porcentage
	 * @var int $pla_gpr
	 */
	public $pla_gpr;
	
	/***
	* If tool has been modified is true
	* @var int $pla_mod
	*/
	public $pla_mod = '0';
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			plantilla::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}

	
	private static function check_params($plantilla, $params) {
		if(!isset($params['id']) && !isset($params['pla_tit'])){
			throw new InvalidArgumentException('Missing Tool title');
		}
		if(!isset($params['id']) && (!isset($params['pla_tip']) || !in_array($params['pla_tip'], $plantilla->valid_types))){
			throw new InvalidArgumentException('Type Tool wrong');
		}
		if(isset($params['pla_glo']) && (!is_numeric($params['pla_glo']) || ($params['pla_glo'] != '0' && $params['pla_glo'] != '1'))){
			throw new InvalidArgumentException('Tool global value missing');
		}		
		
		if(isset($plantilla->pla_por) && (!is_numeric($plantilla->pla_por) || $plantilla->pla_por < 0 || $plantilla->pla_por > 100)){
			throw new RangeException('Tool percentage must be between 0 and 100');
		}
	}
	
	
	
	/**
     * Finds and returns a plantilla instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object plantilla instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('plantilla', 'plantilla', $params);
    }
	
	 /**
     * Finds and returns all plantilla instances.
     * @static abstract
     *
     * @return array array of plantilla instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('plantilla', 'plantilla', $params);
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
