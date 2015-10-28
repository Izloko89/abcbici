<?php include ('header.php');?>
<div class="main">
   	<h1>Carrito de Compras</h1>
<?php
if (isset($_SESSION['cartTVAmNet']) and count($_SESSION['cartTVAmNet']) > 0)
{
?>
	<div class="divArticulo titulo">Articulo</div>
    <div class="divCantidad titulo">Cantidad</div>
    <div class="divPrecio titulo">Precio</div>
    <div class="divPrecio titulo">Monto</div>
    <div class="clear"></div>
<?php
	$total = 0;
	foreach ($_SESSION['cartTVAmNet'] as $k => $v)
	{
		$infoImagen = getimagesize('imagenes/productos/'.$v['imagen']);
		$alto = $infoImagen[1];
		$ancho = $infoImagen[0];
		$size =  'height="80"';
		if ($ancho > $alto) { $size =  'width="80"'; }
?>
	<div class="filaCarrito">
    	<div class="divArticulo"><div class="imgCarrito"><img src="<?php echo RUTA.'imagenes/productos/'.$v['imagen']?>" <?php echo $size?> /></div><div class="datosCarrito"><?php echo utf8_encode($v['nombre'])?></div></div>
        <div class="divCantidad" style="text-align:center;"><input type="text" name="cantidad" id="cantidad" style="width:50%;" value="<?php echo $v['cantidad']?>" onkeyup="Actualiza('<?php //echo RUTA?>','<?php echo $k?>',this.value)" /></div>
        <div class="divPrecio"><?php echo Moneda($v['precio'])?></div>
		<div class="divPrecio"><?php echo Moneda($v['precio'] * $v['cantidad'])?><div class="divEliminar" title="Eliminar Articulo" onclick="RemoveFromCart('<?php echo RUTA?>','<?php echo $k?>')"></div></div>
        <div class="clear"></div>
	</div>
<?php
		$total += ($v['cantidad'] * $v['precio']);
	}
	$iva = $total * ($pctIVA / 100);
?>
	<div class="clear"></div>
    <div class="totales">
		<div class="labelTotal">Subtotal</div><div class="cantidadTotal"><?php echo Moneda($total)?></div>
    	<div class="clear"></div>
	   	<div class="labelTotal">I.V.A. (<?php echo $pctIVA.'%'?>)</div><div class="cantidadTotal"><?php echo Moneda($iva)?></div>
    	<div class="clear"></div>
		<div class="labelTotal">Total</div><div class="cantidadTotal"><?php echo Moneda($total + $iva)?></div>
    	<div class="clear"></div>
	</div>
    <div class="clear"></div>
	<div class="divBoton"><input type="button" value="Continuar" onclick="window.location = 'pedido.php'" class="boton" /></div>
<?php
}
else
{
	echo '<div class="alertaMsg">Tu carrito de compras esta vacio</div>';
}
?>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>