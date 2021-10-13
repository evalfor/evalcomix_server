<?php
/**
* @author     Daniel Cabeza Sánchez <info@ansaner.net>
*/

include_once("evalcomix_object.php");

class lms extends evalcomix_object {
	 public $table = "lms";
	
	  /**
     * Array of required table fields, must start with "id".
     * @var array $required_fields
     */

    public $required_fields = array('id','lms_nam','lms_url');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $optional_fields
     */
    public $optional_fields = array('lms_des','lms_tkn','lms_enb');

	/**
	* lms_nam
	*/
	public $lms_nam;
  
	/**
	* lms_url
	*/
	public $lms_url;
  
	/**
	* lms_des
	*/
	public $lms_des;
	
	/**
	* lms_tkn
	*/
	public $lms_tkn;
	
	/**
	* lms_enb
	*/
	public $lms_enb;
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			lms::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	private static function check_params($lms, $params) {
		
	}
	
	
	/**
     * Finds and returns a instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('lms', 'lms', $params);
    }
	
	 /**
     * Finds and returns all instances.
     * @static abstract
     *
     * @return array array of instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('lms', 'lms', $params, $sortfields);
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

    public static function search($search, $columns, $pagination = array(), $sortfields = array()){
      return evalcomix_object::search_helper('lms', 'lms', $search, $columns, $pagination, $sortfields);
    }
 }
