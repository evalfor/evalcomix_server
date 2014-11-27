<?php
include_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX atrcomment class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class atrcomment extends evalcomix_object {
	 public $table = 'atrcomment';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'atc_eva', 'atc_atr');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('atc_obs');
	
	
	/**
	* atrcomment comments
	* @var string $atc_obs
	*/
	public $atc_obs;
	
	/**
	* Foreign key atributo
	* @var string $atc_atr
	*/
	public $atc_atr;
	
	/**
	* Foreign key assessment
	* @var string $atc_eva
	*/
	public $atc_eva;
		
		/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			atrcomment::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($atrcomment, $params) {
		if(!isset($params['id']) && !isset($params['atc_atr']) && !isset($params['atc_eva'])){
			throw new InvalidArgumentException('Missing parameters');
		}
	}
	
	
	/**
     * Finds and returns a atrcomment instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object atrcomment instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('atrcomment', 'atrcomment', $params);
    }
	
	 /**
     * Finds and returns all atrcomment instances.
     * @static abstract
     *
     * @return array array of atrcomment instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('atrcomment', 'atrcomment', $params);
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
	
	static function duplicate($params)
	{
		$ass1 = $params['ass_old'];
		$ass2 = $params['ass_new'];
		$attributes_code = $params['attributes'];
		
		$atrcomment_old = atrcomment::fetch_all(array('atc_eva' => $ass1));
		foreach($atrcomment_old as $atc){
			$old_attribute_id = $atc->atc_atr;
			if(isset($attributes_code[$old_attribute_id])){
				$new_attribute_id = $attributes_code[$old_attribute_id];
				if(!$atrcomment = atrcomment::fetch(array('atc_eva' => $ass2, 'atc_atr' => $new_attribute_id))){
					$atrcomment = new atrcomment(array('atc_eva' => $ass2, 'atc_atr' => $new_attribute_id, 'atc_obs' => $atc->atc_obs));
					$atrcomment->insert();
				}
			}
		}
	}
 }
