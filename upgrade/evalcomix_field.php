<?php
include_once('evalcomix_constant.php');
include_once('evalcomix_dbobject.php');

/** This class represents one EvalCOMIX Field */

class evalcomix_field extends evalcomix_dbobject{
	/** @var string name of field */
	private $name;
	
	/** @var int EVALCOMIX_TYPE_ constants */
	private $type;
	
    /** @var int size of field */
    protected $length;

    /** @var bool is null forbidden? EVALCOMIX_NOTNULL */
    protected $notnull;

    /** @var mixed default value */
    protected $default;

    /** @var bool use automatic counter */
    protected $sequence;

    /** @var int number of decimals */
    protected $decimals;
	
	/** @var string $unique */
	protected $unique;
	
	/** @var string $pk */
	protected $pk;

    /** @var array defines valid types */
  	private $valid_types = array(EVALCOMIX_TYPE_INTEGER, EVALCOMIX_TYPE_NUMERIC, EVALCOMIX_TYPE_FLOAT, EVALCOMIX_TYPE_CHAR, EVALCOMIX_TYPE_TEXT, EVALCOMIX_TYPE_BINARY, EVALCOMIX_TYPE_DATETIME, EVALCOMIX_TYPE_TIMESTAMP, EVALCOMIX_TYPE_BOOL, EVALCOMIX_TYPE_BIGINT);
    /**
     * Note:
     *  - Oracle: VARCHAR2 has a limit of 4000 bytes
     *  - SQL Server: NVARCHAR has a limit of 40000 chars
     *  - MySQL: VARCHAR 65,535 chars
     *  - PostgreSQL: no limit
     *
     * @const maximum length of text field
     */
    const CHAR_MAX_LENGTH = 1333;


    /**
     * @const maximum number of digits of integers
     */
    const INTEGER_MAX_LENGTH = 20;

    /**
     * @const max length of decimals
     */
    const NUMBER_MAX_LENGTH = 20;

    /**
     * @const max length of floats
     */
    const FLOAT_MAX_LENGTH = 20;

    /**
     * Note:
     *  - Oracle has 30 chars limit for all names
     *
     * @const maximumn length of field names
     */
    const NAME_MAX_LENGTH = 30;

	
	public function get_name(){return $this->name;}
	public function get_type(){return $this->type;}
	public function get_length(){return $this->length;}
	public function get_notnull(){return $this->notnull;}
	public function get_sequence(){return $this->sequence;}
	public function get_unsigned(){return $this->unsigned;}
	public function get_default(){return $this->default;}
	public function get_unique(){return $this->unique;}
	public function get_decimals(){return $this->decimals;}
	public function get_pk(){return $this->pk;}
	
	public function set_name($name){
		$this->name = $name;
		if(empty($this->name) || !$this->check_name($this->name)){
        	throw new Exception('Field name "'. $this->type .'" is not valid');
		}
	}
	
	public function set_type($type){
		$this->type = $type;
		if(!isset($this->type) || !in_array($this->type, $this->valid_types)){
        	throw new Exception('Field type "'. $this->type .'" is not valid');
        }
	}
	
	public function set_length($length){$this->length = $length;}
	
	public function set_notnull($notnull){$this->notnull = $notnull;}
	
	public function set_sequence($sequence){$this->sequence = $sequence;}
	
	public function set_unsigned($unsigned){return false;}
	
	public function set_default($default){
		// Check, warn and auto-fix '' (empty) defaults for CHAR NOT NULL columns, changing them
        // to NULL so EVALCOMIX will apply the proper default
        if ($this->type == EVALCOMIX_TYPE_CHAR && $this->notnull && $default === '') {
            $this->errormsg = 'EVALCOMIX has detected one CHAR NOT NULL column (' . $this->name . ") with '' (empty string) as DEFAULT value. This type of columns must have one meaningful DEFAULT declared or none (NULL). EVALCOMIX have fixed it automatically changing it to none (NULL). The process will continue ok and proper defaults will be created accordingly with each DB requirements. Please fix it in source (XML and/or upgrade script) to avoid this message to be displayed.";
            //$this->debug($this->errormsg);
            $default = null;
        }
        // Check, warn and autofix TEXT|BINARY columns having a default clause (only null is allowed)
        if (($this->type == EVALCOMIX_TYPE_TEXT || $this->type == EVALCOMIX_TYPE_BINARY) && $default !== null) {
            $this->errormsg = 'EVALCOMIX has detected one TEXT/BINARY column (' . $this->name . ") with some DEFAULT defined. This type of columns cannot have any default value. Please fix it in source (XML and/or upgrade script) to avoid this message to be displayed.";
            $default = null;
        }
		$this->default = $default;
	}
	
	public function set_unique($unique){$this->unique = $unique;}
	
	public function set_pk($pk){$this->pk = $pk;}
	
	/**
     * Creates one new EVALCOMIX_field
     * @param string $name of field
     * @param int $type EVALCOMIX_TYPE_INTEGER, EVALCOMIX_TYPE_NUMBER, EVALCOMIX_TYPE_CHAR, EVALCOMIX_TYPE_TEXT, EVALCOMIX_TYPE_BINARY
     * @param string $precision length for integers and chars, two-comma separated numbers for numbers
     * @param bool $unsigned EVALCOMIX_UNSIGNED or null (or false)
     * @param bool $notnull EVALCOMIX_NOTNULL or null (or false)
     * @param bool $sequence EVALCOMIX_SEQUENCE or null (or false)
     * @param mixed $default meaningful default o null (or false)
     */
	public function __construct($params = array()){
		$this->type = null;
        $this->length = null;
        $this->notnull = false;
        $this->default = null;
        $this->sequence = false;
        $this->decimals = null;
		$this->unique = null;
		$this->pk = null;
		$this->set_attributes($params);
	}

    /**
     * Set all the attributes of one EVALCOMIX_field
     *
     * @param int $type EVALCOMIX_TYPE_INTEGER, EVALCOMIX_TYPE_NUMBER, EVALCOMIX_TYPE_CHAR, EVALCOMIX_TYPE_TEXT, EVALCOMIX_TYPE_BINARY
     * @param string $precision length for integers and chars, two-comma separated numbers for numbers
     * @param bool $unsigned EVALCOMIX_UNSIGNED or null (or false)
     * @param bool $notnull EVALCOMIX_NOTNULL or null (or false)
     * @param bool $sequence EVALCOMIX_SEQUENCE or null (or false)
     * @param mixed $default meaningful default o null (or false)
     */
    public function set_attributes($params) {
		if(isset($params['name'])){
			$this->name = $params['name'];
		}
		
		if(empty($this->name) || !$this->check_name($this->name)){
        	throw new Exception('Field name "'. $this->type .'" is not valid');
		}
		
        $this->type = $params['type'];
        if(!isset($this->type) || !in_array($this->type, $this->valid_types)){
        	throw new Exception('Field type "'. $this->type .'" is not valid');
        }
		
    /// Try to split the precision into length and decimals and apply
    /// each one as needed
		$precision = null;
		if(isset($params['precision'])){
			$precisionarr = explode(',', $params['precision']);
			if (isset($precisionarr[0])) {
				$this->length = trim($precisionarr[0]);
			}
			/*else{
				$this->length = $precision;			
			}*/
			if (isset($precisionarr[1])) {
				$this->decimals = trim($precisionarr[1]);
			}
        }
		$notnull = null;
		if(isset($params['notnull'])){
			$this->notnull = $params['notnull'];
		}
		$sequence = null;
		if(isset($params['sequence'])){
			$this->sequence = $params['sequence'];
		}
		$default = null;
		if(isset($params['default'])){
			$this->set_default($params['default']);
		}

        if ($this->type == EVALCOMIX_TYPE_BINARY || $this->type == EVALCOMIX_TYPE_TEXT) {
            $this->length = null;
            $this->decimals = null;
        }
		
		if(isset($params['pk']) && $params['pk'] == EVALCOMIX_KEY_PRIMARY){
			$this->pk = $params['pk'];
		}
		elseif(isset($params['unique']) && $params['unique'] == 'true'){
			$this->unique = $params['unique'];
		}
		
    }

}

?>