<?php include ('header.php')?>
<?php
$arrEstatus = array();
$r = mysql_query("SELECT id,nombre FROM pedidos_estatus");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
		$arrEstatus[] = array('id' => $reg['id'], 'nombre' => $reg['nombre']);
	}
}
$class = array("fila1","fila2");
if (!isset($_GET['mod']))
{
	$q = "SELECT a.id AS id,a.fecha AS fecha,a.estatusID AS estatusID,b.nombre AS estatus FROM pedidos a JOIN pedidos_estatus b ON b.id = a.estatusID WHERE a.clienteID = ".$_GET['ID']." ORDER BY a.id DESC";
	if (!isset($_GET['Ver']) or $_GET['Ver'] <> 'All')
	{
		$q .= " LIMIT 8";
	}
	$r = mysql_query($q);
?>
<center><input type="submit" value="Regresar a Clientes" onclick="window.location = 'clientes.php'" /></center><br />
<?php
	if (!isset($_GET['Ver']) or $_GET['Ver'] <> 'All')
	{
?>
<center><input type="button" value="Historial de Pedidos" onclick="window.location = 'pedidos.php?ID=<?php echo $_GET['ID']?>&Ver=All'" /></center><br />
<?php
	}
?>
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="15%">No. de Pedido</td>
    <td width="29%">Fecha Elaboracion</td>
    <td>Estatus</td>
    <td width="15%">Detalle</td>
    <td width="15%">Eliminar</td>
  </tr>
<?php
	if (mysql_num_rows($r) > 0)
	{
		$i = 0;
		while ($reg = mysql_fetch_array($r))
		{
			$n = $i % 2;
?>
<form id="form<?php echo $reg['id']?>" name="form<?php echo $reg['id']?>" method="post" action="backend.php?mod=Estatus" onsubmit="return Valida('estatus',this);">
<input type="hidden" name="ID" id="ID" value="<?php echo $reg['id']?>" />
<input type="hidden" name="return" id="return" value="<?php echo $_SERVER['REQUEST_URI']?>" />
  <tr class="<?php echo $class[$n]?>">
    <td align="center" valign="top" style="font-weight:bold; color:#A00;"><?php echo sprintf('%06d',$reg['id'])?></td>
    <td height="25" align="center" valign="top"><?php echo Fecha($reg['fecha'])?></td>
    <td width="26%" align="center" valign="top">
      <select name="estatus" id="estatus" onchange="document.getElementById('form<?php echo $reg['id']?>').submit();">
  <?php
			foreach ($arrEstatus as $k => $v)
			{
?>
        <option value="<?php echo $v['id']?>"<?php if ($reg['estatusID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
  <?php
			}
?>
        </select>
    </td>
    <td align="center" valign="top"><input type="button" value="Ver" onclick="window.location = 'pedidos.php?mod=Detalle&ID=<?php echo $reg['id']?>'" /></td>
    <td align="center" valign="top"><input type="button" value="Eliminar" onclick="Borrar('Pedido','<?php echo $reg['id']?>')" /></td>
  </tr>
</form>
<?php
			$i++;
		}
	}
	else
	{
?>
  <tr>
    <td colspan="7">Por el momento no existen pedidos registradas por este cliente</td>
  </tr>
<?php
	}
?>
</table>
<?php
}
elseif (isset($_GET['mod']) and $_GET['mod'] == 'Detalle')
{
	$r1 = mysql_query("SELECT a.clienteID AS clienteID, a.fecha AS fecha, a.formaEntrega AS formaEntrega, a.domEntrega AS domEntrega, a.datosFactura AS datosFactura, a.formaPago AS formaPago, a.comentarios AS comentarios, b.nombre AS cliente, b.email AS email, b.telefono AS telefono, b.movil AS movil FROM pedidos a JOIN clientes b ON b.id = a.clienteID WHERE a.id = ".Limpia($_GET['ID']));
	$reg1 = mysql_fetch_array($r1);
	
	echo '<h1>Detalle de Pedido</h1>';
	echo '<center><input type="submit" value="Regresar a Pedidos del Cliente" onclick="window.location = \'pedidos.php?ID='.$reg1['clienteID'].'\'" /></center><br />';
	echo '<center><input type="submit" value="Imprimir Pedido" onclick="print();" /></center><br /><br />';
	echo '<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
	echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">DATOS DEL CLIENTE</td></tr>';
	echo '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">No. de Cliente</td><td width="35%" style="background:#D9F2FF; font-weight:bold; color:#A00;">'.sprintf('%06d',$reg1['clienteID']).'</td><td width="15%" style="background:#CCC; font-weight:bold;">Nombre</td><td width="35%" style="background:#D9F2FF;">'.$reg1['cliente'].'</td></tr>';
	echo '  <tr><td style="background:#CCC; font-weight:bold;">Telefono Fijo</td><td style="background:#D9F2FF;">'.$reg1['telefono'].'</td><td style="background:#CCC; font-weight:bold;">Telefono Movil</td><td style="background:#D9F2FF;">'.$reg1['movil'].'</td></tr>';
	echo '  <tr><td style="background:#CCC; font-weight:bold;">Correo Electronico</td><td style="background:#D9F2FF;">'.$reg1['email'].'</td><td style="background:#CCC; font-weight:bold;">&nbsp;</td><td style="background:#D9F2FF;">&nbsp;</td></tr>';
	echo '</table><br />';
	echo '<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
	echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">DATOS DEL PEDIDO</td></tr>';
	echo '  <tr><td width="15%" style="background:#CCC; font-weight:bold;">Folio</td><td width="35%" style="background:#D9F2FF; font-weight:bold; color:#A00;">'.sprintf('%06d',$_GET['ID']).'</td><td width="15%" style="background:#CCC; font-weight:bold;">Fecha</td><td width="35%" style="background:#D9F2FF;">'.Fecha($reg1['fecha']).'</td></tr>';
	echo '  <tr><td style="background:#CCC; font-weight:bold;">Forma de Entrega</td><td style="background:#D9F2FF; font-weight:bold;">'.$reg1['formaEntrega'].'</td><td style="background:#CCC; font-weight:bold;">Forma de Pago</td><td style="background:#D9F2FF;">'.$reg1['formaPago'].'</td></tr>';
	echo '  <tr><td style="background:#CCC; font-weight:bold;">Domicilio de Entrega</td><td style="background:#D9F2FF; font-weight:bold;">'.nl2br($reg1['domEntrega']).'</td><td style="background:#CCC; font-weight:bold;">Datos de Facturacion</td><td style="background:#D9F2FF;">'.nl2br($reg1['datosFactura']).'</td></tr>';
	echo '</table><br />';
	echo '<table width="50%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
	echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="5">DETALLE</td></tr>';
	echo '  <tr><td width="55%" style="background:#CCC; font-weight:bold;">Producto</td><td width="15%" style="background:#CCC; font-weight:bold;">Cantidad</td><td width="15%" style="background:#CCC; font-weight:bold;">Precio</td><td width="15%" style="background:#CCC; font-weight:bold;">Monto</td></tr>';
	$r2 = mysql_query("SELECT producto,cantidad,precio FROM pedidos_productos WHERE pedidoID = ".Limpia($_GET['ID']));
	$total = 0;
	while ($reg2 = mysql_fetch_array($r2))
	{
		$total += ($reg2['cantidad'] * $reg2['precio']);
		echo '  <tr><td style="background:#D9F2FF;">'.$reg2['producto'].'</td><td align="center" style="background:#D9F2FF;">'.$reg2['cantidad'].'</td><td align="right" style="background:#D9F2FF;">'.Moneda($reg2['precio']).'</td><td align="right" style="background:#D9F2FF;">'.Moneda($reg2['cantidad'] * $reg2['precio']).'</td></tr>';
	}
	echo '  <tr><td colspan="3" style="background:#CCC; font-weight:bold;">Subtotal</td><td align="right" style="background:#D9F2FF;">'.Moneda($total).'</td></tr>';
	echo '  <tr><td colspan="3" style="background:#CCC; font-weight:bold;">I.V.A.</td><td align="right" style="background:#D9F2FF;">'.Moneda($total * 0.16).'</td></tr>';
	echo '  <tr><td colspan="3" style="background:#CCC; font-weight:bold;">Total</td><td align="right" style="background:#D9F2FF;">'.Moneda($total + ($total * 0.16)).'</td></tr>';
	echo '</table><br />';
	if ($reg1['comentarios'] <> '')
	{
		echo '<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">';
		echo '  <tr style="background:#333; color:#FFF; font-weight:bold;"><td colspan="4">COMENTARIOS</td></tr>';
		echo '  <tr><td style="background:#D9F2FF;">'.nl2br($reg1['comentarios']).'</td></tr>';
		echo '</table>';
	}
}
elseif (isset($_GET['mod']) and $_GET['mod'] == 'porEstatus')
{
	if (!isset($_GET['estatus'])) { $estatus = 1; }
	else { $estatus = $_GET['estatus']; }
	$r = mysql_query("SELECT a.id AS id, a.fecha AS fecha, a.estatusID AS estatusID, b.nombre AS nombre FROM pedidos a JOIN clientes b ON b.id = a.clienteID WHERE a.estatusID = ".Limpia($estatus)." ORDER BY a.fecha DESC");
?>
<table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="tabla">
  <tr>
    <td colspan="7">Mostrar Pedidos 
      <select onchange="window.location = this.value">
      	<option value="pedidos.php?mod=porEstatus" selected="selected">Por Estatus</option>
        <option value="pedidos.php?mod=porFecha">Por Rango de Fechas</option>
      </select>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estatus:
       <select onchange="window.location = this.value">
<?php
		foreach ($arrEstatus as $k => $v)
		{
?>
      	<option value="pedidos.php?mod=porEstatus&estatus=<?php echo $v['id']?>"<?php if ($estatus == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
<?php
		}
?>
    </select></td>
  </tr>
</table>
<?php
	if (mysql_num_rows($r) > 0)
	{
?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="10%">No. de Pedido</td>
    <td width="30%">Cliente</td>
    <td width="20%">Fecha Elaboracion</td>
    <td width="20%">Estatus</td>
    <td width="10%">Detalle</td>
    <td width="10%">Eliminar</td>
  </tr>
  <?php
		while ($reg = mysql_fetch_array($r))
		{
?>
<form id="form<?php echo $reg['id']?>" name="form<?php echo $reg['id']?>" method="post" action="backend.php?mod=Estatus" onsubmit="return Valida('estatus',this);">
<input type="hidden" name="ID" id="ID" value="<?php echo $reg['id']?>" />
<input type="hidden" name="return" id="return" value="<?php echo $_SERVER['REQUEST_URI']?>" />
    <tr class="fila">
      <td align="center"><span style="font-weight:bold; color:#A00;"><?php echo sprintf('%06d',$reg['id'])?></span></td>
      <td><?php echo $reg['nombre']?></td>
      <td align="center"><?php echo Fecha($reg['fecha'])?></td>
      <td align="center" valign="top">
      <select name="estatus" id="estatus" onchange="document.getElementById('form<?php echo $reg['id']?>').submit();">
  <?php
			foreach ($arrEstatus as $k => $v)
			{
?>
        <option value="<?php echo $v['id']?>"<?php if ($reg['estatusID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
  <?php
			}
?>
        </select>
    </td>
      <td width="10%" align="center"><input type="button" value="Ver" onclick="window.location = 'pedidos.php?mod=Detalle&ID=<?php echo $reg['id']?>'" /></td>
      <td width="10%" align="center"><input type="button" value="Eliminar" onclick="Borrar('Pedido','<?php echo $reg['id']?>')" /></td>
    </tr>
</form>
  <?php
		}
?>
</table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No existen pedidos con el estatus seleccionado</div>';
	}
}
elseif (isset($_GET['mod']) and $_GET['mod'] == 'porFecha')
{
	if (!isset($_GET['dia1']) or !isset($_GET['dia2'])) { $dia1 = date('Y-m-d'); $dia2 = date('Y-m-d'); }
	else { $dia1 = $_GET['dia1']; $dia2 = $_GET['dia2']; }
	$r = mysql_query("SELECT a.id AS id, a.fecha AS fecha, a.estatusID AS estatusID, b.nombre AS nombre FROM pedidos a JOIN clientes b ON b.id = a.clienteID WHERE a.fecha >= ".Limpia($dia1.'-01 00:00:00')." AND a.fecha <= ".Limpia($dia2.' 23:59:59')." ORDER BY a.fecha DESC");
?>
<table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="tabla">
  <tr>
    <td colspan="7">Mostrar Pedidos 
      <select onchange="window.location = this.value">
      	<option value="pedidos.php?mod=porEstatus">Por Estatus</option>
        <option value="pedidos.php?mod=porFecha" selected="selected">Por Rango de Fechas</option>
      </select>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha entre: <input type="text" class="w16em dateformat-Y-ds-m-ds-d" id="dia1" name="dia1" value="<?php echo $dia1?>" style="width:10%;" readonly="readonly" /> y: <input type="text" class="w16em dateformat-Y-ds-m-ds-d" id="dia2" name="dia2" value="<?php echo $dia2?>" style="width:10%;" readonly="readonly" />
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Buscar" onclick="window.location = 'pedidos.php?mod=porFecha&dia1=' + document.getElementById('dia1').value + '&dia2=' + document.getElementById('dia2').value" /></td>
  </tr>
</table>
<?php
	if (mysql_num_rows($r) > 0)
	{
?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="10%">No. de Pedido</td>
    <td width="30%">Cliente</td>
    <td width="20%">Fecha Elaboracion</td>
    <td width="20%">Estatus</td>
    <td width="10%">Detalle</td>
    <td width="10%">Eliminar</td>
  </tr>
  <?php
		while ($reg = mysql_fetch_array($r))
		{
?>
<form id="form<?php echo $reg['id']?>" name="form<?php echo $reg['id']?>" method="post" action="backend.php?mod=Estatus" onsubmit="return Valida('estatus',this);">
<input type="hidden" name="ID" id="ID" value="<?php echo $reg['id']?>" />
<input type="hidden" name="return" id="return" value="<?php echo $_SERVER['REQUEST_URI']?>" />
    <tr class="fila">
      <td align="center"><span style="font-weight:bold; color:#A00;"><?php echo sprintf('%06d',$reg['id'])?></span></td>
      <td><?php echo $reg['nombre']?></td>
      <td align="center"><?php echo Fecha($reg['fecha'])?></td>
      <td align="center" valign="top">
      <select name="estatus" id="estatus" onchange="document.getElementById('form<?php echo $reg['id']?>').submit();">
  <?php
			foreach ($arrEstatus as $k => $v)
			{
?>
        <option value="<?php echo $v['id']?>"<?php if ($reg['estatusID'] == $v['id']) { echo ' selected="selected"'; }?>><?php echo $v['nombre']?></option>
  <?php
			}
?>
        </select>
    </td>
      <td width="10%" align="center"><input type="button" value="Ver" onclick="window.location = 'pedidos.php?mod=Detalle&ID=<?php echo $reg['id']?>'" /></td>
      <td width="10%" align="center"><input type="button" value="Eliminar" onclick="Borrar('Pedido','<?php echo $reg['id']?>')" /></td>
    </tr>
</form>
  <?php
		}
?>
</table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No existen pedidos dentro del rango de fechas seleccionado</div>';
	}
}
?>
<?php include ('footer.php')?>