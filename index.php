<?php include ('header.php');?>
	<div id="slide">
<?php
$r = mysql_query("SELECT imagen,liga,target FROM slider_imagenes");
if (mysql_num_rows($r) > 0)
{
?>
    	<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
<?php
	while ($reg = mysql_fetch_array($r))
	{
		if ($reg['liga'] <> '') { echo '<a href="'.$reg['liga'].'" target="'.$reg['target'].'">'; }
		echo '<img src="imagenes/slider/'.$reg['imagen'].'" alt="Goray" />';
		if ($reg['liga'] <> '') { echo '</a>'; }
	}
?>
            </div>
        </div>
<?php
}
?>
    </div>
    <div class="clear"></div>
	<div id="servi">
		<div class="cuadr">
			<div class="circ">
				<img src="imagenes/servi1.png" width="130" height="130" alt="1">
			</div>
			<p><strong>TODO TIPO DE BICICLETAS</strong><br>Contamos con un gran stock de todo tipo de Bicicletas.</p>
		</div>
		<div class="cuadr">
			<div class="circ">
				<img src="imagenes/calidad.png" width="130" height="130" alt="1">
			</div>
			<p><strong>SERVICIO DE CALIDAD</strong><br>Contamos con un gran stock de todo tipo de Bicicletas.</p>
		</div>
		<div class="cuadr">
			<div class="circ">
				<img src="imagenes/compra.png" width="130" height="130" alt="1">
			</div>
			<p><strong>COMPRA 100% SEGURA</strong><br>Contamos con un gran stock de todo tipo de Bicicletas.</p>
		</div>
		<div class="cuadr">
			<div class="circ">
				<img src="imagenes/envi.png" width="130" height="130" alt="1">
			</div>
			<p><strong>ENVIOS A TODO MÉXICO</strong><br>Contamos con un gran stock de todo tipo de Bicicletas.</p>
		</div>
		<div class="clear"></div>
	</div>
	<div id="elementos">
		<div class="barra">LOS MÁS VISTOS</div>
	</div>
	<div id="flecha"></div>
	<div id="arti">
		<ul>
			<li><a>On-Road</a></li>
			<li><p>&#8226;</p></li>
			<li><a>X.Road</a></li>
			<li><p>&#8226;</p></li>
			<li><a>Off-Road</a></li>
			<li><p>&#8226;</p></li>
			<li><a>BMX</a></li>
		</ul>
	</div>
<div class="main">
	<!--<div id="slide">
<?php
$r = mysql_query("SELECT imagen,liga,target FROM slider_imagenes");
if (mysql_num_rows($r) > 0)
{
?>
    	<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
<?php
	while ($reg = mysql_fetch_array($r))
	{
		if ($reg['liga'] <> '') { echo '<a href="'.$reg['liga'].'" target="'.$reg['target'].'">'; }
		echo '<img src="imagenes/slider/'.$reg['imagen'].'" />';
		if ($reg['liga'] <> '') { echo '</a>'; }
	}
?>
            </div>
        </div>
<?php
}
?>
    </div>-->
    <!--<div id="promocion">
    	<h1>Promociones</h1>
<?php
$r = mysql_query("SELECT imagen FROM promociones WHERE vigencia >= '".date('Y-m-d')."' ORDER BY id DESC LIMIT 1");
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
	echo '<img src="imagenes/promociones/'.$reg['imagen'].'" alt="Goray" />';
	echo '<div class="btnVerMasPromo"><a href="promociones.php" title="Promociones">Ver mas Promociones</a></div>';
}
else
{
	echo '&nbsp;';
}
?>
    </div>-->
    <div class="clear"></div>
<?php
$r = mysql_query("SELECT id,nombre,modelo,precio".$_SESSION['cteTVAnetTIPO']." AS precio,imagen FROM productos WHERE visitas > 0 ORDER BY visitas DESC LIMIT 4");
if (mysql_num_rows($r) > 0)
{
?>
	<h1>Los Más Vistos</h1>
<?php
	while ($reg = mysql_fetch_array($r))
	{
		$imagen = 'sinImagen.jpg';
		if ($reg['imagen'] <> NULL and file_exists('imagenes/productos/'.$reg['imagen'])) { $imagen = $reg['imagen']; }
		$infoImagen = getimagesize('imagenes/productos/'.$imagen);
		$alto = $infoImagen[1];
		$ancho = $infoImagen[0];
		$size =  'height="130"';
		if ($ancho > $alto) { $size =  'width="130"'; }
?>
	<div class="divProducto">
		<div class="divImagen"><img src="imagenes/productos/<?php echo $imagen?>" <?php echo $size?> border="0" align="absmiddle" /></div>
		<div class="divLabel">Nombre:</div><div class="divDatosDetalle"><?php echo $reg['nombre']?></div>
		<div class="divLabel">Modelo:</div><div class="divDatosDetalle"><?php echo $reg['modelo']?></div>
        <div class="divLabel">Precio:</div><div class="divDatosDetalle"><?php echo Moneda($reg['precio']).' + I.V.A'?></div>
		<div class="btnAgregar"><a href="addToCart.php?ID=<?php echo $reg['id']?>" title="Agregar al Carrito"><img src="imagenes/btn-agregar.png" alt="Agregar al Carrito" name="ag1" width="87" height="33" border="0" id="ag1" onmouseover="MM_swapImage('ag1','','imagenes/btn-agregar2.png',1)" onmouseout="MM_swapImgRestore()" /></a></div>
		<div class="btnVerMas"><a href="detalle.php?ID=<?php echo $reg['id']?>" title="Ver Más"><img src="imagenes/btn-vermas.png" alt="Ver Más" name="ver1" width="77" height="25" border="0" id="ver1" onmouseover="MM_swapImage('ver1','','imagenes/btn-vermas2.png',1)" onmouseout="MM_swapImgRestore()" /></a></div>
	</div>
<?php
	}
?>
	<div class="clear"></div>
<?php
}
?>
</div>
<script type="text/javascript" src="include/SLIDER/jquery.nivo.slider.js"></script>
<script type="text/javascript">
$(window).load(function() {
     $('#slider').nivoSlider();
});
</script>
<?php include ('footer.php');?>