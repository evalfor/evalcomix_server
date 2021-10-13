<?php
$root = WWWROOT;
require_once(DIRROOT . '/classes/render.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array('Dashboard' => '#');

echo render::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root, 'showlogin' => true,
	'username' => $username, 'loginaction' => $loginaction));

echo render::show_page_header(array('content' => $title, 'type' => 'h3'));

echo render::show_status_message(array('message' => $statusmessage));



echo render::show_body_close();		
echo render::show_footer();