<?php include ('header.php');?>
<div class="main">
	<h1>Promociones</h1>
<?php
$r = mysql_query("SELECT imagen,vigencia FROM promociones WHERE vigencia >= '".date('Y-m-d')."'");
if (mysql_num_rows($r) > 0)
{
	$numCols = 4;
	$i = 1;
	while ($reg = mysql_fetch_array($r))
	{
?>
	<div class="divProducto">
		<div class="divImagen"><img src="imagenes/promociones/<?php echo $reg['imagen']?>" width="220" /></div>
		<div class="divLabel">Vigencia:</div><div class="divDatos"><?php echo Fecha($reg['vigencia'])?></div>
	</div>
<?php
		if ($i == $numCols) { echo '<div class="clear"></div>'; $i = 1; }
		else { $i++; }
	}
}
else
{
	echo '<div class="alertaMsg">No hay promociones vigentes</div>';
}
?>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>