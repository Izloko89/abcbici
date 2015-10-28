<?php include ('header.php');?>
<div class="main">
 	<h1>Login</h1>
    <div id="content">
<?php
if (!isset($_SESSION['cteTVAnetID']) and !isset($_SESSION['sessionCteTVAnetID']))
{
?>
        <div id="formLogin">
            <div class="divForm">
                <form name="login" id="login" method="post" action="<?php echo RUTA?>send.php?mod=Login">
                <label>E-mail</label><input type="text" name="email" id="email" />
                <label>Contraseña</label><input type="password" name="password" id="password" />
                <input type="submit" value="Entrar" class="boton" />
                <div class="nota"><a href="registro.php">Crear una Cuenta</a></div>
                <div class="nota"><a onclick="document.getElementById('divRecuperar').style.display = 'block'">¿Olvidaste tu Contraseña?</a></div>
                </form>
            </div>
        </div>
<?php
}
else
{
?>
<div id="msjFelicidades">
	<img src="imagenes/okIcon.jpg" width="150" height="146" /><br /><br />
	Felicidades, tu cuenta ha sido creada.
    <ul>
    	<li><a href="carrito.php">Ver mi Carrito</a></li>
        <li><a href="registro.php">Ver Datos de mi Cuenta</a></li>
        <li><a href="logout.php">Salir</a></li>
    </ul>
</div>
<?php
}
?>
   	  <div class="clear"></div>
	</div>
</div>
<?php include ('footer.php');?>