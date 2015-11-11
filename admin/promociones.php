<?php include ('header.php')?>
<h1>Administracion de Promociones</h1>
<?php
if (!isset($_GET['mod']))
{
?>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="backend.php?mod=Promocion&acc=Crear" onsubmit="Sube();">
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
    <tr class="encabezado">
      <td>Agregar Promocion</td>
    </tr>
    <tr>
      <td><label>Imagen <small>(JPG, GIF o PNG. 243px Ancho X 278px Alto)</small></label>
      <br />        <input name="archivo" type="file" id="archivo" size="70" /></td>
    </tr>
    <tr>
      <td><label>Vigente hasta</label><br /><input type="text" class="w16em dateformat-Y-ds-m-ds-d" id="vigencia" name="vigencia" value="<?php echo date('Y-m-d')?>" style="width:20%;" readonly="readonly" />
      </td>
    </tr>
    <tr>
      <td align="right"><input type="submit" value="Guardar Cambios" /></td>
    </tr>
  </table>
</form>
<div id="cargando" class="subiendoMsg"><img src="imagenes/loader.png" /><br />Subiendo Archivo...<br />Esta operaci&oacute;n puede tardar algunos minutos, dependiendo del tama&ntilde;o del archivo.</div>
<?php
	$r = mysql_query("SELECT * FROM promociones");
	if (mysql_num_rows($r) > 0)
	{
?>
<br />
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="25%" align="center">Imagen</td>
    <td width="45%" align="center">Vigencia</td>
    <td width="15%" align="center">&nbsp;</td>
    <td width="15%" align="center">&nbsp;</td>
  </tr>
<?php
		while ($reg = mysql_fetch_array($r))
		{
?>
  <tr class="fila">
    <td align="center"><img src="../imagenes/promociones/<?php echo $reg['imagen']?>" width="130" /></td>
    <td><?php echo Fecha($reg['vigencia'])?></td>
    <td align="center"><input type="button" value="Editar" onclick="window.location = 'promociones.php?mod=Editar&ID=<?php echo $reg['id']?>'" /></td>
    <td align="center"><input type="button" value="Eliminar" onclick="Borrar('Slide','<?php echo $reg['id']?>')" /></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No se han agregado imagenes al Slide</div>';
	}
}
else
{
	$r = mysql_query("SELECT * FROM promociones WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="backend.php?mod=Promocion&acc=Editar" onsubmit="Sube();">
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
    <tr class="encabezado">
      <td>Editar Promocion</td>
    </tr>
    <tr>
      <td><label>Cambiar Imagen</label><input name="archivo" type="file" id="archivo" size="70" /></td>
    </tr>
    <tr>
      <td><label>Vigente hasta</label><br /><input type="text" class="w16em dateformat-Y-ds-m-ds-d" id="vigencia" name="vigencia" value="<?php echo $reg['vigencia']?>" style="width:20%;" readonly="readonly" />
      </td>
    </tr>
    <tr>
      <td align="right"><input type="submit" value="Guardar Cambios" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="window.location = 'promociones.php'" /></td>
    </tr>
  </table>
</form>
<div id="cargando" class="subiendoMsg"><img src="imagenes/loader.png" /><br />Subiendo Archivo...<br />Esta operaci&oacute;n puede tardar algunos minutos, dependiendo del tama&ntilde;o del archivo.</div>
<?php
	}
	else
	{
		echo '<div class="errorMsg">La promocion que intentas editar no existe</div>';
	}
}
?>
<?php include ('footer.php')?>