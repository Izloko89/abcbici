<?php include ('header.php')?>
<h1>Administracion de Imagenes del Slide</h1>
<?php
if (!isset($_GET['mod']))
{
?>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="backend.php?mod=Slide&act=Crear" onsubmit="Sube();">
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
    <tr class="encabezado">
      <td>Agregar Imagen</td>
    </tr>
    <tr>
      <td><label>Imagen <small>(JPG, GIF o PNG. 725px Ancho X 358px Alto)</small></label><input name="archivo" type="file" id="archivo" size="70" /></td>
    </tr>
    <tr>
      <td><label>Liga</label>
        <input type="text" name="liga" id="liga" />
      </td>
    </tr>
    <tr>
      <td><label>Target</label>
        <br />
        <select name="target" id="target">
          <option value="_self" selected="selected">Misma Pagina (_self)</option>
          <option value="_blank">Nueva Pagina (_blank)</option>
      </select></td>
    </tr>
    <tr>
      <td align="right"><input type="submit" value="Guardar Cambios" /></td>
    </tr>
  </table>
</form>
<div id="cargando" class="subiendoMsg"><img src="imagenes/loader.png" /><br />Subiendo Archivo...<br />Esta operaci&oacute;n puede tardar algunos minutos, dependiendo del tama&ntilde;o del archivo.</div>
<?php
	$r = mysql_query("SELECT * FROM slider_imagenes");
	if (mysql_num_rows($r) > 0)
	{
		$arrTargets = array('_self' => 'Misma Pagina (_self)', '_blank' => 'Nueva Pagina (_blank)');
?>
<br />
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="25%" align="center">Imagen</td>
    <td width="45%" align="center">Liga</td>
    <td width="15%" align="center">&nbsp;</td>
    <td width="15%" align="center">&nbsp;</td>
  </tr>
<?php
		while ($reg = mysql_fetch_array($r))
		{
?>
  <tr class="fila">
    <td align="center"><img src="../imagenes/slider/<?php echo $reg['imagen']?>" width="130" /></td>
    <td><?php if ($reg['liga'] <> '') { echo $reg['liga'].'<br>(Target: '.$arrTargets[$reg['target']].')'; } else { echo 'SIN LIGA'; }?></td>
    <td align="center"><input type="button" value="Editar" onclick="window.location = 'slide.php?mod=Editar&ID=<?php echo $reg['id']?>'" /></td>
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
	$r = mysql_query("SELECT liga,target FROM slider_imagenes WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="backend.php?mod=Slide&act=Editar" onsubmit="Sube();">
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
    <tr class="encabezado">
      <td>Editar Imagen</td>
    </tr>
    <tr>
      <td><label>Cambiar Imagen <small>(JPG, GIF o PNG. 725px Ancho X 358px Alto)</small></label><input name="archivo" type="file" id="archivo" size="70" /></td>
    </tr>
    <tr>
      <td><label>Liga</label>
        <input type="text" name="liga" id="liga" value="<?php echo $reg['liga']?>" />
      </td>
    </tr>
    <tr>
      <td><label>Target</label>
        <select name="target" id="target">
          <option value="_self"<?php if ($reg['target'] == '_self') { echo ' selected="selected"'; }?>>Misma Pagina (_self)</option>
          <option value="_blank"<?php if ($reg['target'] == '_blank') { echo ' selected="selected"'; }?>>Nueva Pagina (_blank)</option>
      </select></td>
    </tr>
    <tr>
      <td align="right"><input type="submit" value="Guardar Cambios" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="window.location = 'slide.php'" /></td>
    </tr>
  </table>
</form>
<div id="cargando" class="subiendoMsg"><img src="imagenes/loader.png" /><br />Subiendo Archivo...<br />Esta operaci&oacute;n puede tardar algunos minutos, dependiendo del tama&ntilde;o del archivo.</div>
<?php
	}
	else
	{
		echo '<div class="errorMsg">La imagen que intentas editar no existe</div>';
	}
}
?>
<?php include ('footer.php')?>