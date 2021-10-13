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
echo install_renderer::show_status_message(array('message' => $statusmessage));

echo '
<input type="hidden" name="substage" value="3">
';
echo '
<div class="border border-dark p-2 m-2">
<pre>
';
echo htmlentities($configphp);
echo '
</pre>
</div>

<center><button class="btn btn-primary mb-5">'.get_string('next').'</button></center>
';

echo install_renderer::show_form_close();
echo install_renderer::show_body_close();		
echo install_renderer::show_footer();