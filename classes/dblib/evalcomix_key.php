<?php

/** 
 * @author Daniel Cabeza
 * 
 */
class evalcomix_key {
	
	/** @var string $name	 */
	private $name;
	
	/** @var string $type [ primary | foreign ] */
	private $type;
	
	/** @var array $fields */
	private $fields;
	
	/** @var string $reftable */
	private $reftable;
	
	/** @var string $reffield*/
	private $reffield;
	
	public function get_name(){return $this->name;}
	public function get_type(){return $this->type;}
	public function get_fields(){return $this->fields;}
	public function get_reftable(){return $this->reftable;}
	public function get_reffield(){return $this->reffield;}
	
	public function set_name($name){$this->name = $name;}
	public function set_type($type){$this->type = $type;}
	public function set_fields($fields){$this->fields = $fields;}
	public function set_reftable($reftable){$this->reftable = $reftable;}
	public function set_reffield($reffield){$this->reffield = $reffield;}
	/**
	 */
	function __construct($params = array()) {
		if(isset($params['name'])){
			$this->name = $params['name'];
		}
		if(isset($params['type'])){	
			$this->type = $params['type'];
		}	
		if(isset($params['fields'])){
			$this->fields = $params['fields'];
		}
		if(isset($params['reftable'])){
			$this->reftable = $params['reftable'];
		}
		if(isset($params['reffield'])){
			$this->reffield = $params['reffield'];
		}
	}
}