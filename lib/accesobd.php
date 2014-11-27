<?php
//conexión con la BD
function ejecutar($sql){
   include_once("../../configuracion/conf.php");

   $bd = new basededatos(SERVER, USERDB, PASSDB, DATABASE);
   $bd->conectar();
   $rst = $bd->ejecutar($sql);
   $bd->desconectar($sql);

   return $rst;
}
?>
