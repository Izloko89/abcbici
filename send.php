<?php session_start(); ?>
<?php require_once ('include/config.php');?>
<?php require_once ('include/libreria.php');?>
<?php
include_once('include/class.phpmailer.php');
$mail = new PHPMailer();
$mail->IsSMTP();

switch ($_GET['mod'])
{
	case "Login":
	{
		$r = mysql_query("SELECT id,nombre,tipoClienteID FROM clientes WHERE email = ".Limpia($_POST['email'])." AND password = '".MD5($_POST['password'])."' AND activo = 1");
		if (mysql_num_rows($r) > 0 and $_POST['email'] <> '0')
		{
			$reg = mysql_fetch_array($r);
			$_SESSION['cteTVAnetID'] = $reg['id'];
			$_SESSION['cteTVAnetNOMBRE'] = $reg['nombre'];
			$_SESSION['cteTVAnetTIPO'] = $reg['tipoClienteID'];
			$_SESSION['sessionCteTVAnetID'] = session_id();
			header('Location: carrito.php');
		}
		else
		{
			$_SESSION['systemAlertTEXT'] = 'Lo Sentimos, el E-mail y / o la Contrase&ntilde;a que estas utilizando No son Correctos, o bien, tu Cuenta ha sido Temporalmente Suspendida';
			$_SESSION['systemAlertTYPE'] = 'Error';
			header ('Location: login.php');
		}
		break;
	}
	case "Registro":
	{
		/*if(strlen($_POST['imagetext']) == 7 and isset($_SESSION['text']) and strtolower($_POST['imagetext']) == $_SESSION['text'])
		{*/
			$q1 = "SELECT id FROM clientes WHERE email = ".Limpia($_POST['email']);
			$r1 = mysql_query($q1);
			if (mysql_num_rows($r1) > 0)
			{
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['password'] = $_POST['password'];
				$_SESSION['nombre'] = $_POST['nombre'];
				$_SESSION['telefono'] = $_POST['telefono'];
				$_SESSION['movil'] = $_POST['movil'];
				$_SESSION['domicilio'] = $_POST['domicilio'];
				$_SESSION['colonia'] = $_POST['colonia'];
				$_SESSION['cp'] = $_POST['cp'];
				$_SESSION['entreCalles'] = $_POST['entreCalles'];
				$_SESSION['ciudad'] = $_POST['ciudad'];
				$_SESSION['estado'] = $_POST['estado'];
				$_SESSION['solicitudMayorista'] = $_POST['solicitudMayorista'];
				$_SESSION['systemAlertTEXT'] = 'El E-mail que intentas registrar ya existe en otra cuenta';
				$_SESSION['systemAlertTYPE'] = 'Error';
				header ('Location: registro.php');
			}
			else
			{
				unset($_SESSION['email']);
				unset($_SESSION['password']);
				unset($_SESSION['nombre']);
				unset($_SESSION['telefono']);
				unset($_SESSION['movil']);
				unset($_SESSION['domicilio']);
				unset($_SESSION['colonia']);
				unset($_SESSION['cp']);
				unset($_SESSION['entreCalles']);
				unset($_SESSION['ciudad']);
				unset($_SESSION['estado']);
				unset($_SESSION['solicitudMayorista']);
				$arrRespuestas = array('No','Si');
				mysql_query("INSERT INTO clientes(nombre,telefono,movil,email,password,solicitudMayorista) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['telefono']).",".Limpia($_POST['movil']).",".Limpia($_POST['email']).",MD5('".$_POST['password']."'),".Limpia($_POST['solicitudMayorista']).")");
				$IDUsuario = mysql_insert_id();
				if (trim($_POST['domicilio']) <> '' and trim($_POST['colonia']) <> '' and trim($_POST['ciudad']) <> '')
				{
					mysql_query("INSERT INTO clientes_entregas(domicilio,colonia,cp,entreCalles,ciudad,estadoID,clienteID) VALUES (".Limpia($_POST['domicilio']).",".Limpia($_POST['colonia']).",".Limpia($_POST['cp']).",".Limpia($_POST['entreCalles']).",".Limpia($_POST['ciudad']).",".Limpia($_POST['estado']).",".Limpia($IDUsuario).")");
				}
				
				$mensaje = "<strong>Nombre: </strong> ".$_POST['nombre']."<br>";
				$mensaje .= "<strong>Telefono: </strong> ".$_POST['telefono']."<br>";
				$mensaje .= "<strong>Telefono Movil: </strong> ".$_POST['movil']."<br>";
				$mensaje .= "<strong>E-mail: </strong> ".$_POST['email']."<br>";
				$mensaje .= "<strong>¿Solicita ser mayorista?: </strong> ".$arrRespuestas[$_POST['solicitudMayorista']]."<br>";

				$mail->From = 'webmaster@'.$dominio;
				$mail->FromName = 'Catalogo Virtual ['.$dominio.']';
				$mail->Subject = "Registro de Cliente Nuevo";
				$mail->AltBody = "Para ver el mensaje, por favor, utilice un visor de correo electrónico compatible con HTML!";
				$mail->MsgHTML($mensaje);
				foreach ($arrEMails as $k => $v)
				{
					$mail->AddAddress($v);
				}
				$mail->Send();
				$_SESSION['cteTVAnetID'] = $IDUsuario;
				$_SESSION['cteTVAnetNOMBRE'] = $_POST['nombre'];
				$_SESSION['sessionCteTVAnetID'] = session_id();
				header('Location: login.php');
			}
		/*}
		else
		{
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $_POST['password'];
			$_SESSION['nombre'] = $_POST['nombre'];
			$_SESSION['telefono'] = $_POST['telefono'];
			$_SESSION['movil'] = $_POST['movil'];
			$_SESSION['domicilio'] = $_POST['domicilio'];
			$_SESSION['colonia'] = $_POST['colonia'];
			$_SESSION['cp'] = $_POST['cp'];
			$_SESSION['entreCalles'] = $_POST['entreCalles'];
			$_SESSION['ciudad'] = $_POST['ciudad'];
			$_SESSION['estado'] = $_POST['estado'];
			$_SESSION['solicitudMayorista'] = $_POST['solicitudMayorista'];
			$_SESSION['systemAlertTEXT'] = 'El texto no coincide con la imagen';
			$_SESSION['systemAlertTYPE'] = 'Error';
			header ('Location: registro.php');
		}*/
		break;
	}
	case "EditaCuenta":
	{
		$r = mysql_query("SELECT id FROM clientes WHERE email = ".Limpia($_POST['email'])." AND id != ".$_SESSION['cteTVAnetID']);
		if (mysql_num_rows($r) > 0)
		{
			$_SESSION['systemAlertTEXT'] = 'El E-mail que intentas registrar ya existe en otra cuenta';
			$_SESSION['systemAlertTYPE'] = 'Error';
		}
		else
		{
			$q = "UPDATE clientes SET ";
			if ($_POST['cPass'] == 1)
			{
				$q .= "password = MD5('".$_POST['password']."'),";
			}
			$q .= "nombre = ".Limpia($_POST['nombre']).",telefono = ".Limpia($_POST['telefono']).",movil = ".Limpia($_POST['movil']).",email = ".Limpia($_POST['email'])." WHERE id = '".$_SESSION['cteTVAnetID']."'";
			mysql_query($q);
			$_SESSION['systemAlertTEXT'] = 'Tus datos han sido actualizados';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
		}
		header ('Location: registro.php');
		break;
	}
	case "Pedido":
	{
		$_SESSION['fEmbarque'] = $_POST['fEmbarque'];
		if ($_POST['fEmbarque'] == 'Ocurre') { $_SESSION['domEntrega'] = 'N / A'; }
		$_SESSION['fPago'] = $_POST['fPago'];
		$_SESSION['comentarios'] = $_POST['comentarios'];
		if ($_POST['fEmbarque'] == 'A Domicilio' and (!isset($_SESSION['domEntrega']) or $_SESSION['domEntrega'] == 'N / A'))
		{
			$_SESSION['systemAlertTEXT'] = 'Si tu Forma de Entrega es <b>A Domicilio</b>, es necesario que indiques el Domicilio de Entrega';
			$_SESSION['systemAlertTYPE'] = 'Error';
			$liga = 'pedido.php';
		}
		else
		{
			$liga = 'cPedido.php';
		}
		header('Location: '.$liga);
		break;
	}
	case "Contacto":
	{
		mysql_query("INSERT INTO contactos(nombre,telefono,email,ubicacion,mensaje) VALUES (".Limpia($_POST['nombre']).",".Limpia($_POST['telefono']).",".Limpia($_POST['email']).",".Limpia($_POST['ubicacion']).",".Limpia($_POST['mensaje']).")");
		$mensaje = '<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">';
		$mensaje .= '<tr><td align="right">Nombre:</td><td>'.$_POST['nombre'].'</td></tr>';
		$mensaje .= '<tr><td align="right">Telefono:</td><td>'.$_POST['telefono'].'</td></tr>';
		$mensaje .= '<tr><td align="right">E-mail:</td><td>'.$_POST['email'].'</td></tr>';
		$mensaje .= '<tr><td align="right">Mensaje:</td><td>'.nl2br($_POST['mensaje']).'</td></tr>';
		$mensaje .= '</table>';
	
		$mail->From = 'webmaster@'.$dominio;
		$mail->FromName = 'Catalogo Virtual ['.$dominio.']';
		$mail->Subject = "Contacto Pagina Web";

		$mail->AltBody = "Para ver el mensaje, por favor, utilice un visor de correo electrónico compatible con HTML!";
		$mail->MsgHTML($mensaje);
		foreach ($arrEMails as $k => $v)
		{
			$mail->AddAddress($v);
		}
		if($mail->Send())
		{
			$_SESSION['systemAlertTEXT'] = 'Tus comentarios fueron enviados correctamente';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
		}
		else
		{
			$_SESSION['systemAlertTEXT'] = 'Se presento un error al intentar enviar tus comentarios';
			$_SESSION['systemAlertTYPE'] = 'Error';
		}
		header ('Location: contenido.php?ID=2');
		break;
	}
	case "RecuperaPass":
	{
		$r = mysql_query("SELECT id,nombre,email FROM clientes WHERE email = ".Limpia($_POST['emailRecupera']));
		if (mysql_num_rows($r) > 0)
		{
			$pass = '';
			for($i = 0; $i < 8; $i++)
			{
				$pass.=chr(rand(65,90));
	    	}
			$reg = mysql_fetch_array($r);
			mysql_query("UPDATE clientes SET password = MD5('".strtoupper($pass)."') WHERE id = ".$reg['id']);
		
			$mensaje = "Hola ".$reg['nombre'].",<br>La Contrase&ntilde;a para accesar a tu cuenta de nuestro catalogo virtual ha sido cambiada a:<br><br>";
			$mensaje .= "<strong>".$pass."</strong><br><br>Recuerda que puedes volverla a cambiar accesando a tu cuenta y entrando a la Seccion 'Mi Cuenta'.";
		
			$mail->From = 'webmaster@'.$dominio;
			$mail->FromName = 'Catalogo Virtual ['.$dominio.']';
			$mail->Subject = "Recuperacion de Password";
			$mail->AltBody = "Para ver el mensaje, por favor, utilice un visor de correo electrónico compatible con HTML!";
			$mail->MsgHTML($mensaje);
			$mail->AddAddress(strtolower($reg['email']),$reg['nombre']);
			$mail->Send();
			$_SESSION['systemAlertTEXT'] = 'Su contrase&ntilde;a ha sido cambiada, le hemos enviado los nuevos datos de acceso a su correo electronico <b><i>'.$reg['email'].'</i></b>, recuerde buscar en la <b>Carpeta de Correo no Deseado</b> en caso de que no vea el correo en su <b>Bandeja de Entrada</b>.';
			$_SESSION['systemAlertTYPE'] = 'Aviso';
		}
		else
		{
			$_SESSION['systemAlertTEXT'] = 'Lo Sentimos, el Correo Electronico <b><i>'.$_POST['email'].'</i></b> no existe en nuestra base de datos de Clientes<br><br>Registrece Gratis y comience a solicitar sus cotizaciones por Internet';
			$_SESSION['systemAlertTYPE'] = 'Error';
		}
		header('Location: login.php');
		break;
	}
	default:
	{
		header("Location: index.php");
		break;
	}
}
?>