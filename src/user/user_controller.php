<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class user_controller {
	public static function insert_user_action($params) {
		require_once(DIRROOT . '/classes/users.php');
		$userparams = array();
		if (!empty($params['username']) && !empty($params['firstname']) && !empty($params['lastname']) &&
				!empty($params['password'])) {
			if (!$user = users::fetch(array('usr_nam' => $params['username']))) {
				$userparams['usr_nam'] = $params['username'];
				$userparams['usr_pss'] = users::encrypt_password($params['password']);
				$userparams['usr_fnm'] = $params['firstname'];
				$userparams['usr_lnm'] = $params['lastname'];
				$userparams['usr_enb'] = '1';
				$newuser = new users($userparams);
				$userid = $newuser->insert();
				return $userid;
			}
		}
		return 0;
	}
	
	public static function change_password_action () {
		require_once(DIRROOT . '/classes/users.php');
		$request = Request::createFromGlobals();
		if (self::check_session()) {
			$title = get_string('resetpassword');
			$statusmessage = array('message' => '', 'type' => 'danger');
			$username = self::get_username();
			$loginaction = self::get_loginaction();
			
			if ($request->getMethod() == 'POST') {
				$currentpassword = $request->request->get('currentpassword');
				$newpassword1 = trim($request->request->get('newpassword1'));
				$newpassword2 = trim($request->request->get('newpassword2'));
				
				if (!empty($currentpassword) && !empty($newpassword1) && !empty($newpassword2)) {
					if ($user = users::fetch(array('username' => $username))) { 
						unset($user->usr_enb);
						$encryptedpassword = users::encrypt_password($currentpassword);
						if ($user->usr_pss == $encryptedpassword && $newpassword1 === $newpassword2) {
							$newencryptedpassword = users::encrypt_password($newpassword1);
							if ($newencryptedpassword == $encryptedpassword) {
								$statusmessage['message'] = get_string('errorsamepassword');
							} else {
								$user->usr_pss = $newencryptedpassword;
								$user->update();
								$statusmessage['message'] = get_string('passwordresetsuccessfully');
								$statusmessage['type'] = 'success';
							}
						} else {
							$statusmessage['message'] = get_string('errorresetpassword');
						}
					}
				} else {
					$statusmessage['message'] = get_string('errorrequiredfields');
				}
			}
			$action = WWWROOT . '/app.php/dashboard/password/edit';
			$html = render::render_template('src/user/user_resetpassword_view.php', array('title' => $title,
					'statusmessage' => $statusmessage, 'action' => $action, 'username' => $username, 'loginaction' => $loginaction));
			return new Response($html);
		} else {
			return new RedirectResponse(WWWROOT .'/app.php/login', 301);
		}
	}
	
	public static function change_password($userid, $newpassword) {
		require_once(DIRROOT . '/classes/users.php');
		
		if ($user = users::fetch(array('id' => $userid))) {
			unset($user->usr_enb);
			if (is_string($newpassword)) {
				$user->usr_pss = users::encrypt_password($newpassword);
				$user->update();
				return true;
			}			
		}
		
		return null;
	}
	
	public static function login_action() {
		require_once(DIRROOT . '/classes/users.php');
		$request = Request::createFromGlobals();
		
		$title = get_string('login');
		$statusmessage = array('message' => '', 'type' => 'danger');
		$action = WWWROOT . '/app.php/login';
		
		$html = '';
		if (self::check_session()) {
			return new RedirectResponse(WWWROOT . '/app.php/dashboard', 302);
		} else {
			if ($request->getMethod() == 'POST') {
				$originalusername = trim($request->request->get('username'));
				$username = htmlentities($originalusername);
				$username = strtolower($username);
				$password = $request->request->get('password');
				$password = users::encrypt_password($password);
				
				if ($user = users::fetch(array('usr_nam' => $username, 'usr_pss' => $password))) {
					$_SESSION['idsession'] = session_id();
					$_SESSION['userid'] = $user->id;
					$_SESSION['username'] = $username;
					$_SESSION['timestart'] = time();
					return new RedirectResponse(WWWROOT . '/app.php/dashboard', 302);
				} else {
					$statusmessage['message'] = get_string('loginerror');
					$html = install_renderer::render_template('src/user/user_login_view.php', array('title' => $title,
					'statusmessage' => $statusmessage, 'action' => $action, 'username' => $originalusername));
				}
			} else {
				$html = install_renderer::render_template('src/user/user_login_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'action' => $action, 'username' => ''));
			}
		}
		
		return new Response($html);
	}
	
	public static function logout_action() {
		unset($_SESSION['idsession']);
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		unset($_SESSION['timestart']);
		session_destroy();
		return new RedirectResponse(WWWROOT, 301);
	}
	
	public static function check_session() {
		if (!isset($_SESSION['userid']) || !isset($_SESSION['username']) || !isset($_SESSION['idsession'])
				|| !isset($_SESSION['timestart']) || $_SESSION['idsession'] != session_id()) {
			return false;
		} else {
			$timesaved = $_SESSION['timestart'];
		
			$now = time();  
			$timeelapsed = $now - $timesaved;

			if($timeelapsed >= 1800) {
				self::logout_action();
				return false;
			} else{
			  $_SESSION['timestart'] = time();
			}
		}
		return true;
	}
	
	public static function get_username() {
		if (self::check_session()) {
			return $_SESSION['username'];
		}
		return '';
	}
	
	public static function get_loginaction() {
		if (self::check_session()) {
			return '<a href="'.WWWROOT.'/app.php/logout">'.get_string('logout').'</a>';
		}
		return '<a href="'.WWWROOT.'/app.php/login">'.get_string('login').'</a>';;
	}
}