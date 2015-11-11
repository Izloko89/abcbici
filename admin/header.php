<?php
session_start();
$SID = session_id();
if (!$_SESSION['autorizado'] or $_SESSION['nombreSESION'] <> "AnetAdminMTY2010" or $SID <> $_SESSION['sesionID'])
{
	header("Location: index.php");
}
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");

require_once('../include/config.php');
require_once('../include/libreria.php');
?>
<!--
Diseño y Desarrollo: Ing. Ruben Aaron Islas Trujillo
Monterrey, Nuevo Leon, Mexico, 2011
 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="include/CALENDARIO/datepicker.js"></script>
<link href="include/CALENDARIO/css/datepicker.css" rel="stylesheet" type="text/css" />
<!--ALERTAS -->
<link rel="stylesheet" type="text/css" media="all" href="include/SA/sexyalertbox.css"/>
<script type="text/javascript" src="include/SA/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="include/SA/sexyalertbox.v1.2.moo.js"></script>
<!--GENERAL -->
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="include/jsFunctions.js"></script>

<script type="text/javascript" src="include/TM/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "contenido,preguntas",
		theme : "advanced",
		skin : "o2k7",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",
		extended_valid_elements :"a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],input[accept|accesskey|align<bottom|left|middle|right|top|alt|checked<checked|class|dir<ltr|rtl|disabled<disabled|id|ismap<ismap|lang|maxlength|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect|readonly<readonly|size|src|style|tabindex|title|type<button|checkbox|file|hidden|image|password|radio|reset|submit|text|usemap|value],form[accept|accept-charset|action|class|dir<ltr|rtl|enctype|id|lang|method<get|post|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onsubmit|style|title|target]",

		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,advhr,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		content_css : "css/content.css",

		template_external_list_url : "include/TM/lists/template_list.js",
		external_link_list_url : "include/TM/lists/link_list.js",
		external_image_list_url : "include/TM/lists/image_list.js",
		media_external_list_url : "include/TM/lists/media_list.js",

		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<title>PANEL DE ADMINISTRACION</title>
</head>
<body<?php if (isset($_SESSION['systemAlertTEXT']) and isset($_SESSION['systemAlertTYPE'])) {?> onload="Alerta('<?php echo $_SESSION['systemAlertTEXT']?>','<?php echo $_SESSION['systemAlertTYPE']?>');return false;"<?php unset($_SESSION['systemAlertTEXT']); unset($_SESSION['systemAlertTYPE']); }?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#333333"><img src="imagenes/logo.jpg" width="243" height="66" /></td>
  </tr>
</table>
<div id="menu">
	<ul id="navi">
        <li><a href="contenidos.php">Contenidos</a></li>
        <li><a href="media.php">Media</a></li>
        <li><a href="productos.php">Productos</a></li>
        <li><a href="clientes.php">Clientes</a></li>
        <li><a href="pedidos.php?mod=porEstatus">Pedidos</a></li>
        <li><a href="contactos.php">Datos de Contactos</a></li>
        <li><a href="promociones.php">Promociones</a></li>
        <li><a href="slide.php">Imagenes Slide</a></li>
		<li><a href="cuenta.php">Mi Cuenta</a></li>
        <li><a href="logout.php">Salir</a></li>
	</ul>
</div>
<br />