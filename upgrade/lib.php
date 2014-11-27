<?php

include_once('../configuration/conf.php');
include_once(DIRROOT . '/classes/db.php');
include_once(DIRROOT . '/classes/dbpdo.php');
include_once('evalcomix_table.php');
include_once('evalcomix_constant.php');

function upgrade_evalcomix_savepoint($version){
	include_once('../classes/config.php');
	if($config = config::fetch(array('name' => 'version'))){
		$config->value = $version;
		$config->update();
	}
	else{
		$config = new config(array('name' => 'version', 'value' => $version));
		$config->insert();
	}
	return true;
}

function print_error($message){
	echo "<br><div style='color:#f00'>$message</div><br>";
}

function ejecutar($sql){
	echo '<br>' . $sql . '<br><hr>';
	ob_flush();flush();
	try{
		if(!$result = DB::query($sql)){
			print_error("Error: No se puede ejecutar la sentencia $sql");
			exit;
		}
	}
	catch(Exception $e){
		print_error("Error: No se puede ejecutar la sentencia $sql. Mensaje del Error: " . $e->getMessage());
		exit;
	}
	//echo "<br>$sql<br>";
	return $result;
}

function print_message($message){
	echo '<br>' . $message . '<br><hr>';
	ob_flush();flush();
}

?>