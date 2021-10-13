<?php
	if (file_exists('../configuration/conf.php')) {
		include_once('../configuration/conf.php');
	}
	
	include_once('pdo_database.php');
	
	class DB 	{
		private static $driver = 'pdo_database';
		
		public static function insert_record($table, $params, $config = array()){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->insert_record($table, $params, $config);
		}
		
		public static function update_record($table, $params){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->update_record($table, $params);
		}
		
		public static function get_record($table, $params){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->get_record($table, $params);
		}
		
		public static function get_records($table, $params, $sortfields = array()){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->get_records($table, $params, $sortfields);
		}
		
		public static function delete_records($table, $params){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->delete_records($table, $params);
		}
		
		public static function query($sql){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->query($sql);
		}
		
		public static function next_row($rst){
			return $rst->fetch();
		}
		
		public static function row_count($rst){
			return $rst->rowCount();
		}
		
		public static function table_exists($params){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->table_exists($params);
		}
		
		public static function get_info_columns($params){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->get_info_columns($params);
		}
		
		public static function get_info_keys($params){
			$objectdb = new self::$driver(array('dbtype' => TYPEDB, 'dbhost' => HOSTDB, 'dbuser' => USERDB, 'dbpass' => PASSDB, 'dbname' => NAMEDB));
			return $objectdb->get_info_keys($params);
		}
		
	}