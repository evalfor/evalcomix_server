<?php
include_once('../configuration/conf.php');
include_once('evalcomix_field.php');
include_once('evalcomix_key.php');
include_once('evalcomix_dbobject.php');
include_once('../classes/db.php');
include_once('evalcomix_constant.php');
include_once('lib.php');
include_once(DIRROOT . '/classes/pdo_database.php');


class evalcomix_table extends evalcomix_dbobject {
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
	
	public function get_name(){return $this->name;}
	public function get_fields(){return $this->fields;}
	public function get_keys(){return $this->keys;}
	public function get_indexes(){return $this->indexes;}
	public function get_exist(){return $this->exist;}
	
	public function set_name($name){
		if (strlen($name) > self::NAME_MAX_LENGTH) {
			return 'Invalid table name {'.$name.'}: name is too long. Limit is 28 chars.';
		}
		if (!preg_match('/^[a-z][a-z0-9_]*$/', $name)) {
			return 'Invalid table name {'.$name.'}: name includes invalid characters.';
		}
		
		$this->name = $name;
	}
	
	public function set_fields($fields){$this->fields = $fields;}
	
	public function set_keys($keys){$this->keys = $keys;}
	
	public function set_indexes($indexes){$this->indexes = $indexes;}

	public function set_exist($exist){$this->exist = $exist;}
	/**
	*@param string $name of the table
	*/
	public function __construct($params = array()){		
		$this->fields = array();
		$this->keys = array();
		$this->indexes = array();
		$this->change = false;
		$this->exist = false;
		
		if(isset($params['name'])){
			$name = $params['name'];
			if (strlen($name) > self::NAME_MAX_LENGTH) {
				return 'Invalid table name {'.$name.'}: name is too long. Limit is 28 chars.';
			}
			if (!preg_match('/^[a-z][a-z0-9_]*$/', $name)) {
				return 'Invalid table name {'.$name.'}: name includes invalid characters.';
			}
			
			$this->name = $name;
		
			if($this->table_exists($params)){
				$this->exist = true;
				$this->get_fields_db();
				$this->get_keys_db();
			}
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
	* @return xmlddb_field
	*/
	public function add_field($params = array()) {
		$fieldname = $params['name'];
		if(!$this->check_name($fieldname)){
			throw new Exception('Field name "'.$fieldname.'" is not valid');
		}
		
		foreach($this->fields as $name => $column){
			if($fieldname == $name){
				throw new Exception('Field "'.$fieldname.'" just exists in table');
			}
		}
		
		$field = new evalcomix_field($params);
		$this->fields[$fieldname] = $field;
		
		
		if($this->exist == true){
			$sqlfield = $this->get_sqlfield($field);
			$sql = 'ALTER TABLE ' . $this->name . ' ADD COLUMN ' . $sqlfield;
			ejecutar($sql);
		}		
	
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
		foreach($this->keys as $value){
			$keyname = $key->get_name();
			$valuename = $value->get_name();
			
			$keytype = $key->get_type();
			$valuetype = $value->get_type();
			
			$keyfields = $key->get_fields();
			$valuefields = $value->get_fields();
			
			$keyreftable = $key->get_reftable();
			$valuereftable = $value->get_reftable();
			
			$keyreffield = $key->get_reffield();
			$valuereffield = $value->get_reffield();
			
			if($keytype == $valuetype && $keyfields == $valuefields && $keyreftable == $valuereftable && $keyreffield == $valuereffield){
				if(($keytype == 'fk' && $keyname == $valuename) || $keytype == 'pk'){
					throw new Exception('Key just exists in table');
				}
			}
		}

		$this->keys[] = $key;
		
		if($this->exist == true){
			$sqlkey = $this->get_sqlkey($key);
			
			$sql = 'ALTER TABLE ' . $this->name . ' ADD ' .  $sqlkey;
			ejecutar($sql);
		}
		$this->changed = true;
		
		return $key;
	}
	
	/**
	* This function checks if table exists in database
	*/
	public function table_exists($params = array()) {
		$tablename = $this->name;
		if(!empty($params['tablename'])){
			$tablename = $params['tablename'];
		}
		if(!$this->check_name($tablename)){
			throw new Exception($tablename . ' is no a correct table name');
		}
		
		return DB::table_exists(array('tablename' => $tablename));
	}
	
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
		
		if(!empty($tablename) && !empty($fields)){
			if($this->exist == false){
				$sql = 'CREATE TABLE ' . $tablename . ' (';
				$extra = '';
			
				$pk = false;
				foreach($fields as $field){
					$fieldpk = $field->get_pk();
					if(!empty($fieldpk)){
						$pk = true;
					}
					
					if(TYPEDB == 'mysql'){
						$extra = 'ENGINE=INNODB';
					}
					$sql.= $this->get_sqlfield($field);
					$sql.= ',';  
				}
				
				foreach($keys as $key) {
					$type = $key->get_type();
					if($pk && $type == 'pk'){
						continue;
					}
					$sql.= $this->get_sqlkey($key);
					$sql.= ',';
				}
				$sql = substr($sql, 0, -1);
				$sql.= ')';
				$sql.= $extra;		
				
				$result = ejecutar($sql);
				
				$this->exist = true;
				return $result;
			}
		}
		else{
			throw new Exception('Create table missing parameters');
		}
		return false;
	}
	
	
	/**
	 * This function generate sql code for a new field into a table
	 * @params object $field evalcomix_field object
	 */
	public function get_sqlfield($field){
		$fieldname = $field->get_name();

		$type = $field->get_type();
			
		$notnullsql = '';
		$notnullbool = $field->get_notnull();
		if(!empty($notnullbool) && $notnullbool){
			$notnullsql = ' NOT NULL';
		}
		
		$defaultsql = '';
		$defaultvalue = $field->get_default();
		if(isset($defaultvalue)){
			$defaultsql = ' DEFAULT ' . $field->get_default();
		}
			
		$sequencebool = $field->get_sequence();
		$sequence = '';
		if($type === EVALCOMIX_TYPE_INTEGER && $sequencebool){
			if(defined('TYPEDB')){
				if(TYPEDB == 'mysql'){
					$sequence = ' AUTO_INCREMENT';
				}
				elseif(TYPEDB == 'postgresql'){
					$type = ' SERIAL';
				}
			}
			$notnullsql = '';
			$defaultsql = '';
		}
			
		$length = $field->get_length();
		$precision = '';
		if(!empty($length)){
			$precision = '('. $length;
			$decimals = $field->get_decimals();
			if(!empty($decimals)){
				$precision.= ',' . $decimals;
			}
			$precision.= ')';
		}
		
		$type_precision = ' ' . $type . $precision;
		
		$uniquesql = '';
		$pk = $field->get_pk();
		$pksql = '';
		if(!empty($pk)){
			$pksql = ' PRIMARY KEY';
		}
		else{
			$unique = $field->get_unique();
			if(!empty($unique)){
				$uniquesql = ' UNIQUE';
			}
		}
		
		$result = $field->get_name() . $type_precision . $sequence . $uniquesql . $notnullsql . $defaultsql . $pksql;
		return $result; 
	}
	
	/**
	 * This function generates sql code for a new (primary or foreing) key
	 * @param object $key evalcomix_key
	 */
	public function get_sqlkey($key){
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
				$sql_fk = '';
				if(!empty($keyname)){
					$sql_fk.= 'CONSTRAINT ' . $keyname;
				}
				$sql_fk.= ' FOREIGN KEY (';
					
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
		else{
			throw new Exception('Missing Fields to build constraint');
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
			$ktype = $key->get_type();
			if($ktype == 'fk'){
				foreach($kfields as $kfield){
					if($kfield == $fieldname){
						throw new Exception('This field has associated a foreign key');
					}
				}
			}
		}

		$sql = 'ALTER TABLE '. $this->name. ' DROP COLUMN ' . $fieldname;
		$result = ejecutar($sql);
		
		unset($this->fields[$keyfield]);
		$this->change = true;		
		
		return $result;
	}
	
	/**
	 * @param string $keyname
	 */
	public function delete_key($keyname){
		$sql = 'ALTER TABLE ' . $this->name . ' DROP ';
		$clave = null;
		foreach($this->keys as $k => $key){
			$kname = $key->get_name();
			if($kname == $keyname){
				$clave = $k;
			}
		}
		if(isset($clave)){
			$type = $key->get_type();
			if($type == 'fk'){
				if(TYPEDB == 'mysql'){
					$sql.= 'FOREIGN KEY ' . $keyname;
				}
				elseif(TYPEDB == 'postgresql'){
					$sql.= 'CONSTRAINT ' . $keyname;
				}
			}
			elseif($type == 'pk'){
				if(TYPEDB == 'mysql'){
					$sql.= 'PRIMARY KEY';
				}
				elseif(TYPEDB == 'postgresql'){
					$sql.= 'CONSTRAINT ' . $keyname;
				}
			}
			$result = ejecutar($sql);
			unset($this->keys[$clave]);
			$this->changed = true;
		}
		else{
			throw new Exception('The key "'.$keyname.'" does not exist');
		}
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
	
	//$params['tablename'] => 'newtablename'
	public function rename_table($params){
		if(!is_array($params)){
			throw new Exception('Rename Table: wrong parameters');
		}
	
		$sql = 'RENAME TABLE ';
		$newtablename = null;
		foreach($params as $tablename => $newname){
			if($this->check_name($tablename) && $this->check_name($newname)){
				if($this->table_exists(array('tablename' => $tablename)) && !$this->table_exists(array('tablename' => $newname))){
					$sql.= $tablename . ' TO ' . $newname . ',';
					if((string)$tablename == (string)$this->name){
						$newtablename = $newname;
					}
				}
				else{
					throw new Exception('Renaming table: wrong parameters');
				}
			}
			else{
				continue;
			}
		}
		$sql = substr($sql, 0, -1);
		ejecutar($sql);
		
		if($newtablename != null){
			$this->name = $newtablename;
		}
		
		return true;
	}
	
	public function rename_field($params){
		if(isset($params['oldname'])){
			$oldname = $params['oldname'];
		}
		if(isset($params['newfield'])){
			$newfield = $params['newfield'];
		}
		
		//Checking parameters
		if(empty($oldname) || empty($newfield)){
			throw new Exception('renaming fields: Missing Parameters');
		}
		
		//Checking that oldname exists into table
		$name_fields = array();
		foreach($this->fields as $field){
			$name_fields[] = $field->get_name();
		}		
		if(!in_array($oldname, $name_fields)){
			throw new Exception('Field "'.$oldname.'" does not exist in table ' . $this->name);
		}
		
		$sqlfield = $this->get_sqlfield($newfield);
		$sql = 'ALTER TABLE ' .  $this->name . ' CHANGE ' . $oldname . ' ' . $sqlfield;
		
		ejecutar($sql);
		
		$newname = $newfield->get_name();
		$this->fields[$newname] = $newfield;
		
		if($oldname != $newname){
			unset($this->fields[$oldname]);
		}
		
		return true;
	}
	
	/**
	* Get columns from database. 
	*/
	function get_fields_db(){
		$result = array();
		
		if(!$this->table_exists(array('tablename' => $this->name))){
			throw new Exception('Database Name does not exist');
		}
		
		if($instances = DB::get_info_columns(array('tablename' => $this->name))){
			$fields = array();
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
				if($type == EVALCOMIX_TYPE_INTEGER || $type == EVALCOMIX_TYPE_NUMERIC || $type == EVALCOMIX_TYPE_FLOAT){
					$precision = $instance['numeric_precision'];
				}
				elseif($type == EVALCOMIX_TYPE_CHAR){
					$precision = $instance['character_maximum_length'];
				}	
				
				$result[$column_name]['name'] = $instance['column_name'];
				$result[$column_name]['notnull'] = $notnull;
				$result[$column_name]['type'] = $type;
				$result[$column_name]['precision'] = $precision;
				$result[$column_name]['default'] = $default;
				$result[$column_name]['sequence'] = $sequence;
				
				$field = new evalcomix_field($result[$column_name]);
				$fields[$column_name] = $field;		
			}
			if(!empty($fields)){
				$this->fields = $fields;
			}
		}
		
		return $this->fields;
	}
	
	/**
	* Get primary and foreign keys from database
	*/
	function get_keys_db(){
		$result = array();
		
		if(!$this->table_exists(array('tablename' => $this->name))){
			throw new Exception('Database Name does not exist');
		}
		
		if($instances = DB::get_info_keys(array('tablename' => $this->name))){
			$fields_pk = array();
			$fields_fk = array();
			$namepk = '';
			foreach($instances as $instance){
				$type = strtolower($instance['type']);
				if($type == 'foreign key'){
					$name_fk = $instance['constraint_name'];
					$params_fk = array();
					$params_fk['type'] = EVALCOMIX_KEY_FOREIGN;
					$params_fk['name'] = $name_fk;
					$params_fk['fields'] = array($instance['column_name']);
					$params_fk['reftable'] = $instance['reftable'];
					$params_fk['reffield'] = $instance['reffield'];
					$fields_fk[$name_fk] = new evalcomix_key($params_fk);
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
				$this->keys[$namepk] = new evalcomix_key($params);
			}
			if(!empty($fields_fk)){
				$this->keys = array_merge($this->keys, $fields_fk);
			}
		}
		
		return $this->keys;
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
			case 'tinyint':
				$result = EVALCOMIX_TYPE_INTEGER;
                break;
			case 'smallint':
				$result = EVALCOMIX_TYPE_INTEGER;
                break;
			case 'bigint':
				$result = EVALCOMIX_TYPE_BIGINT;
                break;
			case 'numeric':
                $result = EVALCOMIX_TYPE_NUMERIC;
                break;
			case 'decimal':
                $result = EVALCOMIX_TYPE_NUMERIC;
                break;
			case 'bool':
                $result = EVALCOMIX_TYPE_BOOL;
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
			case 'timestamp':
                $result = EVALCOMIX_TYPE_TIMESTAMP;
                break;
        }
        // Return the normalized EVALCOMIX_TYPE
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
	
	/**
	*
	*/
	function delete_fk($tables = array()){
		foreach($tables as $table){
			if($this->table_exists(array('tablename' => $table))){
				$this->set_name($table);
				$this->set_exist(true);
				$this->keys = array();
				$keys = $this->get_keys_db();			
				foreach($keys as $key){
					$type = $key->get_type();
					$keyname = $key->get_name();
					if($type == 'fk'){
						$this->delete_key($keyname);
					}
				}
			}
			else{
				echo "No existe la tabla de nombre: $table <br>";
			}
		}
		
		return true;
	}
	
	/**
	*
	*/
	function field_exist($fieldname){
		foreach($this->fields as $name => $column){
			if($fieldname == $name){
				return true;
			}
		}
		return false;
	}
	
	/**
	*
	*/
	function key_exist($params){
		if(isset($params['keytype'])){
			$keytype = $params['keytype'];
			
			if(isset($params['keyname'])){
				$keyname = $params['keyname'];
			}
		
			foreach($this->keys as $value){
				$valuename = $value->get_name();
				$valuetype = $value->get_type();
				if(($keytype == $valuetype)){
					if(($keytype == 'fk' && $keyname == $valuename)  || $keytype == 'pk') {
						return true;
					}
				}
			}
		}
		return false;
	}
}


?>