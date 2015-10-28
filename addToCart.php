<?php
session_start();
include ('include/config.php');
include ('include/libreria.php');

if (isset($_GET['mod']) and $_GET['mod'] == 'Editar')
{
	$_SESSION['cartTVAmNet'][$_GET['ID']]['cantidad'] = $_GET['cantidad'];
}
else
{
	$r = mysql_query("SELECT id,nombre,modelo,precio".$_SESSION['cteTVAnetTIPO']." AS precio,imagen FROM productos WHERE id = ".Limpia($_GET['ID']));
	$reg = mysql_fetch_array($r);
	$imagen = 'sinImagen.jpg';
	if ($reg['imagen'] <> NULL and file_exists('imagenes/productos/'.$reg['imagen'])) { $imagen = $reg['imagen']; }
	$_SESSION['cartTVAmNet'][$reg['id']] = array('id' => $reg['id'], 'cantidad' => 1, 'nombre' => '<strong>'.$reg['nombre'].'</strong><br>Modelo: '.$reg['modelo'], 'precio' => $reg['precio'], 'imagen' => $imagen);
}
header('Location: carrito.php');
?>