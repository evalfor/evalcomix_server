<?php
	session_start();
	if(!isset($_SESSION['idsession']) || $_SESSION['idsession'] != session_id())
		die("La sesión ha expirado. Por favor, vuelva a conectarse");
?>