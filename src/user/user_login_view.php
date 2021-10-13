<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array();

echo install_renderer::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root, 'showlogin' => false));

echo install_renderer::show_page_header(array('content' => $title, 'type' => 'h3'));

echo install_renderer::show_status_message($statusmessage);
echo install_renderer::show_form_open(array('id' => 'mainform', 'name' => 'mainform', 
	'action' => $action));

echo '
<input type="hidden" name="usersubstage" value="1">
<div class="w-25 m-auto mb-5">
	<div class="form-group mt-5 pb-3">
		<label for="username"><b>'.get_string('username').'</b></label>
		<input type="text" class="form-control" id="username" name="username" placeholder="'.get_string('username').
		'" required value="'.$username.'">
	</div>
	<div class="form-group pb-3">
		<label for="password"><b>'.get_string('password').'</b></label>
		<div id="hidepasswordfield">
			<input type="password" class="form-control" id="password" name="password" placeholder="'.get_string('password').
			'">
		</div>
	</div>
	<button class="w-100" type="submit">'.get_string('login').'</button>
</div>
';
echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();