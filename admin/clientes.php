<?php include ('header.php')?>
<h1>Clientes</h1>
<?php
if (!isset($_GET['mod']))
{
	$porPagina = 100;
	if (!isset($_GET['page'])) { $_GET['page'] = 1; }
	$desde = ($_GET['page'] - 1) * $porPagina;
	$q = "SELECT COUNT(*) AS paginas FROM clientes";
	if (isset($_GET['search'])) { $q .= " WHERE nombre LIKE '%".$_GET['search']."%'"; }
	$r = mysql_query($q);
	$reg = mysql_fetch_array($r);
	$noPaginas = ceil($reg['paginas'] / $porPagina);
	if ($noPaginas == 0) {$noPaginas = 1;}
	$q = "SELECT a.id AS id,a.fecha AS fecha,a.nombre AS nombre,a.telefono AS telefono,a.email AS email,b.nombre AS tipo FROM clientes a JOIN clientes_tipos b ON b.id = a.tipoClienteID";
	if (isset($_GET['search'])) { $q .= " WHERE a.nombre LIKE '%".$_GET['search']."%'"; }
	$q .= " ORDER BY a.fecha DESC, a.nombre ASC LIMIT ".$desde.",".$porPagina;
	$r = mysql_query($q);
	if (mysql_num_rows($r) > 0)
	{
?>
<form name="buscar" id="buscar" method="get" action="<?php echo $_SERVER['PHP_SELF']?>">
<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0" class="forma">
  <tr class="encabezado">
    <td>Buscador de Clientes</td>
  </tr>
  <tr>
    <td><input type="text" name="search" id="search" style="width:100%;"<?php if (isset($_GET['search'])) {?> value="<?php echo $_GET['search']?>"<?php }?> /></td>
  </tr>
  <tr>
    <td><input type="submit" value="Buscar" /></td>
  </tr>
</table>
</form>
<table width="50%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="33%" align="center"><?php if ($_GET['page'] > 1) {?><a href="clientes.php?page=<?php echo $_GET['page'] - 1?>">Página Anterior</a><?php }?></td>
    <td width="34%" align="center">Página <?php echo $_GET['page']?> de <?php echo $noPaginas?></td>
    <td width="33%" align="center"><?php if ($_GET['page'] < $noPaginas) {?><a href="clientes.php?page=<?php echo $_GET['page'] + 1?>">Página Siguiente</a><?php }?></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="15%">Fecha de Alta</td>
    <td width="20%">Nombre</td>
    <td width="25%">Datos de Contacto</td>
    <td width="10%">Tipo de Cliente</td>
    <td width="10%">Pedidos</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
<?php
		while ($reg = mysql_fetch_array($r))
		{
			$conPedidos = false;
			$r1 = mysql_query("SELECT id FROM pedidos WHERE clienteID = ".$reg['id']);
			if (mysql_num_rows($r1) > 0) { $conPedidos = true; }
?>
        <tr class="fila">
          <td><?php echo Fecha($reg['fecha'])?></td>
    <td><?php echo $reg['nombre']?></td>
    <td><?php echo 'Telefono: '.$reg['telefono'].'<br>E-mail: '.$reg['email']?></td>
    <td align="center"><?php echo $reg['tipo']?></td>
        <td align="center"><?php if ($conPedidos) {?><input type="button" value="Administrar" onclick="window.location = 'pedidos.php?ID=<?php echo $reg['id']?>'" /><?php } else { echo 'Sin Pedidos'; }?></td>
    <td align="center"><input type="button" value="Editar" onclick="window.location = 'clientes.php?mod=Editar&ID=<?php echo $reg['id']?>'" /></td>
    <td align="center"><input type="button" value="Eliminar" onclick="Borrar('Cliente','<?php echo $reg['id']?>')" /></td>
  </tr>
<?php
		}
?>
</table>
<table width="50%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="33%" align="center"><?php if ($_GET['page'] > 1) {?><a href="clientes.php?page=<?php echo $_GET['page'] - 1?>">Página Anterior</a><?php }?></td>
    <td width="34%" align="center">Página <?php echo $_GET['page']?> de <?php echo $noPaginas?></td>
    <td width="33%" align="center"><?php if ($_GET['page'] < $noPaginas) {?><a href="clientes.php?page=<?php echo $_GET['page'] + 1?>">Página Siguiente</a><?php }?></td>
  </tr>
</table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No hay clientes registrados</div>';
	}
}
elseif ($_GET['mod'] == 'Editar')
{
?>
    <center>
      <input type="button" value="Regresar" onclick="window.location = 'clientes.php'" />
    </center>
    <br />
<?php
	$r = mysql_query("SELECT * FROM clientes WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		$arrEstados = array();
		$r1 = mysql_query("SELECT id,nombre FROM clientes_estados ORDER BY nombre ASC");
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$arrEstados[$reg1['id']] = $reg1['nombre'];
			}
		}
		$arrTiposCliente = array();
		$r1 = mysql_query("SELECT id,nombre FROM clientes_tipos ORDER BY id ASC");
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
				$arrTiposCliente[$reg1['id']] = $reg1['nombre'];
			}
		}
?>
<form name="EditRegistro" id="EditRegistro" method="post" action="backend.php?mod=Cliente&acc=Editar">
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
    <table width="60%" border="0" align="center" cellpadding="5" cellspacing="0" class="forma">
      <tr class="encabezado">
        <td colspan="4">Estatus del Cliente</td>
      </tr>
      <tr>
        <td><input type="radio" name="estatus" id="radio" value="1"<?php if ($reg['activo'] == 1) {?> checked="checked" <?php }?> />
          Activo</td>
        <td colspan="3"><input type="radio" name="estatus" id="radio2" value="0"<?php if ($reg['activo'] == 0) {?> checked="checked" <?php }?> />
        Suspendido</td>
      </tr>
      <tr>
        <td>Tipo de Cliente:</td>
        <td colspan="3"><select name="tipoCliente" id="tipoCliente">
<?php
		foreach ($arrTiposCliente as $k => $v)
		{
?>
	<option value="<?php echo $k?>"<?php if ($reg1['tipoClienteID'] == $k) { echo ' selected="selected"'; }?>><?php echo $v?></option>
<?php
		}
?>
        </select></td>
      </tr>
      <tr class="encabezado">
        <td colspan="4">Datos de la Cuenta</td>
      </tr>
      
      <tr>
        <td class="etiqueta">E-mail: *</td>
        <td colspan="3"><input name="email" type="text" id="email" value="<?php echo $reg['email']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Contraseña: *</td>
        <td width="20%"><input name="password" type="text" disabled="disabled" id="password" value="**********" size="20" /></td>
        <td width="5%" align="center"><input name="mPass" type="checkbox" id="mPass" value="1" onclick="if (this.checked) { document.getElementById('cPassword').disabled=false; document.getElementById('password').disabled=false; document.getElementById('password').value=''; } else { document.getElementById('cPassword').disabled=true; document.getElementById('password').disabled=true; document.getElementById('password').value='**********'; }" /></td>
        <td width="50%">Cambiar Contrase&ntilde;a</td>
      </tr>
      <tr class="titulo">
        <td>Confirmar Contrase&ntilde;a: *</td>
        <td><input name="cPassword" type="text" disabled="disabled" id="cPassword" size="20" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="encabezado">
        <td colspan="4">Datos Personales</td>
      </tr>
      <tr>
        <td class="etiqueta">Nombre: *</td>
        <td colspan="3"><input name="nombre" type="text" id="nombre" value="<?php echo $reg['nombre']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Teléfono: *</td>
        <td colspan="3"><input name="telefono" type="text" id="telefono" value="<?php echo $reg['telefono']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Teléfono móvil: *</td>
        <td colspan="3"><input name="movil" type="text" id="movil" value="<?php echo $reg['movil']?>" size="40" /></td>
      </tr>
      <tr class="encabezado">
        <td colspan="4">Domicilios de Entrega</td>
      </tr>
<?php
		$r1 = mysql_query("SELECT * FROM clientes_entregas WHERE clienteID = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
	  <tr>
        <td class="etiqueta">Domicilio: *</td>
        <td colspan="3"><input name="domicilio_<?php echo $reg1['id']?>" type="text" id="domicilio_<?php echo $reg1['id']?>" value="<?php echo $reg1['domicilio']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Colonia: *</td>
        <td colspan="3"><input name="colonia_<?php echo $reg1['id']?>" type="text" id="colonia_<?php echo $reg1['id']?>" value="<?php echo $reg1['colonia']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">C&oacute;digo Postal: *</td>
        <td colspan="3"><input name="cp_<?php echo $reg1['id']?>" type="text" id="cp_<?php echo $reg1['id']?>" value="<?php echo $reg1['cp']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Entre Calles:</td>
        <td colspan="3"><input name="entreCalles_<?php echo $reg1['id']?>" type="text" id="entreCalles_<?php echo $reg1['id']?>" value="<?php echo $reg1['entreCalles']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Ciudad: *</td>
        <td colspan="3"><input name="ciudad_<?php echo $reg1['id']?>" type="text" id="ciudad_<?php echo $reg1['id']?>" value="<?php echo $reg1['ciudad']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Estado: *</td>
        <td colspan="3"><select name="estado_<?php echo $reg1['id']?>" id="estado_<?php echo $reg1['id']?>">
<?php
				foreach ($arrEstados as $k => $v)
				{
?>
	<option value="<?php echo $k?>"<?php if ($reg1['estadoID'] == $k) { echo ' selected="selected"'; }?>><?php echo $v?></option>
<?php
				}
?>
    </select></td>
      </tr>
      <tr>
        <td colspan="4"><hr /></td>
      </tr>
<?php
			}
		}
		else
		{
?>
      <tr>
        <td colspan="4"><div class="alertaMsg">No se han agregado domicilios de entrega</div></td>
      </tr>
<?php
		}
?>
	  <tr class="encabezado">
        <td colspan="4">Datos de Facturacion</td>
      </tr>
<?php
		$r1 = mysql_query("SELECT * FROM clientes_facturacion WHERE clienteID = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r1) > 0)
		{
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
	  <tr>
        <td class="etiqueta">Raz&oacute;n Social: *</td>
        <td colspan="3"><input name="razonSocial_<?php echo $reg1['id']?>" type="text" id="razonSocial_<?php echo $reg1['id']?>" value="<?php echo $reg1['razonSocial']?>" size="40" /></td>
      </tr>
	  <tr>
        <td class="etiqueta">R.F.C.: *</td>
        <td colspan="3"><input name="rfc_<?php echo $reg1['id']?>" type="text" id="rfc_<?php echo $reg1['id']?>" value="<?php echo $reg1['rfc']?>" size="40" /></td>
      </tr>
	  <tr>
        <td class="etiqueta">Domicilio: *</td>
        <td colspan="3"><input name="domicilioF_<?php echo $reg1['id']?>" type="text" id="domicilioF_<?php echo $reg1['id']?>" value="<?php echo $reg1['domicilio']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Colonia: *</td>
        <td colspan="3"><input name="coloniaF_<?php echo $reg1['id']?>" type="text" id="coloniaF_<?php echo $reg1['id']?>" value="<?php echo $reg1['colonia']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">C&oacute;digo Postal: *</td>
        <td colspan="3"><input name="cpF_<?php echo $reg1['id']?>" type="text" id="cpF_<?php echo $reg1['id']?>" value="<?php echo $reg1['cp']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Ciudad: *</td>
        <td colspan="3"><input name="ciudadF_<?php echo $reg1['id']?>" type="text" id="ciudadF_<?php echo $reg1['id']?>" value="<?php echo $reg1['ciudad']?>" size="40" /></td>
      </tr>
      <tr>
        <td class="etiqueta">Estado: *</td>
        <td colspan="3"><select name="estadoF_<?php echo $reg1['id']?>" id="estadoF_<?php echo $reg1['id']?>">
<?php
				foreach ($arrEstados as $k => $v)
				{
?>
	<option value="<?php echo $k?>"<?php if ($reg1['estadoID'] == $k) { echo ' selected="selected"'; }?>><?php echo $v?></option>
<?php
				}
?>
    </select></td>
      </tr>
      <tr>
        <td colspan="4"><hr /></td>
      </tr>
<?php
			}
		}
		else
		{
?>
      <tr>
        <td colspan="4"><div class="alertaMsg">No se han agregado datos de facturacion</div></td>
      </tr>
<?php
		}
?>
      <tr>
        <td colspan="4" align="right"><input type="submit" value="Guardar Cambios" /></td>
      </tr>
    </table>
</form>
<?php
	}
	else
	{
		echo '<div class="errorMsg">El cliente que intentas editar no existe</div>';
	}
}
?>
<?php include ('footer.php')?>