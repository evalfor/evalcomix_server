<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');
require_once(DIRROOT . '/classes/render.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array();

echo install_renderer::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root));
echo render::show_script(array('url' => WWWROOT.'/src/user/js/validateAddsystemuser.js'));
echo install_renderer::show_page_header(array('content' => $title, 'type' => 'h3'));

echo '<h2>' . get_string('installation') . '</h2>';
echo '<h3>' . get_string('createadmin') . '</h3>';

echo install_renderer::show_form_open(array('id' => 'mainform', 'name' => 'mainform', 
	'action' => $action));
echo install_renderer::show_status_message(array('message' => $statusmessage));

$username = (!empty($username)) ? $username : 'admin';
$firstname = (!empty($firstname)) ? $firstname : '';
$lastname = (!empty($lastname)) ? $lastname : '';
$email = (!empty($email)) ? $email : '';
$suspended = (!empty($suspended)) ? 'checked' : '';
$changepassword = (!empty($changepassword)) ? $changepassword : false;
	
echo '
<input type="hidden" name="usersubstage" value="1">
<div class="w-50 m-auto">
	<div class="form-group pb-3">
		<label for="username"><b>'.get_string('username').'</b></label>
		<input type="text" class="form-control" id="username" name="username" readonly placeholder="'.get_string('username').
		'" required value="'.$username.'">
	</div>
	<div class="form-group pb-3">
		<label for="password"><b>'.get_string('password').'</b></label>
		<div id="hidepasswordfield">
			<input type="password" class="form-control" id="password" name="password" placeholder="'.get_string('password').
			'" value="'.$username.'">
			<input type="checkbox" id="unmask" onclick="javascript:validate_unmask(\'password\',\'unmask\');"> '.
			get_string('unmaskpassword') .'
		</div>
		<div id="hidelinkpass">
			<div class="fst-italic">
				<a href=# onclick="
					var e1 = document.getElementById(\'hidepasswordfield\');
					var e2 = document.getElementById(\'hidelinkpass\');
					e1.style.display = \'inline\';
					e2.style.display = \'none\';">Haz clic para insertar texto</a>
			</div>
		</div>
	</div>
	<div class="form-group pb-3">
		<label for="firstname"><b>'.get_string('firstname').'</b></label>
		<input type="text" class="form-control" id="firstname" name="firstname" placeholder="'.get_string('firstname').
		'" required value="'.$firstname.'">
	</div>
	<div class="form-group pb-3">
		<label for="lastname"><b>'.get_string('lastname').'</b></label>
		<input type="text" class="form-control" id="lastname" name="lastname" placeholder="'.get_string('lastname').
		'" required value="'.$lastname.'">
	</div>
	<button type="submit" class="btn btn-primary">'.get_string('save').'</button>
</div>
';
if ($changepassword === true) {
	echo '
	<script>
		var e1 = document.getElementById("hidepasswordfield");
		var e2 = document.getElementById("hidelinkpass");
		e1.style.display = "none";
		e2.style.display = "inline";
	</script>
	';
} else {
	echo '
	<script>
		var e1 = document.getElementById("hidepasswordfield");
		var e2 = document.getElementById("hidelinkpass");
		e1.style.display = "inline";
		e2.style.display = "none";
	</script>
	';
}
echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();