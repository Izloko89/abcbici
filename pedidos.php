<?php include ('header.php');?>
<div class="main">
	<h1>Mis Pedidos</h1>
    <div id="content">
<?php
if (isset($_SESSION['cteTVAnetID']) and isset($_SESSION['sessionCteTVAnetID']))
{
	if (!isset($_GET['mod']) and !isset($_GET['View']))
	{
		$q = "SELECT a.id AS id,a.fecha AS fecha,b.nombre AS estatus FROM pedidos a JOIN pedidos_estatus b ON b.id = a.estatusID WHERE a.clienteID = ".$_SESSION['cteTVAnetID']." ORDER BY a.id DESC";
		if (!isset($_GET['Ver']) or $_GET['Ver'] <> 'All')
		{
			$q .= " LIMIT 5";
		}
		$r = mysql_query($q);
		if (mysql_num_rows($r) > 0)
		{
			if (!isset($_GET['Ver']) or $_GET['Ver'] <> 'All')
			{
?>
<center><input type="button" value="Historial de Pedidos" class="boton" onclick="window.location = 'pedidos.php?Ver=All'" /></center><br />
<?php
			}
?>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="15%">Folio</td>
    <td width="35%">Fecha de Elaboracion</td>
    <td>Estatus</td>
    <td width="15%">Detalle</td>
    </tr>
<?php
			while ($reg = mysql_fetch_array($r))
			{
?>
  <tr class="fila">
    <td align="center" valign="top" style="font-weight:bold; color:#A00;"><?php echo sprintf('%06d',$reg['id'])?></td>
    <td height="25" align="center" valign="top"><?php echo Fecha($reg['fecha'])?></td>
    <td width="35%" align="center" valign="top"><?php echo $reg['estatus']?></td>
    <td align="center" valign="top"><input type="button" value="Ver" onclick="window.location = 'pedidos.php?mod=Detalle&ID=<?php echo $reg['id']?>'" class="boton" /></td>
    </tr>
<?php
			}
?>
</table>
<br />
<?php
		}
		else
		{
			echo '<div class="alertaMsg">No existen pedidos registrados</div>';
		}
	}
	elseif (isset($_GET['mod']) and $_GET['mod'] == 'Detalle')
	{
		$r1 = mysql_query("SELECT a.fecha AS fecha,a.formaEntrega AS formaEntrega,a.domEntrega AS domEntrega,a.datosFactura AS datosFactura,a.formaPago AS formaPago,a.comentarios AS comentarios,a.clienteID AS clienteID,b.nombre AS nombre,b.telefono AS telefono,b.movil AS movil,b.email AS email FROM pedidos a JOIN clientes b ON b.id = a.clienteID WHERE a.id = ".Limpia($_GET['ID'])." AND a.clienteID = ".$_SESSION['cteTVAnetID']);
			
		echo '<center><input type="submit" value="Regresar" onclick="window.location = \'pedidos.php\'" class="boton" /></center><br />';
		if (mysql_num_rows($r1) > 0)
		{
			$reg1 = mysql_fetch_array($r1);
			echo '<center><input type="submit" value="Imprimir" onclick="print();" class="boton" /></center><br />';
			echo '<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
			echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">DATOS DEL CLIENTE</td></tr>';
			echo '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">No. de Cliente</td><td width="35%" style="background:#D9F2FF; font-weight:bold; color:#A00;">'.sprintf('%06d',$reg1['clienteID']).'</td><td width="15%" style="background:#CCC; font-weight:bold;">Nombre</td><td width="35%" style="background:#D9F2FF;">'.utf8_encode($reg1['nombre']).'</td></tr>';
			echo '  <tr><td style="background:#CCC; font-weight:bold;">Correo Electronico</td><td style="background:#D9F2FF;">'.$reg1['email'].'</td><td style="background:#CCC; font-weight:bold;">Telefono</td><td style="background:#D9F2FF;">'.$reg1['telefono'].'</td></tr>';
			echo '  <tr><td style="background:#CCC; font-weight:bold;">Telefono Movil</td><td style="background:#D9F2FF;">'.$reg1['movil'].'</td><td style="background:#CCC; font-weight:bold;">&nbsp;</td><td style="background:#D9F2FF;">&nbsp;</td></tr>';
			echo '</table><br />';
			echo '<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
			echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">DATOS DEL PEDIDO</td></tr>';
			echo '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">Folio</td><td width="35%" style="background:#D9F2FF; font-weight:bold; color:#A00;">'.sprintf('%06d',$_GET['ID']).'</td><td width="15%" style="background:#CCC; font-weight:bold;">Fecha</td><td width="35%" style="background:#D9F2FF;">'.Fecha($reg1['fecha']).'</td></tr>';
			echo '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">Forma de Entrega</td><td width="35%" style="background:#D9F2FF;">'.$reg1['formaEntrega'].'</td><td width="15%" style="background:#CCC; font-weight:bold;">Forma de Pago</td><td width="35%" style="background:#D9F2FF;">'.$reg1['formaPago'].'</td></tr>';
			echo '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">Domicilio de Entrega</td><td width="35%" style="background:#D9F2FF;">'.utf8_encode($reg1['domEntrega']).'</td><td width="15%" style="background:#CCC; font-weight:bold;">Datos de Facturacion</td><td width="35%" style="background:#D9F2FF;">'.utf8_encode($reg1['datosFactura']).'</td></tr>';
			echo '</table><br />';
			echo '<table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
			echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="5">PRODUCTOS</td></tr>';
			echo '  <tr><td width="50%" style="background:#CCC; font-weight:bold;">Producto</td><td width="10%" style="background:#CCC; font-weight:bold;">Cantidad</td><td width="20%" style="background:#CCC; font-weight:bold;">Precio</td><td width="20%" style="background:#CCC; font-weight:bold;">Monto</td></tr>';
			$r2 = mysql_query("SELECT producto,cantidad,precio FROM pedidos_productos WHERE pedidoID = ".Limpia($_GET['ID']));
			$total = 0;
			while ($reg2 = mysql_fetch_array($r2))
			{
				$total += ($reg2['cantidad'] * $reg2['precio']);
				echo '  <tr><td style="background:#D9F2FF;">'.$reg2['producto'].'</td><td align="center" style="background:#D9F2FF;">'.$reg2['cantidad'].'</td><td align="right" style="background:#D9F2FF;">'.Moneda($reg2['precio']).'</td><td align="right" style="background:#D9F2FF;">'.Moneda($reg2['precio'] * $reg2['cantidad']).'</td></tr>';
			}
			echo '  <tr><td colspan="3" style="background:#CCC; font-weight:bold;">Subtotal</td><td align="right" style="background:#D9F2FF;">'.Moneda($total).'</td></tr>';
			echo '  <tr><td colspan="3" style="background:#CCC; font-weight:bold;">I.V.A.</td><td align="right" style="background:#D9F2FF;">'.Moneda($total * 0.16).'</td></tr>';
			echo '  <tr><td colspan="3" style="background:#CCC; font-weight:bold;">Total</td><td align="right" style="background:#D9F2FF;">'.Moneda($total + ($total * 0.16)).'</td></tr>';
			echo '</table>';
			if ($reg1['comentarios'] <> '')
			{
				echo '<br /><table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
				echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td>NOTAS</td></tr>';
				echo '  <tr><td style="background:#CCC; font-weight:bold;">Comentarios del Cliente</td></tr>';
				echo '  <tr><td style="background:#D9F2FF;">'.nl2br(utf8_encode($reg1['comentarios'])).'</td></tr>';
				echo '</table>';
			}				
		}
		else
		{
			echo '<div class="errorMsg">La cotizacion que intentas ver no existe</div>';
		}
	}
}
else
{
?>
	<div class="alertaMsg">Para poder ver tus cotizaciones debes ser un usuario registrado y haber ingresado a tu cuenta</div>
<?php
}
?>
	</div>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>