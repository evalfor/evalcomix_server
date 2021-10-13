<?php
header('Content-type: text/xml; charset="utf-8"', true);

$xml = "<grade xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://circe.uca.es/evalcomixserver422/xsd/Grade.xsd'>
	<finalAssessment>". $assessment->ass_grd ."</finalAssessment>
	<maxgrade>". $assessment->ass_mxg ."</maxgrade>
</grade>";

echo $xml;