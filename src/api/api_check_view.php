<?php
$status = ($result === true) ? 'Success' : 'error';

header('Content-type: text/xml; charset="utf-8"', true);
echo '<?xml version="1.0" encoding="utf-8"?>
<evalcomixstatus xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="'.WWWROOT.'/xsd/Status.xsd">
	<status>'.$status.'</status>
	<description>'.$message.'</description>
</evalcomixstatus>';