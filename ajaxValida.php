<?php session_start(); ?>
<?php require_once ('include/config.php'); ?>
<?php require_once ('include/libreria.php'); ?>
<?php
switch ($_GET['mod'])
{
	case 'validaEmail':
	{
		$r = mysql_query("SELECT id FROM clientes WHERE email = ".Limpia($_GET['email']));
		if (mysql_num_rows($r) <= 0)
		{
			echo '<img src="imagenes/okIcon.png" title="El e-mail que ingresaste aun no esta registrado en ninguna cuenta" />';
		}
		else
		{
			echo '<img src="imagenes/errorIcon.png" title="El e-mail que ingresaste ya esta registrado en una cuenta, y no puede volverse a registrar" />';
		}
		break;
	}
	case 'validaPassword':
	{
		if ($_GET['pass1'] == $_GET['pass2'])
		{
			echo '<img src="imagenes/okIcon.png" title="La confirmacion de la contraseña coincide con la contraseña seleccionada" />';
		}
		else
		{
			echo '<img src="imagenes/errorIcon.png" title="La confirmacion de la contraseña no coincide con la contraseña seleccionada, favor de volverla a teclear" />';
		}
		break;
	}
}
?>