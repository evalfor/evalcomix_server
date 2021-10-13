<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array();

echo install_renderer::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root));

echo install_renderer::show_page_header(array('content' => $title, 'type' => 'h3'));

echo '<h2>' . get_string('installation') . '</h2>';
echo '<h3>' . get_string('database') . '</h3>';

echo install_renderer::show_form_open(array('id' => 'formlanguage', 'name' => 'formlanguage', 
	'action' => $action));
echo install_renderer::show_status_message(array('message' => $statusmessage));

$driver = (!empty($driver)) ? $driver : '';
$selmysql = ($driver == 'mysql') ? 'selected' : '';
$selpgsql = ($driver == 'postgresql') ? 'selected' : '';
$dbhost = (!empty($dbhost)) ? $dbhost : '';
$dbuser = (!empty($dbuser)) ? $dbuser : '';
$dbpass = (!empty($dbpass)) ? $dbpass : '';
$dbname = (!empty($dbname)) ? $dbname : '';

echo '
<input type="hidden" name="substage" value="2">
<div class="w-50 m-auto">
	<div class="form-group pb-3">
		<label for="driver"><b>'.get_string('databasetypehead').'</b></label>
		<select id="driver" name="driver" class="form-select" required>
			<option value="">'.get_string('databasetypehead').'</option>
			<option value="mysql" '.$selmysql.'>MySQL / MariaDB</option>
			<option value="postgresql" '.$selpgsql.'>PostgreSQL</option>
		</select>
	</div>
	<div class="form-group pb-3">
		<label for="databasehost"><b>'.get_string('databasehost').'</b></label>
		<input type="text" class="form-control" id="databasehost" name="databasehost" placeholder="'.get_string('databasehost').
		'" required value="'.$dbhost.'">
	</div>
	<div class="form-group pb-3">
		<label for="databaseuser"><b>'.get_string('databaseuser').'</b></label>
		<input type="text" class="form-control" id="databaseuser" name="databaseuser" placeholder="'.get_string('databaseuser').
		'" required value="'.$dbuser.'">
	</div>
	<div class="form-group pb-3">
		<label for="databasepass"><b>'.get_string('databasepass').'</b></label>
		<input type="text" class="form-control" id="databasepass" name="databasepass" placeholder="'.get_string('databasepass').
		'" required value="'.$dbpass.'">
	</div>
	<div class="form-group pb-3">
		<label for="databasename"><b>'.get_string('databasename').'</b></label>
		<input type="text" class="form-control" id="databasename" name="databasename" placeholder="'.get_string('databasename').
		'" required value="'.$dbname.'">
	</div>
	<button type="submit" class="btn btn-primary">'.get_string('next').'</button>
</div>
';

echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();