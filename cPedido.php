<?php include ('header.php');?>
<div class="main">
	<h1>Confirma los Datos del Pedido</h1>
<?php
if (isset($_SESSION['cteTVAnetID']) and isset($_SESSION['sessionCteTVAnetID']) and isset($_SESSION['cartTVAmNet']) and count($_SESSION['cartTVAmNet']) > 0)
{
?>
	<form id="form2" name="form2" method="post" action="confirmado.php">
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
       	<div class="divCantidad" style="text-align:center;"><?php echo $v['cantidad']?></div>
	    <div class="divPrecio"><?php echo Moneda($v['precio'])?></div>
		<div class="divPrecio"><?php echo Moneda($v['precio'] * $v['cantidad'])?></div>
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
	<div id="content">
        <div class="boxPedido">
	       	<h2>Forma de Entrega</h2>
           	<?php echo $_SESSION['fEmbarque']?>
		</div>
        <div class="boxPedido">
           	<h2>Domicilio de Entrega</h2>
       		<?php echo utf8_encode($_SESSION['domEntrega'])?>
		</div>
        <div class="boxPedido">
    	    <h2>Datos de Facturacion</h2>
			<?php echo utf8_encode($_SESSION['datosFactura'])?>
        </div>
        <div class="boxPedido">
        	<h2>Forma de Pago</h2>
            <?php echo $_SESSION['fPago']?>
        </div>
<?php
	if (isset($_SESSION['comentarios']) and $_SESSION['comentarios'] <> '')
	{
?>
        <div class="boxPedido">
	        <h2>Comentarios del Pedido</h2>
            <?php echo $_SESSION['comentarios']?>
        </div>
<?php
	}
?>
        <center><input type="button" value="Regresar" onClick="window.location = 'pedido.php'" class="boton">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Confirmar" class="boton"></center>
        </form>
<?php
}
else
{
?>
	<div id="content">
        <div class="alertaMsg">Para poder completar tu pedido debes ser un usuario registrado y haber ingresado a tu cuenta</div>
        <div id="formLogin">
            <div class="divForm">
                <form name="login" id="login" method="post" action="<?php echo RUTA?>send.php?mod=Login">
                <label>E-mail</label><input type="text" name="email" id="email" />
                <label>Contraseña</label><input type="password" name="password" id="password" />
                <input type="submit" value="Entrar" class="boton" />
                <div class="nota"><a href="registro.php">Crear una Cuenta</a></div>
                <div class="nota"><a >¿Olvidaste tu Contraseña?</a></div>
                </form>
            </div>
        </div>
<?php
}
?>
	</div>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>