<?php include ('header.php');?>
<div class="main">
<?php
if (!isset($_SESSION['cteTVAnetID']))
{
	$arrEstados = array();
	$r = mysql_query("SELECT id,nombre FROM clientes_estados ORDER BY nombre ASC");
	if (mysql_num_rows($r) > 0)
	{
		while ($reg = mysql_fetch_array($r))
		{
			$arrEstados[$reg['id']] = $reg['nombre'];
		}
	}
?>
    <h1>Crear Cuenta</h1>
	<div id="content">
        <small>* Datos Requeridos</small>
        <form name="Registro" id="Registro" method="post" action="send.php?mod=Registro" onsubmit="return Valida(this,'Registro')">
        <h2>Datos de Acceso a la Cuenta</h2>
        <label>* E-mail</label><input name="email" type="text" id="email"<?php if (isset($_SESSION['email'])) { echo ' value="'.$_SESSION['email'].'"'; }?> onchange="ajaxValida('<?php echo RUTA?>','validaEmail',this.value)" /><div id="validaEmail" class="divValidacion"></div>
        <div class="clear"></div>
        <label>* Contraseña</label><input name="password" type="password" id="password"<?php if (isset($_SESSION['password'])) { echo ' value="'.$_SESSION['password'].'"'; }?> />
        <div class="clear"></div>
        <label>* Confirmar Contraseña</label><input name="cPassword" type="password" id="cPassword"<?php if (isset($_SESSION['password'])) { echo ' value="'.$_SESSION['password'].'"'; }?> onchange="ajaxValida('<?php echo RUTA?>','validaPassword',this.value)" /><div id="validaPassword" class="divValidacion"></div>
        <div class="clear"></div>
        <h2 class="registro">Datos Personales</h2>
        <label>* Nombre</label><input name="nombre" type="text" id="nombre"<?php if (isset($_SESSION['nombre'])) { echo ' value="'.$_SESSION['nombre'].'"'; }?> />
        <div class="clear"></div>
        <label>* Telefono</label><input name="telefono" type="text" id="telefono"<?php if (isset($_SESSION['telefono'])) { echo ' value="'.$_SESSION['telefono'].'"'; }?> />
        <div class="clear"></div>
        <label>* Telefono Móvil</label><input name="movil" type="text" id="movil"<?php if (isset($_SESSION['movil'])) { echo ' value="'.$_SESSION['movil'].'"'; }?> />
        <div class="clear"></div>
        <label>Domicilio</label><input type="text" name="domicilio" id="domicilio"<?php if (isset($_SESSION['domicilio'])) { echo ' value="'.$_SESSION['domicilio'].'"'; }?> />
        <div class="clear"></div>
        <label>Colonia</label><input type="text" name="colonia" id="colonia"<?php if (isset($_SESSION['colonia'])) { echo ' value="'.$_SESSION['colonia'].'"'; }?> />
        <div class="clear"></div>
        <label>Codigo Postal</label><input type="text" name="cp" id="cp"<?php if (isset($_SESSION['cp'])) { echo ' value="'.$_SESSION['cp'].'"'; }?> />
        <div class="clear"></div>
        <label>Entre Calles</label><input type="text" name="entreCalles" id="entreCalles"<?php if (isset($_SESSION['entreCalles'])) { echo ' value="'.$_SESSION['entreCalles'].'"'; }?> />
        <div class="clear"></div>
        <label>Ciudad</label><input type="text" name="ciudad" id="ciudad"<?php if (isset($_SESSION['ciudad'])) { echo ' value="'.$_SESSION['ciudad'].'"'; }?> />
        <div class="clear"></div>
        <label>Estado</label><select name="estado" id="estado">
<?php
	foreach ($arrEstados as $k => $v)
	{
?>
			<option value="<?php echo $k?>"<?php if (isset($_SESSION['estado']) and isset($_SESSION['estado']) == $k) { echo ' selected="selected"'; }?>><?php echo utf8_encode($v)?></option>
<?php
	}
?>
        </select>
        <div class="clear"></div>
        <div id="divMayorista"><input type="checkbox" name="solicitudMayorista" style="float:right; margin-right:102px; margin-top:184px;" /></div>
        <!-- <div id="captcha"><label><?php //echo '* Para poder completar el registro, por favor teclea el texto que veas en la siguiente imagen dentro del cuadro de texto.'?></label><br /><img src="<?php //echo RUTA?>include/aasup/aasup.php?<//?=session_id()?>" alt="" /><br /><input type="text" name="imagetext" id="imagetext" style="width:25%; float:none; margin:3px auto;" /></div> -->
        <center><input type="submit" value="Registrarme" class="boton" /></center>
        </form>
	</div>
<?php
}
else
{
	$r = mysql_query("SELECT * FROM clientes WHERE id = ".$_SESSION['cteTVAnetID']);
	$reg = mysql_fetch_array($r);
?>
	<h1>Editar Datos de Mi Cuenta</h1>
    <div id="content">
        <form name="Registro" id="Registro" method="post" action="send.php?mod=EditaCuenta" onsubmit="return Valida(this,'Registro')">
        <div id="captcha"><input name="cPass" type="checkbox" id="cPass" value="1" onclick="if (this.checked) { document.getElementById('password').disabled=false; document.getElementById('password').value=''; document.getElementById('cPassword').disabled=false; document.getElementById('password').focus();} else { document.getElementById('password').disabled=true; document.getElementById('cPassword').disabled=true; document.getElementById('password').value='**********'; };" /> Activa esta casilla si deseas modificar tu Contraseña</div>
        <small>* Datos Requeridos</small>
        <h2>Datos de Acceso a la Cuenta</h2>
        <label>* E-mail</label><input name="email" type="text" id="email" value="<?php echo $reg['email']?>" onchange="ajaxValida('<?php echo RUTA?>','validaEmail',this.value)" /><div id="validaEmail" class="divValidacion"></div>
        <div class="clear"></div>
        <label>* Contraseña</label><input name="password" type="password" id="password" value="**********" disabled="disabled" />
        <div class="clear"></div>
        <label>* Confirmar Contraseña</label><input name="cPassword" type="password" id="cPassword" disabled="disabled" onchange="ajaxValida('<?php echo RUTA?>','validaPassword',this.value)" /><div id="validaPassword" class="divValidacion"></div>
        <div class="clear"></div>
        <h2 class="registro">Datos Personales</h2>
        <label>* Nombre</label><input name="nombre" type="text" id="nombre" value="<?php echo $reg['nombre']?>" />
        <div class="clear"></div>
        <label>* Telefono</label><input name="telefono" type="text" id="telefono" value="<?php echo $reg['telefono']?>" />
        <div class="clear"></div>
        <label>* Telefono Móvil</label><input name="movil" type="text" id="movil" value="<?php echo $reg['movil']?>" />
        <div class="clear"></div>
        <center><input type="submit" value="Guardar Cambios" class="boton" /></center>
        </form>
	</div>
<?php
}
?>
</div>
<?php include ('footer.php');?>