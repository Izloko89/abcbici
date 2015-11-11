<?php include('header.php'); ?>
<h1>Catalogo de Productos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cambiar Precios" onclick="window.location = 'productos.php?mod=Precios'" /></h1>
<?php
if (!isset($_GET['mod']))
{
?>  
<form action="backend.php?mod=Categoria&acc=Crear" method="post" name="form1" id="form1">
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
  <tr class="encabezado">
    <td>Crear Categoria</td>
  </tr>
  <tr>
    <td width="75%"><label>Nombre</label><input type="text" name="nombre" id="nombre" /></td>
  </tr>
  <tr>
    <td class="encabezado">Meta Tags</td>
  </tr>
  <tr>
      <td><label>Title <small>(M&aacute;ximo 60 Caracteres)</small></label><input type="text" name="title" id="title" /></td>
    </tr>
    <tr>
      <td><label>Keywords<small> (M&aacute;ximo 160 Caracteres)</small></label><input type="text" name="keywords" id="keywords" /></td>
    </tr>
    <tr>
      <td><label>Description <small>(M&aacute;ximo 160 Caracteres)</small></label><input type="text" name="description" id="description" /></td>
    </tr>
  <tr>
    <td align="right"><input type="submit" value="Guardar" /></td>
    </tr>
</table>
</form>
<?php
	$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY id ASC");
	if (mysql_num_rows($r) > 0)
	{
?>
<br />
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="54%">Nombre</td>
    <td width="16%">Productos</td>
    <td width="15%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
  </tr>
<?php
		while ($reg = mysql_fetch_array($r))
    	{
?>
  <tr class="fila">
    <td><?php echo $reg['nombre']?></td>
    <td align="center"><input type="button" value="Administrar" onclick="window.location = 'productos.php?mod=Productos&ID=<?php echo $reg['id']?>'" /></td>
    <td align="center"><input type="button" value="Editar" onclick="window.location = 'productos.php?mod=EditarCategoria&ID=<?php echo $reg['id']?>'" /></td>
    <td align="center"><input type="button" value="Eliminar" onclick="Borrar('Categoria','<?php echo $reg['id']?>')" /></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
	else
	{
		echo '<div class="alertaMsg">No se han registrado categorias</div>';
	}
}
elseif ($_GET['mod'] == 'EditarCategoria')
{
	$r = mysql_query("SELECT * FROM productos_categorias WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>  
<form action="backend.php?mod=Categoria&acc=Editar" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
  <tr class="encabezado">
    <td>Editar Categoria</td>
  </tr>
  <tr>
    <td width="75%"><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
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
    <td align="right"><input type="submit" value="Guardar" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="window.location = 'productos.php?mod=Categorias&ID=<?php echo $reg['marcaID']?>'" /></td>
    </tr>
</table>
</form>
<?php
	}
	else
	{
		echo '<div class="errorMsg">La categoria que intentas editar no existe</div>';
	}
}
elseif ($_GET['mod'] == 'Productos')
{
	$r = mysql_query("SELECT nombre FROM productos_categorias WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>  
<form action="backend.php?mod=Producto&acc=Crear" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
  <tr class="encabezado">
    <td>Crear Producto<?php echo ' - '.$reg['nombre']; ?></td>
  </tr>
  <tr>
    <td><label>Nombre</label><input type="text" name="nombre" id="nombre" /></td>
    </tr>
    <tr>
      <td><label>Modelo</label>
      <input type="text" name="modelo" id="modelo" /></td>
    </tr>
    <tr>
      <td><label>Descripcion</label>
      <textarea name="descripcion" id="descripcion" rows="5"></textarea></td>
    </tr>
    <tr>
      <td><label>Precio Menudeo <small>(Solo valores numericos)</small></label>
      <input type="text" name="precio" id="precio" onkeyup="return SoloNumero(this);" /></td>
    </tr>
    <tr>
      <td><label>Precio Mayoreo <small>(Solo valores numericos)</small></label>
      <input type="text" name="precio" id="precio" onkeyup="return SoloNumero(this);" /></td>
    </tr>
    <tr>
      <td><label>Imagen <small>(Solo formatos JPG, GIF y PNG)</small></label>
      <input name="archivo" type="file" id="archivo" size="70" /></td>
    </tr>
    <tr>
    <td class="encabezado">Meta Tags</td>
  </tr>
  <tr>
      <td><label>Title <small>(M&aacute;ximo 60 Caracteres)</small></label><input type="text" name="title" id="title" /></td>
    </tr>
    <tr>
      <td><label>Keywords<small> (M&aacute;ximo 160 Caracteres)</small></label><input type="text" name="keywords" id="keywords" /></td>
    </tr>
    <tr>
      <td><label>Description <small>(M&aacute;ximo 160 Caracteres)</small></label><input type="text" name="description" id="description" /></td>
    </tr>
  <tr>
      <td align="right"><input type="submit" value="Guardar" /></td>
    </tr>
</table>
</form>
<?php
		$r1 = mysql_query("SELECT id,nombre,modelo,precio1,precio2,imagen FROM productos WHERE categoriaID = ".Limpia($_GET['ID'])." ORDER BY nombre ASC");
		if (mysql_num_rows($r1) > 0)
		{
?>
<br />
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr class="encabezado">
    <td width="15%">Imagen</td>
    <td width="10%">Modelo</td>
    <td width="35%">Nombre</td>
    <td width="10%">Precio Menudeo</td>
    <td width="10%">Precio Mayoreo</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
<?php
			while ($reg1 = mysql_fetch_array($r1))
			{
?>
  <tr class="fila">
    <td align="center"><?php if ($reg1['imagen'] <> NULL and file_exists('../imagenes/productos/'.$reg1['imagen'])) { echo '<img src="../imagenes/productos/'.$reg1['imagen'].'" width="100" />'; } else { echo 'PRODUCTO SIN IMAGEN'; }?></td>
    <td><?php echo $reg1['modelo']?></td>
    <td><?php echo $reg1['nombre']?></td>
    <td align="right"><?php echo '$ '.number_format($reg1['precio1'],2)?></td>
    <td align="right"><?php echo '$ '.number_format($reg1['precio2'],2)?></td>
    <td align="center"><input type="button" value="Editar" onclick="window.location = 'productos.php?mod=EditarProducto&ID=<?php echo $reg1['id']?>'" /></td>
    <td align="center"><input type="button" value="Eliminar" onclick="Borrar('Producto','<?php echo $reg1['id']?>')" /></td>
  </tr>
<?php
			}
?>
</table>
<?php
		}
		else
		{
			echo '<div class="alertaMsg">No se han registrado productos en esta categoria</div>';
		}
	}
	else
	{
		echo '<div class="errorMsg">La categoria que intentas editar no existe</div>';
	}
}
elseif ($_GET['mod'] == 'EditarProducto')
{
	$r = mysql_query("SELECT * FROM productos WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
?>  
<form action="backend.php?mod=Producto&acc=Editar" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']?>" />
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
  <tr class="encabezado">
    <td>Editar Producto</td>
  </tr>
  <tr>
    <td><label>Nombre</label><input type="text" name="nombre" id="nombre" value="<?php echo $reg['nombre']?>" /></td>
    </tr>
    <tr>
      <td><label>Modelo</label>
      <input type="text" name="modelo" id="modelo" value="<?php echo $reg['modelo']?>" /></td>
    </tr>
    <tr>
      <td><label>Descripcion</label>
      <textarea name="descripcion" id="descripcion" rows="5"><?php echo $reg['descripcion']?></textarea></td>
    </tr>
    <tr>
      <td><label>Precio <small>(Solo valores numericos)</small></label>
      <input type="text" name="precio1" id="precio1" onkeyup="return SoloNumero(this);" value="<?php echo $reg['precio1']?>" /></td>
    </tr>
    <tr>
      <td><label>Precio <small>(Solo valores numericos)</small></label>
      <input type="text" name="precio2" id="precio2" onkeyup="return SoloNumero(this);" value="<?php echo $reg['precio2']?>" /></td>
    </tr>
    <tr>
      <td><label>Cambiar Imagen <small>(Solo formatos JPG, GIF y PNG)</small></label><input name="archivo" type="file" id="archivo" size="70" /></td>
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
      <td align="right"><input type="submit" value="Guardar" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="window.location = 'productos.php?mod=Productos&ID=<?php echo $reg['categoriaID']?>'" /></td>
    </tr>
</table>
</form>
<?php
	}
	else
	{
		echo '<div class="errorMsg">El producto que intentas editar no existe</div>';
	}
}
elseif ($_GET['mod'] == 'Precios')
{
?>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="forma">
  <tr class="encabezado">
    <td>Cambio Rapido de Precios</td>
  </tr>
  <tr>
    <td><form name="Modelos" method="post" action="backend.php?mod=Producto&acc=AddLista"><label style="display:inline; margin-right:10px;">Modelo</label><input type="text" name="modelo" id="modelo" style="width:30%; margin-right:10px;" /><input type="submit" value="Agregar" /></form></td>
    </tr>
    <tr class="encabezado">
    <td>Productos a modificar</td>
  </tr>
    <tr>
    <td>
<?php
	if (isset($_SESSION['listaProductos']))
	{
		echo '<form name="formPrecios" method="post" action="backend.php?mod=Producto&acc=Precios">';
		echo '<input type="submit" value="Aplicar Cambios" align="right" style="margin-bottom:10px;" />';
		echo '<ul class="listaPR">';
		foreach ($_SESSION['listaProductos'] as $k => $v)
		{
			echo '<li><strong><i>'.$v['modelo'].'</i></strong> '.$v['nombre'].'<div><strong>Mayoreo:</strong> <input type="text" name="precio2_'.$k.'" id="precio2_'.$k.'" value="'.$v['precio2'].'" style="width:60px;" /></div><div><strong>Menudeo:</strong> <input type="text" name="precio1_'.$k.'" id="precio1_'.$k.'" value="'.$v['precio1'].'" style="width:60px;" /></div></div></li>';
		}
		echo '</ul>';
		echo '<input type="submit" value="Aplicar Cambios" align="right" style="margin-bottom:10px;" />';
		echo '</form>';
	}
	else
	{
		echo '<div class="alertaMsg">La lista esta vacia</div>';
	}
?>
	</td>
    </tr>
</table>
<?php
}
?>
<?php include('footer.php'); ?>