<?php

require_once 'simpletest/autorun.php';
require_once '../upgrade/evalcomix_dbobject.php';

class EvalcomixDBobjectCase extends UnitTestCase
{
	
    function setUp() {
	}
	
	function testCheckname(){
		$object = new evalcomix_dbobject();
		
		$valids = array('tabla1', 'plantilla', 'block_evalcomix_mode_extra', '123456789', 'tabla-nombre');
		$novalids = array('', 'field1 ', 'tabla/', 'block.evalcomix', 'nombrelargodetablacolumnaocualquierotracosaquedeberiaproducirunerror', 'million$baby');
		
		foreach($valids as $value){
			$result = $object->check_name($value);
			$this->assertTrue($result);	
		}
		
		foreach($novalids as $value){
			$result = $object->check_name($value);
			$this->assertFalse($result);	
		}
	}
	
	function tearDown(){
	}
}

?>