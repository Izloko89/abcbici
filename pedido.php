<?php include ('header.php');?>
<div class="main">
 	<h1>Datos Adicionales de la Cotización</h1>
    <div id="content">
<?php
if (isset($_SESSION['cteTVAnetID']) and isset($_SESSION['sessionCteTVAnetID']))
{
?>
        <form id="form" name="form2" method="post" action="<?php echo RUTA?>send.php?mod=Pedido">
        <div class="boxPedido">
            <h2>Forma de Entrega</h2>
            <ul>
                <li><input name="fEmbarque" type="radio" id="radio5" value="A Domicilio"<?php if (!isset($_SESSION['fEmbarque']) or $_SESSION['fEmbarque'] == 'A Domicilio') {?> checked="checked"<?php }?> onclick="if (this.checked) { document.getElementById('Entrega').style.display = 'block'; }" />A Domicilio</li>
                <li><input type="radio" name="fEmbarque" id="radio5" value="Ocurre"<?php if (isset($_SESSION['fEmbarque']) and $_SESSION['fEmbarque'] == 'Ocurre') {?> checked="checked"<?php }?> onclick="if (this.checked) { document.getElementById('Entrega').style.display = 'none'; }" />Ocurre</li>
            </ul>
        </div>
        <div class="boxPedido" id="Entrega"<?php  if (isset($_SESSION['fEmbarque']) and $_SESSION['fEmbarque'] == 'Ocurre') {?> style="display:none;"<?php }?>>
            <h2>Domicilio de Entrega</h2>
            <center><input type="button" value="Nuevo Domicilio..." onclick="ajaxEntregas('<?php echo RUTA?>','Crear','')" class="boton" /></center>
            <div id="divEntregas">
<?php
	$r = mysql_query("SELECT a.id AS id,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.entreCalles AS entreCalles,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_entregas a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.clienteID = ".$_SESSION['cteTVAnetID']);
	if (mysql_num_rows($r) > 0)
	{
		$i = 1;
		while ($reg = mysql_fetch_array($r))
		{
			if ($i = 1 and (!isset($_SESSION['domEntrega']) or $_SESSION['domEntrega'] == 'N / A')) { $_SESSION['domEntrega'] = $reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles']; }
?>
                <div class="opcion<?php if ($_SESSION['domEntrega'] == $reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles']) { echo ' selected'; }?>">
                    <div class="divDatos"><?php echo utf8_encode($reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']."<br>Entre Calles: ".$reg['entreCalles']);?></div>
                    <div class="divBotones">
                        <ul>
                            <li onClick="ajaxEntregas('<?php echo RUTA?>','Seleccionar','<?php echo $reg['id']?>')">Seleccionar</li>
                            <li onClick="ajaxEntregas('<?php echo RUTA?>','Editar','<?php echo $reg['id']?>')">Editar</li>
                            <li onClick="ajaxEntregas('<?php echo RUTA?>','Eliminar','<?php echo $reg['id']?>')">Eliminar</li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
<?php
			$i++;
		}
	}
	else
	{
		echo '<div class="alertaMsg">No haz agregado ningun domicilio de entrega a tu cuenta</div>';
	}
	if (!isset($_SESSION['datosFactura'])) { $_SESSION['datosFactura'] = 'Sin Factura'; }
?>
            </div>
        </div>
        <div class="boxPedido">
            <h2>Datos de Facturacion</h2>
            <center><input type="button" value="Nuevos Datos de Facturacion..." onclick="ajaxFacturacion('<?php echo RUTA?>','Crear','')" class="boton" /></center>
            <div id="divFacturacion">
                <div class="opcion<?php if ($_SESSION['datosFactura'] == 'Sin Factura') { echo ' selected'; }?>">
                    <div class="divDatos">No requiero factura</div>
                    <div class="divBotones">
                        <ul>
                            <li onClick="ajaxFacturacion('<?php echo RUTA?>','Seleccionar','0')">Seleccionar</li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
<?php
	$r = mysql_query("SELECT a.id AS id,a.razonSocial AS razonSocial,a.rfc AS rfc,a.domicilio AS domicilio,a.colonia AS colonia,a.cp AS cp,a.ciudad AS ciudad,b.nombre AS estado FROM clientes_facturacion a JOIN clientes_estados b ON b.id = a.estadoID WHERE a.clienteID = ".$_SESSION['cteTVAnetID']);
	if (mysql_num_rows($r) > 0)
	{
		$i = 1;
		while ($reg = mysql_fetch_array($r))
		{
?>
                <div class="opcion<?php if ($_SESSION['datosFactura'] == $reg['razonSocial']."<br>".$reg['rfc']."<br>".$reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']) { echo ' selected'; }?>">
                    <div class="divDatos"><?php echo utf8_encode($reg['razonSocial']."<br>".$reg['rfc']."<br>".$reg['domicilio']."<br>".$reg['colonia'].", ".$reg['cp']."<br>".$reg['ciudad'].", ".$reg['estado']);?></div>
                    <div class="divBotones">
                        <ul>
                            <li onClick="ajaxFacturacion('<?php echo RUTA?>','Seleccionar','<?php echo $reg['id']?>')">Seleccionar</li>
                            <li onClick="ajaxFacturacion('<?php echo RUTA?>','Editar','<?php echo $reg['id']?>')">Editar</li>
                            <li onClick="ajaxFacturacion('<?php echo RUTA?>','Eliminar','<?php echo $reg['id']?>')">Eliminar</li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
<?php
	}
}
?>
            </div>
        </div>
        <div class="boxPedido">
            <h2>Forma de Pago</h2>
            <ul class="listaPagos">
            	<li class="payPal"><input type="radio" name="fPago" id="radio" value="Pago Seguro con PayPal"<?php if (!isset($_SESSION['fPago']) or $_SESSION['fPago'] == 'Pago Seguro con PayPal') {?> checked="checked"<?php }?> />Pago SEGURO en línea con</li>
                <li><input name="fPago" type="radio" id="radio2" value="Deposito Bancario"<?php if (isset($_SESSION['fPago']) and $_SESSION['fPago'] == 'Deposito Bancario') {?> checked="checked"<?php }?> />Deposito Bancario</li>
                <li><input type="radio" name="fPago" id="radio2" value="Transferencia Bancaria"<?php if (isset($_SESSION['fPago']) and $_SESSION['fPago'] == 'Transferencia Bancaria') {?> checked="checked"<?php }?> />Transferencia Bancaria</li>
            </ul>
        </div>
        <div class="boxPedido">
            <h2 class="registro">Comentarios del Pedido</h2>
            <textarea name="comentarios" rows="5" id="comentarios" style="width:98%;"><?php if (isset($_SESSION['comentarios']) and $_SESSION['comentarios'] <> '') { echo $_SESSION['comentarios']; }?></textarea>
        </div>
        <center><input type="button" value="Regresar" onClick="window.location = '<?php echo RUTA.'cesta/'?>'" class="boton">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Confirmar" class="boton"></center>
        </form>
<?php
}
else
{
?>
        <div class="alertaMsg">Para poder completar tu pedido debes ser un usuario registrado y haber ingresado a tu cuenta</div>
        <div id="formLogin">
            <div class="divForm">
                <form name="login" id="login" method="post" action="<?php echo RUTA?>send.php?mod=Login">
                <label>E-mail</label><input type="text" name="email" id="email" />
                <label>Contraseña</label><input type="password" name="password" id="password" />
                <input type="submit" value="Entrar" class="boton" />
                <div class="nota"><a href="registro.php">Crear una Cuenta</a></div>
                <div class="nota"><a >¿Olvidaste tu Contraseña?</a></div>
                </form>
            </div>
        </div>
<?php
}
?>
    	<div class="clear"></div>
	</div>
</div>
<?php include ('footer.php');?>