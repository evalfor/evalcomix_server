<?php
	class dbpdo{
		public $instance;
		function __construct($db_dsn, $db_user, $db_pass){
			$this->instance = new PDO($db_dsn, $db_user, $db_pass); 
			return $this->instance;
		}
		
		/**
			Executes an SQL statement, returning a result set as a PDOStatement object 
			@param string $sql command
		*/
		public function query($sql){
			if(isset($this->instance)){	
				return $this->instance->query($sql);
			}
			return false;
		}
		
		/**
			Execute an SQL statement and return the number of affected rows 
			@param string $sql
		*/
		public function execute($sql){
			if(isset($this->instance)){
				try {
					return $this->instance->exec($sql);
				}
				catch (PDOException $e) {
					echo "\nerrorCode(): ";
					echo $this->instance->errorCode();
				}
			}
			return false;
		}
				
	}