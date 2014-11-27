<?php

include_once('db.php');
//TODO: DESARROLLO DE PRUEBAS DE TODAS LAS CLASES CON SIMPLETEST

class evalcomix_object {
	protected $table;
	
	/**
     * The PK.
     * @var int $id
     */
	var $id;
	

	/**
	* Records this object in the Database, sets its id to the returned value, and returns that value.
	* If successful this function also fetches the new object data from database and stores it
	* in object properties.
	* @return int PK ID if successful, false otherwise
	*/
	public function insert(){

        if (!empty($this->id)) {
            //error_log("Tool object already exists!");
            return false;
        }
		
        $data = $this->get_record_data();
		
        $this->id = DB::insert_record($this->table, $data);

        // set all object properties from real DB data
        $this->update_from_db();

        //$this->notify_changed(false);
        return $this->id;
	}
	
	 /**
     * Updates this object in the Database, based on its object variables. ID must be set.
     * @return boolean success
     */
	public function update(){

        if (empty($this->id)) {
            //error_log('Can not update tool object, no id!');
            return false;
        }
		
        $data = $this->get_record_data();
        DB::update_record($this->table, $data);

        //$this->notify_changed(false);
        return true;
	}
	
	/**
     * Deletes this object from the database.
     * @param string $source from where was the object deleted
     * @return boolean success
     */
	public function delete(){

        if (empty($this->id)) {
            //error_log('Can not delete grade object, no id!');
            return false;
        }

        $data = $this->get_record_data();

        if (DB::delete_records($this->table, array('id'=>$this->id))) {
            //$this->notify_changed(true);
            return true;

        } else {
            return false;
        }
	}
	
	/**
     * Using this object's id field, fetches the matching record in the DB, and looks at
     * each variable in turn. If the DB has different data, the DB's data is used to update
     * the object. This is different from the update() function, which acts on the DB record
     * based on the object.
     */
    public function update_from_db() {
        if (empty($this->id)) {
            //error_log("The object could not be used in its state to retrieve a matching record from the DB, because its id field is not set.");
            return false;
        }
 
        if (!$params = DB::get_record($this->table, array('id' => $this->id))) {
            //error_log("Object with this id:{$this->id} does not exist in table:{$this->table}, can not update from DB!");
            return false;
        }

        evalcomix_object::set_properties($this, $params);

        return true;
    }
	
	 /**
     * Given an associated array or object, cycles through each key/variable
     * and assigns the value to the corresponding variable in this object.
     * @static final
     */
	public static function set_properties(&$instance, $params, $clean = 'clean') {
        $params = (array) $params;
        foreach ($params as $var => $value) {
            if (in_array($var, $instance->required_fields) or in_array($var, $instance->optional_fields)) {
				if($clean == 'clean'){
					$instance->$var = addslashes($value);
				}
				else{
					$instance->$var = $value;
				}
            }
        }
    }
	
	 /**
     * Returns object with fields and values that are defined in database
     */
    public function get_record_data() {
        $data = new stdClass();

        foreach ($this as $var=>$value) {
            if (in_array($var, $this->required_fields) or in_array($var, $this->optional_fields)) {
                if (is_object($value) or is_array($value)) {
					return false;
                } else {
                    $data->$var = $value;
                }
            }
        }
        return $data;
    }
	
	/**
     * Factory method - uses the parameters to retrieve matching instance from the DB.
     * @static final protected
     * @return mixed object instance or false if not found
     */
    protected static function fetch_helper($table, $classname, $params) {
        if ($instances = evalcomix_object::fetch_all_helper($table, $classname, $params)) {
            if (count($instances) > 1) {
                // we should not tolerate any errors here - problems might appear later
                //error_log('morethanonerecordinfetch');
				//AÑADIDO 23042012
				return false;
				//FIN AÑADIDO
            }
            return reset($instances);
        } else {
            return false;
        }
    }
	
	 /**
     * Factory method - uses the parameters to retrieve all matching instances from the DB.
     * @static final protected
     * @return mixed array of object instances or false if not found
     */
    public static function fetch_all_helper($table, $classname, $params, $sortfields = array()) {
		
		$instance = new $classname();
		
        $classvars = (array)$instance;
        $params    = (array)$params;

        $wheresql = array();
        $newparams = array();
		
        foreach ($params as $var=>$value) {//echo "var:$var = $value<br>";
            if (!in_array($var, $instance->required_fields) and !in_array($var, $instance->optional_fields)) {
                continue;
            }
            if (is_null($value)) {
                $wheresql[] = " $var IS NULL ";
            } else {
                $wheresql[] = " $var = ? ";
                $newparams[$var] = $value;
            }
        }

        if (empty($wheresql)) {
            $wheresql = '';
        } else {
            $wheresql = implode("AND", $wheresql);
        }

        $rs = DB::get_records($table, $newparams, $sortfields);
        //returning false rather than empty array if nothing found

        $result = array();
        foreach($rs as $data) {
            $instance = new $classname();
            evalcomix_object::set_properties($instance, $data, 'noclean');
            $result[$instance->id] = $instance;
        }

        return $result;
    }
	
	public function exist()
	{
		//Que devuelva el ID del procedimiento
		return $this->id;
	}	
	
}

?>