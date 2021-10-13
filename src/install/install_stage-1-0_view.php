<?php
$root = WWWROOT;
require_once(DIRROOT . '/src/install/renderer.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array();

echo install_renderer::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root));

echo install_renderer::show_page_header(array('content' => $title, 'type' => 'h3'));

echo '<h2>' . get_string('installation') . '</h2>';

echo install_renderer::show_form_open(array('id' => 'formlanguage', 'name' => 'formlanguage', 
	'action' => $action));

$es = 'selected';
$en = '';
if ($lang == 'en_utf8') {
	$en = 'selected';
	$es = '';
}
echo '
<input type="hidden" name="substage" value="1">
<div class="selectlanguage">
	<div>
		<div><label for="selectlanguage">'.get_string('selectlanguage').'</label></div>
		<select id="selectlanguage" name="lang" onchange="location.href=\''.$action.'?lang=\'+this.value">
			<option value="es_utf8" '.$es.'>'.get_string('spanish').'</option>
			<option value="en_utf8" '.$en.'>'.get_string('english').'</option>
		</select>
	</div>
	<div class="mt-5">
		<button type="submit">'.get_string('next').'</button>
	</div>
</div>
';
echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();