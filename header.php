<?php session_start(); ?>
<?php require_once('include/config.php');?>
<?php require_once('include/libreria.php');?>
<?php
$title = ':: GORAY ::';
$keywords = 'Bicicletas Goray';
$description = 'Bicicletas Goray';

if(strpos($_SERVER['PHP_SELF'],"show.php") and isset($_GET['ID']))
{
	$r = mysql_query("SELECT title,keywords,description FROM productos_categorias WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		if (trim($reg['title']) <> '') { $title = utf8_encode($reg['title']); }
		if (trim($reg['keywords']) <> '') { $keywords = utf8_decode($reg['keywords']); }
		if (trim($reg['description']) <> '') { $description = utf8_decode($reg['description']); }
	}
}
elseif(strpos($_SERVER['PHP_SELF'],"contenido.php") and isset($_GET['ID']))
{
	$r = mysql_query("SELECT title,keywords,description FROM contenidos WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		if (trim($reg['title']) <> '') { $title = utf8_decode($reg['title']); }
		if (trim($reg['keywords']) <> '') { $keywords = utf8_decode($reg['keywords']); }
		if (trim($reg['description']) <> '') { $description = utf8_decode($reg['description']); }
	}
}
elseif(strpos($_SERVER['PHP_SELF'],"detalle.php") and isset($_GET['ID']))
{
	$r = mysql_query("SELECT title,keywords,description FROM productos WHERE id = ".Limpia($_GET['ID']));
	if (mysql_num_rows($r) > 0)
	{
		$reg = mysql_fetch_array($r);
		if (trim($reg['title']) <> '') { $title = utf8_decode($reg['title']); }
		if (trim($reg['keywords']) <> '') { $keywords = utf8_decode($reg['keywords']); }
		if (trim($reg['description']) <> '') { $description = utf8_decode($reg['description']); }
	}
}
if (!isset($_SESSION['cteTVAnetTIPO'])) { $_SESSION['cteTVAnetTIPO'] = 1; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $description?>" />
<meta name="keywords" content="<?php echo $keywords?>" />
<title><?php echo $title?></title>
<!--NIVO SLIDER -->
<link rel="stylesheet" href="include/SLIDER/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="include/SLIDER/nivo-slider.css" type="text/css" media="screen" />
<!--ALERTAS -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript" src="include/SA/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="include/SA/sexyalertbox.v1.2.jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="include/SA/sexyalertbox.css"/>
<!--AJAX -->
<script type="text/javascript" src="include/ajax.js"></script>
<!--GENERAL -->
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="include/jsFunctions.js"></script>
<!--GALERIA -->
<link rel="stylesheet" type="text/css" href="include/GALERIA/highslide.css" />
<script type="text/javascript" src="include/GALERIA/highslide.js"></script>
<script type="text/javascript">
hs.registerOverlay({
	html: '<div class="closebutton" onclick="return hs.close(this)" title="Cerrar"></div>',
	position: 'top right',
	fade: 2
});


hs.graphicsDir = 'include/GALERIA/graphics/';
hs.wrapperClassName = 'borderless';
hs.align = 'center';
hs.outlineType = 'glossy-dark';
hs.wrapperClassName = 'dark';
</script>
<!--ANALITYCS -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-68257838-1', 'auto');
  ga('send', 'pageview');
 
</script>
</head>
<body onload="MM_preloadImages('imagenes/btn-entrar2.png','imagenes/btn-ver-carrito2.png','imagenes/btn-agregar2.png','imagenes/btn-vermas2.png','imagenes/bgMenuOver.png');<?php if (isset($_SESSION['systemAlertTEXT']) and isset($_SESSION['systemAlertTYPE'])) {?> Alerta('<?php echo $_SESSION['systemAlertTEXT']?>','<?php echo $_SESSION['systemAlertTYPE']?>');return false;<?php unset($_SESSION['systemAlertTEXT']); unset($_SESSION['systemAlertTYPE']); }?>">
<div id="divRecuperar">
	<div class="divCerrar" onclick="document.getElementById('divRecuperar').style.display = 'none'"></div>
	<form name="Recupera" id="Recupera" method="post" action="send.php?mod=RecuperaPass">
   		<label>Por favor, proporcionanos el correo electrónico que tienes registrado en tu cuenta para enviarte una nueva contraseña</label>
        <input type="text" name="emailRecupera" id="emailRecupera" />
        <input type="submit" value="Enviar" class="boton" />
   	</form>
</div>
<div id="header">
	<div class="main">
    	<div id="divHeader">
            <div id="divEnvio">Envio a todo México</div>
            <a href="">Faq</a>
            <a href="contenido.php?ID=2">Contacto</a>
            <div id="divTelefono">(81) 8372.0199 y 01800.58.10.691</div>
<?php
if (isset($_SESSION['cteTVAnetID']) and isset($_SESSION['sessionCteTVAnetID']))
{
?>
                <ul>
                    <li class="datos">En Linea<br /><span><?php echo $_SESSION['cteTVAnetNOMBRE']?></span></li>
                    <li><a href="">Mi<br />Cuenta</a></li>
                    <li><a href="pedidos.php">Mis Pedidos</a></li>
                    <li><a href="logout.php">Cerrar Sesion</a></li>
                </ul>
<?php
}
else
{
?>
			<a href="login.php" id="aMicuenta">Mi cuenta</a>
<?php
}
?>
            
            <div class="clear"></div>
		</div>
    	<div id="logo"><img src="imagenes/logo-goray.png" /></div>
        <div id="divBuscador">
        	<form method="get" action="">
            	<input type="text" name="Search" />
                <input type="submit" value="" />
            </form>
        </div>
<?php
$totalProductos = 0;
if (isset($_SESSION['cartTVAmNet']) and count($_SESSION['cartTVAmNet']) > 0)
{
	foreach ($_SESSION['cartTVAmNet'] as $k => $v)
	{
		$totalProductos += $v['cantidad'];
	}
}
?>
        <a href="carrito.php" id="aCarrito" class="aBox">
<?php

?>
        </a>
        <a href="" id="aTwitter" class="aBox"></a>
        <a href="https://www.facebook.com/abcbici" id="aFacebook" class="aBox"></a>
        <div class="clear"></div>
	</div>
</div>
<div id="nav">
	<div class="main">
    	<ul>
			<li><a href="<?php echo RUTA?>">Inicio</a></li>
            <li><a href="contenido.php?ID=1">Quienes Somos</a></li>
<?php
$r = mysql_query("SELECT id,nombre FROM productos_categorias ORDER BY id ASC");
if (mysql_num_rows($r) > 0)
{
	while ($reg = mysql_fetch_array($r))
	{
?>
			<li><a href="show.php?ID=<?php echo $reg['id']?>" title="<?php echo utf8_encode($reg['nombre'])?>"><?php echo utf8_encode($reg['nombre'])?></a></li>
<?php
	}
}
?>
        	<li><a href="contenido.php?ID=2" title="Contacto">Contacto</a></li>
		</ul>
        <div class="clear"></div>
	</div>
</div>