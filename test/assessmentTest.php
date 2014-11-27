<?php

require_once 'simpletest/autorun.php';
require_once '../classes/assessment.php';
require_once '../classes/plantilla.php';

class AssessmentTestCase extends UnitTestCase
{
    var $params_array;
	var $required_fields = array('id', 'ass_id', 'ass_pla');
	var $optional_fields = array('ass_com', 'ass_grd', 'ass_mxg');
	var $params_insert = array();
	var $params_noinsert = array();
	var $ids;
	var $plantilla;

    function setUp() {
		$params['pla_cod'] = '123456789';
		$params['pla_tit'] = 'Título del CUARTO instrumento';
		$params['pla_tip'] = 'lista';
		$params['pla_glo'] = '0';
		$params['pla_des'] = 'Todos los valores correcto SIN ID';
		$params['pla_por'] = '50';
		$this->plantilla = new plantilla($params);
		$id = $this->plantilla->insert();
		
		$params['id'] = 1;
		$params['ass_id'] = 'primerAssessment';
		$params['ass_pla'] = $id;
		$params['ass_com'] = 'Todo inicializado correctamente con ID';
		$params['ass_grd'] = '100';
		$params['ass_mxg'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 2;
		$params['ass_id'] = 'segundoAssessment';
		$params['ass_pla'] = $id;
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		
		$params['ass_id'] = 'tercerAssessment';
		$params['ass_pla'] = $id;
		$params['ass_com'] = 'Todo inicializado correctamente sin ID';
		$params['ass_grd'] = '50';
		$params['ass_mxg'] = '100';
		$this->params_array[] = $params;
		$this->params_insert[] = $params;
		unset($params);
		
		$params['ass_id'] = 'cuartoAssessment';
		$params['ass_pla'] = $id;
		$this->params_array[] = $params;
		$this->params_insert[] = $params;
		unset($params);
		
		$params['id'] = 5;
		$params['ass_id'] = 'quintoAssessment';
		$params['ass_pla'] = $id;
		$params['ass_com'] = 'grade > maxgrade con ID';
		$params['ass_grd'] = '150';
		$params['ass_mxg'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 6;
		$params['ass_id'] = 'sextoAssessment';
		$params['ass_pla'] = $id;
		$params['ass_com'] = 'grade < 0 con ID';
		$params['ass_grd'] = '-3';
		$params['ass_mxg'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 7;
		$params['ass_id'] = 'septimoAssessment';
		$params['ass_pla'] = $id;
		$params['ass_com'] = 'grade alfanumérico';
		$params['ass_grd'] = 'abc';
		$params['ass_mxg'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 8;
		$params['ass_id'] = 'octavoAssessment';
		$params['ass_pla'] = 7777777777777777;
		$params['ass_com'] = 'assessment foránea incorrecta';
		$params['ass_grd'] = '75';
		$params['ass_mxg'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['ass_id'] = 'novenoAssessment';
		$params['ass_pla'] = $id;
		$params['ass_com'] = 'todo inicializado correctamente sin maxgrade y sin ID';
		$params['ass_grd'] = '90';
		$this->params_array[] = $params;
		$this->params_insert[] = $params;
		unset($params);
		
		$params['ass_id'] = 'decimoAssessment';
		$params['ass_pla'] = $id;
		$params['ass_com'] = "<todo> inicia'lizadó correctamente sin ID";
		$params['ass_grd'] = '80';
		$this->params_array[] = $params;
		$this->params_insert[] = $params;
		unset($params);
    }
	
	function testInsert(){
		foreach($this->params_array as $params){
			$insert = true;
			
			try{
				if(!isset($params['id']) && !isset($params['ass_pla'])){
					$this->expectException(new InvalidArgumentException('Missing assessment title'));
					$assessment = new assessment($params);
					$insert = false;
				}
				if(isset($params['ass_grd']) && ($params['ass_grd'] < 0 || $params['ass_grd'] > 100)){
					$this->expectException(new RangeException('Grade must be between 0 and maxgrade'));
					$assessment = new assessment($params);
					$insert = false;
				}
				
				$tool = new assessment($params);
				
				if($insert && isset($params['id'])){
					$this->assertFalse(
							$tool->insert(),
							'ID = ' . $params['id']);
				}
				else{
					$id = $tool->insert();
					$this->assertTrue(is_numeric($id));
					$this->ids[] = $id;
				}
			}catch(InvalidArgumentException $e){
				continue;
			}
			catch(RangeException $ex){
				continue;
			}
			catch(Exception $exc){
				continue;
			}
		}
	}
	
	
	function testFetch(){
		foreach($this->params_insert as $params){
			/*$paramsnew = $params;
			$paramsnew['pla_tit'] = addslashes($paramsnew['pla_tit']);
			if(isset($paramsnew['pla_des'])){
				$paramsnew['pla_des'] = addslashes($paramsnew['pla_des']);
			}*/
			$tool_fetch = assessment::fetch($params);
			$tool = new assessment($params);
			
			//$this->assertIdentical($tool_fetch->ass_id, $tool->ass_id);
			//$this->assertIdentical($tool_fetch->ass_pla, $tool->ass_pla);
		}
		
		foreach($this->params_noinsert as $params){
			$this->assertFalse(assessment::fetch($params));
		}
	}

	function testUpdate(){
		$result = assessment::fetch_all();
		$i = 0;
		foreach($result as $instance){
			$grade = '73';
			$description = 'Descripcion: Prueba de Modificacion'.$i;
			evalcomix_object::set_properties($instance, array('ass_grd' => $grade, 'ass_com' => $description));
			$instance->update();
			$tool = assessment::fetch(array('id' => $instance->id));
			$this->assertIdentical($tool->ass_com, $description);
			$this->assertIdentical($tool->ass_grd, $grade);
			++$i;
		}
	}
	
	function testDelete(){
		$result = assessment::fetch_all();
		foreach($result as $tool){
			$this->assertTrue($tool->delete());
		}
		
		$tool = new assessment(array());
		$this->assertFalse($tool->delete());

		$tool = new assessment(array('id' => '999999999999999999'));
		$this->assertFalse($tool->delete());
	}    
	
	function tearDown(){
		unset($params_array);
		unset($required_fields);
		unset($optional_fields);
		unset($params_insert);
		unset($params_noinsert);
		unset($ids);
		$this->plantilla->delete();
		unset($this->plantilla);
	}
}
?>