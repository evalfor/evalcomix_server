<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class api_controller {
	public static function check_action() {
		if (!self::check_request()) {
			return 401;
		}
		$result = true;
		$message = '';
		if (!install_controller::tempdir_is_writable()) {
			$result = false;
			$message .= get_string('tempdirisnotwritable');
		} 
		$checkconfigfile = install_controller::check_configfile_action();
		if ($checkconfigfile === DIRROOT_IS_NOT_CONFIGURED_PROPERLY) {
			$result = false;
			$message .= '#DIRROOT is not configured properly, directory does not exist or is not accessible! Exiting.';
		} else if ($checkconfigfile === WWWROOT_IS_NOT_CONFIGURED_PROPERLY) {
			$result = false;
			$message .= '#WWWROOT is not configured properly! Exiting.';
		} else if ($checkconfigfile === true) {
			$checkinstall = install_controller::test_install_action();
			if ($checkinstall !== true) {
				$result = false;
				$message .= '#' . $checkinstall;
			}
		}
		
		if ($result === true) {
			$message = 'System Checked Successment';
		}
		
		$output = render::render_template('src/api/api_check_view.php', array('result' => $result, 'message' => $message));			
		return new Response($output);
	}
	
	public static function get_grade($assessmentid) {
		if (!self::check_request()) {
			return 401;
		}
		
		if (empty($assessmentid)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/assessment.php');
		if(!$assessment = assessment::fetch(array('ass_id' => $assessmentid))){
			return null;
		} 
		
		$output = render::render_template('src/api/api_get_grade_view.php', array('assessment' => $assessment));		
		return new Response($output);
	}
	
	public static function client_view_tool($id) {
		if (!self::check_request()) {
			return 401;
		}
		$request = Request::createFromGlobals();
		$title = $request->query->get('title');
		
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/exporter.php');
		require_once(DIRROOT . '/client/tool.php');
		
		if (!$plantilla = plantilla::fetch(array('pla_cod' => $id))) {
			return null;
		}
		$format = 'xml';
		$params = array('tool_id' => $plantilla->id, 'format' => $format);
		$exporter = new exporter($params, $format);
		$xml = $exporter->export(null);
		$xmlobject = simplexml_load_string($xml);
		$language = $_SESSION['lang'];
		$tool = new tool($language,'','','','','','','','','','','','','','','','','','','','');
		$tool->import($xmlobject);
		
		if($plantilla->pla_tip == 'mixto'){		
			$tool->view_tool_mixed(WWWROOT, '', $title);
		}
		else{
			$tool->view_tool(WWWROOT, '', 'view', $title);
		}
		
		$output = '';		
		return new Response($output);
	}
	
	public static function client_view_assessment($id) {
		$request = Request::createFromGlobals();
		$title = $request->query->get('title');
		
		require_once(DIRROOT . '/classes/assessment.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/exporter.php');
		require_once(DIRROOT . '/client/tool.php');
		
		if (!$assessment = assessment::fetch(array('ass_id' => $id))) {
			return null;
		}
		if (!$plantilla = plantilla::fetch(array('id' => $assessment->ass_pla))) {
			return null;
		}
		$format = 'xml';
		$params = array('tool_id' => $plantilla->id, 'assessment' => $assessment, 'format' => $format);
		$exporter = new exporter($params, $format);
		$xml = $exporter->export(null);
		$xmlobject = simplexml_load_string($xml);
		$language = $_SESSION['lang'];
		$tool = new tool($language,'','','','','','','','','','','','','','','','','','','','');
		$tool->import($xmlobject);
		
		$grade = $assessment->ass_grd . '/' . $assessment->ass_mxg;
		if($plantilla->pla_tip == 'mixto'){		
			$tool->view_tool_mixed(WWWROOT, $grade, $title);
		}
		else{
			$tool->view_tool(WWWROOT, $grade, 'view', $title);
		}
		
		$output = '';		
		return new Response($output);
	}
	
	public static function client_assessment($assessmentid, $toolid) {
		if (!self::check_request()) {
			return 401;
		}
		
		$request = Request::createFromGlobals();
		$title = $request->query->get('title');
		$saved = $request->query->get('saved');
		
		require_once(DIRROOT . '/classes/assessment.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/mixtopla.php');
		require_once(DIRROOT . '/classes/exporter.php');
		require_once(DIRROOT . '/client/tool.php');
		require_once(DIRROOT . '/lib/finalgrade.php');
		
		if (!$toolfetch = plantilla::fetch(array('pla_cod' => $toolid))) {
			return null;
		}
		if (!$assessment = assessment::fetch(array('ass_id' => $assessmentid))) {
			$params['ass_id'] = $assessmentid;
			$params['ass_pla'] = $toolfetch->id;
			$assessment = new assessment($params);
			$assessment->insert();
		}
		
		if($assessment->ass_pla != $toolfetch->id){
			assessment::set_properties($assessment, array('ass_pla' => $toolfetch->id));
			$assessment->update();
		}
		
		$format = 'xml';
		$params = array('tool_id' => $toolfetch->id, 'assessment' => $assessment, 'format' => $format);
		$exporter = new exporter($params, $format);
		$xml = $exporter->export(null);
		$xmlobject = simplexml_load_string($xml);
		$language = $_SESSION['lang'];
		$tool = new tool($language,'','','','','','','','','','','','','','','','','','','','');
		$tool->import($xmlobject);
		$grade = $assessment->ass_grd . '/' . $assessment->ass_mxg;
		if($plantillas = mixtopla::fetch_all(array('mip_mix' => $toolfetch->id))){
			$assid = $assessment->id;
			foreach($plantillas as $item){	
				$objectplantilla = plantilla::fetch(array('id' => $item->mip_pla));
				$placod = $objectplantilla->pla_cod;
				
				$params = array('tool_id' => $objectplantilla->id, 'assessment' => $assessment, 'format' => $format);
				$exporter = new exporter($params, $format);
				$xml = $exporter->export(null);
				$xml = simplexml_load_string($xml);
				
				$toolaux = new tool($language,'','','','','','','','','','','','','','','','','','','','');
				$toolaux->import($xml);
				$id = $objectplantilla->id;
				$tools[$id] = $toolaux;
				
			}
			
			$finalgrade = finalgrade($assid, $toolfetch->id);
			$gradexp = explode('/', $finalgrade);
			$params['ass_grd'] = $gradexp[0];
			$params['ass_mxg'] = $gradexp[1];
			//$params['ass_com'] = '';
			assessment::set_properties($assessment, $params);
			$assessment->update();
			
			$tool->assessment_tool_mixed(WWWROOT, $assid, $toolfetch->id, $finalgrade, $saved, $tools, $title);
		}
		else{
			$tool->assessment_tool(WWWROOT, $assessment->id, $toolfetch->id, $grade, $saved, $title);
		}
		
		$output = '';		
		return new Response($output);
	}
	
	public static function get_tools($xmldatas = '') {
		if (!self::check_request()) {
			return 401;
		}
		
		if (empty($xmldatas)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/cleanxml.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/exporter.php');
		
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xmldatas);
		if ($xml) {
			$xml = cleanxml($xml);
		} else {
			return null;
		}
		
		$format = 'xml';
		$datas = array();
		foreach($xml as $tool){
			$placod = (string)$tool;
			if (!$toolfetch = plantilla::fetch(array('pla_cod' => $placod))) {
				continue;
			}
			$params = array('tool_id' => $toolfetch->id, 'format' => $format);
			$exporter = new exporter($params, $format);
			$datas[$placod] = new stdClass();
			$datas[$placod]->toolfetch = $toolfetch;
			$datas[$placod]->xml = $exporter->export(null, null);
		}
		
		$output = render::render_template('src/api/api_get_tools_view.php', array('datas' => $datas));		
		return new Response($output);
	}
	
	public static function get_tool($toolid = '') {
		if (!self::check_request()) {
			return 401;
		}
		if (empty($toolid)) {
			return null;
		}

		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/exporter.php');
		
		$success = false;
		$message = '';
		if ($tool = plantilla::fetch(array('pla_cod' => $toolid))) {
			$params['tool_id'] = $tool->id;
			$format = 'xml';
			$result = new exporter($params, $format);
			$output = $result->export(null);
			$success = true;
		} else {
			return null;
		}
		
		return new Response($output);
	}
	
	public static function delete_tool($toolid = null) {
		if (!self::check_request()) {
			return 401;
		}
		if (empty($toolid)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/plantilla.php');
		$success = false;
		$message = 'Parameters wrong';
		if ($tool = plantilla::fetch(array('pla_cod' => $toolid))) {
			$tool->delete();
			$success = true;
			$message = 'Tool deleted successfully';
		} else {
			return null;
		}
		
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function import_tool($xmldatas = '', $newid = null) {
		if (empty($xmldatas) or empty($newid)) {
			return null;
		}
		require_once(DIRROOT . '/classes/cleanxml.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/client/tool.php');
		
		$success = false;
		$message = '';
		
		if ($t = plantilla::fetch(array('pla_cod' => $newid))) {
			$message = $newid . ' already exists';
		} else {	
			$xml = simplexml_load_string($xmldatas);
			$xml = cleanxml($xml);

			$tool = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
			$tool->import($xml);
					
			try{
				$resultparams = $tool->save($newid);
				$result = $resultparams['xml'];
				$success = true;
				$message .= $result; 
			}
			catch(Exception $e){
				$message .= $newid . ' cannot be imported';
			}
		}
		
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function tool_modified($xmldatas) {
		if (empty($xmldatas)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/cleanxml.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/exporter.php');
		
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xmldatas);
		if ($xml) {
			$xml = cleanxml($xml);
		} else {
			return null;
		}
		$success = false;
		$message = '';
		
		foreach($xml as $toolid){
			$placod = (string)$toolid['id'];
			if (!$toolfetch = plantilla::fetch(array('pla_cod' => $placod))) {
				continue;
			}
			$success = true;
			$message = 'Tool modified successfully';
			if($toolfetch->pla_mod != '0'){
				$toolfetch->pla_mod = '0';
				$plaglo = '0';
				if(!empty($toolfetch->pla_glo)){
					$plaglo = (string)$toolfetch->pla_glo;
				}
				$toolfetch->pla_glo = $plaglo;
				$toolfetch->update();
			}
		}
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function get_assessments($xmldatas = '') {
		if (empty($xmldatas)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/cleanxml.php');
		require_once(DIRROOT . '/classes/assessment.php');
		require_once(DIRROOT . '/classes/exporter.php');
		
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xmldatas);
		if ($xml) {
			$xml = cleanxml($xml);
		} else {
			return null;
		}
		
		$format = 'xml';
		$datas = array();
		foreach($xml as $assessmentid){
			$assid = (string)$assessmentid;
			if (!$assessmentfetch = assessment::fetch(array('ass_id' => $assid))) {
				continue;
			}
			$params = array('tool_id' => $assessmentfetch->ass_pla, 'assessment' => $assessmentfetch, 'format' => $format);
			$exporter = new exporter($params, $format);
			$datas[$assid] = new stdClass();
			$datas[$assid]->assessmentfetch = $assessmentfetch;
			$datas[$assid]->xml = $exporter->export(null);
		}
		
		$output = render::render_template('src/api/api_get_assessments_view.php', array('datas' => $datas));		
		return new Response($output);
	}
	
	public static function get_modified_tool_grades($xmldatas = '') {
		if (!self::check_request()) {
			return 401;
		}
		
		if (empty($xmldatas)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/cleanxml.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/assessment.php');
		
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xmldatas);
		if ($xml) {
			$xml = cleanxml($xml);
		} else {
			return null;
		}
		
		$format = 'xml';
		$success = false;
		$message = 'No valid identifier received';
		$datas = '<assessments>';
		foreach($xml as $toolid){
			$placod = (string)$toolid;
			if ($toolfetch = plantilla::fetch(array('pla_cod' => $placod, 'pla_mod' => '1'))) {
				$success = true;
				if ($assessmentfetch = assessment::fetch_all(array('ass_pla' => $toolfetch->id))) {
					foreach($assessmentfetch as $assessment){
						$datas.= '<assessment id="'.$assessment->ass_id.'">
							<grade>'.$assessment->ass_grd.'</grade>
							<maxgrade>'.$assessment->ass_mxg.'</maxgrade>
							<toolid>'.$toolfetch->pla_cod.'</toolid>
						</assessment>';
					}
				}
			}
		}
		$datas .= '</assessments>';
		if ($success) {
			$message = $datas;
		}
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function duplicate_tool($oldid = null, $newid = null) {
		if (!self::check_request()) {
			//return 401;
		}
		
		if (empty($oldid) || empty($newid)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/client/tool.php');
		require_once(DIRROOT . '/classes/exporter.php');
		
		$success = true;
		$message = '';
		
		if (!$oldtool = plantilla::fetch(array('pla_cod' => $oldid))) {
			$message .= 'Old ID ' . $oldid . ' does not exist | ';
			$success = false;
		}
		if ($newtool = plantilla::fetch(array('pla_cod' => $newid))) {
			$message .= 'New ID ' . $newid . ' is invalid because already exists | ';
			$success = false;
		}
		
		if ($success) {
			$format = 'xml';
			$params = array('tool_id' => $oldtool->id, 'format' => $format);
			$exporter = new exporter($params, $format);
			$xmlstring = $exporter->export(null);
			$xml = simplexml_load_string($xmlstring);
			$tool = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
			$tool->import($xml);
				
			try{
				$resultparams = $tool->save($newid);
				$message .= $oldid . ' duplicated successfully | '; 
			}
			catch(Exception $e){
				$success = false;
				$message .= $oldid . ' cannot be duplicated | ';
			}
		}
		
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function duplicate_tools($xmldatas = '') {
		if (!self::check_request()) {
			return 401;
		}
		
		if (empty($xmldatas)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/cleanxml.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/client/tool.php');
		require_once(DIRROOT . '/classes/exporter.php');
		
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xmldatas);
		if ($xml) {
			$xml = cleanxml($xml);
		} else {
			return null;
		}
		
		$format = 'xml';
		$success = false;
		$message = '';
		foreach($xml as $toolidentifiers){
			if (!isset($toolidentifiers->oldid) || !isset($toolidentifiers->newid)) {
				continue;
			}
			$oldid = (string)$toolidentifiers->oldid;
			$newid = (string)$toolidentifiers->newid;
			
			if (!$oldtool = plantilla::fetch(array('pla_cod' => $oldid))) {
				$message .= 'Old ID ' . $oldid . ' does not exist | ';
				continue;
			}
			if ($newtool = plantilla::fetch(array('pla_cod' => $newid))) {
				$message .= 'New ID ' . $newid . ' is invalid because already exists | ';
				continue;
			}
			$params = array('tool_id' => $oldtool->id, 'format' => $format);
			$exporter = new exporter($params, $format);
			$xmlstring = $exporter->export(null);
			$xml = simplexml_load_string($xmlstring);
			$tool = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
			$tool->import($xml);
			
			try{
				$resultparams = $tool->save($newid);
				$success = true;
				$message .= $oldid . ' duplicated successfully | '; 
			}
			catch(Exception $e){
				$message .= $oldid . ' cannot be duplicated | ';
			}
		}
	
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function duplicate_assessments($xmldatas = '') {
		if (!self::check_request()) {
			return 401;
		}
		
		if (empty($xmldatas)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/cleanxml.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/assessment.php');
		
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xmldatas);
		if ($xml) {
			$xml = cleanxml($xml);
		} else {
			return null;
		}
		
		$format = 'xml';
		$success = false;
		$message = '';
		$hashtools = array();
		foreach($xml->toolIdentifiers[0] as $toolid){
			if (!isset($toolid->oldid) || !isset($toolid->newid)) {
				continue;
			}
			$oldid = (string)$toolid->oldid;
			$newid = (string)$toolid->newid;
			
			if (!$oldtool = plantilla::fetch(array('pla_cod' => $oldid))) {
				$message .= 'Old ID ' . $oldid . ' does not exist | ';
				continue;
			}
			if (!$newtool = plantilla::fetch(array('pla_cod' => $newid))) {
				$message .= 'New ID ' . $newid . ' does not exist | ';
				continue;
			}
			$hashtools[$oldtool->id] = $newtool->id;
		}

		if (!empty($hashtools)) {
			foreach($xml->assessmentIdentifiers[0] as $assid){	
				if (!isset($assid->oldid) || !isset($assid->newid)) {
					continue;
				}
				$oldid = (string)$assid->oldid;
				$newid = (string)$assid->newid;
				$params['oldid'] = $oldid;
				$params['newid'] = $newid;
				$params['hashtools'] = $hashtools;
				if ($assid = assessment::duplicate($params)) {
					$success = true;
				} else {
					$message .= 'Assessment ' . $oldid . ' cannot be duplicate |';
				}
			}
		}
		
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function get_assessment($assessmentid = null) {
		if (empty($assessmentid)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/assessment.php');
		require_once(DIRROOT . '/classes/plantilla.php');
		require_once(DIRROOT . '/classes/exporter.php');
		
		$success = false;
		$message = 'Parameters wrong';
		if ($assessment = assessment::fetch(array('ass_id' => $assessmentid))) {
			$params['tool_id'] = $assessment->ass_pla;
			$params['ass_id'] = $assessmentid;
			$params['ass_pla'] = $assessment->ass_pla;
			$params['assessment'] = $assessment;
			$format = 'xml';
			$result = new exporter($params, $format);
			$output = $result->export(null);
			$success = true;
		} else {
			return null;
		}
		
		return new Response($output);
	}
	
	public static function delete_assessment($assessmentid = null) {
		if (empty($assessmentid)) {
			return null;
		}
		
		require_once(DIRROOT . '/classes/assessment.php');
		$success = false;
		$message = 'Parameters wrong';
		if($assessment = assessment::fetch(array('ass_id' => $assessmentid))){
			$assessment->delete();
			$success = true;
			$message = 'Assessment deleted successfully';
		} else {
			return null;
		}
		
		$output = render::render_template('src/api/api_check_view.php', array('result' => $success, 'message' => $message));		
		return new Response($output);
	}
	
	public static function check_request() {
		require_once(DIRROOT . '/classes/lms.php');
		$request = Request::createFromGlobals();
		$token = $request->query->get('token');
		$ipaddress = $request->getClientIp();
		$rawdomain = (string)gethostbyaddr($ipaddress); // It can return more than one hostname.
		$explodedomain = explode(',', $rawdomain);
		$domain = $explodedomain[0];
		
		$validtoken = false;
		if ($lms = lms::fetch_all(array('lms_enb' => '1'))) {
			foreach ($lms as $item) {
				$lmstkn = self::process_token($item->lms_tkn);
				if ($lmstkn == $token) {
					$lmsurl = $item->lms_url;
					$host = (string)parse_url($lmsurl, PHP_URL_HOST);
					if (!filter_var($host, FILTER_VALIDATE_IP)) {
						$host .= '.';
					}
					$ip = gethostbyname($host);
					$host = (string)gethostbyaddr($ip);
					if (strtolower($domain) == strtolower($host)) {
						return true;
					}
				}
			}
		}
	
		return false;
	}

	public static function check_token() {
		require_once(DIRROOT . '/classes/lms.php');
		$request = Request::createFromGlobals();
		$token = $request->query->get('token');
		
		if ($lms = lms::fetch_all(array('lms_enb' => '1'))) {
			foreach ($lms as $item) {
				$lmstkn = self::process_token($item->lms_tkn);
				if ($lmstkn == $token) {
					return true;
				}
			}
		}
		return false;
	}
	
	private static function process_token($token) {
		date_default_timezone_set('Europe/Madrid');
		$date = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
		return sha1($token.$date);
	}
}