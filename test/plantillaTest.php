<?php

require_once 'simpletest/autorun.php';
require_once '../classes/plantilla.php';

class PlantillaTestCase extends UnitTestCase
{
    var $params_array;
	var $valid_types = array('lista', 'escala', 'rubrica', 'lista+escala', 'diferencial', 'argumentario', 'mixto');
	var $required_fields = array('id', 'pla_tit', 'pla_tip');
	var $optional_fields = array('pla_des', 'pla_por', 'pla_glo');
	var $params_insert = array();
	var $params_noinsert = array();
	var $ids = array();

    function setUp() {
		$params['id'] = 1;
		$params['pla_tit'] = 'Título del PRIMER instrumento';
		$params['pla_tip'] = 'escala';
		$params['pla_glo'] = '1';
		$params['pla_des'] = 'Tiene todos los valores asignados incluido el ID con valores correctos';
		$params['pla_por'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 2;
		$params['pla_tit'] = 'Título del SEGUNDO instrumento';
		$params['pla_tip'] = 'escala';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['pla_cod'] = '123456789';
		$params['pla_tit'] = 'Título del CUARTO instrumento';
		$params['pla_tip'] = 'lista';
		$params['pla_glo'] = '0';
		$params['pla_des'] = 'Todos los valores correcto SIN ID';
		$params['pla_por'] = '50';
		$this->params_array[] = $params;
		$this->params_insert[] = $params;
		unset($params);
		
		$params['pla_cod'] = 'a6a7dfg99d00w98vdf8790009jjdf';
		$params['pla_tit'] = 'Título del QUINTO instrumento. Sólo OBLIGATORIO SIN ID';
		$params['pla_tip'] = 'rubrica';
		$this->params_array[] = $params;
		$this->params_insert[] = $params;
		unset($params);
		
		$params['id'] = 4;
		$params['pla_tit'] = 'Título del SEXTO instrumento';
		$params['pla_tip'] = 'matriz';
		$params['pla_glo'] = '1';
		$params['pla_des'] = 'Tipo incorrecto con ID y todo inicializado';
		$params['pla_por'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 5;
		$params['pla_tit'] = 'Título del SÉPTIMO instrumento';
		$params['pla_tip'] = 'diferencial';
		$params['pla_glo'] = '3';
		$params['pla_des'] = 'pla_glo incorrecto con ID y todo inicializado';
		$params['pla_por'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 6;
		$params['pla_tit'] = 'Título del OCTAVO instrumento';
		$params['pla_tip'] = 'matriz';
		$params['pla_glo'] = '1';
		$params['pla_des'] = 'Tipo incorrecto con ID y todo inicializado';
		$params['pla_por'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 7;
		$params['pla_tit'] = 'Título del NOVENO instrumento';
		$params['pla_tip'] = 'argumentario';
		$params['pla_glo'] = '1';
		$params['pla_des'] = 'Porcentaje incorrecto con ID y todo inicializado';
		$params['pla_por'] = '120';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['id'] = 8;
		$params['pla_tit'] = 'Título del DÉCIMO instrumento';
		$params['pla_tip'] = 'argumentario';
		$params['pla_glo'] = '1';
		$params['pla_des'] = 'Tipo, porcentaje y glo incorrecto con ID y todo inicializado';
		$params['pla_por'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
		
		$params['pla_cod'] = '123456789999999999';
		$params['pla_tit'] = 'Título del UNDÉCIMO instrumento\'<tool>';
		$params['pla_tip'] = 'lista+escala';
		$params['pla_glo'] = '1';
		$params['pla_des'] = 'prueba de <caracteres> extraños como las "comilla\'s" y otros como lista + esçala';
		$params['pla_por'] = '100';
		$this->params_array[] = $params;
		$this->params_insert[] = $params;
		unset($params);
		
		$params['pla_glo'] = '1';
		$params['pla_des'] = 'Solo inicializa los valores opcionales correctamente';
		$params['pla_por'] = '100';
		$this->params_array[] = $params;
		$this->params_noinsert[] = $params;
		unset($params);
    }
	
	function testInsert(){
		foreach($this->params_array as $params){
			$insert = true;
			
			try{
				if(!isset($params['id']) && (!isset($params['pla_tit']) || isset($params['pla_tip']) && !in_array($params['pla_tip'], $this->valid_types))
				|| (isset($params['pla_glo']) && (!is_numeric($params['pla_glo']) || ($params['pla_glo'] != '0' && $params['pla_glo'] != '1')))
				|| (isset($params['pla_por']) && (!is_numeric($params['pla_por']) || $params['pla_por'] < '0' || $params['pla_por'] > '100'))){					
					$this->expectException(new Exception());
					$plantilla = new plantilla($params);
					$insert = false;
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
				
			$tool = new plantilla($params);
			
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
		}
	}
	
	function testFetch(){
		foreach($this->params_insert as $params){
			$paramsnew = $params;
			$paramsnew['pla_tit'] = addslashes($paramsnew['pla_tit']);
			if(isset($paramsnew['pla_des'])){
				$paramsnew['pla_des'] = addslashes($paramsnew['pla_des']);
			}
			$tool_fetch = plantilla::fetch($paramsnew);
			$tool = new plantilla($params);
			
			$this->assertIdentical($tool_fetch->pla_tit, $tool->pla_tit);
			$this->assertIdentical($tool_fetch->pla_tip, $tool->pla_tip);
		}
		
		foreach($this->params_noinsert as $params){
			$this->assertFalse(plantilla::fetch($params));
		}
	}

	function testUpdate(){
		$result = plantilla::fetch_all();
		$i = 0;
		foreach($result as $instance){
			$title = 'Título: Prueba de modificación'.$i;
			$description = 'Descripcion: Prueba de Modificación'.$i;
			$percentage = '15';
			$global_value = '1';
			evalcomix_object::set_properties($instance, array('pla_tit' => $title, 'pla_des' => $description, 'pla_glo' => $global_value, 'pla_por' => $percentage));
			$instance->update();
			$tool = plantilla::fetch(array('id' => $instance->id));
			$this->assertIdentical($tool->pla_tit, $title);
			$this->assertIdentical($tool->pla_des, $description);
			$this->assertIdentical($tool->pla_glo, $global_value);
			$this->assertIdentical($tool->pla_por, $percentage);
			++$i;
		}
	}
	
	function testDelete(){
		foreach($this->ids as $id){
			$tool = new plantilla(array('id' => $id));
			$this->assertTrue($tool->delete());
		}
		
		$tool = new plantilla(array());
		$this->assertFalse($tool->delete());

		$tool = new plantilla(array('id' => '999999999999999999'));
		$this->assertFalse($tool->delete());
	}    
	
	function tearDown(){
		unset($params_array);
		unset($valid_types);
		unset($required_fields);
		unset($optional_fields);
		unset($params_insert);
		unset($params_noinsert);
		unset($ids);
	}
}
?>