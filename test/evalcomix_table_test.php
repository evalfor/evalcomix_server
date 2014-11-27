<?php
require_once 'simpletest/autorun.php';
require_once '../upgrade/evalcomix_table.php';
require_once '../upgrade/evalcomix_field.php';
require_once '../classes/db.php';
require_once '../upgrade/lib.php';

class EvalcomixTableCase extends UnitTestCase
{
	var $object;
	var $params_field;
	
    function setUp() {
		$sql = '';
		if(TYPEDB == 'mysql'){
			$sql = "
				CREATE TABLE IF NOT EXISTS simpletest2 (
					columna1 INTEGER(2) AUTO_INCREMENT PRIMARY KEY,
					columna2 INTEGER(5) UNIQUE NOT NULL
				)ENGINE=INNODB;
				
				CREATE TABLE IF NOT EXISTS simpletest1 (
					columna1 INTEGER AUTO_INCREMENT,
					columna2 VARCHAR(33) NOT NULL DEFAULT 'hola mundo',
					columna3 TEXT,
					columna4 ENUM('item1', 'item2', 'item3'),
					columna5 INTEGER(2) NOT NULL,
					columna6 INTEGER(5),
					PRIMARY KEY (columna1, columna2),
					CONSTRAINT fk_columna5 FOREIGN KEY (columna5) REFERENCES simpletest2(columna1),
					FOREIGN KEY (columna6) REFERENCES simpletest2(columna2)
				)ENGINE=INNODB;
				
				CREATE TABLE IF NOT EXISTS simpletest3 (
					cod INTEGER
				)ENGINE=INNODB;
				
				CREATE TABLE IF NOT EXISTS simplemix (
					columna1 INTEGER,
					columna2 INTEGER,
					PRIMARY KEY(columna1, columna2),
					CONSTRAINT fk_mixtopla FOREIGN KEY (columna1) REFERENCES simpletest2(columna1)
				)ENGINE=INNODB;
			";
		}
		elseif(TYPEDB == 'postgresql'){
		
		}
		
		ejecutar($sql);
		
		$this->object = new evalcomix_table();
		$this->params_field[1] = array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
		
		//char - precision - unique
		$this->params_field[2] = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null, 'unique' => true);
		
		//text 
        $this->params_field[3] = array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null);
		
		//text - precision - notnull - sequence - default - unique (text no debería tener default ni sequence)
		$this->params_field[4] = array('name' => 'columna3', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => '200', 'unsigned' => null, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => 'hola mundo', 'unique' => true);
		
		//float - precision - notnull - sequence - default - unique
		$this->params_field[5] = array('name' => 'columna4', 'type' => EVALCOMIX_TYPE_FLOAT, 'precision' => '10,5', 'unsigned' => null, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'unique' => true);
		
		//timestamp - precision - notnull - sequence - default - unique
		$this->params_field[6] = array('name' => 'columna5', 'type' => EVALCOMIX_TYPE_TIMESTAMP, 'precision' => '5', 'unsigned' => null, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => '0', 'unique' => true);
		
		//numeric - precision - notnull - sequence - default - unique
		$this->params_field[7] = array('name' => 'columna6', 'type' => EVALCOMIX_TYPE_NUMERIC, 'precision' => '5,4', 'unsigned' => null, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'unique' => true);
		
		//numeric - precision - default
		$this->params_field[8] = array('name' => 'columna6_1', 'type' => EVALCOMIX_TYPE_NUMERIC, 'precision' => '5,4', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => 'null', 'unique' => false);
		
		//integer - precision - default
		$this->params_field[9] = array('name' => 'columna7', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'default' => '3');
		
		//char - precision - notnull
		$this->params_field[10] = array('name' => 'columna8', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '50', 'notnull' => EVALCOMIX_NOTNULL);
		
		//timestamp
		$this->params_field[11] = array('name' => 'columna9', 'type' => EVALCOMIX_TYPE_TIMESTAMP);
		
		//float - default - unique
		$this->params_field[12] = array('name' => 'columna10', 'type' => EVALCOMIX_TYPE_FLOAT, 'default' => '1');
		
		//int - notnull - sequence - pk
		$this->params_field[13] = array('name' => 'columna11', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'pk' => EVALCOMIX_KEY_PRIMARY);
		
		//int - notnull - sequence - pk - unique
		$this->params_field[14] = array('name' => 'columna12', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'unique' => true, 'pk' => EVALCOMIX_KEY_PRIMARY);
	}
	
	function testFieldExist(){
		$table = new evalcomix_table(array('name' => 'simplemix'));
		$this->assertTrue($table->field_exist('columna1'));
		$this->assertTrue($table->field_exist('columna2'));
		$this->assertFalse($table->field_exist('id'));
	}
	
	function testKeyExist(){
		$table = new evalcomix_table(array('name' => 'simplemix'));
		$this->assertTrue($table->key_exist(array('keytype' => 'pk')));
		$params['keyname'] = 'fk_mixtopla';
		$params['keytype'] = 'fk';
		$this->assertTrue($table->key_exist($params));
		$params['keyname'] = 'fk_erronea';
		$params['keytype'] = 'fk';
		$this->assertFalse($table->key_exist($params));
	}
	
	function testTableExist(){
		$params['tablename'] = 'simpletest1';
		$this->assertTrue($this->object->table_exists($params));
		
		$params['tablename'] = 'simpletest_table_name';
		$this->assertFalse($this->object->table_exists($params));
		
		$error = false;
		try{
			$params['tablename'] = 'simpletest1;"';
			$this->object->table_exists($params);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//-----------------------------
		
		$error = false;
		try{
			$params['tablename'] = '';
			$this->object->table_exists($params);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//-----------------------------
		
		$error = false;
		try{
			$this->object->table_exists();
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//-----------------------------
		
		$this->object->set_name('simpletest1');
		$this->assertTrue($this->object->table_exists());
	}
	
	function testGetType(){
		
	}
	
	
	function testGetFieldsDb(){
		$this->object->set_name('simpletest1');		
		$fields = $this->object->get_fields_db();
		
		$this->assertEqual('columna1', $fields['columna1']->get_name());
		$this->assertEqual('true', $fields['columna1']->get_notnull());
		$this->assertEqual('integer', $fields['columna1']->get_type());
		$this->assertEqual('', $fields['columna1']->get_default());
		$this->assertEqual('true', $fields['columna1']->get_sequence());
		
		$this->assertEqual('columna2', $fields['columna2']->get_name());
		$this->assertEqual('true', $fields['columna2']->get_notnull());
		$this->assertEqual('varchar', $fields['columna2']->get_type());
		$this->assertEqual('33', $fields['columna2']->get_length());
		$this->assertEqual('hola mundo', $fields['columna2']->get_default());
		$this->assertEqual('', $fields['columna2']->get_sequence());
		
		$this->assertEqual('columna3', $fields['columna3']->get_name());
		$this->assertEqual('', $fields['columna3']->get_notnull());
		$this->assertEqual('text', $fields['columna3']->get_type());
		$this->assertEqual('', $fields['columna3']->get_length());
		$this->assertEqual('', $fields['columna3']->get_default());
		$this->assertEqual('', $fields['columna3']->get_sequence());
		
		$this->assertEqual('columna4', $fields['columna4']->get_name());
		$this->assertEqual('', $fields['columna4']->get_notnull());
		$this->assertEqual('text', $fields['columna4']->get_type());
		$this->assertEqual('', $fields['columna4']->get_length());
		$this->assertEqual('', $fields['columna4']->get_default());
		$this->assertEqual('', $fields['columna4']->get_sequence());

		$this->assertEqual('columna5', $fields['columna5']->get_name());
		$this->assertEqual('true', $fields['columna5']->get_notnull());
		$this->assertEqual('integer', $fields['columna5']->get_type());
		$this->assertEqual('', $fields['columna5']->get_default());
		$this->assertEqual('', $fields['columna5']->get_sequence());
		
		$this->assertEqual('columna6', $fields['columna6']->get_name());
		$this->assertEqual('', $fields['columna6']->get_notnull());
		$this->assertEqual('integer', $fields['columna6']->get_type());
		$this->assertEqual('', $fields['columna6']->get_default());
		$this->assertEqual('', $fields['columna6']->get_sequence());
		
		//----------------------
		$error = false;
		try{
			$this->object->set_name('database_name_novalid');
			$this->object->get_fields_db();
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//----------------------
		$error = false;
		try{
			$this->object->set_name('');
			$this->object->get_fields_db();
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
	}
	
	function testGetKeysDb(){
		$this->object->set_name('simpletest1');		
		$keys = $this->object->get_keys_db();
		
		$this->assertEqual('PRIMARY', $keys['PRIMARY']->get_name());
		$this->assertEqual('pk', $keys['PRIMARY']->get_type());
		$this->assertEqual(array('columna1','columna2'), $keys['PRIMARY']->get_fields());
		$this->assertEqual('', $keys['PRIMARY']->get_reftable());
		$this->assertEqual('', $keys['PRIMARY']->get_reffield());
		
		$this->assertEqual('fk_columna5', $keys['fk_columna5']->get_name());
		$this->assertEqual('fk', $keys['fk_columna5']->get_type());
		$this->assertEqual(array('columna5'), $keys['fk_columna5']->get_fields());
		$this->assertEqual('simpletest2', $keys['fk_columna5']->get_reftable());
		$this->assertEqual('columna1', $keys['fk_columna5']->get_reffield());
		
		$this->assertEqual('simpletest1_ibfk_1', $keys['simpletest1_ibfk_1']->get_name());
		$this->assertEqual('fk', $keys['simpletest1_ibfk_1']->get_type());
		$this->assertEqual(array('columna6'), $keys['simpletest1_ibfk_1']->get_fields());
		$this->assertEqual('simpletest2', $keys['simpletest1_ibfk_1']->get_reftable());
		$this->assertEqual('columna2', $keys['simpletest1_ibfk_1']->get_reffield());
		
		//----------------------
		$error = false;
		try{
			$this->object->set_name('database_name_novalid');
			$this->object->get_fields_db();
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//----------------------
		$error = false;
		try{
			$this->object->set_name('');
			$this->object->get_fields_db();
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
	}
	
	
	function testGetFieldSql(){
		$fields = array();
		foreach($this->params_field as $key => $value){
			$fields[$key] = new evalcomix_field($value);
		}
		
		if(TYPEDB == 'mysql'){
			$sql = $this->object->get_sqlfield($fields[1]);
			$this->assertEqual('id integer(10) AUTO_INCREMENT', trim($sql));
		}		
        if(TYPEDB == 'postgresql'){
			throw new Exception('Hay que programar esto para POSTGRESQL');
		}
		
		$sql = $this->object->get_sqlfield($fields[2]);
		$this->assertEqual('name varchar(255) UNIQUE', trim($sql));
		
		$sql = $this->object->get_sqlfield($fields[3]);
		$this->assertEqual('value text', trim($sql));
		
		$sql = $this->object->get_sqlfield($fields[4]);
		$this->assertEqual("columna3 text UNIQUE NOT NULL", trim($sql));
			
		$sql = $this->object->get_sqlfield($fields[5]);
		$this->assertEqual("columna4 float(10,5) UNIQUE NOT NULL", trim($sql));
			
		$sql = $this->object->get_sqlfield($fields[6]);
		$this->assertEqual("columna5 timestamp(5) UNIQUE NOT NULL DEFAULT 0", trim($sql));
		
		$sql = $this->object->get_sqlfield($fields[7]);
		$this->assertEqual("columna6 numeric(5,4) UNIQUE NOT NULL", trim($sql));
		
		$sql = $this->object->get_sqlfield($fields[8]);
		$this->assertEqual("columna6_1 numeric(5,4) DEFAULT null", trim($sql));
		
		$sql = $this->object->get_sqlfield($fields[9]);
		$this->assertEqual("columna7 integer(10) DEFAULT 3", trim($sql));
			
		$sql = $this->object->get_sqlfield($fields[10]);
		$this->assertEqual("columna8 varchar(50) NOT NULL", trim($sql));
			
		$sql = $this->object->get_sqlfield($fields[11]);
		$this->assertEqual("columna9 timestamp", trim($sql));
			
		$sql = $this->object->get_sqlfield($fields[12]);
		$this->assertEqual("columna10 float DEFAULT 1", trim($sql));
		
		$sql = $this->object->get_sqlfield($fields[13]);
		$this->assertEqual("columna11 integer AUTO_INCREMENT PRIMARY KEY", trim($sql));
		
		$sql = $this->object->get_sqlfield($fields[14]);
		$this->assertEqual("columna12 integer AUTO_INCREMENT PRIMARY KEY", trim($sql));
	}
	
	function testGetKeySql(){
		$key1 = new evalcomix_key(array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY));
		$key2 = new evalcomix_key(array('name' => 'pk_id', 'fields' => array('columna1', 'columna2'), 'type' => EVALCOMIX_KEY_PRIMARY));
		$key3 = new evalcomix_key(array('name' => 'fk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1'));
		$key4 = new evalcomix_key(array('name' => 'fk_id', 'fields' => array('id', 'columna1'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1'));
		$key5 = new evalcomix_key(array('name' => 'fk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reffield' => 'columna1'));
		$key6 = new evalcomix_key(array('name' => 'fk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN));
		$key7 = new evalcomix_key(array('name' => 'fk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2'));
		$key8 = new evalcomix_key(array('name' => 'pk_id', 'type' => EVALCOMIX_KEY_PRIMARY));
		$key9 = new evalcomix_key(array('fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1'));
		
		if(TYPEDB == 'mysql'){
			$sql = $this->object->get_sqlkey($key1);
			$this->assertEqual('PRIMARY KEY(id)', trim($sql));
		}		
        if(TYPEDB == 'postgresql'){
			throw new Exception('Hay que programar esto para POSTGRESQL');
		}
		
		$sql = $this->object->get_sqlkey($key2);
		$this->assertEqual('PRIMARY KEY(columna1,columna2)', trim($sql));
			
		$sql = $this->object->get_sqlkey($key3);
		$this->assertEqual('CONSTRAINT fk_id FOREIGN KEY (id) REFERENCES simpletest2(columna1) ON DELETE CASCADE', trim($sql));
		
		$sql = $this->object->get_sqlkey($key9);
		$this->assertEqual('FOREIGN KEY (id) REFERENCES simpletest2(columna1) ON DELETE CASCADE', trim($sql));
		
		//----------------------
		$error = false;
		try{
			$sql = $this->object->get_sqlkey($key4);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//----------------------
		$error = false;
		try{
			$sql = $this->object->get_sqlkey($key5);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//----------------------
		$error = false;
		try{
			$sql = $this->object->get_sqlkey($key6);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//----------------------
		$error = false;
		try{
			$sql = $this->object->get_sqlkey($key7);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//----------------------
		$error = false;
		try{
			$sql = $this->object->get_sqlkey($key8);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
	}
	
	function testAddField(){
		//Add new fields to new table object
		$table = new evalcomix_table(array('name' => 'new'));
		$fields = array();
		foreach($this->params_field as $key => $value){
			$name = $value['name'];
			$table->add_field($value);
			$fields = $table->get_fields();
			$newfield = new evalcomix_field($value);
			$this->assertEqual($fields[$name], $newfield);
		}
		
		unset($this->params_field[13]);
		unset($this->params_field[14]);
		//Add new field to existing table object
		$table = new evalcomix_table(array('name' => 'simpletest2'));
		foreach($this->params_field as $key => $value){
			$name = $value['name'];
			if($name == 'id' || $name == 'columna3'){
				continue;
			}
			$table->add_field($value);
			$fields = $table->get_fields();
			$newfield = new evalcomix_field($value);
			$this->assertEqual($fields[$name], $newfield);
		}

		
		//Errors:
		//----------------------------------
		//Add new field with duplicated name
		$error = false;
		try{
			$params = array('name' => 'columna1', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
			$table->add_field($params);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//----------------------------------
		
		//Add new field with wrong name
		$error = false;
		try{
			$params = array('name' => 'columna/1', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
			$table->add_field($params);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//----------------------------------
		
		//Add new field without name
		$error = false;
		try{
			$params = array('name' => '', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
			$table->add_field($params);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//----------------------------------
		
		//Add new field without type
		$error = false;
		try{
			$params = array('name' => 'columna13', 'type' => EVALCOMIX_TYPE_INCORRECT, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'default' => null);
			$table->add_field($params);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//----------------------------------
	}
	
	function testAddKey(){
		//Add primary key to new table object with name
		$table = new evalcomix_table(array('name' => 'simpletest4'));
		$table->add_field($this->params_field[1]);
		$params = array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY);
		$table->add_key($params);        
		$keys = $table->get_keys();
		$newkey = new evalcomix_key($params);
		foreach($keys as $key){
			$this->assertEqual($key, $newkey);
		}
		
		//Add primary key to new table object without name
		$table = new evalcomix_table();
		$table->add_field($this->params_field[1]);
		$params = array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY);
		$table->add_key($params);        
		$keys = $table->get_keys();
		$newkey = new evalcomix_key($params);
		foreach($keys as $key){
			$this->assertEqual($key, $newkey);
		}
		
		//Add foreign key to new table object with name
		unset($table);
		$table = new evalcomix_table(array('name' => 'simpletest4'));
		$table->add_field($this->params_field[1]);
		$params = array('name' => 'fk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1');
		$table->add_key($params);        
		$keys = $table->get_keys();
		$newkey = new evalcomix_key($params);
		foreach($keys as $key){
			$this->assertEqual($key, $newkey);
		}
		
		//Add foreign key to new table object without name
		unset($table);
		$table = new evalcomix_table();
		$table->add_field($this->params_field[1]);
		$params = array('fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1');
		$table->add_key($params);        
		$keys = $table->get_keys();
		$newkey = new evalcomix_key($params);
		foreach($keys as $key){
			$this->assertEqual($key, $newkey);
		}
		
		//Add primary key to existing table object
		$table2 = new evalcomix_table(array('name' => 'simpletest3'));
		$params = array('name' => 'pk_id', 'fields' => array('cod'), 'type' => EVALCOMIX_KEY_PRIMARY);
		$table2->add_key($params);        
		$keys = $table2->get_keys();
		$newkey = new evalcomix_key($params);
		foreach($keys as $key){
			$this->assertEqual($key, $newkey);
		}
		$table2->delete_key('pk_id');
		$table2->add_field(array('name' => 'cod2', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL));
		$table2->add_key(array('name' => 'pk_id', 'fields' => array('cod2'), 'type' => EVALCOMIX_KEY_PRIMARY));    
		$newfield = new evalcomix_field(array('name' => 'cod2', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE));
		$table2->rename_field(array('oldname' => 'cod2', 'newfield' => $newfield));
		
		//Add foreign key to existing table object with name
		$table1 = new evalcomix_table(array('name' => 'simpletest3'));
		$table1->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'default' => null));
		$params = array('name' => 'fk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1');
		$table1->add_key($params);
		$keys = $table1->get_keys();
		$newkey = new evalcomix_key($params);
		foreach($keys as $key){
			$type = $key->get_type();
			if($type == 'fk'){
				$this->assertEqual($key, $newkey);
			}
		}
		
		//TODO: Add foreign key to existing table object without name
		
		//Errors:
		//Add duplicated primary key 
		$table2 = new evalcomix_table(array('name' => 'simpletest3'));
		$error = false;
		try{
			$params = array('name' => 'pk_id', 'fields' => array('cod2'), 'type' => EVALCOMIX_KEY_PRIMARY);
			$table2->add_key($params);        
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		//----------------------------------
		
		
		//Add duplicated foreign key
		$table1 = new evalcomix_table(array('name' => 'simpletest3'));
		$error = false;
		try{
			$table1 = new evalcomix_table(array('name' => 'simpletest3'));
			$params = array('name' => 'fk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1');
			$table1->add_key($params);
			$table1->add_key($params);
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
	}
	
	function testCreateTable(){
		//utilizando los atributos propios de evalcomix_table -> tablename y fields
        $table = new evalcomix_table(array('name' => 'simpletest4'));
        $table->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'default' => null));
        $table->add_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $table->add_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
		$table->create_table();
		$this->assertTrue($table->table_exists(array('tablename' => 'simpletest4')));
		$table->delete_table(array('tablename' => 'simpletest4'));
		
		//utilizando los atributos propios de evalcomix_table -> tablename, fields y keys
		$table = new evalcomix_table(array('name' => 'simpletest4'));
        $table->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '2', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null));
        $table->add_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '5', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $table->add_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $table->add_key(array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY));       
		$params = array('fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1');
		$table->add_key($params);        
		$params = array('fields' => array('name'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna2');
		$table->add_key($params);        
		$table->create_table();
		$this->assertTrue($table->table_exists(array('tablename' => 'simpletest4')));
		$table->delete_table(array('tablename' => 'simpletest4'));
		
		//pasándole parámetros - tablename y fields
		$table = new evalcomix_table();
		unset($params);
        $params['fields'][] = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'default' => null));
        $params['fields'][] = new evalcomix_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $params['fields'][] = new evalcomix_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
		$params['tablename'] = 'simpletest4';
		$table->create_table($params);
		$this->assertTrue($table->table_exists(array('tablename' => 'simpletest4')));
		$table->delete_table(array('tablename' => 'simpletest4'));
		
		//pasándole parámetros - tablename, fields y keys
		$table = new evalcomix_table();
		unset($params);
		$params['tablename'] = 'simpletest4';
		$params['fields'][] = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '2', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null));
        $params['fields'][] = new evalcomix_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '5', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $params['fields'][] = new evalcomix_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $params['keys'][] = new evalcomix_key(array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY));       
		$params['keys'][] = new evalcomix_key(array('fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1'));
		$params['keys'][] = new evalcomix_key(array('fields' => array('name'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna2'));
		$table->create_table($params);
		$this->assertTrue($table->table_exists(array('tablename' => 'simpletest4')));
		$table->delete_table(array('tablename' => 'simpletest4'));
		
		//TODO: combinado
		$table = new evalcomix_table(array('name' => 'simpletest4'));
		unset($params);
		$params['fields'][] = new evalcomix_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '2', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null));
        $params['fields'][] = new evalcomix_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '5', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $params['fields'][] = new evalcomix_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $params['keys'][] = new evalcomix_key(array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY));       
		$params['keys'][] = new evalcomix_key(array('fields' => array('id'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna1'));
		$params['keys'][] = new evalcomix_key(array('fields' => array('name'), 'type' => EVALCOMIX_KEY_FOREIGN, 'reftable' => 'simpletest2', 'reffield' => 'columna2'));
		$table->create_table($params);
		$this->assertTrue($table->table_exists(array('tablename' => 'simpletest4')));
		$table->delete_table(array('tablename' => 'simpletest4'));
		
		//Errores
		//Sin tablename - Exception
		$table = new evalcomix_table();
        $table->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'default' => null));
        $table->add_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $table->add_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
		$error = false;
		try{
			$table->create_table();
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//Sin fields - Exception		
		$table = new evalcomix_table(array('name' => 'simpletest4'));
		$error = false;
		try{
			$table->create_table();
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		$table = new evalcomix_table(array('name' => 'simpletest1'));
        $table->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'default' => null));
        $table->add_field(array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
        $table->add_field(array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null));
		$table->create_table();
	}
	
	function testRenameField(){
		//Pasar correctamente los campos
		$newfield = new evalcomix_field(array('name' => 'columna32', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'notnull' => EVALCOMIX_NOTNULL, 'default' => null));
		$table = new evalcomix_table(array('name' => 'simpletest1'));
		$this->assertTrue($table->rename_field(array('oldname' => 'columna3', 'newfield' => $newfield)));
		$fields = $table->get_fields();
		$this->assertTrue(isset($fields['columna32']));
		
		$newfield = new evalcomix_field(array('name' => 'columna3', 'type' => EVALCOMIX_TYPE_TEXT));
		$table = new evalcomix_table(array('name' => 'simpletest1'));
		$this->assertTrue($table->rename_field(array('oldname' => 'columna32', 'newfield' => $newfield)));
		$fields = $table->get_fields();
		$this->assertTrue(isset($fields['columna3']));
		
		$newfield = new evalcomix_field(array('name' => 'columna3', 'type' => EVALCOMIX_TYPE_BOOL, 'default' => 'false'));
		$table = new evalcomix_table(array('name' => 'simpletest1'));
		$this->assertTrue($table->rename_field(array('oldname' => 'columna3', 'newfield' => $newfield)));
		$fields = $table->get_fields();
		$this->assertTrue(isset($fields['columna3']));
		
		$newfield = new evalcomix_field(array('name' => 'columna3', 'type' => EVALCOMIX_TYPE_TEXT));
		$table = new evalcomix_table(array('name' => 'simpletest1'));
		$this->assertTrue($table->rename_field(array('oldname' => 'columna3', 'newfield' => $newfield)));
		$fields = $table->get_fields();
		$this->assertTrue(isset($fields['columna3']));
		
		//Errores:
		//Sin oldname
		$error = false;
		try{
			$newfield = new evalcomix_field(array('name' => 'columna3', 'type' => EVALCOMIX_TYPE_TEXT));
			$table = new evalcomix_table(array('name' => 'simpletest1'));
			$table->rename_field(array('newfield' => $newfield));
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//Sin newfield
		$error = false;
		try{
			$newfield = new evalcomix_field(array('name' => 'columna3', 'type' => EVALCOMIX_TYPE_TEXT));
			$table = new evalcomix_table(array('name' => 'simpletest1'));
			$table->rename_field(array('oldname' => 'columna3'));
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//Oldname incorrecto
		$error = false;
		try{
			$newfield = new evalcomix_field(array('name' => 'columna3', 'type' => EVALCOMIX_TYPE_TEXT));
			$table = new evalcomix_table(array('name' => 'simpletest1'));
			$this->assertTrue($table->rename_field(array('oldname' => 'columna44', 'newfield' => $newfield)));
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//newfield de tipo distinto a evalcomix_field
		$error = false;
		try{
			$newfield = 'columna3';
			$table = new evalcomix_table(array('name' => 'simpletest1'));
			$this->assertTrue($table->rename_field(array('oldname' => 'columna32', 'newfield' => $newfield)));
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
	}
	
	function testRenameTable(){
		//Renombrar tabla objeto
		$table = new evalcomix_table(array('name' => 'simpletest3'));
		$this->assertTrue($table->rename_table(array('simpletest3' => 'test3')));
		$tablename = $table->get_name();
		$this->assertEqual($tablename, 'test3');
		
		$table = new evalcomix_table(array('name' => 'test3'));
		$this->assertTrue($table->rename_table(array('test3' => 'simpletest3')));
		$tablename = $table->get_name();
		$this->assertEqual($tablename, 'simpletest3');
		
		//Renombrar varias tablas, entre ellas la tabla objeto
		$table = new evalcomix_table(array('name' => 'simpletest3'));
		$this->assertTrue($table->rename_table(array('simpletest3' => 'test3', 'simpletest1' => 'test1')));
		$tablename = $table->get_name();
		$this->assertEqual($tablename, 'test3');
		
		$table = new evalcomix_table(array('name' => 'test3'));
		$this->assertTrue($table->rename_table(array('test3' => 'simpletest3', 'test1' => 'simpletest1')));
		$tablename = $table->get_name();
		$this->assertEqual($tablename, 'simpletest3');
		
		//Renombrar tabla distinta a la tabla objeto
		$table = new evalcomix_table(array('name' => 'simpletest3'));
		$this->assertTrue($table->rename_table(array('simpletest1' => 'test1')));
		
		$table = new evalcomix_table(array('name' => 'simpletest3'));
		$this->assertTrue($table->rename_table(array('test1' => 'simpletest1')));
		
		//Renombrar varias tablas todas distintas a la tabla objeto
		$table = new evalcomix_table();
		$this->assertTrue($table->rename_table(array('simpletest1' => 'test1', 'simpletest2' => 'test2')));
		
		$table = new evalcomix_table();
		$this->assertTrue($table->rename_table(array('test1' => 'simpletest1', 'test2' => 'simpletest2')));
		
		//Errores
		//Parámetros de tipo erróneo
		$error = false;
		try{
			$table = new evalcomix_table();
			$table->rename_table('simpletest1');
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		$error = false;
		try{
			$table = new evalcomix_table();
			$this->assertTrue($table->rename_table(array('noexiste' => 'simpletest1')));
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
	}
	
	function testDeleteField(){
		//Borramos campo sin clave
		$table = new evalcomix_table(array('name' => 'simpletest1'));
		$table->delete_field('columna3');
		$table->delete_field('columna4');
		
		//Boramos campo con PK
		$table->delete_field('columna1');
		
		$error = false;
		$fields = $table->get_fields();
		if(isset($fields['columna3']) || isset($fields['columna4']) || isset($fields['columna1'])){
			$error = true;
		}
		$this->assertFalse($error);
		
		//Errores
		//Borramos campos inexistente
		$error = false;
		try{
			$table->delete_field('columna4444');
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
		//Borramos campo con FK
		$error = false;
		try{
			$table->delete_field('columna5');
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
	}
	
	function testDeleteKey(){
		$table = new evalcomix_table(array('name' => 'simpletest1'));
		//FK
		$table->delete_key('fk_columna5');
		$table->delete_key('simpletest1_ibfk_1');
		//PK
		$newfield = new evalcomix_field(array('name' => 'columna1', 'type' => EVALCOMIX_TYPE_INTEGER, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => null));
		$table->rename_field(array('oldname' => 'columna1', 'newfield' => $newfield));
		$table->delete_key('PRIMARY');
		
		$table = new evalcomix_table(array('name' => 'simplemix'));
		$table->delete_key('PRIMARY');
		
		//Borramos key inexistente
		$error = false;
		try{
			$table->delete_key('key55555');
		}
		catch(Exception $e){
			$error = true;
		}
		$this->assertTrue($error);
		
	}
	
	function testDeleteTable(){
	
	}
	
	function testCheckSize(){
		
	}
	
	function testDeleteFk(){
		$table = new evalcomix_table();
		$tables = array('simpletest1', 'simpletest3');
		$this->assertTrue($table->delete_fk($tables));
		
		$simpletest1 = new evalcomix_table(array('name' => 'simpletest1'));
		$keys = $simpletest1->get_keys();
		foreach($keys as $key){
			$type = $key->get_type();
			$this->assertEqual($type, 'pk');
		}
		
		$simpletest3 = new evalcomix_table(array('name' => 'simpletest3'));
		$keys = $simpletest1->get_keys();
		foreach($keys as $key){
			$type = $key->get_type();
			$this->assertEqual($type, 'pk');
		}
	}
	
	function droptables(){
		$table = new evalcomix_table();
		$table->delete_table(array('tablename' => 'simpletest1'));
		$table->delete_table(array('tablename' => 'simpletest3'));
		$table->delete_table(array('tablename' => 'simplemix'));
		$table->delete_table(array('tablename' => 'simpletest2'));
	}
	
	function tearDown(){
		$this->droptables();
	}
	
}

?>