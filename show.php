<?php include ('header.php');?>
<div class="main">
<?php
$r = mysql_query("SELECT nombre FROM productos_categorias WHERE id = ".Limpia($_GET['ID']));
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
?>
	<h1><?php echo utf8_encode($reg['nombre'])?></h1>
<?php
	$porPagina = 12;
	if (!isset($_GET['page'])) { $_GET['page'] = 1; }
	$desde = ($_GET['page'] - 1) * $porPagina;
	$r1 = mysql_query("SELECT COUNT(id) AS productos FROM productos WHERE categoriaID = ".Limpia($_GET['ID']));
	$reg1 = mysql_fetch_array($r1);
	$totalProductos = $reg1['productos'];
	$noPaginas = ceil($totalProductos / $porPagina);
	$r1 = mysql_query("SELECT id,nombre,modelo,precio".$_SESSION['cteTVAnetTIPO']." AS precio,imagen FROM productos WHERE categoriaID = ".Limpia($_GET['ID'])." ORDER BY nombre ASC LIMIT ".$desde.",".$porPagina);
	if (mysql_num_rows($r1) > 0)
	{
		$numCols = 4;
		$i = 1;
		while ($reg1 = mysql_fetch_array($r1))
		{
			$imagen = 'sinImagen.jpg';
			if ($reg1['imagen'] <> NULL and file_exists('imagenes/productos/'.$reg1['imagen'])) { $imagen = $reg1['imagen']; }
			$infoImagen = getimagesize('imagenes/productos/'.$imagen);
			$alto = $infoImagen[1];
			$ancho = $infoImagen[0];
			$size =  'height="130"';
			if ($ancho > $alto) { $size =  'width="130"'; }
?>
	<div class="divProducto">
		<div class="divImagen"><img src="imagenes/productos/<?php echo $imagen?>" <?php echo $size?> border="0" /></div>
		<div class="divLabel">Nombre:</div><div class="divDatosDetalle"><?php echo utf8_encode($reg1['nombre'])?></div>
		<div class="divLabel">Modelo:</div><div class="divDatosDetalle"><?php echo $reg1['modelo']?></div>
        <div class="divLabel">Precio:</div><div class="divDatosDetalle"><?php echo Moneda($reg1['precio']).' + I.V.A'?></div>
		<div class="btnAgregar"><a href="addToCart.php?ID=<?php echo $reg1['id']?>" title="Agregar al Carrito"><img src="imagenes/btn-agregar.png" alt="Agregar al Carrito" name="ag1" width="87" height="33" border="0" id="ag1" onmouseover="MM_swapImage('ag1','','imagenes/btn-agregar2.png',1)" onmouseout="MM_swapImgRestore()" /></a></div>
		<div class="btnVerMas"><a href="detalle.php?ID=<?php echo $reg1['id']?>" title="Ver Más"><img src="imagenes/btn-vermas.png" alt="Ver Más" name="ver1" width="77" height="25" border="0" id="ver1" onmouseover="MM_swapImage('ver1','','imagenes/btn-vermas2.png',1)" onmouseout="MM_swapImgRestore()" /></a></div>
	</div>
<?php
			if ($i == $numCols) { echo '<div class="clear"></div>'; $i = 1; }
			else { $i++; }
		}
?>
	<ul class="paginacion">   
<?php
		for ($i = 1; $i <= $noPaginas; $i++)
		{
?>
		<li><a<?php if ($_GET['page'] == $i) { echo ' class="active"'; }?> href="show.php?ID=<?php echo $_GET['ID']?>&page=<?php echo $i?>"><?php echo $i?></a></li>
<?php
		}
?>
	</ul>
    <div class="clear"></div>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No se han creado productos en esta categoria</div>';
	}
}
else
{
	echo '<div class="errorMsg">La categoria que intentas ver no existe</div>';
}
?>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>