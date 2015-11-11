<?php
session_start();
$SID = session_id();
if (!$_SESSION['autorizado'] or $_SESSION['nombreSESION'] <> "AnetAdminMTY2010" or $SID <> $_SESSION['sesionID'])
{
	header("Location: index.php");
}
include ('../include/config.php');
include ('../include/libreria.php');

switch ($_GET['mod'])
{
	case 'Categoria':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO productos_categorias (nombre,title,keywords,description) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['title']).",".Limpia($_POST['keywords']).",".Limpia($_POST['description']).")");
			header('Location: productos.php');
		}
		elseif ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE productos_categorias SET nombre = ".Limpia($_POST['nombre']).", title = ".Limpia($_POST['title']).", keywords = ".Limpia($_POST['keywords']).", description = ".Limpia($_POST['description'])." WHERE id = ".Limpia($_POST['ID']));
			header('Location: productos.php');
		}
		elseif ($_GET['acc'] == "Borrar")
		{
			$r = mysql_query("SELECT imagen FROM productos WHERE categoriaID = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				while ($reg = mysql_fetch_array($r))
				{
					if (file_exists('../imagenes/productos/'.$reg['imagen'])) { unlink ('../imagenes/productos/'.$reg['imagen']); }
				}
				mysql_query("DELETE FROM productos WHERE categoriaID = ".Limpia($_GET['ID']));
			}
			mysql_query("DELETE FROM productos_categorias WHERE id = ".Limpia($_GET['ID']));
			header("Location: productos.php");
		}
		break;
	}
	case 'Producto':
	{
		if ($_GET['acc'] == 'Crear')
		{
			mysql_query("INSERT INTO productos (nombre,modelo,descripcion,precio1,precio2,title,keywords,description,categoriaID) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['modelo']).",".Limpia($_POST['descripcion']).",".Limpia($_POST['precio1']).",".Limpia($_POST['precio2']).",".Limpia($_POST['title']).",".Limpia($_POST['keywords']).",".Limpia($_POST['description']).",".Limpia($_POST['ID']).")");
			$ID = mysql_insert_id();
			if ($_FILES['archivo']['name'] <> '')
			{
				$tipos = array('.JPG','.GIF','.PNG');
				$directorio = '../imagenes/productos/';
				$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],'.')));
		
				if (in_array($extension,$tipos))
				{
					foreach ($tipos as $k => $v)
					{
						if ($extension == $v)
						{
							$temp = "temp".$ID.strtolower($extension);
							$img = "img".$ID.strtolower($extension);
						}
					}
					if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$temp))
					{
						ReDimensionaImagen($temp,$img,600,600,$directorio);
						unlink ($directorio.$temp);
						mysql_query("UPDATE productos SET imagen = ".Limpia($img)." WHERE id = ".Limpia($ID));
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir la imagen al servidor';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'La imagen que intentas subir No tiene un formato Valido';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			header("Location: productos.php?mod=Productos&ID=".$_POST['ID']);
		}
		elseif ($_GET['acc'] == "Editar")
		{
			mysql_query("UPDATE productos SET nombre = ".Limpia($_POST['nombre']).", modelo = ".Limpia($_POST['modelo']).", descripcion = ".Limpia($_POST['descripcion']).", precio1 = ".Limpia($_POST['precio1']).", precio2 = ".Limpia($_POST['precio2']).", title = ".Limpia($_POST['title']).", keywords = ".Limpia($_POST['keywords']).", description = ".Limpia($_POST['description'])." WHERE id = ".Limpia($_POST['ID']));
			if ($_FILES['archivo']['name'] <> '')
			{
				$tipos = array('.JPG','.GIF','.PNG');
				$directorio = '../imagenes/productos/';
				$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],'.')));
		
				if (in_array($extension,$tipos))
				{
					foreach ($tipos as $k => $v)
					{
						if ($extension == $v)
						{
							$temp = "temp".$_POST['ID'].strtolower($extension);
							$img = "img".$_POST['ID'].strtolower($extension);
						}
					}
					if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$temp))
					{
						$r = mysql_query("SELECT imagen FROM productos WHERE id = ".Limpia($_POST['ID']));
						$reg = mysql_fetch_array($r);
						if ($reg['imagen'] <> NULL and file_exists($directorio.$reg['imagen'])) { unlink ($directorio.$reg['imagen']); }
						ReDimensionaImagen($temp,$img,500,500,$directorio);
						unlink ($directorio.$temp);
						mysql_query("UPDATE productos SET imagen = ".Limpia($img)." WHERE id = ".Limpia($_POST['ID']));
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir la imagen al servidor';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'La imagen que intentas subir No tiene un formato Valido';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			$r = mysql_query("SELECT categoriaID FROM productos WHERE id = ".Limpia($_POST['ID']));
			$reg = mysql_fetch_array($r);
			header("Location: productos.php?mod=Productos&ID=".$reg['categoriaID']);
		}
		elseif ($_GET['acc'] == "Borrar")
		{
			$r = mysql_query("SELECT imagen,categoriaID FROM productos WHERE id = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				if ($reg['imagen'] <> '' and file_exists('../imagenes/productos/'.$reg['imagen'])) { unlink ('../imagenes/productos/'.$reg['imagen']); }
			}
			mysql_query("DELETE FROM productos WHERE id = ".Limpia($_GET['ID']));
			header("Location: productos.php?mod=Productos&ID=".$reg['categoriaID']);
		}
		elseif ($_GET['acc'] == 'AddLista')
		{
			$r = mysql_query("SELECT id,nombre,modelo,precio1,precio2 FROM productos WHERE UCASE(modelo) = ".Limpia(strtoupper($_POST['modelo'])));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				$_SESSION['listaProductos'][$reg['id']] = array('nombre' => $reg['nombre'], 'modelo' => $reg['modelo'], 'precio1' => $reg['precio1'], 'precio2' => $reg['precio2']);
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El producto que intentas agregar no existe';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header ('Location: productos.php?mod=Precios');
		}
		elseif ($_GET['acc'] == 'Precios')
		{
			foreach ($_SESSION['listaProductos'] as $k => $v)
			{
				mysql_query("UPDATE productos SET precio1 = ".Limpia($_POST['precio1_'.$k]).", precio2 = ".Limpia($_POST['precio2_'.$k])." WHERE id = ".$k);
			}
			unset ($_SESSION['listaProductos']);
			header ('Location: productos.php?mod=Precios');
		}
		break;
	}
	case 'Contenido':
	{
		if ($_GET['acc'] == 'Editar')
		{
			mysql_query("UPDATE contenidos SET nombre = ".Limpia($_POST['nombre']).", contenido = '".$_POST['contenido']."', title = ".Limpia($_POST['title']).", keywords = ".Limpia($_POST['keywords']).", description = ".Limpia($_POST['description'])." WHERE id = ".Limpia($_POST['ID']));
			header('Location: contenidos.php');
		}
		break;
	}
	case 'Media':
	{
		if ($_GET['acc'] == 'Crear')
		{
			$tipos = array('.JPG','.GIF','.PNG');
			$directorio = '../imagenes/media/';
			$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],'.')));

			if (in_array($extension,$tipos))
			{
				$id = 1;
				$r = mysql_query("SELECT id FROM contenidos_media ORDER BY id DESC LIMIT 1");
				if (mysql_num_rows($r) > 0) { $reg = mysql_fetch_array($r); $id = $reg['id'] + 1; }
				foreach ($tipos as $k => $v)
				{
					if ($extension == $v)
					{
						$file = "img".$id.strtolower($extension);
					}
				}
				if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$file))
				{
					mysql_query("INSERT INTO contenidos_media (title,imagen) VALUES (".Limpia($_POST['nombre']).",".Limpia($file).")");
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir la Imagen al servidor';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'La imagen que intentas subir No es Valida';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
		}
		elseif ($_GET['acc'] == "Borrar")
		{
			$r = mysql_query("SELECT imagen FROM contenidos_media WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			unlink('../imagenes/media/'.$reg['imagen']);
			mysql_query("DELETE FROM contenidos_media WHERE id = ".Limpia($_GET['ID']));
		}
		$r = mysql_query("SELECT title,imagen FROM contenidos_media");
		$image_list = "var tinyMCEImageList = new Array(\n";
		if (mysql_num_rows($r) > 0)
		{
			while ($reg = mysql_fetch_array($r))
			{
				$image_list .= "[\"".$reg['title']."\", \"../imagenes/media/".$reg['imagen']."\"],\n";
			}
			$image_list = substr($image_list, 0, -2)."\n";
		}
		$image_list .= ");";
		$enlace = "include/TM/lists/image_list.js";
		$fp = fopen($enlace,"w"); 
		fwrite($fp,$image_list); 
		fclose($fp);
		header('Location: media.php');
		break;
	}
	case "Cliente":
	{
		if ($act == "Crear")
		{
			$q1 = "SELECT id FROM clientes WHERE email = ".Limpia($_POST['email']);
			$r1 = mysql_query($q1);
			if (mysql_num_rows($r1) > 0)
			{
				$_SESSION['systemAlertTEXT'] = 'La Direccion de Correo Electronico '.$_POST['email'].' ya esta asignada a la cuenta de otro Cliente';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			else
			{
				mysql_query("INSERT INTO clientes(email,nombre,razonSocial,rfc,contacto,direccion,telefono,ciudad,estado,pais,password,tipoClienteID,distribuidorID) VALUES (".Limpia($_POST['email']).",".Limpia($_POST['nombreC']).",".Limpia($_POST['razonSocial']).",".Limpia($_POST['rfc']).",".Limpia($_POST['contacto']).",".Limpia($_POST['domicilio']).",".Limpia($_POST['telefono']).",".Limpia($_POST['ciudad']).",".Limpia($_POST['estado']).",".Limpia($_POST['pais']).",MD5('".$_POST['password']."'),3,0)");
				$r = mysql_query("SELECT id FROM boletines WHERE email = ".Limpia($_POST['email']));
				if (mysql_num_rows($r) <= 0)
				{
					mysql_query("INSERT INTO boletines(nombre,ciudad,email) VALUES (".Limpia($_POST['nombreC']).",".Limpia($_POST['ciudad'].', '.$_POST['estado']).",".Limpia($_POST['email']).")");
				}
				
			}
			header("Location: clientes.php");
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$r = mysql_query("SELECT id FROM pedidos WHERE clienteID = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				while ($reg = mysql_fetch_row($r))
				{
					mysql_query("DELETE FROM pedidos_productos WHERE pedidoID = ".$reg['id']);
				}
			}
			mysql_query("DELETE FROM pedidos WHERE clienteID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM clientes_entregas WHERE clienteID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM clientes_facturacion WHERE clienteID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM clientes WHERE id = ".Limpia($_GET['ID']));
			header("Location: clientes.php");
		}
		elseif ($_GET['acc'] == "Editar")
		{
			$r = mysql_query("SELECT id FROM clientes WHERE email = ".Limpia($_POST['email'])." AND id != ".Limpia($_POST['ID']));
			if (mysql_num_rows($r) > 0)
			{
				$_SESSION['systemAlertTEXT'] = 'El E-mail que intentas registrar ya existe en otra cuenta';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			else
			{
				$q = "UPDATE clientes SET ";
				if ($_POST['mPass'] == 1)
				{
					$q .= "password = MD5('".$_POST['password']."'),";
				}
				$q .= "nombre = ".Limpia($_POST['nombre']).",telefono = ".Limpia($_POST['telefono']).",movil = ".Limpia($_POST['movil']).",email = ".Limpia($_POST['email']).",activo = ".Limpia($_POST['estatus']).",tipoClienteID = ".Limpia($_POST['tipoCliente'])." WHERE id = ".Limpia($_POST['ID']);
				mysql_query($q);
				foreach ($_POST as $k => $v)
				{
					if (strpos($k,'domicilio_') === 0)
					{
						$ID = substr($k,strpos($k,'_') + 1);
						mysql_query("UPDATE clientes_entregas SET domicilio = ".Limpia($_POST['domicilio_'.$ID]).", colonia = ".Limpia($_POST['colonia_'.$ID]).", cp = ".Limpia($_POST['cp_'.$ID]).", entreCalles = ".Limpia($_POST['entreCalles_'.$ID]).", ciudad = ".Limpia($_POST['ciudad_'.$ID]).", estadoID = ".Limpia($_POST['estado_'.$ID])." WHERE id = ".$ID);
					}
				}
				foreach ($_POST as $k => $v)
				{
					if (strpos($k,'razonSocial_') === 0)
					{
						$ID = substr($k,strpos($k,'_') + 1);
						mysql_query("UPDATE clientes_facturacion SET razonSocial = ".Limpia($_POST['razonSocial'.$ID]).", rfc = ".Limpia($_POST['rfc_'.$ID]).", domicilio = ".Limpia($_POST['domicilioF_'.$ID]).", colonia = ".Limpia($_POST['coloniaF_'.$ID]).", cp = ".Limpia($_POST['cpF_'.$ID]).", ciudad = ".Limpia($_POST['ciudadF_'.$ID]).", estadoID = ".Limpia($_POST['estadoF_'.$ID])." WHERE id = ".$ID);
					}
				}
			}
			header("Location: clientes.php");
		}
		break;
	}
	case 'Promocion':
	{
		if ($_GET['acc'] == 'Crear')
		{
			if ($_FILES['archivo']['name'] <> '')
			{
				$tipos = array('.JPG','.GIF','.PNG');
				$directorio = '../imagenes/promociones/';
				$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],'.')));
		
				if (in_array($extension,$tipos))
				{
					$ID = 1;
					$r = mysql_query("SELECT id FROM promociones ORDER BY id DESC LIMIT 1");
					if (mysql_num_rows($r) > 0) { $reg = mysql_fetch_array($r); $ID = $reg['id'] + 1; }
					foreach ($tipos as $k => $v)
					{
						if ($extension == $v)
						{
							$temp = "temp".$ID.strtolower($extension);
							$img = "img".$ID.strtolower($extension);
						}
					}
					if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$temp))
					{
						ReDimensionaImagen($temp,$img,600,800,$directorio);
						unlink ($directorio.$temp);
						mysql_query("INSERT INTO promociones (imagen,vigencia) VALUES (".Limpia($img).",".Limpia($_POST['vigencia']).")");
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir la imagen al servidor';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'La imagen que intentas subir No tiene un formato Valido';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			header("Location: promociones.php");
		}
		elseif ($_GET['acc'] == "Editar")
		{
			mysql_query("UPDATE promociones SET vigencia = ".Limpia($_POST['vigencia'])." WHERE id = ".Limpia($_POST['ID']));
			if ($_FILES['archivo']['name'] <> '')
			{
				$tipos = array('.JPG','.GIF','.PNG');
				$directorio = '../imagenes/promociones/';
				$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],'.')));
		
				if (in_array($extension,$tipos))
				{
					foreach ($tipos as $k => $v)
					{
						if ($extension == $v)
						{
							$temp = "temp".$_POST['ID'].strtolower($extension);
							$img = "img".$_POST['ID'].strtolower($extension);
						}
					}
					if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$temp))
					{
						$r = mysql_query("SELECT imagen FROM promociones WHERE id = ".Limpia($_POST['ID']));
						$reg = mysql_fetch_array($r);
						if ($reg['imagen'] <> NULL and file_exists($directorio.$reg['imagen'])) { unlink ($directorio.$reg['imagen']); }
						ReDimensionaImagen($temp,$img,600,800,$directorio);
						unlink ($directorio.$temp);
						mysql_query("UPDATE promociones SET imagen = ".Limpia($img)." WHERE id = ".Limpia($_POST['ID']));
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir la imagen al servidor';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'La imagen que intentas subir No tiene un formato Valido';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			header("Location: promociones.php");
		}
		elseif ($_GET['acc'] == "Borrar")
		{
			$r = mysql_query("SELECT imagen FROM promociones WHERE id = ".Limpia($_GET['ID']));
			if (mysql_num_rows($r) > 0)
			{
				$reg = mysql_fetch_array($r);
				if (file_exists('../imagenes/promociones/'.$reg['imagen'])) { unlink ('../imagenes/promociones/'.$reg['imagen']); }
			}
			mysql_query("DELETE FROM promociones WHERE id = ".Limpia($_GET['ID']));
			header("Location: promociones.php");
		}
		break;
	}
	
	case "Estatus":
	{
		mysql_query("UPDATE pedidos SET estatusID = ".Limpia($_POST['estatus'])." WHERE id = ".Limpia($_POST['ID']));
		$r = mysql_query("SELECT clienteID FROM pedidos WHERE id = ".Limpia($_POST['ID']));
		$reg = mysql_fetch_array($r);
		header("Location: ".$_POST['return']);
		break;
	}
	case 'EditarPass':
	{
		mysql_query("UPDATE usuarios SET password = MD5(".Limpia($_POST['password']).") WHERE nivel = 1");
		header("Location: cuenta.php");
		break;
	}
	case 'Slide':
	{
		if ($_GET['act'] == 'Crear')
		{
			$tipos = array('.JPG','.GIF','.PNG');
			$directorio = '../imagenes/slider/';
			$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],".")));
			if (in_array($extension,$tipos))
			{
				$ID = 1;
				$r = mysql_query("SELECT id FROM slider_imagenes ORDER BY id DESC LIMIT 1");
				if (mysql_num_rows($r) > 0) { $reg = mysql_fetch_array($r); $ID = $reg['id'] + 1; }
				foreach ($tipos as $k => $v)
				{
					if ($extension == $v)
					{
						$img = 'img'.$ID.strtolower($extension);
					}
				}
				if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$img))
				{
					mysql_query("INSERT INTO slider_imagenes (imagen,liga,target) VALUE ('".$img."',".Limpia($_POST['liga']).",".Limpia($_POST['target']).")");
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir el Archivo al servidor';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			else
			{
				$_SESSION['systemAlertTEXT'] = 'El Archivo que intentas subir no esta en un formato valido';
				$_SESSION['systemAlertTYPE'] = 'Error';
			}
			header('Location: slide.php');
		}
		elseif ($_GET['act'] == 'Editar')
		{
			mysql_query("UPDATE slider_imagenes SET liga = ".Limpia($_POST['liga']).",target = ".Limpia($_POST['target'])." WHERE id = ".Limpia($_POST['ID']));
			if ($_FILES['archivo']['name'])
			{
				$tipos = array('.JPG','.GIF','.PNG');
				$directorio = '../imagenes/slider/';
				$extension = strtoupper(substr($_FILES['archivo']['name'],strrpos($_FILES['archivo']['name'],".")));
				if (in_array($extension,$tipos))
				{
					$ID = $_POST['ID'];
					foreach ($tipos as $k => $v)
					{
						if ($extension == $v)
						{
							$img = 'img'.$ID.strtolower($extension);
						}
					}
					$r = mysql_query("SELECT imagen FROM slider_imagenes WHERE id = ".Limpia($ID));
					$reg = mysql_fetch_array($r);
					if (file_exists($directorio.$reg['imagen'])) { unlink ($directorio.$reg['imagen']); }
					if (move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$img))
					{
						mysql_query("UPDATE slider_imagenes SET imagen = '".$img."' WHERE id = ".Limpia($ID));
					}
					else
					{
						$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar subir el Archivo al servidor';
						$_SESSION['systemAlertTYPE'] = 'Error';
					}
				}
				else
				{
					$_SESSION['systemAlertTEXT'] = 'El Archivo que intentas subir no esta en un formato valido';
					$_SESSION['systemAlertTYPE'] = 'Error';
				}
			}
			header('Location: slide.php');
		}
		elseif ($_GET['acc'] == 'Borrar')
		{
			$r = mysql_query("SELECT imagen FROM slider_imagenes WHERE id = ".Limpia($_GET['ID']));
			$reg = mysql_fetch_array($r);
			if (file_exists('../imagenes/slider/'.$reg['imagen'])) { unlink('../imagenes/slider/'.$reg['imagen']); }
			mysql_query("DELETE FROM slider_imagenes WHERE id = ".Limpia($_GET['ID']));
			header('Location: slide.php');
		}
		break;
	}
	case "Contacto":
	{
		if ($_GET['acc'] == 'Borrar')
		{
			mysql_query("DELETE FROM contactos WHERE id = ".Limpia($_GET['ID']));
			header("Location: contactos.php");
		}
		break;
	}
	case "Pedido":
	{
		if ($_GET['acc'] == 'Borrar')
		{
			mysql_query("DELETE FROM pedidos_productos WHERE pedidoID = ".Limpia($_GET['ID']));
			mysql_query("DELETE FROM pedidos WHERE id = ".Limpia($_GET['ID']));
			header("Location: clientes.php");
		}
		break;
	}
}
?>