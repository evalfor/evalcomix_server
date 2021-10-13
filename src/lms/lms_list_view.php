<?php
$root = WWWROOT;
require_once(DIRROOT . '/classes/render.php');

$css = '<link rel="stylesheet" href="'.WWWROOT.'/src/install/styles/general.css">';
echo install_renderer::show_head(array('title' => $title, 'path' => $root, 'links' => $css));

$path = array('Dashboard' => WWWROOT . '/app.php/dashboard', get_string('lmsmanager') => '#');

echo render::show_body_open(array('path' => $path, 'menutype' => 'global', 'root' => $root, 'showlogin' => true,
	'username' => $username, 'loginaction' => $loginaction));

echo render::show_page_header(array('content' => $title, 'type' => 'h3'));

echo render::show_status_message($statusmessage);

echo '<p><i>'.get_string('lmsmanagerhelp').'</i></p>';
echo '
<div class="mt-4" style="text-align:right"><button type="button" onclick="location.href=\''.WWWROOT.
'/app.php/dashboard/lms/new\'">'.get_string('addlms').'</button></div>

<table class="table table-responsive table-condensed table-striped mt-1">
	<thead>
		<th>'.get_string('name').'</th>
		<th>'.get_string('description').'</th>
		<th>'.get_string('baseurl').'</th>
		<th>Token</th>
		<th>'.get_string('enabled').'</th>
		<th></th>
	</thead>
	
	<tbody>
';

if (!empty($lms)) {
	foreach ($lms as $item) {
		$checked = ((int)$item->lms_enb == 1) ? 'checked' : '';
		echo '
			<tr>
				<td>'.$item->lms_nam.'</td>
				<td>'.$item->lms_des.'</td>
				<td>'.$item->lms_url.'</td>
				<td>'.$item->lms_tkn.'</td>
				<td>'.render::input(array('type' => 'checkbox', 'extra' => $checked . ' disabled')).'</td>
				<td> 
					<a href="'.WWWROOT.'/app.php/dashboard/lms/'.$item->id.'/edit">' . render::icon('edit', get_string('editlms')). '</a> '.
					'<a href="'.WWWROOT.'/app.php/dashboard/lms/'.$item->id.'/delete" onclick="
						if (!confirm(\''.get_string('lmsconfirmdeletion').'\')) {
							return false;
						}">'.render::icon('delete', get_string('deletelms')).'
				</td>
			</tr>
		';
	}
}

echo '
	</tbody>
</table>
';

echo render::show_body_close();		
echo render::show_footer();