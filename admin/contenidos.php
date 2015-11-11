<?php include('header.php'); ?>
<h1>Administracion de Secciones y Contenidos</h1>
<?php
if (!isset($_GET['mod']))
{
	$r = mysql_query("SELECT id, nombre FROM contenidos ORDER BY id ASC");
	if (mysql_num_rows($r) > 0)
	{
?>
<br />
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
   <tr class="encabezado">
     <td width="80%">Secci&oacute;n</td>
     <td width="20%">&nbsp;</td>
   </tr>
<?php
		while ($reg = mysql_fetch_array($r))
		{
?>
        <tr class="fila">
          <td><?php echo $reg['nombre']?></td>
          <td align="center"><input type="button" value="Editar" onclick="window.location = 'contenidos.php?mod=Editar&ID=<?php echo $reg['id']?>'" /></td>
        </tr>
<?php
		}
?>
</table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No se han registrado secciones</div>';
	}
}
elseif ($_GET['mod'] == "Editar" and isset($_GET['ID']))
{
	$r = mysql_query("SELECT * FROM contenidos WHERE id = ".$_GET['ID']);
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>
<form id="form1" name="form1" method="post" action="backend.php?mod=Contenido&acc=Editar">
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
  <tr class="encabezado">
    <td>Editar Contenido</td>
  </tr>
  <tr>
    <td width="70%"><label>Nombre</label><input name="nombre" type="text" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
  </tr>
  <tr>
      <td><label>Contenido</label><textarea name="contenido" id="contenido" rows="20"><?php echo $reg['contenido']?></textarea></td>
    </tr>
  <tr>
    <td class="encabezado">Meta Tags</td>
  </tr>
  <tr>
      <td><label>Title <small>(M&aacute;ximo 60 Caracteres)</small></label><input type="text" name="title" id="title" value="<?php echo $reg['title']?>" /></td>
    </tr>
    <tr>
      <td><label>Keywords<small> (M&aacute;ximo 160 Caracteres)</small></label><input type="text" name="keywords" id="keywords" value="<?php echo $reg['keywords']?>" /></td>
    </tr>
    <tr>
      <td><label>Description <small>(M&aacute;ximo 160 Caracteres)</small></label><input type="text" name="description" id="description" value="<?php echo $reg['description']?>" /></td>
    </tr>
    <tr>
    <td width="70%" align="right"><input type="submit" value="Guardar Cambios" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="window.location = 'contenidos.php'" /></td>
  </tr>
</table>
</form>
<?php
	}
	else
	{
		echo '<div class="errorMsg">La seccion que intentas editar no existe</div>';
	}
}
?>
<?php include('footer.php'); ?>