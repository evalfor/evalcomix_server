<?php

include_once('../configuration/conf.php');
include_once(DIRROOT . '/classes/db.php');
include_once(DIRROOT . '/classes/dbpdo.php');
include_once('lib.php');
include_once('upgrader.php');

$version = '';

$sql = 'SELECT * FROM config WHERE name = "version"';
try{
	if(!$result = DB::query($sql)){
		print_error("Error: No se puede ejecutar la sentencia $sql");
		$version = '00000000';
	}
	else{
		$row = $result->fetch();
		$version = $row['value'];
	}
}
catch(Exception $e){
	$version = '00000000';
}
echo "version: $version";

//Invocamos al actualizador envi�ndole el número de versión (en el caso de existir)
$undone = upgrader($version);

?>