<?php
header('Content-type: text/xml; charset="utf-8"', true);
echo '<?xml version="1.0" encoding="utf-8"?>
<subdimensiongrades>
';

foreach ($datas as $subdimensionid => $data) {
	echo '<subdimensiongrade subdimensionid="'.$subdimensionid.'">';
	foreach ($data as $assessmentid => $value) {
		echo '<assessment id="'.$assessmentid.'">';
		echo '<grade>' . $value->grade . '</grade>';
		echo '<maxgrade>' . $value->maxgrade . '</maxgrade>';
		echo '</assessment>';
	}
	echo '</subdimensiongrade>';
}
echo '</subdimensiongrades>';
