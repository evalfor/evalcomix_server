<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class lms_controller {
	public static function list_action($statusmessage = array('message' => '')) {
		require_once(DIRROOT . '/classes/lms.php');
		$title = get_string('lmsmanager');
		
		if (user_controller::check_session()) {
			$username = user_controller::get_username();
			$loginaction = user_controller::get_loginaction();
			$lms = lms::fetch_all(array());
			$html = render::render_template('src/lms/lms_list_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'username' => $username, 'loginaction' => $loginaction, 'lms' => $lms));
			return new Response($html);
		}
		
		return new RedirectResponse(WWWROOT . '/app.php/login', 301);
	}
	
	public static function insert_action() {
		require_once(DIRROOT . '/classes/lms.php');
		require_once(DIRROOT . '/lib/validateurlsyntax.php');
		$request = Request::createFromGlobals();
		$title = get_string('addlms');
		$statusmessage = array('message' => '', 'type' => 'danger');
		
		if (user_controller::check_session()) {
			$username = user_controller::get_username();
			$loginaction = user_controller::get_loginaction();
			$action = WWWROOT . '/app.php/dashboard/lms/new';
			
			$item = null;
			
			if ($request->getMethod() == 'POST') {
				$name = htmlentities(trim($request->request->get('name')));
				$description = htmlentities(trim($request->request->get('description')));
				$url = htmlentities(trim($request->request->get('url')));
				$token = htmlentities(trim($request->request->get('token')));
				$enabled = htmlentities(trim($request->request->get('enabled')));
				
				if (!empty($name) && !empty($url) && !empty($token)) {
					$enabled = (empty($enabled)) ? 0 : 1;
					
					$item = new stdClass();
					$item->name = $name;
					$item->description = $description;
					$item->url = $url;
					$item->token = self::generate_token();
					$item->enabled = '1';
					
					if (!$newlms = lms::fetch(array('lms_nam' => $name))) {
						if (!$newlms = lms::fetch(array('lms_tkn' => $token))) {
							if (!$newlms = lms::fetch(array('lms_url' => $url))) {
								if (validateUrlSyntax($url, 's+H?S?F-E-u?P?a?I?p?f?q-r-') === true) {
									$params = array();
									$params['lms_nam'] = $name;
									$params['lms_des'] = $description;
									$params['lms_url'] = $url;
									$params['lms_tkn'] = $token;
									$params['lms_enb'] = (string)$enabled;
									$newlms = new lms($params);
									$newlms->insert();
									$statusmessage['message'] = get_string('lmsinsertedsuccessfully');
									$statusmessage['type'] = 'success';
									return self::list_action($statusmessage);
								} else {
									$statusmessage['message'] = get_string('invalidurl');
								}
							} else {
								$statusmessage['message'] = get_string('lmsurlalreadyexists');
							}
						} else {
							$statusmessage['message'] = get_string('lmstokenalreadyexists');
						}
					} else {
						$statusmessage['message'] = get_string('lmsnamealreadyexists');
					}
				} else {
					$statusmessage['message'] = get_string('errorrequiredfields');
				}
			} else {
				$item = new stdClass();
				$item->name = '';
				$item->description = '';
				$item->url = '';
				$item->token = self::generate_token();
				$item->enabled = '1';
			}
			
			if (empty($item)) {
				$item = new stdClass();
				$item->token = self::generate_token();
			}
			$html = render::render_template('src/lms/lms_edit_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'username' => $username, 'loginaction' => $loginaction,
				'action' => $action, 'lms' => $item));
			return new Response($html);
		}
		
		return new RedirectResponse(WWWROOT . '/app.php/login', 301);
	}
	
	public static function edit_action($id = null) {
		require_once(DIRROOT . '/classes/lms.php');
		require_once(DIRROOT . '/lib/validateurlsyntax.php');
		$request = Request::createFromGlobals();
		$title = get_string('editlms');
		$statusmessage = array('message' => '', 'type' => 'danger');
		
		if (user_controller::check_session()) {
			$username = user_controller::get_username();
			$loginaction = user_controller::get_loginaction();
			$action = WWWROOT . '/app.php/dashboard/lms/'.$id.'/edit';
			
			$item = null;
			
			if ($request->getMethod() == 'POST') {
				$name = htmlentities(trim($request->request->get('name')));
				$description = htmlentities(trim($request->request->get('description')));
				$url = htmlentities(trim($request->request->get('url')));
				$token = htmlentities(trim($request->request->get('token')));
				$enabled = htmlentities(trim($request->request->get('enabled')));
				
				$item = new stdClass();
				$item->id = $id;
				$item->name = $name;
				$item->description = $description;
				$item->url = $url;
				$item->token = $token;
				$item->enabled = $enabled;
				
				if (!empty($name) && !empty($url) && !empty($token)) {
					$enabled = (empty($enabled)) ? 0 : 1;
					
					if (is_numeric($id) && $id > 0) {
						if ($lms = lms::fetch(array('id' => $id))) {
							$update = true;
							if ((string)$name !== (string)$lms->lms_nam) {
								$update = false;
								if (!$anotherlms = lms::fetch(array('lms_nam' => $name))) {
									$update = true;
								} else {
									$statusmessage['message'] = get_string('lmsnamealreadyexists');
								}
							} 
							if ((string)$url !== (string)$lms->lms_url) {
								$update = false;
								if (!$anotherlms = lms::fetch(array('lms_url' => $url))) {
									$update = true;
								} else {
									$statusmessage['message'] = get_string('lmsurlalreadyexists');
								}
							}
							
							if (validateUrlSyntax($url, 's+H?S?F-E-u?P?a?I?p?f?q-r-') === false) {
								$update = false;
								$statusmessage['message'] = get_string('invalidurl');
							}
							
							if ($update) {
								$rest = substr($url, -1);
								if ($rest === '/') {
									$url = substr($url, 0, -1);
								}
								
								$lms->lms_nam = $name;
								$lms->lms_des = $description;
								$lms->lms_url = $url;
								$lms->lms_tkn = $token;
								$lms->lms_enb = (string)$enabled;
								$lms->update();
								$statusmessage['message'] = get_string('lmsupdatedsuccessfully');
								$statusmessage['type'] = 'success';
								return self::list_action($statusmessage);
							}
						} else {
							$statusmessage['message'] = 'Error: LMS ID does not exist';
						}
					} else {
						if ($lms = lms::fetch(array('id' => $id))) {
							
						}
					}
				} else {
					$statusmessage['message'] = get_string('errorrequiredfields');
				}
			} else {
				if (empty($id)) {
					$item = new stdClass();
					$item->name = '';
					$item->description = '';
					$item->url = '';
					$item->token = self::generate_token();
					$item->enabled = '1';
				} else {
					if ($lms = lms::fetch(array('id' => $id))) {
						$item = new stdClass();
						$item->name = $lms->lms_nam;
						$item->description = $lms->lms_des;
						$item->url = $lms->lms_url;
						$item->token = $lms->lms_tkn;
						$item->enabled = $lms->lms_enb;
					}
				}
			}
			
			$html = render::render_template('src/lms/lms_edit_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'username' => $username, 'loginaction' => $loginaction,
				'action' => $action, 'id' => $id, 'lms' => $item));
			return new Response($html);
		}
		
		return new RedirectResponse(WWWROOT . '/app.php/login', 301);
	}
	
	public static function delete_action($id) {
		require_once(DIRROOT . '/classes/lms.php');
		$request = Request::createFromGlobals();
		
		if (user_controller::check_session()) {
			if ($lms = lms::fetch(array('id' => $id))) {
				$lms->delete();
			}
		
			$statusmessage['message'] = get_string('lmsdeletedsuccessfully');
			$statusmessage['type'] = 'success';
			return self::list_action($statusmessage);
		}
		
		return new RedirectResponse(WWWROOT . '/app.php/login', 301);
	}
	
	public static function generate_token() {
		require_once(DIRROOT . '/classes/lms.php');
		$token = bin2hex(random_bytes(32));
		while ($lms = lms::fetch(array('lms_tkn' => $token))) {
			$token = bin2hex(random_bytes(32));
		}
		return $token;
	}
}