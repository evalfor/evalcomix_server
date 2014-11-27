<?php

require_once 'simpletest/autorun.php';
require_once '../upgrade/evalcomix_field.php';

class EvalcomixFieldCase extends UnitTestCase
{
	var $fields_params_valid = array();
	var $fields_params_novalid = array();
	
    function setUp() {
		$this->fields_params_valid[] = array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
		$this->fields_params_valid[] = array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => 5);
		$this->fields_params_valid[] = array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '5', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => null);
		$this->fields_params_valid[] = array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => null, 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => null, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => 5);

        $this->fields_params_valid[] = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => null);
		$this->fields_params_valid[] = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255', 'unsigned' => null, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => 'hola a todos');
		$this->fields_params_valid[] = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null);
		
        $this->fields_params_valid[] = array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null);
		$this->fields_params_valid[] = array('name' => 'value', 'type' => EVALCOMIX_TYPE_TEXT, 'precision' => '500', 'unsigned' => null, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => 'campo de texto');
    }
	
	function testConstruct(){
		foreach($this->fields_params_valid as $params){
			$field = new evalcomix_field($params);
			$name = $field->get_name();
			$type = $field->get_type();
			$this->assertNotNull($name);
			$this->assertNotNull($type);
		}
		
		$error1 = false;
		$error2 = false;
		
		try{
			$params = array('name' => 'a', 'type' => '', 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
			$field = new evalcomix_field($params);
		}
		catch(Exception $e){
			$error1 = true;
		}
		
		try{
			$params = array('name' => '', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
			$field = new evalcomix_field($params);
		}
		catch(Exception $e){
			$error2 = true;
		}
		
		$this->assertTrue($error1);	
		$this->assertTrue($error2);	
	}
	
	function testName(){
		$error1 = false;
		$params = array('name' => 'field1', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
		$field = new evalcomix_field($params);
		
		try{
			$field->set_name('');
		}
		catch(Exception $e){
			$error1 = true;
		}
		$this->assertTrue($error1);	
		
		$field->set_name('campo1');
		$name = $field->get_name();	
		$this->assertEqual('campo1', $name);
	}
	
	function testType(){
		$error1 = false;
		
		$params = array('name' => 'a', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10', 'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null);
		$field = new evalcomix_field($params);
		
		try{
			$field->set_type('hola');
		}
		catch(Exception $e){
			$error1 = true;
		}
		$this->assertTrue($error1);	
		
		$field->set_type(EVALCOMIX_TYPE_CHAR);
		$type = $field->get_type();	
		$this->assertEqual(EVALCOMIX_TYPE_CHAR, $type);
	}
	
	function testLength(){
		$params = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null);
		$field = new evalcomix_field($params);
		$field->set_length('33');
		$value = $field->get_length();	
		$this->assertEqual('33', $value);
	}
	
	function testNotnull(){
		$params = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null);
		$field = new evalcomix_field($params);
		$field->set_notnull(EVALCOMIX_NOTNULL);
		$value = $field->get_notnull();	
		$this->assertEqual(EVALCOMIX_NOTNULL, $value);
	}
	
	function testSequence(){
		$params = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null);
		$field = new evalcomix_field($params);
		$field->set_sequence(EVALCOMIX_SEQUENCE);
		$value = $field->get_sequence();	
		$this->assertEqual(EVALCOMIX_SEQUENCE, $value);
	}
	
	function testUnsigned(){
	
	}
	
	function testDefault(){
		$params = array('name' => 'name', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => null, 'unsigned' => null, 'notnull' => null, 'sequence' => null, 'default' => null);
		$field = new evalcomix_field($params);
		$field->set_default('treinta y tres');
		$value = $field->get_default();	
		$this->assertEqual('treinta y tres', $value);
	}
	
	
	function tearDown(){
		unset($this->fields_params_novalid);
		unset($this->fields_params_valid);
	}
}
?>