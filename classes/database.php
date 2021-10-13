<?php

	abstract class database {
		/** @var string db host name */
		protected $dbhost;
		/** @var string db host user */
		protected $dbuser;
		/** @var string db host password */
		protected $dbpass;
		/** @var string db name */
		protected $dbname;
		
		/**
		 * Returns the driver-dependent DSN for PDO based on members stored by connect.
		 * Must be called after connect (or after $dbname, $dbhost, etc. members have been set).
		 * @param string $dbtype It will be "postgresql", "mysql" or "oracle"
		 * @return string driver-dependent DSN
		 */
		public function get_dsn($dbtype){
			$dsn = '';
			switch($dbtype){
				case 'postgresql':{
					$dsn = 'pgsql:dbname='.$this->dbname.';host='. $this->dbhost;
				}break;
				case 'mysql':{
					$dsn = 'mysql:host='.$this->dbhost.';dbname='. $this->dbname;
				}break;
				case 'oracle':{
					$dsn = 'oci:dbname='.$this->dbname;
				}break;
			}
			return $dsn;
		}
		
		abstract public function insert_record($table, $params, $config = array());
		abstract public function update_record($table, $params);
		abstract public function get_record($table, $params);
		abstract public function get_records($table, $params);
		abstract public function delete_records($table, $params);
		abstract public function table_exists($params);
		abstract public function get_info_columns($params);
		abstract public function get_info_keys($params);
	}