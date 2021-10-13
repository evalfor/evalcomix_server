<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array();

echo install_renderer::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root, 'showlogin' => true,
	'username' => $username, 'loginaction' => $loginaction));

echo install_renderer::show_page_header(array('content' => $title, 'type' => 'h3'));

echo install_renderer::show_status_message(array('message' => $statusmessage));

if ($dashboard) {
	echo '
	<div>
		<button type="button" onclick="location.href=\''.WWWROOT .'/app.php/dashboard\'">'.get_string('dashboardaccess').'</button>
	</div>
	';
}

echo install_renderer::show_body_close();		
echo install_renderer::show_footer();