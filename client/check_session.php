<?php
session_start();
if($_SESSION['idsession'] != session_id()) {
	die("La sesión ha expirado. Por favor, vuelva a conectarse");
}