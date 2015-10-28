<?php include ('header.php');?>
<div class="main">
	<h1>Pedido Confirmado</h1>
    <div id="content">
<?php
if (isset($_SESSION['cteTVAnetID']) and isset($_SESSION['sessionCteTVAnetID']) and isset($_SESSION['cartTVAmNet']) and count($_SESSION['cartTVAmNet']) > 0)
{
	include_once('include/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->IsSMTP();
	
	$nombreTienda = 'BICICLETAS GORAY';
		
	mysql_query("INSERT INTO pedidos(formaEntrega,domEntrega,datosFactura,formaPago,comentarios,clienteID) VALUES (".Limpia($_SESSION['fEmbarque']).",".Limpia($_SESSION['domEntrega']).",".Limpia($_SESSION['datosFactura']).",".Limpia($_SESSION['fPago']).",".Limpia($_SESSION['comentarios']).",".$_SESSION['cteTVAnetID'].")");
	$ID = mysql_insert_id();
	$r = mysql_query("SELECT * FROM clientes WHERE id = ".$_SESSION['cteTVAnetID']);
	$reg = mysql_fetch_array($r);

	$mensaje = '<div style="width:70%; margin:0 auto; background:#006A9D; color:#FFF; font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:center; padding:5px;">Gracias por realizar su pedido en <b>'.$nombreTienda.'</b><br /><br /> Su solicitud sera procesada.<br><br>Detalles de su solicitud.</div><br />';
	$mensaje .= '<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
	$mensaje .= '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">DATOS DEL CLIENTE</td></tr>';
	$mensaje .= '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">No. de Cliente</td><td width="35%" style="background:#D9F2FF; font-weight:bold; color:#A00;">'.sprintf('%06d',$_SESSION['cteTVAnetID']).'</td><td width="15%" style="background:#CCC; font-weight:bold;">Nombre o Razon Social</td><td width="35%" style="background:#D9F2FF;">'.$reg['nombre'].'</td></tr>';
	$mensaje .= '  <tr><td style="background:#CCC; font-weight:bold;">Contacto</td><td style="background:#D9F2FF;">'.$reg['contacto'].'</td><td rowspan="3" valign="top" style="background:#CCC; font-weight:bold;">Correo Electronico</td><td rowspan="3" valign="top" style="background:#D9F2FF;">'.$reg['email'].'</td></tr>';
	$mensaje .= '  <tr><td style="background:#CCC; font-weight:bold;">Telefono</td><td style="background:#D9F2FF;">'.$reg['telefono'].'</td></tr>';
	$mensaje .= '  <tr><td style="background:#CCC; font-weight:bold;">Telefono Movil</td><td style="background:#D9F2FF;">'.$reg['movil'].'</td></tr>';
	$mensaje .= '</table><br />';
	$mensaje .= '<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
	$mensaje .= '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">DATOS DEL PEDIDO</td></tr>';
	$mensaje .= '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">Folio</td><td width="35%" style="background:#D9F2FF; font-weight:bold; color:#A00;">'.sprintf('%06d',$ID).'</td><td width="15%" style="background:#CCC; font-weight:bold;">Fecha</td><td width="35%" style="background:#D9F2FF;">'.Fecha(date('Y-m-d H:i:s')).'</td></tr>';
	$mensaje .= '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">Forma de Entrega</td><td width="35%" style="background:#D9F2FF;">'.$_SESSION['fEmbarque'].'</td><td width="15%" style="background:#CCC; font-weight:bold;">Forma de Pago</td><td width="35%" style="background:#D9F2FF;">'.$_SESSION['fPago'].'</td></tr>';
	$mensaje .= '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">Domicilio de Entrega</td><td width="35%" style="background:#D9F2FF;">'.$_SESSION['domEntrega'].'</td><td width="15%" style="background:#CCC; font-weight:bold;">Datos de Facturacion</td><td width="35%" style="background:#D9F2FF;">'.$_SESSION['datosFactura'].'</td></tr>';
	$mensaje .= '</table><br />';
	$mensaje .= '<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
	$mensaje .= '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">PRODUCTOS</td></tr>';
	$mensaje .= '  <tr><td width="70%" style="background:#CCC; font-weight:bold;">Producto</td><td width="30%" style="background:#CCC; font-weight:bold;">Cantidad</td><td width="30%" style="background:#CCC; font-weight:bold;">Precio</td><td width="30%" style="background:#CCC; font-weight:bold;">Monto</td></tr>';
		
	$total = 0;
	foreach($_SESSION['cartTVAmNet'] as $k => $v)
	{
		mysql_query("INSERT INTO pedidos_productos (producto,cantidad,precio,pedidoID) VALUES ('".$v['nombre']."','".$v['cantidad']."','".$v['precio']."',".$ID.")");
		$mensaje .= '  <tr><td style="background:#D9F2FF;">'.$v['nombre'].'</td><td align="center" style="background:#D9F2FF;">'.$v['cantidad'].'</td><td align="right" style="background:#D9F2FF;">'.Moneda($v['precio']).'</td><td align="right" style="background:#D9F2FF;">'.Moneda($v['cantidad'] * $v['precio']).'</td></tr>';
		$total += $v['cantidad'] * $v['precio'];
	}
	$iva = $total * ($pctIVA / 100);
	$mensaje .= '  <tr><td colspan="3" style="background:#D9F2FF;">Subtotal</td><td align="right" style="background:#D9F2FF;">'.Moneda($total).'</td></tr>';
	$mensaje .= '  <tr><td colspan="3" style="background:#D9F2FF;">I.V.A.</td><td align="right" style="background:#D9F2FF;">'.Moneda($iva).'</td></tr>';
	$mensaje .= '  <tr><td colspan="3" style="background:#D9F2FF;">Total</td><td align="right" style="background:#D9F2FF;">'.Moneda($total + $iva).'</td></tr>';
	$mensaje .= '</table><br />';
		
	$r1 = mysql_query("SELECT datos FROM pedidos_datos_pago");
	$reg1 = mysql_fetch_array($r1);
	$mensaje .= '<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
	$mensaje .= '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td>NOTAS</td></tr>';
	if ($_SESSION['comentarios'] <> '')
	{
		$mensaje .= '  <tr><td style="background:#CCC; font-weight:bold;">Comentarios del Cliente</td></tr>';
		$mensaje .= '  <tr><td style="background:#D9F2FF;">'.nl2br($_SESSION['comentarios']).'</td></tr>';
	}
	$mensaje .= '  <tr><td valign="top" style="background:#CCC; font-weight:bold;">Datos para Deposito o Transferencia</td></tr>';
	$mensaje .= '  <tr><td valign="top" style="background:#D9F2FF;">'.nl2br($reg1['datos']).'</td></tr>';
	$mensaje .= '</table>';

	$mensaje .= '<div style="font-family:Verdana; font-size:10px; text-align:center; margin-top:15px;">Este formato es unicamente informativo y no es valido como comprobante de compra y/o pago, tiempos de entrega a partir de la fecha de reporte de pago del pedido.</div>';
					
	$mail->From = 'webmaster@'.$dominio;
	$mail->FromName = 'Catalogo Virtual ['.$dominio.']';
	$mail->Subject = 'Detalle de Pedido';
	$mail->AltBody = "Para ver el mensaje, por favor, utilice un visor de correo electrónico compatible con HTML!";
	$mail->MsgHTML($mensaje);
	$mail->AddAddress(strtolower($reg['email']), $reg['nombre']);
	foreach ($arrEMails as $k => $v)
	{
		$mail->AddBCC($v);
	}
	$mail->Send();
		
	$contenido = '<div class="confirmacion">'.$_SESSION['cteTVAnetNOMBRE'].', tu solicitud ha sido enviada correctamente y en unos minutos comenzaremos a procesarla';
	$contenido .= '<div class="detalles"><div class="tituloDetalles">Detalles</div>';
	$contenido .= '<div class="divDetalle">No. de Cliente</div><div class="divDetalle">'.sprintf("%06d",$_SESSION['cteTVAnetID']).'</div><div class="clear"></div>';
	$contenido .= '<div class="divDetalle">No. de Pedido</div><div class="divDetalle">'.sprintf("%06d",$ID).'</div><div class="clear"></div>';
	$contenido .= '</div><br><br>Te hemos enviado una copia de este pedido al correo electronico <br><b><i>'.strtolower($reg['email']).'</i></b></div>';
	$contenido .= '<div class="formPago">Para Ver o Imprimir una copia de tu pedido, por favor entra a la seccion "Mis Pedidos" en el menu de tu cuenta.</div>';

	switch($_SESSION['fPago'])
	{
		case 'Pago Seguro con PayPal':
		{
			$_SESSION['pedidoTVAnetID'] = $ID;
			$arrLangs = array('Esp' => 'MX', 'Eng' => 'US');
			$return = RUTA.'pedidos.php';
			$cancelReturn = RUTA.'pedido.php';
			$moneda = 'MXN';
			$total = number_format($total + $iva,2);
			//$email = 'vende_1299113379_biz@hotmail.com'; //AMBIENTE DE PRUEBA
			$email = 'goray_mty@hotmail.com'; //AMBIENTE DE PRODUCCION
			//$accion = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //AMBIENTE DE PRUEBA
			$accion = 'https://www.paypal.com/cgi-bin/webscr'; //AMBIENTE DE PRODUCCION
			$contenido .= '<div class="formPago">Para comenzar tu proceso de Pago en Linea, por favor, da clic en el siguiente boton.<br>';
			$contenido .= '<form id="frmPayment" name="frmPayment" method="post" action="'.$accion.'" target="_parent">';
			$contenido .= '<input type="hidden" name="cmd" value="_xclick">';
			$contenido .= '<input type="hidden" name="business" value="'.$email.'" />';
			$contenido .= '<input type="hidden" name="item_name" value="Pedido No. '.$_SESSION['pedidoTVAnetID'].' : '.$nombreTienda.'">';
			$contenido .= '<input type="hidden" name="amount" value="'.$total.'">';
			$contenido .= '<input type="hidden" name="return" value="'.$return.'" />';
			$contenido .= '<input type="hidden" name="cancel_return" value="'.$cancelReturn.'" />';
			$contenido .= '<input type="hidden" name="currency_code" value="'.$moneda.'" />';
			$contenido .= '<input type="hidden" name="lc" value="'.$arrLangs['Esp'].'" />';
			$contenido .= '<input type="image" src="imagenes/boton_paypal.gif" />';
			$contenido .= '</form></div>';
			break;
		}
	}
	unset($_SESSION['cartTVAnet']);
	unset($_SESSION['domEntrega']);
	unset($_SESSION['facturacion']);
	unset($_SESSION['fEmbarque']);
	unset($_SESSION['comentarios']);
	unset($_SESSION['fPago']);
}
else
{
	$contenido = '<div class="alertaMsg">Para poder completar tu cotizacion debes ser un usuario registrado, haber ingresado a tu cuenta y agregar productos a tu cotizacion</div>';
}
?>
<?php echo $contenido?>
	</div>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>