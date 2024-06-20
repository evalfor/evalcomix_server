<?php
/**
* @author     Daniel Cabeza Sánchez <info@ansaner.net>
*/

include_once("evalcomix_object.php");

class users extends evalcomix_object {
	 public $table = "users";
	
	  /**
     * Array of required table fields, must start with "id".
     * @var array $required_fields
     */

    public $required_fields = array('id','usr_nam','usr_pss');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $optional_fields
     */
    public $optional_fields = array('usr_enb','usr_fnm','usr_lnm','usr_eml',
		'usr_phn', 'usr_com', 'usr_del', 'usr_lgn', 'usr_tct', 'usr_tmd');

	/**
	* usr_nam
	*/
	public $usr_nam;
  
	/**
	* usr_pss
	*/
	public $usr_pss;
  
	/**
	* usr_enb
	*/
	public $usr_enb;
  
	/**
	* usr_fnm
	*/
	public $usr_fnm;
  
	/**
	* usr_lnm
	*/
	public $usr_lnm;
  
	/**
	* usr_eml
	*/
	public $usr_eml;
  
	/**
	* usr_phn
	*/
	public $usr_phn;
  
	/**
	* usr_com
	*/
	public $usr_com;
  
	/**
	* usr_del
	*/
	public $usr_del;
	
	/**
	* usr_lgn
	*/
	public $usr_lgn;
  
	/**
	* usr_tct
	*/
	public $usr_tct;
	
	/**
	* usr_tmd
	*/
	public $usr_tmd;
	
	/**
	* Constructor	
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			//users::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}
	
	/*private static function check_params($users, $params) {
	}*/	
	
	/**
     * Finds and returns a instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('users', 'users', $params);
    }
	
	 /**
     * Finds and returns all instances.
     * @static abstract
     *
     * @return array array of instances or false if none found.
     */
	public static function fetch_all($params = array(), $sortfields = array()){
		return evalcomix_object::fetch_all_helper('users', 'users', $params, $sortfields);
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

    /*public static function search($search, $columns, $pagination = array(), $sortfields = array()){
      return evalcomix_object::search_helper('users', 'users', $search, $columns, $pagination, $sortfields);
    }*/
    
    /**
    * @params array -> ['capability'] string capability name
    * @return array of users object with the capability in the system
    */
    /*public static function getUsersWithCapability(array $params) {
		extract($params);
		$result = array();
		
		$sql = 'SELECT u.* 
				FROM users u, role r, role_capability rc
				WHERE u.roleid = r.id AND r.id = rc.roleid AND rc.capabilityid = "'.$capability.'" AND rc.permission = "1"
				ORDER BY u.usr_lnm DESC, u.usr_fnm DESC';
		//echo $sql;
				
		$rs = DB::query($sql);
		foreach($rs as $data) {
			$instance = new users();
            evalcomix_object::set_properties($instance, $data, 'noclean');
            $result[$instance->id] = $instance;
		}
		return $result;
    }*/
    
    public static function encrypt_password($password = '') {
		$result = '';
		if (is_string($password)) {
			$result = md5($password);
		}
		return $result;
	}
 }
