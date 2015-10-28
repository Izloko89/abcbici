<?php session_start(); ?>
<?php require_once ('include/config.php'); ?>
<?php require_once ('include/libreria.php'); ?>
<?php
if(isset($_GET['mod']) and $_GET['mod'] == 'Agregar')
{
	if (isset($_GET['ID']))
	{
		mysql_query("UPDATE clientes_entregas SET domicilio = ".Limpia($_GET['domicilio']).",colonia = ".Limpia($_GET['colonia']).",cp = ".Limpia($_GET['cp']).",entreCalles = ".Limpia($_GET['entreCalles']).",ciudad = ".Limpia($_GET['ciudad']).",estadoID = ".Limpia($_GET['estado'])." WHERE id = ".Limpia($_GET['ID'])." AND clienteID = ".$_SESSION['cteTVAnetID']);
	}
	else
	{
		mysql_query("INSERT INTO clientes_entregas (domicilio,colonia,cp,entreCalles,ciudad,estadoID,clienteID) VALUES (".Limpia($_GET['domicilio']).",".Limpia($_GET['colonia']).",".Limpia($_GET['cp']).",".Limpia($_GET['entreCalles']).",".Limpia($_GET['ciudad']).",".Limpia($_GET['estado']).",".$_SESSION['cteTVAnetID'].")");
		$r = mysql_query("SELECT nombre FROM clientes_estados WHERE id = ".Limpia($_GET['estado']));
		$reg = mysql_fetch_array($r);
		$_SESSION['domEntrega'] = $_GET['domicilio']."<br>".$_GET['colonia'].", ".$_GET['cp']."<br>".$_GET['ciudad'].", ".$reg['nombre']."<br>Entre Calles: ".$_GET['entreCalles'];
	}
}
elseif(isset($_GET['mod']) and $_GET['mod'] == 'Seleccionar')
{
	$r = mysql_query("SELECT a.id AS id,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.entreCalles AS entreCalles,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_entregas a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.id = ".Limpia($_GET['ID'])." AND a.clienteID = ".$_SESSION['cteTVAnetID']);
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		$_SESSION['domEntrega'] = $reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles'];
	}
}
elseif(isset($_GET['mod']) and $_GET['mod'] == 'Eliminar')
{
	$r = mysql_query("SELECT a.id AS id,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.entreCalles AS entreCalles,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_entregas a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.id = ".Limpia($_GET['ID'])." AND a.clienteID = ".$_SESSION['cteTVAnetID']);
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		if ($_SESSION['domEntrega'] == $reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles']) { unset($_SESSION['domEntrega']); }
	}
	mysql_query("DELETE FROM clientes_entregas WHERE id = ".Limpia($_GET['ID'])." AND clienteID = ".$_SESSION['cteTVAnetID']);
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
		$r = mysql_query("SELECT * FROM clientes_entregas WHERE id = ".Limpia($_GET['ID']));
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
	<label>Domicilio</label><input type="text" name="domicilio" id="domicilio"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['domicilio'].'"'; }?> />
    <div class="clear"></div>
    <label>Colonia</label><input type="text" name="colonia" id="colonia"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['colonia'].'"'; }?> />
    <div class="clear"></div>
    <label>Codigo Postal</label><input type="text" name="cp" id="cp"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['cp'].'"'; }?> />
    <div class="clear"></div>
    <label>Entre Calles</label><input type="text" name="entreCalles" id="entreCalles"<?php if ($_GET['mod'] == 'Editar') { echo ' value="'.$reg['entreCalles'].'"'; }?> />
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
    <input type="button" value="Guardar" onClick="ajaxEntregas('<?php echo RUTA?>','Agregar','');" class="boton" />
</div>
<?php
}
$r = mysql_query("SELECT a.id AS id,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.entreCalles AS entreCalles,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_entregas a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.clienteID = ".$_SESSION['cteTVAnetID']);
if (mysql_num_rows($r) > 0)
{
	$i = 1;
	while ($reg = mysql_fetch_array($r))
	{
		if ($i = 1 and (!isset($_SESSION['domEntrega']) or $_SESSION['domEntrega'] == 'N / A')) { $_SESSION['domEntrega'] = $reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles']; }
?>
<div class="opcion<?php if ($_SESSION['domEntrega'] == $reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles']) { echo ' selected'; }?>">
	<div class="divDatos"><?php echo utf8_encode($reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles']);?></div>
    <div class="divBotones">
    	<ul>
        	<li onClick="ajaxEntregas('<?php echo RUTA?>','Seleccionar','<?php echo $reg['id']?>')">Seleccionar</li>
            <li onClick="ajaxEntregas('<?php echo RUTA?>','Editar','<?php echo $reg['id']?>')">Editar</li>
            <li onClick="ajaxEntregas('<?php echo RUTA?>','Eliminar','<?php echo $reg['id']?>')">Eliminar</li>
		</ul>
	</div>
    <div class="clear"></div>
</div>
<?php
		$i++;
	}
}
else
{
	echo '<div class="alertaMsg">No haz agregado ningun domicilio de entrega a tu cuenta</div>';
}
?>