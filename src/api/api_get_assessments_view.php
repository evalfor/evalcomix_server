<?php
header('Content-type: text/xml; charset="utf-8"', true);
echo '
<?xml version="1.0" encoding="utf-8"?>
<assessmentTools>
';

foreach ($datas as $toolid => $data) {
	echo '<assessment id="'.$data->assessmentfetch->ass_id.'">';
	echo $data->xml;
	echo '</assessment>';
}

echo '</assessmentTools>';