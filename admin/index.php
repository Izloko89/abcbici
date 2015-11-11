<?php 
session_start();
require_once('../include/config.php');
require_once('../include/libreria.php');

if (isset($_POST['user']) and isset($_POST['password']))
{
	$q = "SELECT username FROM usuarios WHERE username = ".Limpia($_POST['user'])." AND password = '".MD5($_POST['password'])."'";
	$r = mysql_query($q);
	if (mysql_num_rows($r) > 0)
	{
		$_SESSION['autorizado'] = true;
		$_SESSION['idUSUARIO'] = 0;
		$_SESSION['nivelUSUARIO'] = 'Administrador';
		$_SESSION['nombreSESION'] = "AnetAdminMTY2010";
		$_SESSION['sesionID'] = session_id();
		header("Location: productos.php");
	}
	else
	{
		$_SESSION['systemAlertTEXT'] = 'Usuario y/o Contraseña Incorrectos';
		$_SESSION['systemAlertTYPE'] = 'Error';
	}
}
?>
<!--
Diseño y Desarrollo: Ing. Ruben Aaron Islas Trujillo
Monterrey, Nuevo Leon, Mexico, 2009
 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!--ALERTAS -->
<link rel="stylesheet" type="text/css" media="all" href="include/SA/sexyalertbox.css"/>
<script type="text/javascript" src="include/SA/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="include/SA/sexyalertbox.v1.2.moo.js"></script>
<!--ESTILOS Y FUNCIONES GENERALES DEL SISTEMA -->
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script src="include/jsFunctions.js" type="text/javascript"></script>
<title>PANEL DE ADMINISTRACION</title>
</head>
<body<?php if (isset($_SESSION['systemAlertTEXT']) and isset($_SESSION['systemAlertTYPE'])) {?> onload="Alerta('<?php echo $_SESSION['systemAlertTEXT']?>','<?php echo $_SESSION['systemAlertTYPE']?>');return false;"<?php unset($_SESSION['systemAlertTEXT']); unset($_SESSION['systemAlertTYPE']); }?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#333333"><img src="imagenes/logo.jpg" width="243" height="66" /></td>
  </tr>
  <tr class="login1">
    <td height="25" align="center">Panel de Administracion</td>
  </tr>
</table>
<br />
<br />
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" class="cuerpo">
  
  
  <tr>
    <td><br />
        <br />
          <table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="login">
      <form id="form1" name="form1" method="post" action="">
        <tr>
          <td class="login1">Por Favor, ingresa tu Usuario y Contrase&ntilde;a</td>
        </tr>
        <tr>
          <td width="40%" align="center" class="login2"><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <td align="center">Usuario</td>
              </tr>
              <tr>
                <td align="center"><input name="user" type="text" id="user" size="20" /></td>
              </tr>
              <tr>
                <td align="center">Contrase&ntilde;a</td>
              </tr>
              <tr>
                <td align="center"><input name="password" type="password" id="password" size="20" /></td>
              </tr>
              <tr>
                <td><center>
                    <input type="submit" value="Entrar" />
                </center></td>
              </tr>
          </table></td>
        </tr>
      </form>
    </table>
    <br />
    <br /></td>
  </tr>
</table>
<br />
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" align="center" class="copyright">&copy; Todos los Derechos Reservados <?php echo date("Y"); ?></td>
      </tr>
    </table>
</body>
</html>
