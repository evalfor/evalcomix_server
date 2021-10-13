<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array();

echo install_renderer::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root));

echo install_renderer::show_page_header(array('content' => $title, 'type' => 'h3'));

echo '<h2>' . get_string('installation') . '</h2>';
echo '<h3>' . get_string('checkenvironment') . '</h3>';

echo install_renderer::show_form_open(array('id' => 'formlanguage', 'name' => 'formlanguage', 
	'action' => $action));
echo install_renderer::show_status_message(array('message' => $statusmessage));

$meet = true;

echo '
<div class="w-50 m-auto">
	<table class="table table-responsive table-striped table-bordered">
';

foreach ($checks['extra'] as $name => $status) {
	$renderstatus = '<span class="bg-success text-white p-1">OK</span>';
	if (!$status) {
		$meet = false;
		$renderstatus = '<span class="bg-danger text-white p-1">'.get_string('review').'</span>';
	}
	echo '
		<tr>
			<td>'.get_string($name).'</td>
			<td>'.$renderstatus.'</td>
		</tr>
	';
}

foreach ($checks['phpextensions'] as $name => $status) {
	$renderstatus = '<span class="bg-success text-white p-1">OK</span>';
	if (!$status) {
		$meet = false;
		$renderstatus = '<span class="bg-danger text-white p-1">'.get_string('review').'</span>';
	}
	echo '
		<tr>
			<td>PHP - '.$name.'</td>
			<td>'.$renderstatus.'</td>
		</tr>
	';
}

echo '
	</table>
';

if ($meet) {
	echo '
	<input type="hidden" name="substage" value="3">
	<center><button type="submit" class="btn btn-primary mb-5">'.get_string('next').'</button></center>
	';
} else {
	echo '
	<input type="hidden" name="substage" value="2">
	<center><button type="button" class="btn btn-primary mb-5" onclick="location.reload();">'.get_string('refresh').'</button></center>
	';
}

echo '</div>';

echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();