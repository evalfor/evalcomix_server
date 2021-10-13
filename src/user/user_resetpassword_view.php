<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo render::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array('Dashboard' => WWWROOT . '/app.php/dashboard', get_string('resetpassword') => '#');

echo render::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root, 'showlogin' => true,
'username' => $username, 'loginaction' => $loginaction));

echo render::show_page_header(array('content' => $title, 'type' => 'h3'));

echo render::show_status_message($statusmessage);
echo render::show_form_open(array('id' => 'mainform', 'name' => 'mainform', 
	'action' => $action));

echo '
<input type="hidden" name="usersubstage" value="1">
<div class="w-25 m-auto">
	<div class="form-group mt-5 pb-3">
		<label for="currentpassword"><b>'.get_string('currentpassword').'</b></label>
		<input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="'.get_string('currentpassword').
		'" required>
	</div>
	<div class="form-group pb-3">
		<label for="newpassword1"><b>'.get_string('newpassword').'</b></label>
		<div id="hidepasswordfield">
			<input type="password" class="form-control" id="newpassword1" name="newpassword1" placeholder="'.get_string('newpassword').
			'" required>
		</div>
	</div>
	<div class="form-group pb-3">
		<label for="newpassword2"><b>'.get_string('repeatnewpassword').'</b></label>
		<div id="hidepasswordfield">
			<input type="password" class="form-control" id="newpassword2" name="newpassword2" placeholder="'.get_string('repeatnewpassword').
			'">
		</div>
	</div>
	<button class="w-100" type="submit">'.get_string('resetpassword').'</button>
</div>
';
echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();