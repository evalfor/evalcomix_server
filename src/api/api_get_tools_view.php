<?php
header('Content-type: text/xml; charset="utf-8"', true);
echo '<?xml version="1.0" encoding="utf-8"?>
<assessmentTools>
';

foreach ($datas as $toolid => $data) {
	echo '<tool id="'.$data->toolfetch->pla_cod.'">';
	echo $data->xml;
	echo '</tool>';
}

echo '</assessmentTools>';