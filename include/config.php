<?php
$db_server = 'localhost';
//$db_us = 'desarrollo_demos';
//$db_pas = 'BH2TtToV';
$db_us = 'desarrollo_demo';
$db_pas = 'pruebas';
$db_db = 'desarrollo_goray';
$db_conn = @mysql_connect($db_server,$db_us,$db_pas) or die ('Imposible conectarse con el servidor');
$db_bd = @mysql_select_db($db_db,$db_conn) or die ('Imposible comunicarse con la base de datos');

//define('RUTA','http://www.bicicletasrefacciones.com/');
define('RUTA','http://www.bicicletasrefacciones.com/');

$arrEMails = array('ventas@bicicletasrefacciones.com');
//$arrEMails = array('pruebas@bicicletasrefacciones.com');
$dominio = 'bicicletasrefacciones.com';
$pctIVA = 16;
?>