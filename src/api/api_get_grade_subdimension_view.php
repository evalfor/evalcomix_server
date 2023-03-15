<?php
header('Content-type: text/xml; charset="utf-8"', true);
echo '<?xml version="1.0" encoding="utf-8"?>
<subdimensiongrades>
';

foreach ($datas as $subdimensionid => $data) {
	echo '<subgrade subid="'.$subdimensionid.'">';
	foreach ($data as $assessmentid => $value) {
		echo '<assmt id="'.$assessmentid.'">' . $value->grade . '</assmt>';
	}
	echo '</subgrade>';
}
echo '</subdimensiongrades>';
