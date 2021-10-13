<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class dashboard_controller {
	public static function dashboard_action() {
		$title = get_string('dashboard');
		$statusmessage = get_string('successfullyinstalled');
		
		if (user_controller::check_session()) {
			$username = user_controller::get_username();
			$loginaction = user_controller::get_loginaction();
			
			$html = render::render_template('src/dashboard/dashboard_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'username' => $username, 'loginaction' => $loginaction));
			return new Response($html);
		}
		
		return new RedirectResponse(WWWROOT . '/app.php/login', 302);
	}
	
	public static function about_action() {
		require_once(DIRROOT . '/version.php');
		global $version, $release;
		$title = get_string('about');
		$statusmessage = '';
		
		if (user_controller::check_session()) {
			$username = user_controller::get_username();
			$loginaction = user_controller::get_loginaction();
			
			$html = render::render_template('src/dashboard/dashboard_about_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'username' => $username, 'loginaction' => $loginaction,
				'version' => $version, 'release' => $release));
			return new Response($html);
		}
		
		return new RedirectResponse(WWWROOT, 302);
	}
}