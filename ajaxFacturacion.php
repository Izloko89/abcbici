<?php session_start(); ?>
<?php require_once ('include/config.php'); ?>
<?php require_once ('include/libreria.php'); ?>
<?php
if(isset($_GET['mod']) and $_GET['mod'] == 'Agregar')
{
	if (isset($_GET['ID']))
	{
		mysql_query("UPDATE clientes_facturacion SET razonSocial = ".Limpia($_GET['razonSocial']).",rfc = ".Limpia($_GET['rfc']).",domicilio = ".Limpia($_GET['domicilio']).",colonia = ".Limpia($_GET['colonia']).",cp = ".Limpia($_GET['cp']).",ciudad = ".Limpia($_GET['ciudad']).",estadoID = ".Limpia($_GET['estado'])." WHERE id = ".Limpia($_GET['ID'])." AND clienteID = ".$_SESSION['cteTVAnetID']);
	}
	else
	{
		mysql_query("INSERT INTO clientes_facturacion (razonSocial,rfc,domicilio,colonia,cp,ciudad,estadoID,clienteID) VALUES (".Limpia($_GET['razonSocial']).",".Limpia($_GET['rfc']).",".Limpia($_GET['domicilio']).",".Limpia($_GET['colonia']).",".Limpia($_GET['cp']).",".Limpia($_GET['ciudad']).",".Limpia($_GET['estado']).",".$_SESSION['cteTVAnetID'].")");
		$r = mysql_query("SELECT nombre FROM clientes_estados WHERE id = ".Limpia($_GET['estado']));
		$reg = mysql_fetch_array($r);
		$_SESSION['datosFactura'] = $_GET['razonSocial']."<br>".$_GET['rfc']."<br>".$_GET['domicilio']."<br>".$_GET['colonia'].", ".$_GET['cp']."<br>".$_GET['ciudad'].", ".$reg['nombre'];
	}
}
elseif(isset($_GET['mod']) and $_GET['mod'] == 'Seleccionar')
{
	if ($_GET['ID'] == 0)
	{
		$_SESSION['datosFactura'] = 'Sin Factura';
	}
	else
	{
		$r = mysql_query("SELECT a.id AS id,a.razonSocial AS razonSocial,a.rfc AS rfc,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_facturacion a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.id = ".Limpia($_GET['ID'])." AND a.clienteID = ".$_SESSION['cteTVAnetID']);
		if (mysql_num_rows($r) > 0)
		{
			$reg = mysql_fetch_array($r);
			$_SESSION['datosFactura'] = $reg['razonSocial']."<br>".$reg['rfc']."<br>".$reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado'];
		}
	}
}
elseif(isset($_GET['mod']) and $_GET['mod'] == 'Eliminar')
{
	$r = mysql_query("SELECT a.id AS id,a.razonSocial AS razonSocial,a.rfc AS rfc,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_facturacion a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.id = ".Limpia($_GET['ID'])." AND a.clienteID = ".$_SESSION['cteTVAnetID']);
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		if ($_SESSION['datosFactura'] == $reg['razonSocial']."<br>".$reg['rfc']."<br>".$reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']) { unset($_SESSION['datosFactura']); }
	}
	mysql_query("DELETE FROM clientes_facturacion WHERE id = ".Limpia($_GET['ID'])." AND clienteID = ".$_SESSION['cteTVAnetID']);
}
elseif (isset($_GET['mod']) and ($_GET['mod'] == 'Crear' or $_GET['mod'] == 'Editar'))
{
	$arrEstados = array();
	$r = mysql_query("SELECT id,nombre FROM clientes_estados ORDER BY nombre ASC");
	if (mysql_num_rows($r) > 0)
	{
		while ($reg = mysql_fetch_array($r))
		{
			$arrEstados[$reg['id']] = $reg['nombre'];
		}
	}
	if (isset($_GET['ID']))
	{
		$r = mysql_query("SELECT * FROM clientes_facturacion WHERE id = ".Limpia($_GET['ID']));
		if (mysql_num_rows($r) > 0)
		{
			$reg = mysql_fetch_array($r);
		}
	}
	if ($_GET['mod'] == 'Editar')
	{
?>
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
<?php
	}
?>
<div id="formaRegistro">
	<label>Razon Social</label><input type="text" name="razonSocial" id="razonSocial"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['razonSocial'].'"'; }?> />
    <div class="clear"></div>
    <label>R.F.C.</label><input type="text" name="rfc" id="rfc"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['rfc'].'"'; }?> />
    <div class="clear"></div>
    <label>Domicilio</label><input type="text" name="domicilio" id="domicilio"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['domicilio'].'"'; }?> />
    <div class="clear"></div>
    <label>Colonia</label><input type="text" name="colonia" id="colonia"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['colonia'].'"'; }?> />
    <div class="clear"></div>
    <label>Codigo Postal</label><input type="text" name="cp" id="cp"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['cp'].'"'; }?> />
    <div class="clear"></div>
    <label>Ciudad</label><input type="text" name="ciudad" id="ciudad"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['ciudad'].'"'; }?> />
    <div class="clear"></div>
    <label>Estado</label><select name="estado" id="estado">
<?php
	foreach ($arrEstados as $k => $v)
	{
?>
	<option value="<?php echo $k?>"<?php if ($_GET['mod'] == 'Editar' and $reg['estadoID'] == $k) { echo ' selected="selected"'; }?>><?php echo utf8_encode($v)?></option>
<?php
	}
?>
    </select>
    <div class="clear"></div>
    <input type="button" value="Guardar" onClick="ajaxFacturacion('<?php echo RUTA?>','Agregar','');" class="boton" />
</div>
<?php
}
if (!isset($_SESSION['datosFactura'])) { $_SESSION['datosFactura'] = 'Sin Factura'; }
?>
<div class="opcion<?php if ($_SESSION['datosFactura'] == 'Sin Factura') { echo ' selected'; }?>">
	<div class="divDatos">No requiero factura</div>
    <div class="divBotones">
    	<ul>
        	<li onClick="ajaxFacturacion('<?php echo RUTA?>','Seleccionar','0')">Seleccionar</li>
		</ul>
	</div>
    <div class="clear"></div>
</div>
<?php
$r = mysql_query("SELECT a.id AS id,a.razonSocial AS razonSocial,a.rfc AS rfc,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_facturacion a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.clienteID = ".$_SESSION['cteTVAnetID']);
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
?>
<div class="opcion<?php if ($_SESSION['datosFactura'] == $reg['razonSocial']."<br>".$reg['rfc']."<br>".$reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']) { echo ' selected'; }?>">
	<div class="divDatos"><?php echo utf8_encode($reg['razonSocial']."<br>".$reg['rfc']."<br>".$reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']);?></div>
    <div class="divBotones">
    	<ul>
        	<li onClick="ajaxFacturacion('<?php echo RUTA?>','Seleccionar','<?php echo $reg['id']?>')">Seleccionar</li>
            <li onClick="ajaxFacturacion('<?php echo RUTA?>','Editar','<?php echo $reg['id']?>')">Editar</li>
            <li onClick="ajaxFacturacion('<?php echo RUTA?>','Eliminar','<?php echo $reg['id']?>')">Eliminar</li>
		</ul>
	</div>
    <div class="clear"></div>
</div>
<?php
	}
}
?>