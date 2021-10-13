<?php
session_start();

require_once('vendor/autoload.php');
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

if (!file_exists('configuration/conf.php')) {
	$uriaux = explode('/', $_SERVER['REQUEST_URI']);
	$installuri = '//'.$_SERVER['SERVER_NAME'].'/'.$uriaux[1];
	$response = new RedirectResponse($installuri, 302);
	$response->send();
}

require_once('configuration/conf.php');
require_once('lib/selectlanguage.php');
require_once('lib/generallib.php');
require_once('lib/weblib.php');
require_once('lib/generallib.php');
require_once('classes/render.php');
require_once('src/install/install_controller.php');
require_once('src/api/api_controller.php');
require_once('src/user/user_controller.php');
require_once('src/dashboard/dashboard_controller.php');
require_once('src/lms/lms_controller.php');
			
$request = Request::createFromGlobals();
$uri = $request->getPathInfo();
$method = $request->getMethod();
$response = null;
$isapi = strpos($uri, '/api/');

if ($isapi === false) {
	$status = true;
	try {
		if ($status = install_controller::check_action()) {
			if (install_controller::check_upgrade_required()) {
				$status = false;
			}
		}
	} catch (Exception $e) {
		$status = false;
	}			
	if ($status === false) {
		$response = new RedirectResponse(WWWROOT, 302);
		$response->send();
	}
	$uriparams = explode('/', $uri);
	if ($uri == '/') {
		$response = install_controller::display_landpage_action();	
	} else if ($uri == '/login') {
		$response = user_controller::login_action();
	} else if ($uri == '/dashboard') {
		$response = dashboard_controller::dashboard_action();
	} else if ($uri == '/dashboard/about') {
		$response = dashboard_controller::about_action();
	} else if ($uri == '/logout') {
		$response = user_controller::logout_action();
	} else if ($uri == '/dashboard/password/edit') {
		$response = user_controller::change_password_action();
	} else if ($uri == '/dashboard/lms') {
		$response = lms_controller::list_action();
	} else if ($uri == '/dashboard/lms/new') {
		$response = lms_controller::insert_action();
	} else if ($uriparams[1] == 'dashboard' && $uriparams[2] == 'lms' && $uriparams[4] == 'edit') {
		$response = lms_controller::edit_action($uriparams[3]);
	} else  if ($uriparams[1] == 'dashboard' && $uriparams[2] == 'lms' && $uriparams[4] == 'delete') {
		$response = lms_controller::delete_action($uriparams[3]);
	}
} else {
	if ($uri == '/api/assessment') {
		if ($method == 'POST') {
			$postdatas = file_get_contents( 'php://input' );
			$response = api_controller::get_assessments($postdatas);
		}
	} else if ($uri == '/api/check') {
		if ($method == 'GET') {
			$response = api_controller::check_action();
		}
	} else if ($uri == '/api/grade') {
		if ($method == 'POST') {
			$postdatas = file_get_contents( 'php://input' );
			$response = api_controller::get_modified_tool_grades($postdatas);
		}
	}  else if ($uri == '/api/tool') {
		if ($method == 'POST') {
			$postdatas = file_get_contents( 'php://input' );
			$response = api_controller::get_tools($postdatas);
		}
	}  else if ($uri == '/api/tool/duplicate') {
		if ($method == 'POST') {
			$postdatas = file_get_contents( 'php://input' );
			$response = api_controller::duplicate_tools($postdatas);
		}
	}  else if ($uri == '/api/assessment/duplicate') {
		if ($method == 'POST') {
			$postdatas = file_get_contents( 'php://input' );
			$response = api_controller::duplicate_assessments($postdatas);
		}
	}  else if ($uri == '/api/tool/nomodified') {
		if ($method == 'PUT') {
			$postdatas = file_get_contents( 'php://input' );
			$response = api_controller::tool_modified($postdatas);
		}
	} else { // If URI contains REST params.
		$uriparams = explode('/', $uri);
		$countparams = count($uriparams) - 2;
		if ($uriparams[1] == 'api') {
			unset($uriparams[1]);
			$uriparams = array_values($uriparams);
			switch ($countparams) {
				case 2: {
					if ($uriparams[1] == 'assessment') {
						if ($method == 'GET') {
							$response = api_controller::get_assessment($uriparams[2]);
						} else if ($method == 'DELETE') {
							$response = api_controller::delete_assessment($uriparams[2]);
						}
					} else if ($uriparams[1] == 'grade') {
						if ($method == 'GET') {
							$response = api_controller::get_grade($uriparams[2]);
						}
					} else if ($uriparams[1] == 'tool') {
						if ($method == 'GET') {
							$response = api_controller::get_tool($uriparams[2]);
						} else if ($method == 'POST') {
							$postdatas = file_get_contents( 'php://input' );
							$response = api_controller::import_tool($postdatas, $uriparams[2]);
						} else if ($method == 'DELETE') {
							$response = api_controller::delete_tool($uriparams[2]);
						}
					}	
				}break;
				case 3: {
					if ($uriparams[1] == 'client') {
						if ($uriparams[2] == 'assessment') {
							if ($method == 'GET') {
								$assessmentid = $uriparams[3];
								$response = api_controller::client_view_assessment($assessmentid);
							} 
						} else if ($uriparams[2] == 'tool') {
							if ($method == 'GET') {
								if (!empty($uriparams[3])) {
									$toolid = $uriparams[3];
									$response = api_controller::client_view_tool($toolid);
								}
							} 
						}
					}
				}break;
				case 4: {
					if ($uriparams[1] == 'client') {
						if ($uriparams[2] == 'tool' && $uriparams[4] == 'edit') {
							if ($method == 'GET') {
								if (!api_controller::check_token()) {
									$response = 401;
								} else { 
									$_SESSION['idsession'] = session_id();
									$id = $uriparams[3];
									$response = new RedirectResponse(WWWROOT . '/client/selection.php?identifier='.$id.'&lang='.$_SESSION['lang'].
									'&type=open', 302);
								}
							} 
						} else if ($uriparams[2] == 'tool' && $uriparams[4] == 'new') {
							if ($method == 'GET') {
								if (!api_controller::check_token()) {
									$response = 401;
								} else { 
									$_SESSION['idsession'] = session_id();
									$id = $uriparams[3];
									$response = new RedirectResponse(WWWROOT . '/client/selection.php?identifier='.$id.'&lang='.$_SESSION['lang'].
									'&type=new', 302);
								}
							} 
						}
					} else if ($uriparams[1] == 'tool' && $uriparams[3] == 'duplicate') {
						if ($method == 'POST') {
							$response = api_controller::duplicate_tool($uriparams[2], $uriparams[4]);
						} 
					} 
				}break;
				case 6: {
					if ($uriparams[1] == 'client') {
						if ($uriparams[2] == 'assessment' && $uriparams[4] == 'tool' && $uriparams[6] == 'edit') {
							if ($method == 'GET') {
								$response = api_controller::client_assessment($uriparams[3], $uriparams[5]); 
							} 
						}
					}
				}
			}
		}
	}
}

// Send headers and responses.
if (empty($response)) {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	exit;
} else if ($response === 401) {
	header($_SERVER["SERVER_PROTOCOL"]." 401 Unauthorized");
	exit;
}

$response->send();