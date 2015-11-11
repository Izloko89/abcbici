<?php include ('header.php')?>
<h1>Administración de Imagenes para Contenidos</h1>
<form id="media" name="media" enctype="multipart/form-data" method="post" action="backend.php?mod=Media&acc=Crear" onsubmit="Sube();">
   <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
      <tr class="encabezado">
    	<td>Agregar Imagen</td>
  	  </tr>
      <tr>
        <td><label>Title / Alt <small>(M&aacute;ximo 60 Caracteres)</small></label><input name="nombre" type="text" id="nombre" /></td>
      </tr>
      <tr>
        <td><label>Imagen <small>(Formatos GIF, JPG o PNG)</small></label><input name="archivo" type="file" id="archivo" size="70" /></td>
      </tr>
      <tr>
        <td align="right"><input type="submit" value="Subir" /></td>
      </tr>
    </table>
</form>
<div id="cargando" class="subiendoMsg"><img src="imagenes/loader.png" /><br />Subiendo Archivo...<br />Esta operaci&oacute;n puede tardar algunos minutos, dependiendo del tama&ntilde;o del archivo.</div>
<?php
$r = mysql_query("SELECT * FROM contenidos_media ORDER BY id DESC");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
?>
<div class="imagenMedia"><img src="../imagenes/media/<?php echo $reg['imagen']?>" width="150" /><br /><small><?php echo $reg['title']?></small><br /><input type="button" value="Eliminar" onclick="Borrar('Media','<?php echo $reg['id']?>')" /></div>
<?php
	}
?>
<div class="clear"></div>
<?php
}
else
{
	echo '<div class="alertaMsg">Por el momento no existen imagenes disponibles</div>';
}
?>
<?php include ('footer.php')?>