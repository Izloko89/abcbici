<?php include ('header.php');?>
<div class="main">
<?php
$r = mysql_query("SELECT nombre,contenido FROM contenidos WHERE id = ".Limpia($_GET['ID']));
if (mysql_num_rows($r) > 0)
{
	$reg = mysql_fetch_array($r);
?>
	<h1><?php echo utf8_encode($reg['nombre'])?></h1>
	<div id="content">
<?php
	echo str_replace('src="../imagenes','src="imagenes',utf8_encode($reg['contenido']));
	if ($_GET['ID'] == 2)
	{
?>
		<div id="formaUbicacion">
        	<h1>Ubicación</h1>
            Escobedo 804, Col. Centro, Monterrey, Nuevo León, México, CP. 64000
            <div id="formaTelefono">Tel: (81) 8372.0199 y 01800.58.10.691</div>
            <iframe width="475" height="370" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es-419&amp;geocode=&amp;q=25.681925,-100.309773&amp;aq=&amp;sll=25.681921,-100.309768&amp;sspn=0.006478,0.009645&amp;ie=UTF8&amp;t=m&amp;ll=25.681911,-100.309811&amp;spn=0.02862,0.040684&amp;z=14&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=es-419&amp;geocode=&amp;q=25.681925,-100.309773&amp;aq=&amp;sll=25.681921,-100.309768&amp;sspn=0.006478,0.009645&amp;ie=UTF8&amp;t=m&amp;ll=25.681911,-100.309811&amp;spn=0.02862,0.040684&amp;z=14" style="color:#0000FF;text-align:left">Ver mapa más grande</a></small>
        </div>
        <div id="formaContacto">
        	<h1>¡Envíanos tu mensaje!</h1>
            Para darte una mejor atención<br />
            <small>* Datos Requeridos</small>
            <form name="Registro" id="Registro" method="post" action="send.php?mod=Contacto" onsubmit="return Valida(this,'Contacto')">
            <label>* Nombre</label><input name="nombre" type="text" id="nombre" />
            <div class="clear"></div>
            <label>* Telefono</label><input name="telefono" type="text" id="telefono" />
            <div class="clear"></div>
            <label>* Email</label><input name="email" type="text" id="email" />
            <div class="clear"></div>
            <label>Ubicación</label><input name="ubicacion" type="text" id="ubicacion" />
            <div class="clear"></div>
            <label>* Mensaje</label><textarea id="mensaje" name="mensaje" rows="3" /></textarea>
            <div class="clear"></div>
            <center><input type="submit" value="Enviar Mensaje" class="boton" /></center>
            </form>
		</div>
        <div class="clear"></div>
<?php
	}
}
else
{
	echo '<div class="errorMsg">La seccion que intentas ver no existe</div>';
}
?>
	</div>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>