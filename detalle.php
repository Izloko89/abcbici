<?php include ('header.php');?>
<div class="main">
<?php
$r = mysql_query("SELECT * FROM productos WHERE id = ".Limpia($_GET['ID']));
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	$yaVisito = false;
	$r1 = mysql_query("SELECT fecha FROM productos_ips_visitas ORDER BY fecha DESC LIMIT 1");
	if (mysql_num_rows($r1) > 0)
	{
		$reg1 = mysql_fetch_array($r1);
		if (date('Y-m-d H:i:s') > $reg1['fecha'])
		{
			mysql_query("TRUNCATE TABLE productos_ips_visitas");
		}
		else
		{
			$r2 = mysql_query("SELECT * FROM productos_ips_visitas WHERE ip = '".$_SERVER['REMOTE_ADDR']."'");
			if (mysql_num_rows($r2) > 0) { $yaVisito = true; }
		}
	}
	if (!$yaVisito)
	{
		mysql_query("UPDATE productos SET visitas = visitas + 1 WHERE id = ".Limpia($_GET['ID']));
		mysql_query("INSERT INTO productos_ips_visitas (ip,productoID) VALUES ('".$_SERVER['REMOTE_ADDR']."',".Limpia($_GET['ID']).")");
	}
?>
	<h1><?php echo utf8_encode($reg['nombre'])?></h1>
<?php
	$imagen = 'sinImagen.jpg';
	if ($reg['imagen'] <> NULL and file_exists('imagenes/productos/'.$reg['imagen'])) { $imagen = $reg['imagen']; }
	$infoImagen = getimagesize('imagenes/productos/'.$imagen);
	$alto = $infoImagen[1];
	$ancho = $infoImagen[0];
	$size =  'height="300"';
	if ($ancho > $alto) { $size =  'width="300"'; }
?>
	<div class="imgProducto"><a href="imagenes/productos/<?php echo $imagen?>" class="highslide" onclick="return hs.expand(this)"><img src="imagenes/productos/<?php echo $imagen?>" <?php echo $size?> border="0" /></a></div>
    <div class="datosProducto">
		<div class="divLabel">Modelo:</div><div class="divDatosDetalle"><?php echo utf8_encode($reg['modelo'])?></div>
        <div class="divLabel">Descripción:</div><div class="divDatosDetalle"><?php echo nl2br(utf8_encode($reg['descripcion']))?></div>
        <div class="divLabel">Precio:</div><div class="divDatosDetalle"><?php echo Moneda($reg['precio'.$_SESSION['cteTVAnetTIPO']]).' + I.V.A'?></div>
		<div class="btnAgregar"><a href="addToCart.php?ID=<?php echo $reg['id']?>" title="Agregar al Carrito"><img src="imagenes/btn-agregar.png" alt="Agregar al Carrito" name="ag1" width="87" height="33" border="0" id="ag1" onmouseover="MM_swapImage('ag1','','imagenes/btn-agregar2.png',1)" onmouseout="MM_swapImgRestore()" /></a></div>
	</div>
<?php
}
else
{
	echo '<div class="errorMsg">El producto que intentas ver no existe</div>';
}
?>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>