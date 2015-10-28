<?php
session_start();
include('include/config.php');

unset($_SESSION['cteTVAnetID']);
unset($_SESSION['cteTVAnetNOMBRE']);
unset($_SESSION['sessionCteTVAnetID']);
unset($_SESSION['cartTVAmNet']);
unset($_SESSION['comentarios']);

$_SESSION['systemAlertTEXT'] = 'Haz cerrado sesion correctamente. Gracias por utilizar nuestro Catalogo Virtual!!!';
$_SESSION['systemAlertTYPE'] = 'Aviso';
header('Location: '.RUTA);
?>