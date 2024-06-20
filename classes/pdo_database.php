<?php 
	include_once('database.php');
	
	/**
	* Abstract database driver class
	*/
	class pdo_database extends database{
		protected $pdb;
		protected $lastError = null;
		/** @var string db type */
		protected $dbtype;
		/** @var array Database or driver specific options, such as sockets or TCPIP db connections */
		protected $dboptions;
		protected $namesequence;
		
		/**
		 * Connect to db
		 * Must be called before other methods.
		 * @param array $params with db connection datas
		 * @return bool success
		 */
		public function __construct($params) {
			$this->dbtype = $params['dbtype'];
			$this->dbhost = $params['dbhost'];
			$this->dbuser    = $params['dbuser'];
			$this->dbpass    = $params['dbpass'];
			$this->dbname    = $params['dbname'];
			if(isset($params['dboptions'])){
				$this->dboptions = (array)$params['dboptions'];
			}
			
			try{
				$this->pdb = new PDO($this->get_dsn($this->dbtype), $this->dbuser, $this->dbpass, $this->get_pdooptions());
				// generic PDO settings to match adodb's default; subclasses can change this in configure_dbconnection
				$this->pdb->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
				$this->pdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return true;
			} catch (PDOException $ex) {
				$message = $ex->getMessage();
				throw new Exception($message);
				/*if (isset($params['throw'])) {
					$message = $ex->getMessage();
					throw new Exception($message);
				} else {
					echo "\nerrorCode(): ";
					echo  $ex->getMessage();
					return 2;
				}*/
			}
		}

		/**
		 * Get records in database.
		 * @param string $table name
		 * @param mixed $params data record as object or array
		 * @param bool true means repeated updates expected
		 * @return bool success
		 */
		public function get_records($table, $params, $sortfields = array('id')) {
			if (!is_array($params)) {
				$params = (array)$params;
			}

			$select = "'1'";
			foreach($params as $key => $value){
				if(is_string($value)){
					$match = addslashes($value);
					if($this->dbtype == 'postgresql'){
					  $aux_value = str_replace("\'", "''", $match);
					  $match = str_replace('\"', '"', $aux_value);
					}
					$select .= " AND $key = '". $match ."'";
				}
				else{
					$select .= " AND $key = $value";
				}
			}
			
			$criteria = '';
			if(is_array($sortfields) && !empty($sortfields)){
				$criteria = implode(",", $sortfields);
			}else{
				$criteria = 'id';
			}
			
			$sql = "SELECT *
					FROM $table
					WHERE $select
					ORDER BY " . $criteria;//echo $sql;
			if (!$result = $this->pdb->query($sql)) {
				return false;
			}
			
			return $result->fetchAll();
		}
		
		/**
		 * Get a record in database.
		 * @param string $table name
		 * @param mixed $params data record as object or array
		 * @param bool true means repeated updates expected
		 * @return bool success
		 */
		public function get_record($table, $params) {			
			if (!is_array($params)) {
				$params = (array)$params;
			}
			$instances = $this->get_records($table, $params);
			
			if(count($instances) > 1){
				echo "Se ha encontrado más de una tupla: ".count($instances);
			}
			return reset($instances);
		}
		
		/**
		 * Insert new record into database, as fast as possible, no safety checks, lobs not supported.
		 * @param string $table name
		 * @param mixed $params data record as object or array
		 * @return bool|int true or new id
		 */
		public function insert_record($table, $params, $config = array()){			
			if (!is_array($params)) {
				$params = (array)$params;
			}

			$ignoreid = true;
			if(!empty($config['noignoreid']) && $config['noignoreid'] == true){
				$ignoreid = false;
			}
			
			if (array_key_exists('id', $params) && $ignoreid) {
				unset($params['id']);
			}

			if (empty($params)) {
				throw new Exception('dmlpdo_database::insert_record() no fields found.');
			}
			$processed_params = array();
			foreach($params as $key => $value){
				if(isset($value)){
					$processed_params[$key] = $value;
					if($this->dbtype == 'postgresql'){
					  $aux_value = str_replace("\'", "''", $value);
					  $processed_params[$key] = str_replace('\"', '"', $aux_value);
					}
				}
			}
			$fields = implode(',', array_keys($processed_params));
			
			//$qms    = array_fill(0, count($params), '?');
			//$qms    = implode(',', $qms);
			$qms = '';
			foreach($processed_params as $key => $param){
				if(is_string($param) && $param != 'NULL'){
					$qms .= '\''.$param . '\',';
				}
				else{
					$qms .= $param . ',';
				}
			}
			$qms = substr($qms, 0, -1);

			$sql = "INSERT INTO ". $table ." ($fields) VALUES($qms)";//echo $sql.'<br>';
			if (!$this->pdb->query($sql)) {
				return false;
			}
			
			$namesequence = '';
			if($this->dbtype == 'postgresql'){
				$namesequence = $table . '_id_seq';
			}
			
			if ($id = $this->pdb->lastInsertId($namesequence)) {
				return (int)$id;
			}
			return false;
		}

		/**
		 * Update record in database, as fast as possible, no safety checks, lobs not supported.
		 * @param string $table name
		 * @param mixed $params data record as object or array
		 * @param bool true means repeated updates expected
		 * @return bool success
		 */
		public function update_record($table, $params) {			
			$params = (array)$params;

			if (!isset($params['id'])) {
				throw new Exception('evalcomix_database::update_record() id field must be specified.');
			}
			
			$id = $params['id'];
			unset($params['id']);

			if (empty($params)) {
				throw new Exception('evalcomix_database::update_record() no fields found.');
			}

			$sets = array();
		
			foreach ($params as $field=>$value) {
				if(is_string($value) && $value != 'NULL'){
					$value = addslashes($value);
					if($this->dbtype == 'postgresql'){
					  $aux_value = str_replace("\'", "''", $value);
					  $value = str_replace('\"', '"', $aux_value);
					 // $match = "$field = '". $value ."'";
					}
					$match = "$field = '". $value . "'";
					$sets[] = $match;
				}
				elseif(isset($value)){
					$sets[] = "$field = $value";
				}
				
			}
	
			$params[] = $id; // last ? in WHERE condition

			$sets = implode(',', $sets);
			$sql = "UPDATE $table SET $sets WHERE id=".$id;//echo $sql;
			return $this->pdb->query($sql);
		}
		
		public function delete_records($table, $params) {
			$params = (array)$params;
			
			$sql = "DELETE FROM $table";
			if (isset($params['id'])) {
				$sql .= " WHERE id = " . $params['id'];
			}
			
			return $this->pdb->exec($sql);
		}
		
		
		
		/**
		 * Returns the driver-dependent connection attributes for PDO based on members stored by connect.
		 * Must be called after $dbname, $dbhost, etc. members have been set.
		 * @return array A key=>value array of PDO driver-specific connection options
		 */
		protected function get_pdooptions() {
			return array(PDO::ATTR_PERSISTENT => !empty($this->dboptions['dbpersist']));
		}
		
		/**
		 * Returns general database library name
		 * Note: can be used before connect()
		 * @return string db type pdo, native
		 */
		protected function get_dblibrary() {
			return 'pdo';
		}
		
		/**
		 * Returns database server info array
		 * @return array
		 */
		public function get_server_info() {
			$result = array();
			try {
				$result['description'] = $this->pdb->getAttribute(PDO::ATTR_SERVER_INFO);
			} catch(PDOException $ex) {}
			try {
				$result['version'] = $this->pdb->getAttribute(PDO::ATTR_SERVER_VERSION);
			} catch(PDOException $ex) {}
			return $result;
		}

		/**
		 * Returns supported query parameter types
		 * @return int bitmask
		 */
		protected function allowed_param_types() {
			return SQL_PARAMS_QM | SQL_PARAMS_NAMED;
		}

		/**
		 * Returns last error reported by database engine.
		 * @return string error message
		 */
		public function get_last_error() {
			return $this->lastError;
		}
		
		public function query($sql){
			if (!$rst = $this->pdb->query($sql)) {
				return false;
			}
			return $rst;
		}
		
		public function table_exists($params){
			if(empty($params['tablename'])){
				throw new Exception('Table Exists: Missing parameter');
			}
			$tablename = $params['tablename'];
			
			$schema = "table_schema = '". $this->dbname ."'";
			if($this->dbtype == 'postgresql'){
				$schema = "table_catalog = '". $this->dbname ."'";
			}		
			
			$sql = "SELECT table_name
					FROM information_schema.tables
					WHERE $schema AND table_name = '". $tablename ."'";
			
			if (!$result = $this->pdb->query($sql)) {
				return false;
			}
			
			$instances = $result->fetchAll();
			if(count($instances) > 0){
				return true;
			}
			
			return false;
		}
		
		public function get_info_columns($params){
			if(empty($params['tablename'])){
				throw new Exception('Table Exists: Missing parameter');
			}			
			$tablename = $params['tablename'];
			
			$schema = "table_schema = '". $this->dbname ."'";
			if($this->dbtype == 'postgresql'){
				$schema = "table_catalog = '". $this->dbname ."'";
			}		
			
			$sql = "SELECT *
					FROM INFORMATION_SCHEMA.COLUMNS AS c1
					WHERE c1.table_name = '". $tablename ."'
					AND $schema";
	
			if (!$result = $this->pdb->query($sql)) {
				return false;
			}
			
			$instances = $result->fetchAll();
			return $instances;
		}
		
		public function get_info_keys($params){
			if(empty($params['tablename'])){
				throw new Exception('Table Exists: Missing parameter');
			}			
			$tablename = $params['tablename'];
			
			$sql = "SELECT k.column_name AS \"column_name\", t.constraint_name AS \"constraint_name\", k.referenced_table_name AS \"reftable\", k.referenced_column_name AS \"reffield\", t.constraint_type AS \"type\"
					FROM 
						information_schema.table_constraints t
						JOIN information_schema.key_column_usage k
						USING ( constraint_name, table_schema, table_name ) 
					WHERE 
						t.table_name =  '". $tablename ."'
						AND t.table_schema = '". $this->dbname ."'";
	
			if($this->dbtype == 'postgresql'){
				$sql = "SELECT tc.constraint_type AS \"type\", tc.constraint_name AS \"constraint_name\", kcu.column_name AS \"column_name\", ccu.table_name AS \"reftable\", ccu.column_name AS \"reffield\"
						FROM 
							information_schema.table_constraints AS tc 
							JOIN information_schema.key_column_usage AS kcu
							ON tc.constraint_name = kcu.constraint_name
							JOIN information_schema.constraint_column_usage AS ccu
							ON ccu.constraint_name = tc.constraint_name
						WHERE 
							tc.table_name='". $tablename ."'
							AND tc.table_catalog = '" . $this->dbname . "'";
			}		
			if (!$result = $this->pdb->query($sql)) {
				return false;
			}
			
			$instances = $result->fetchAll();
			return $instances;
		}
	}