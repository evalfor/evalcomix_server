<?php
session_start();
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

require_once('lib/selectlanguage.php');
require_once('lib/generallib.php');
require_once('vendor/autoload.php');
require_once('src/install/install_controller.php');
require_once('src/user/user_controller.php');
require_once('src/upgrade/upgrade_controller.php');
if (file_exists('configuration/conf.php')) {
	require_once('configuration/conf.php');
}

$request = Request::createFromGlobals();
$uri = $request->getPathInfo();

if (!install_controller::check_action()) {
	if (!defined('DIRROOT')) { 
		define('DIRROOT', __DIR__);
	}
	if (!defined('WWWROOT')) {
		$uriaux = explode('/', $_SERVER['REQUEST_URI']);
		$schema = 'http:';
		if (!empty($_SERVER['HTTPS'])) {
			$schema = 'https:';
		}
		define('WWWROOT',$schema.'//'.$_SERVER['SERVER_NAME'].'/'.$uriaux[1]);
	}
	$response = install_controller::install_action();
} else {
	if ($oldversion = install_controller::check_upgrade_required()) {
		$response = upgrade_controller::upgrader_action($oldversion);
	} else {
		$response = install_controller::display_landpage_action();
	}
}

$response->send();