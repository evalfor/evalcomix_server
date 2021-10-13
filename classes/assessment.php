<?php
require_once('evalcomix_object.php');

/**
 * Definitions of EvalCOMIX assessment class
 *
 * @package    evalcomix
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL v2 or later
 */
 class assessment extends evalcomix_object {
	 public $table = 'assessment';
	
	  /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */

    public $required_fields = array('id', 'ass_id', 'ass_pla');
	
	/**
     * Array of optional table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $optional_fields = array('ass_com', 'ass_grd', 'ass_mxg');
	
	
	/**
	* code assessment
	* @var string $ass_id
	*/
	public $ass_id;
	
	/**
	* Foreign key plantilla
	* @var string $ass_pla
	*/
	public $ass_pla;
	
	/**
	* assessment comments
	* @var string $ass_com
	*/
	public $ass_com;
	
	/**
	* Grade
	* @var int $ass_grd
	*/
	public $ass_grd;
	
	/**
	* maxgrade
	* @var int $ass_mxg
	*/
	public $ass_mxg = 100;
	
	
	/**
	* Constructor
	*/
	public function __construct($params = null){
		if (!empty($params) and (is_array($params) or is_object($params))) {
			assessment::check_params($this, $params);
			evalcomix_object::set_properties($this, $params);
		}
	}

	
	private static function check_params($assessment, $params) {
		if(!isset($params['id']) && !isset($params['ass_pla'])){
			throw new InvalidArgumentException('Missing tool id into assessment');
		}
		if(isset($params['ass_grd']) && ($params['ass_grd'] < 0 || $params['ass_grd'] > $assessment->ass_mxg)){
			throw new RangeException('Grade must be between 0 and maxgrade');
		}
	}
	
	
	/**
     * Finds and returns a assessment instance based on params.
     * @static
     *
     * @param array $params associative arrays varname=>value
     * @return object assessment instance or false if none found.
     */
    public static function fetch($params) {
        return evalcomix_object::fetch_helper('assessment', 'assessment', $params);
    }
	
	 /**
     * Finds and returns all assessment instances.
     * @static abstract
     *
     * @return array array of assessment instances or false if none found.
     */
	public static function fetch_all($params = array()){
		return evalcomix_object::fetch_all_helper('assessment', 'assessment', $params);
	}	
	
	/**
     * Called immediately after the object data has been inserted, updated, or
     * deleted in the database. Default does nothing, can be overridden to
     * hook in special behaviour.
     *
     * @param bool $deleted
     */
    function notify_changed($deleted) {
    }
	
	static function duplicate($params){
		require_once('collector_tool.php');
		require_once('plantilla.php');
		require_once('mixtopla.php');
		
		$old_id = $params['oldid'];
		$new_id = $params['newid'];
		$hashtools = $params['hashtools'];
		
		$tool_structure = array();
		$asses = array();
		$tools_merge = array();
		$toolsold = array();
		$toolsnew = array();
		if($assessment_old = assessment::fetch(array('ass_id' => $old_id))){		
			$oldtool = $assessment_old->ass_pla;
			$toolid = $hashtools[$oldtool];
			$params_ass['ass_id'] = $new_id;
			$params_ass['ass_pla'] = $toolid;
			$params_ass['ass_com'] = $assessment_old->ass_com;
			$params_ass['ass_grd'] = $assessment_old->ass_grd;
			$params_ass['ass_mxg'] = $assessment_old->ass_mxg;
			$assessment_new = new assessment($params_ass);
			
			$attributes_code = array();
			$new_attributes_code = array();
			$old_attributes_code = array();
			if(!isset($tool_structure[$toolid])){						
				$type = 'single';
				$plantilla = plantilla::fetch(array('id' => $toolid));
				if($plantilla->pla_tip == 'mixto'){		
					$type = 'composed';
				}
				
				if($type == 'single'){
					$new_attributes_code = assessment::get_attributes_code($toolid);
					$old_attributes_code = assessment::get_attributes_code($oldtool);
				}
				elseif($type == 'composed'){
					$plantillas = mixtopla::fetch_all(array('mip_mix' => $toolid), array('mip_pos'));
					
					$toolsold = array();
					$toolsnew = array();
					$index = 0;
					foreach($plantillas as $mixtopla){
						$aux = assessment::get_attributes_code($mixtopla->mip_pla);
						if(isset($aux['dimension']) && $aux['dimension']!=null){
							foreach($aux['dimension'] as $dimension){
								$new_attributes_code['dimension'][] = $dimension;
							}
						}
						if(isset($aux['subdimension']) && $aux['subdimension']!=null){
							foreach($aux['subdimension'] as $subdimension){
								$new_attributes_code['subdimension'][] = $subdimension;
							}
						}
						if(isset($aux['attribute']) && $aux['attribute']!=null){
							foreach($aux['attribute'] as $attribute){
								$new_attributes_code['attribute'][] = $attribute;
							}
						}
						$index = $mixtopla->mip_pos;
						$toolsnew[$index] = $mixtopla->mip_pla;
					}
					$index = 0;
					$plantillas = mixtopla::fetch_all(array('mip_mix' => $oldtool), array('mip_pos'));
					foreach($plantillas as $mixtopla){ 
						$aux = assessment::get_attributes_code($mixtopla->mip_pla);
						if(isset($aux['dimension']) && $aux['dimension']!=null){
							foreach($aux['dimension'] as $dimension){
								$old_attributes_code['dimension'][] = $dimension;
							}
						}
						if(isset($aux['subdimension']) && $aux['subdimension']!=null){
							foreach($aux['subdimension'] as $subdimension){
								$old_attributes_code['subdimension'][] = $subdimension;
							}
						}
						if(isset($aux['attribute']) && $aux['attribute']!=null){
							foreach($aux['attribute'] as $attribute){
								$old_attributes_code['attribute'][] = $attribute;
							}
						}
						$index = $mixtopla->mip_pos;
						$toolsold[$index] = $mixtopla->mip_pla;
					}
				}
				$attributes_code = array_combine($old_attributes_code['attribute'], $new_attributes_code['attribute']);
				$dimensions_code = array_combine($old_attributes_code['dimension'], $new_attributes_code['dimension']);
				if(!empty($toolsold) && !empty($toolsnew)){
					$toolscombine = array_combine($toolsold, $toolsnew);
					foreach($toolscombine as $key => $value){
						$hashtools[$key] = $value;
					}
				}
				
				$tool_structure[$toolid]['attribute'] = $attributes_code;
				$tool_structure[$toolid]['dimension'] = $dimensions_code;
			}
	
			$ass='';
			if(!$ass_object = assessment::fetch(array('ass_id' => $new_id))){
				$ass = $assessment_new->insert();
			}
			else{
				$ass = $ass_object->id;
			}
			$asses[$ass] = $assessment_old->id;
			require_once('atreva.php');
			require_once('dimeva.php');
			require_once('plaeva.php');
			require_once('atrcomment.php');
			require_once('dimcomment.php');
			$params_attribute['ass_old'] = $assessment_old->id; 
			$params_attribute['ass_new'] = $ass;
			$params_attribute['attributes'] = $tool_structure[$toolid]['attribute'];
			atreva::duplicate($params_attribute);
			
			$params_dimension['ass_old'] = $assessment_old->id;
			$params_dimension['ass_new'] = $ass;
			$params_dimension['dimensions'] = $tool_structure[$toolid]['dimension'];
			dimeva::duplicate($params_dimension);
			
			$params_tool['ass_old'] = $assessment_old->id;
			$params_tool['ass_new'] = $ass;
			$params_tool['hashtools'] = $hashtools;
			plaeva::duplicate($params_tool);		
			atrcomment::duplicate($params_attribute);
			dimcomment::duplicate($params_dimension);
		}//if($row2 = $db->siguiente_fila($rst2))
		
		return $asses;
	}
	
	static function get_attributes_code($toolid){
		$result = array();
		require_once('plantilla.php');
		require_once('dimension.php');
		require_once('subdimension.php');
		require_once('atributo.php');
				
		$i = 0;
		$j = 0;
		$k = 0;
		
		if($plantilla = plantilla::fetch(array('id' => $toolid))){
			$dimensions = dimension::fetch_all(array('dim_pla' => $plantilla->id), array('dim_pos'));
			foreach($dimensions as $dimension){
				$result['dimension'][$k] = $dimension->id;
				++$k;
				$subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id), array('sub_pos'));
				foreach($subdimensions as $subdimension){
					$result['subdimension'][$j] = $subdimension->id;
					++$j;
					$atributos = atributo::fetch_all(array('atr_sub' => $subdimension->id), array('atr_pos'));
					foreach($atributos as $atributo){
						$result['attribute'][$i] = $atributo->id;
						++$i;
					}
				}
			}
		}
		return $result;
	}
 }
