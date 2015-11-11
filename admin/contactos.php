<?php include ('header.php')?>
<h1>Contactos</h1>
<?php
$porPagina = 100;
if (!isset($_GET['page'])) { $_GET['page'] = 1; }
$desde = ($_GET['page'] - 1) * $porPagina;
$r = mysql_query("SELECT COUNT(*) AS paginas FROM contactos");
$reg = mysql_fetch_array($r);
$noPaginas = ceil($reg['paginas'] / $porPagina);
if ($noPaginas == 0) {$noPaginas = 1;}
$r = mysql_query("SELECT * FROM contactos ORDER BY id DESC, nombre ASC LIMIT ".$desde.",".$porPagina);
if (mysql_num_rows($r) > 0)
{
?>
<table width="50%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="33%" align="center"><?php if ($_GET['page'] > 1) {?><a href="contactos.php?page=<?php echo $_GET['page'] - 1?>">Página Anterior</a><?php }?></td>
    <td width="34%" align="center">Página <?php echo $_GET['page']?> de <?php echo $noPaginas?></td>
    <td width="33%" align="center"><?php if ($_GET['page'] < $noPaginas) {?><a href="contactos.php?page=<?php echo $_GET['page'] + 1?>">Página Siguiente</a><?php }?></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="20%">Nombre</td>
    <td width="15%">Telefono</td>
    <td width="20%">E-mail</td>
    <td width="15%">Ubicacion</td>
    <td width="20%">Mensaje</td>
    <td width="10%">&nbsp;</td>
  </tr>
<?php
	while ($reg = mysql_fetch_array($r))
	{
?>
  <tr class="fila">
    <td><?php echo $reg['nombre']?></td>
    <td><?php echo $reg['telefono']?></td>
    <td><?php echo $reg['email']?></td>
    <td><?php echo $reg['ubicacion']?></td>
    <td><?php echo nl2br($reg['mensaje'])?></td>
    <td align="center"><input type="button" value="Eliminar" onclick="Borrar('Contacto','<?php echo $reg['id']?>')" /></td>
  </tr>
<?php
	}
?>
</table>
<table width="50%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="33%" align="center"><?php if ($_GET['page'] > 1) {?><a href="contactos.php?page=<?php echo $_GET['page'] - 1?>">Página Anterior</a><?php }?></td>
    <td width="34%" align="center">Página <?php echo $_GET['page']?> de <?php echo $noPaginas?></td>
    <td width="33%" align="center"><?php if ($_GET['page'] < $noPaginas) {?><a href="contactos.php?page=<?php echo $_GET['page'] + 1?>">Página Siguiente</a><?php }?></td>
  </tr>
</table>
<?php
}
else
{
	echo '<div class="alertaMsg">No hay contactos registrados</div>';
}
?>
<?php include ('footer.php')?>