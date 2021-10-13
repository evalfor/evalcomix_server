<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo render::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array('Dashboard' => WWWROOT . '/app.php/dashboard', get_string('lmsmanager') => WWWROOT . '/app.php/dashboard/lms',
	get_string('editlms') => '#');

echo render::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root, 'showlogin' => true,
'username' => $username, 'loginaction' => $loginaction));

echo render::show_page_header(array('content' => $title, 'type' => 'h3'));

echo render::show_status_message($statusmessage);
echo render::show_form_open(array('id' => 'mainform', 'name' => 'mainform', 
	'action' => $action));

$id = (!empty($lms->id)) ? $lms->id : '';
$name = (!empty($lms->name)) ? $lms->name : '';
$description = (!empty($lms->description)) ? $lms->description : '';
$url = (!empty($lms->url)) ? $lms->url : '';
$token = (!empty($lms->token)) ? $lms->token : '';
$checked = (!empty($lms->enabled)) ? 'checked' : '';

echo '
<input type="hidden" name="id" value="'.$id.'">
<div class="w-50 m-auto mb-5">
	<div class="form-group mt-5 pb-3">
		<label for="name"><b>'.get_string('name').'</b></label>
		<input type="text" class="form-control" id="name" name="name" placeholder="'.get_string('name').
		'" required value="'.$name.'">
	</div>
	<div class="form-group pb-3">
		<label for="description"><b>'.get_string('description').'</b></label>
		<div>
			<textarea class="form-control" id="description" name="description">'.$description.'</textarea>
		</div>
	</div>
	<div class="form-group pb-3">
		<label for="url"><b>'.get_string('baseurl').'</b></label>
		<div>
			<input type="text" class="form-control" id="url" name="url" placeholder="https://moodle.lms.com" value="'.$url.'" required>
		</div>
		<p class="help-block">'.get_string('baseurlhelp').'</p>
	</div>
	<div class="form-group pb-3">
		<label for="token"><b>Token</b></label>
		<div>
			<input type="text" class="form-control" id="token" name="token" readonly placeholder="Token" value="'.$token.'">
		</div>
	</div>
	<div class="form-group pb-3">
		<label for="enabled"><b>'.get_string('enabled').'</b></label>
		<div>
			<input type="checkbox" id="enabled" name="enabled" value="1" '.$checked.'>
		</div>
	</div>
	<button class="w-100" type="submit">'.get_string('save').'</button>
</div>
';
echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();