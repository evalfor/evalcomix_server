<?php
require_once('../configuration/conf.php');
require_once('evalcomix_field.php');
require_once('evalcomix_key.php');
require_once('../classes/db.php');
require_once('evalcomix_constant.php');
require_once('lib.php');
require_once(DIRROOT . '/classes/pdo_database.php');


class evalcomix_table{
	 /** @var string name of table */
	private $name;
	
	/** @var array $fields of evalcomix_field objects */
	private $fields;
	
	/** @var array $keys of evalcomix_keys objects */
	private $keys;
	
	/** @var array $indexes of evalcomix_indexes objects */
	private $indexes;
	
	/** @var bool $changed It indicates if there is any change in table */
	private $changed;
	
	/** @var bool $exist table */
	private $exist;
	
	/**
	 * Note:
	 *  - Oracle has 30 chars limit for all names,
	 *    2 chars are reserved for prefix.
	 *
	 * @const maximum length of field names
	 */
	const NAME_MAX_LENGTH = 28;
	
	/**
	*@param string $name of the table
	*/
	public function __construct($params = array()){
		$name = $params['name'];
		if (strlen($name) > self::NAME_MAX_LENGTH) {
			return 'Invalid table name {'.$name.'}: name is too long. Limit is 28 chars.';
		}
		if (!preg_match('/^[a-z][a-z0-9_]*$/', $name)) {
			return 'Invalid table name {'.$name.'}: name includes invalid characters.';
		}
		
		$this->name = $name;
		$this->fields = array();
		$this->keys = array();
		$this->indexes = array();
		$this->change = false;
		$this->exist = false;
		
		if($this->table_exists($params)){
			$this->exist = true;
			$this->get_fields_db();
			$this->get_keys_db();
		}
	}
	
	/**
	* This function will add one new field to the table with all
	* its attributes defined
	*
	* @param string $name name of the field
	* @param int $type EVALCOMIX_TYPE_INTEGER, EVALCOMIX_TYPE_NUMBER, EVALCOMIX_TYPE_CHAR, EVALCOMIX_TYPE_TEXT, EVALCOMIX_TYPE_BINARY
	* @param string $precision length for integers and chars, two-comma separated numbers for numbers
	* @param bool $unsigned EVALCOMIX_UNSIGNED or null (or false)
	* @param bool $notnull EVALCOMIX_NOTNULL or null (or false)
	* @param bool $sequence EVALCOMIX_SEQUENCE or null (or false)
	* @param mixed $default meaningful default or null (or false)
	* @return evalcomix_field
	*/
	public function add_field($params = array()) {
		$fieldname = $params['name'];
		if(!$this->check_name($fieldname)){
			throw new Exception('Field name "'.$fieldname.'" is not valid');
		}
		
		$field = new evalcomix_field($params);
		if(in_array($field, $this->fields)){
			throw new Exception('Field "'.$field->get_name().'" just exists in table');
		}
		$this->fields[] = $field;		
	
		$this->changed = true;
		
		return $field;
	}
	
	public function add_key($params) {
		$kfields = $params['fields'];
		
		$name_fields = array();
		foreach($this->fields as $field){
			$name_fields[] = $field->get_name();
		}
		
		foreach($kfields as $kfield){
			if(!in_array($kfield, $name_fields)){
				throw new Exception('New key field "'.$kfield.'" does not exist in table ' . $this->name);
			}
		}		
		$key = new evalcomix_key($params);
		if(in_array($key, $this->keys)){
			throw new Exception('Key just exists in table');
		}
		$this->keys[] = $key;
		$this->changed = true;
		
		return $key;
	}
	
	public function table_exists($params = array()) {
		$tablename = $this->name;
		if(!empty($params['tablename'])){
			$tablename = $params['tablename'];
		}
		
		return DB::table_exists(array('tablename' => $tablename));
	}
	
	public function process_table($params = array()) {
		//TODO: comprobar conexión con BD
		//TODO: comprobar que si sequence es 'true', type sea 'integer'
		$result = null;
		
		$exist = $this->exist;
		
		if($exist && $this->changed){
			//Creating temporal table with new structure (if it exists, drop it and create it again)
			$params = array('tablename' => $this->name . '_tmp');
			if($this->table_exists($params)){
				$this->delete_table($params);
			}
			$result = $this->create_table($params);
		}
		elseif(!$exist){
			$this->create_table();
		}
		
		return $result;
	}
	
	/**
	 * This function will check if one name is ok or no (true/false)
	 * only lowercase a-z, 0-9 and _ are allowed
	 * @return bool
	 */
	public function check_name($name){
		$result = true;
	
		if ($name != preg_replace('/[^a-z0-9_ -]/i', '', $name)) {
			$result = false;
		}
		return $result;
	}
	
	/**
	 * This function generate sql code for a new field into a table
	 * @params object $field evalcomix_field object
	 */
	private function get_sqlfield($field){
		$fieldname = $field->get_name();

		$type = $field->get_type();
			
		$notnullsql = '';
		$notnullbool = $field->get_notnull();
		if(!empty($notnullbool) && $notnullbool){
			$notnullsql = 'NOT NULL';
		}
		
		$defaultsql = '';
		$defaultvalue = $field->get_default();
		if(!empty($defaultvalue)){
			$default = 'DEFAULT ' . $field->get_default();
		}
			
		$sequencebool = $field->get_sequence();
		$sequence = '';
		if($type === EVALCOMIX_TYPE_INTEGER && $sequencebool){
			if(defined('TYPEDB')){
				if(TYPEDB == 'mysql'){
					$sequence = ' AUTO_INCREMENT';
				}
				elseif(TYPEDB == 'postgresql'){
					$type = 'SERIAL';
				}
			}
			$notnullsql = '';
			$defaultsql = '';
		}
			
		$length = $field->get_length();
		$precision = '';
		if(!empty($length)){
			$precision = '('. $length . ')';
		}
			
		$type_precision = $type . $precision;
		
		$result = $field->get_name() . ' ' . $type_precision . $sequence . ' ' . $notnullsql . ' ' . $defaultsql;
		return $result; 
	}
	
	/**
	 * This function generates sql code for a new (primary or foreing) key
	 * @param object $key evalcomix_key
	 */
	private function get_sqlkey($key){
		$kfields = $key->get_fields();
		$result = '';
		if(!empty($kfields)){
			$type_key = $key->get_type();
			if($type_key == 'pk'){
				$sql_pk = 'PRIMARY KEY(';
		
				foreach($kfields as $kfield){
					$sql_pk.= $kfield . ',';
				}
				$sql_pk = substr($sql_pk, 0, -1);
				$sql_pk.= ')';
		
				$result.= $sql_pk;
			}
			elseif($type_key == 'fk'){
				$keyname = $key->get_name();
				if(!empty($keyname)){
					$sql_fk = 'CONSTRAINT ' . $keyname;
				}
				$sql_fk.= ' FOREIGN KEY(';
					
				$reftable = $key->get_reftable();
				$reffield = $key->get_reffield();
				if(!empty($reftable) && !empty($reffield)){
					if(count($kfields) == 1){
						foreach($kfields as $kfield){
							$sql_fk.= $kfield;
						}
					}
					else{
						throw new Exception('FK cannot have more than one field');
					}
		
					$sql_fk.= ') REFERENCES ' . $reftable . '(' . $reffield . ') ON DELETE CASCADE';
					$result.= $sql_fk;
				}
				else{
					throw new Exception('Missing datas to build FK restriction');
				}
			}
		}	
		return $result;	
	}

	/**
	 * This function delete a field from table
	 * @param string $fieldname
	 * @throws Exception
	 */
	public function delete_field($fieldname){
		//checking existence
		$exist = false;
		$keyfield = '';
		foreach($this->fields as $key => $field){
			$fname = $field->get_name();
			if($fname == $fieldname){
				$exist = true;
				$keyfield = $key;
			}
		}
		if(!$exist){
			throw new Exception('The field "'.$fieldname.'" does not exist');
		}
		
		//we check keys
		foreach($this->keys as $key){
			$kfields = $key->get_fields();
			foreach($kfields as $kfield){
				if($kfield == $fieldname){
					throw new Exception('This field has associated a key');
				}
			}
		}

		unset($this->fields[$keyfield]);
		
		$this->change = true;
	}
	
	/**
	 * @param string $keyname
	 */
	public function delete_key($keyname){
		$clave = null;
		foreach($this->keys as $k => $key){
			$kname = $key->get_name();
			if($kname == $keyname){
				$clave = $k;
			}
		}
		if(isset($clave)){
			unset($this->keys[$clave]);
		}
		
		$this->changed = true;
	}
	
	/**
	 * This function will delete the table
	 */
	public function delete_table($params = array()){
		$tablename = $this->name;
		if(isset($params['tablename'])){
			$tablename = $params['tablename'];
		}
		$sql = 'DROP TABLE ' . $tablename;
		return ejecutar($sql);
	}
	
	public function rename_table($params){
		if(!is_array($params)){
			throw new Exception('Rename Table: wrong parameters');
		}
		
		$newname = $params['newname'];
		$sql = 'RENAME TABLE ';
		
		foreach($params as $tablename => $newname){
			$sql.= $tablename . ' TO ' . $newname . ',';
		}
		$sql = substr($sql, 0, -1);
		return ejecutar($sql);
	}
	
	public function rename_field($oldname, $newfield){
		$sqlfield = $this->get_sqlfield($field);
		$sql = 'ALTER TABLE ' .  $this->name . ' CHANGE ' . $oldname . ' ' . $sqlfield;
		return ejecutar($sql);
	}
	
	function get_fields_db(){
		$result = array();
		
		if($instances = DB::get_info_columns(array('tablename' => $this->name))){
			foreach($instances as $instance){	
				$column_name = $instance['column_name'];
				
				$notnull = null;
				if($instance['is_nullable'] == 'NO'){
					$notnull = EVALCOMIX_NOTNULL;
				}
				
				$type = evalcomix_table::get_type($instance['data_type']);
				
				$default = $instance['column_default'];
				$sequence = null;
				if(!isset($instance['extra'])){
					$pos = strpos($default, 'nextval');
					if($pos !== false){
						$sequence = EVALCOMIX_SEQUENCE;
					}
				}
				else{
					if($instance['extra'] == 'auto_increment'){
						$sequence = EVALCOMIX_SEQUENCE;
					}
				}
				
				$precision = null;
				if($type == EVALCOMIX_TYPE_INTEGER || $type == EVALCOMIX_TYPE_NUMBER || $type == EVALCOMIX_TYPE_FLOAT){
					$precision = $instance['numeric_precision'];
				}
				elseif($type == EVALCOMIX_TYPE_CHAR){
					$precision = $instance['character_maximum_length'];
				}	
				
				$result[$column_name]['name'] = $instance['column_name'];
				$result[$column_name]['notnull'] = $notnull;
				$result[$column_name]['type'] = $type;
				$result[$column_name]['precision'] = $precision;
				$result[$column_name]['default'] = $default['value'];
				$result[$column_name]['sequence'] = $sequence;
				
				$field = new evalcomix_field($result[$column_name]);
				$this->fields[] = $field;		
			}
		}
		
		return $result;
	}
	
	function get_keys_db(){
		$result = array();
		
		if($instances = DB::get_info_keys(array('tablename' => $this->name))){
			$fields_pk = array();
			foreach($instances as $instance){	print_r($instance);
				$type = strtolower($instance['type']);
				if($type == 'foreign key'){
					$params_fk = array();
					$params_fk['type'] = EVALCOMIX_KEY_FOREIGN;
					$params_fk['name'] = $instance['constraint_name'];
					$params_fk['fields'] = array($instance['column_name']);
					$params_fk['reftable'] = $instance['reftable'];
					$params_fk['reffield'] = $instance['reffield'];
					$this->keys[] = new evalcomix_key($params_fk);
				}
				elseif($type == 'primary key'){
					$namepk = $instance['constraint_name'];
					$type_key = EVALCOMIX_KEY_PRIMARY;
					$fields_pk[] = $instance['column_name'];
				}
			}
			if(!empty($fields_pk)){
				$params['name'] = $namepk;
				$params['type'] = EVALCOMIX_KEY_PRIMARY;
				$params['fields'] = $fields_pk;
				$this->keys[] = new evalcomix_key($params);
			}
		}
		
		return $result;
	}
	
	    /**
     * This function returns the correct EVALCOMIX_TYPE_XXX value for the
     * string passed as argument
     * @param string $type
     * @return int
     */
    public static function get_type($type) {

        $result = EVALCOMIX_TYPE_TEXT;

        switch (strtolower($type)) {
            case 'int':
                $result = EVALCOMIX_TYPE_INTEGER;
                break;
			case 'integer':
                $result = EVALCOMIX_TYPE_INTEGER;
                break;
			case 'bool':
                $result = EVALCOMIX_TYPE_INTEGER;
                break;
			case 'tinyint':
				$result = EVALCOMIX_TYPE_INTEGER;
                break;
			case 'smallint':
				$result = EVALCOMIX_TYPE_INTEGER;
                break;
            case 'number':
                $result = EVALCOMIX_TYPE_NUMBER;
                break;
            case 'float':
                $result = EVALCOMIX_TYPE_FLOAT;
                break;
            case 'char':
                $result = EVALCOMIX_TYPE_CHAR;
                break;
			case 'varchar':
                $result = EVALCOMIX_TYPE_CHAR;
                break;
			case 'character varying':
                $result = EVALCOMIX_TYPE_CHAR;
                break;
            case 'text':
                $result = EVALCOMIX_TYPE_TEXT;
                break;
            case 'binary':
                $result = EVALCOMIX_TYPE_BINARY;
                break;
            case 'datetime':
                $result = EVALCOMIX_TYPE_DATETIME;
                break;
        }
        // Return the normalized EVALCOMIX_TYPE
        return $result;
    }
	
	/**
	*
	*
	*/
	function create_table($params = array()){
		$tablename = $this->name;
		$fields = $this->fields;
		$keys = $this->keys;
		
		if(isset($params['tablename'])){
			$tablename = $params['tablename'];
		}
		if(isset($params['fields'])){
			$fields = $params['fields'];
		}
		if(isset($params['keys'])){
			$keys = $params['keys'];
		}
		
		$sql = 'CREATE TABLE ' . $tablename . ' (';
		$extra = '';
		
		if(empty($fields)){
			throw new Exception('Create table missing parameters');
		}
		
		foreach($fields as $field){
			if(TYPEDB == 'mysql'){
				$extra = 'ENGINE=INNODB';
			}
			$sql.= $this->get_sqlfield($field);
			$sql.= ',';  
		}
		
		foreach($keys as $key) {
			$sql.= $this->get_sqlkey($key);
			$sql.= ',';
		}
		$sql = substr($sql, 0, -1);
		$sql.= ')';
		$sql.= $extra;		
		echo $sql;
		$result = ejecutar($sql);
		
		return $result;
	}
	
	/**
	*
	*/
	function check_size($params){
		if(!isset($params['table1']) || !isset($params['table2'])){
			throw new Exception('Migrating Data: Missing parameters');
		}
		
		$table1 = $params['table1'];
		$table2 = $params['table2'];
		if($table1_rows = DB::get_records($table1, array())){
			if($table2_rows = DB::get_records($table2, array())){
				if(count($table1_rows) == count($table2_rows)){
					return true;
				}
				else{
					return false;
				}
			}
		}
		
		return false;
	}
}